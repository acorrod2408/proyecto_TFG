// main.tf
variable "region" {
  description = "AWS region"
  type        = string
  default     = "us-east-1"
}

variable "tamano_volumen" {
  description = "Tamaño volumen"
  type        = number
  default     = 20
}

provider "aws" {
  region = var.region
}

provider "kubernetes" {
  host                   = module.eks.cluster_endpoint
  cluster_ca_certificate = base64decode(module.eks.cluster_ca_certificate)
  token                  = data.aws_eks_cluster_auth.cluster.token
}

module "redes" {
  source              = "../recursos/redes"
  cidr                = var.cidr
  subredes_publicas = var.subredes_publicas
  zonas_disponibilidad                 = var.public_subnet_azs
  etiquetas                = { Environment = "prod" }
}

module "grupos" {
  source       = "../recursos/grupos"
  id_vpc       = module.redes.id_vpc
  nombre_cluster = var.nombre_cluster
}

module "efs" {
  source               = "../recursos/efs"
  name                 = var.efs_name
  id_subredes           = module.redes.subnet_ids
  subredes_publicas  = var.subredes_publicas
  id_grupos_seg    = module.grupos.efs_sg_id
}

module "eks" {
  source                     = "../recursos/eks"
  nombre_cluster               = var.nombre_cluster
  id_vpc                     = module.redes.id_vpc
  id_subredes                 = module.redes.subnet_ids
  nombre_grupo_nodos            = var.nombre_grupo_nodos
  numero_replicas                 = var.numero_replicas
  nodo_tipo_instancia         = var.nodo_tipo_instancia
  eks_id_gs                  = module.grupos.eks_nodes_sg_id
  eks_role_arn           = var.eks_role_arn
  arn_nodo              = var.arn_nodo
  habilitar_endpint  = true
  cidrs_privado = false
  cidrs_publico     = ["0.0.0.0/0"]
  nombre_clave_ssh                    = var.nombre_clave_ssh
  id_grupo_seguridad         = [module.grupos.ec2_app_sg_id]
}


data "aws_eks_cluster_auth" "cluster" {
  name = var.nombre_cluster
}

data "aws_s3_bucket" "backup" {
  bucket = var.backup_bucket_name
}



resource "aws_instance" "app_server" {
  ami                         = var.ami_id
  instance_type               = var.tipo_instancia
  subnet_id                   = module.redes.subnet_ids[0]
  vpc_security_group_ids      = [module.grupos.ec2_app_sg_id]
  key_name                    = var.nombre_clave_ssh

  root_block_device {
    volume_size = var.tamano_volumen
  }

  user_data = templatefile(
    "${path.module}/../recursos/ec2/user_data.sh",
    {
      nombre_cluster    = var.nombre_cluster
      region          = var.region
      id_efs          = module.efs.efs_id
      punto_montaje = "/mnt/efs"   
      git_token = var.git_token
      aws_access_key_id      = var.aws_access_key_id
      aws_secret_access_key  = var.aws_secret_access_key
      aws_session_token      = var.aws_session_token
      aws_region             = var.aws_region
    }
  )

  tags = {
    Name = "app-server"
  }

  depends_on = [
    module.eks,
    module.efs,
  ]
}
