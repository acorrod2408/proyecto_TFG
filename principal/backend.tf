terraform {
  backend "s3" {
    bucket       = "tecnoiliberis-backups-00e650fd"
    key          = "eks-prod/state.tfstate"
    region       = "us-east-1"
#   use_lockfile = true
    encrypt      = true
  }
}
