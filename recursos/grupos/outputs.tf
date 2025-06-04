output "eks_nodes_sg_id" {
  description = "ID del grupo de seguridad de los workers de EKS"
  value       = aws_security_group.eks_nodes.id
}

output "efs_sg_id" {
  description = "ID grupo de seguridad de los puntos de montaje de EFS"
  value       = aws_security_group.efs.id
}

output "ec2_app_sg_id" {
  description = "ID del grupo de seguridad para EC2"
  value       = aws_security_group.ec2_app.id
}
