variable "name" {
  type = string
}
variable "id_subredes" {
  type = list(string)
}
variable "subredes_publicas" {
  description = "Lista de CIDRs de las subnets públicas (keys estáticas para el map)"
  type        = list(string)
}
variable "id_grupos_seg" {
  type = string
}
