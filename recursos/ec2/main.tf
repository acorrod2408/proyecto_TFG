provider "aws" {}

resource "aws_instance" "app" {
  ami                    = var.ami_id
  tipo_instancia          = var.tipo_instancia
  id_subred              = var.id_subred
  associate_public_ip_address = true
  key_name = var.nombre_clave_ssh
  vpc_security_group_ids = [var.id_grupos_seg]
  etiquetas                   = { Name = var.nombre_instancia }

  root_block_device {
    volume_size = var.tamano_volumen
  }

  user_data = "user_data.sh", {
    id_efs          = var.id_efs
    punto_montaje = var.punto_montaje
    git_token = var.git_token
    aws_access_key_id  = var.aws_access_key_id
    aws_secret_access_key = var.aws_secret_access_key
    aws_region         = var.region
    aws_session_token  = var.aws_session_token
  } 
}

