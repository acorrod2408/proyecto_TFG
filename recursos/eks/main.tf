provider "kubernetes" {
  host                   = aws_eks_cluster.this.endpoint
  cluster_ca_certificate = base64decode(aws_eks_cluster.this.certificate_authority[0].data)
  token                  = data.aws_eks_cluster_auth.this.token
}

resource "aws_eks_cluster" "this" {
  name     = var.nombre_cluster
  role_arn = var.eks_role_arn

  vpc_config {
    subnet_ids             = var.id_subredes
    security_group_ids     = var.id_grupo_seguridad
    endpoint_public_access  = var.habilitar_endpint
    endpoint_private_access = var.cidrs_privado
    public_access_cidrs     = var.cidrs_publico
  }
}

resource "aws_eks_node_group" "this" {
  cluster_name    = aws_eks_cluster.this.name
  node_group_name = var.nombre_grupo_nodos
  node_role_arn   = var.arn_nodo
  subnet_ids      = var.id_subredes

  scaling_config {
    desired_size = var.numero_replicas
    max_size     = var.numero_replicas + 1
    min_size     = var.numero_replicas
  }

  instance_types = [var.nodo_tipo_instancia]
}

