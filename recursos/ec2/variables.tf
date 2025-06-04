variable "ami_id" {
  type = string
}
variable "tipo_instancia" {
  type = string
}
variable "id_subred" {
  type = string
}
variable "id_grupos_seg" {
  type = string
}
variable "nombre_instancia" {
  type = string
}
variable "tamano_volumen" {
  type = number
}
variable "id_efs" {
  type = string
}
variable "punto_montaje" {
  type        = string
}
variable "nombre_clave_ssh" {
  description = "Par SSH para la instancia EC2"
  type        = string
}

variable "git_token" {
  type        = string
  sensitive   = true
}

variable "aws_access_key_id" {
  type      = string
  sensitive = true
}

variable "aws_secret_access_key" {
  type      = string
  sensitive = true
}

variable "aws_session_token" {
  type      = string
  sensitive = true
}

variable "aws_region" {
  type      = string
  default   = "us-east-1"
}


