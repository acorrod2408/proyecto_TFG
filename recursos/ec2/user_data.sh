#!/bin/bash
sudo su <<'EOF_SUDO_FINAL'
cat << 'EOF' >> ~/.bashrc
export AWS_ACCESS_KEY_ID="${aws_access_key_id}"
export AWS_SECRET_ACCESS_KEY="${aws_secret_access_key}"
export AWS_SESSION_TOKEN="${aws_session_token}"
export AWS_DEFAULT_REGION="${aws_region}"
EOF
source ~/.bashrc
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o /tmp/awscliv2.zip
unzip -q /tmp/awscliv2.zip -d /tmp
/tmp/aws/install --install-dir /usr/aws-cli --bin-dir /usr/bin --update
rm -rf /tmp/awscliv2.zip /tmp/aws


yum install -y amazon-efs-utils jq git

curl -fsSL "https://dl.k8s.io/release/$(curl -fsSL https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl" \
     -o /usr/local/bin/kubectl
chmod +x /usr/local/bin/kubectl

cp /usr/local/bin/kubectl /usr/bin/kubectl
chmod 755 /usr/bin/kubectl
chown root:root /usr/bin/kubectl

aws eks update-kubeconfig --name "tecnoiliberis" --region "us-east-1"
slepp 3

mkdir -p ${punto_montaje}
mount -t efs -o tls ${id_efs}:/ ${punto_montaje}
bash -c "echo \"${id_efs}:/ ${punto_montaje} efs defaults,_netdev 0 0\" >> /etc/fstab"

chmod -R 777 /mnt/efs

REPO_URL="https://${git_token}@github.com/acorrod2408/proyecto_TFG.git"
CLONE_DIR="/mnt/efs"

git clone --depth 1 \
  --branch "Web" \
  "$REPO_URL" \
  "$CLONE_DIR"

chmod -R 777 /mnt/efs/
export KUBECONFIG=/root/.kube/config
kubectl apply -k "github.com/kubernetes-sigs/aws-efs-csi-driver/deploy/kubernetes/overlays/stable/ecr/?ref=release-1.7"
yum install -y openssh-server
systemctl enable sshd
systemctl start sshd

EOF_SUDO_FINAL
