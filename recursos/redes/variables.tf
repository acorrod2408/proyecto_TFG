variable "subredes_publicas" {
  type        = list(string)
}

variable "etiquetas" {
  type        = map(string)
}

variable "cidr" {
  description = "CIDR vpc"
  type        = string
}

variable "zonas_disponibilidad" {
  type        = list(string)
}
