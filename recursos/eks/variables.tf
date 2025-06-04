variable "nombre_cluster" {
  description = "Nombre eks"
  type        = string
}
variable "id_vpc" {
  type        = string
}
variable "id_subredes" {
  type        = list(string)
}
variable "nombre_grupo_nodos" {
  description = "Nombre para el grupo de nodos"
  type        = string
}
variable "numero_replicas" {
  description = "Numero de replicas"
  type        = number
}
variable "nodo_tipo_instancia" {
  description = "Tipo de instancia para los nodos"
  type        = string
}
variable "eks_id_gs" {
  type        = string
}
variable "eks_role_arn" {
  type        = string
}

variable "arn_nodo" {
  type        = string
}
variable "habilitar_endpint" {
  type        = bool
  default     = true
}

variable "cidrs_privado" {
  type        = bool
  default     = false
}

variable "cidrs_publico" {
  type        = list(string)
  default     = ["0.0.0.0/0"]
}

variable "id_grupo_seguridad" {
  type        = list(string)
  default     = []
}

#OPCIONAL
variable "nombre_clave_ssh" {
  type        = string
  default     = ""
}