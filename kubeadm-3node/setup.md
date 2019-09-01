# Setup Kubernets cluster with 1 master and 2 worker nodes
* create 3 vms [1 master, 2 nodes]
* instal docker on all 3 vms

```
cat >>/etc/hosts<<EOF
192.168.33.10 master.example.com master
192.168.33.11 node01.example.com node01
192.168.33.12 node02.example.com node02
EOF

kubeadm join 192.168.33.10:6443 --token 7kv24k.t89226md2oow7fuy \
    --discovery-token-ca-cert-hash sha256:8ed7fdcdda805b0d43da4825b5940a79bbba9280444a2df78c11ec8a382b0329

```