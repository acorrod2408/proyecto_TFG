resource "aws_efs_file_system" "this" {
  creation_token = var.name
  lifecycle_policy {
    transition_to_ia = "AFTER_14_DAYS"
  }
}

locals {
  subnet_map = {
    for cidr in var.subredes_publicas :
    cidr => var.id_subredes[index(var.subredes_publicas, cidr)]
  }
}

resource "aws_efs_mount_target" "this" {
  for_each        = local.subnet_map
  file_system_id  = aws_efs_file_system.this.id
  subnet_id       = each.value
  security_groups = [var.id_grupos_seg]
}
