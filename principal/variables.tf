variable "region_pref" {
  type    = string
  default = "us-east-1"
}

variable "nombre_cluster" {
  description = "Nombre del cluster EKS"
  type        = string
  default     = "tecnoiliberis"
}

variable "nombre_grupo_nodos" {
  description = "Nombre del grupo de nodos"
  type        = string
  default     = "worker-nodes"
}

variable "numero_replicas" {
  description = "Cantidad de nodos"
  type        = number
  default     = 2
}

variable "tipo_instancia" {
  description = "Tipo de instancia para nodos"
  type        = string
  default     = "t3.medium"
}

variable "efs_name" {
  description = "Nombre del sistema de ficheros EFS"
  type        = string
  default     = "app-efs"
}

variable "ami_id" {
  description = "AMI ID para la instancia EC2"
  type        = string
  default     = "ami-0c02fb55956c7d316"
}

variable "nodo_tipo_instancia" {
  description = "Tipo de instancia EC2"
  type        = string
  default     = "t3.medium"
}

variable "backup_bucket_name" {
  type        = string
  default     = "tecnoiliberis-backups-00e650fd"
}

variable "cidr" {
  type        = string
  default     = "50.0.0.0/16"
}

variable "subredes_publicas" {
  type        = list(string)
  default     = ["50.0.1.0/24", "50.0.2.0/24", "50.0.3.0/24"]
}
variable "public_subnet_azs" {
  type    = list(string)
  default = ["us-east-1a","us-east-1b","us-east-1c"]
}

variable "eks_role_arn" {
  type        = string
  default     = "arn:aws:iam::891376930154:role/LabRole"
}

variable "arn_nodo" {
  type        = string
  default     = "arn:aws:iam::891376930154:role/LabRole"
}

variable "habilitar_endpint" {
  type    = bool
  default = true
}
variable "cidrs_privado" {
  type    = bool
  default = false
}
variable "cidrs_publico" {
  type    = list(string)
  default = ["0.0.0.0/0"]
}
variable "nombre_clave_ssh" {
  type        = string
  description = "Par de claves SSH"
  default     = ""
}

variable "aws_account_id" {
  description = "Id cuenta AWS"
  type        = string
  default     = "891376930154"
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

