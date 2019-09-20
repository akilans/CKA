# Kubernetes the Hard way

# Architecture
* 3 master, etcd
* 2 worker
* 1 haproxy load balancer
* 1 workstation

# Steps

### Provision VMs
* lxd init
* lxc profile copy default k8s-worker
* lxc profile edit k8s-worker - set cpu & memory limits
* lxc launch images:centos/7 haproxy
* lxc launch ubuntu:18.04 controller-0 --profile k8s-controller
* lxc launch ubuntu:18.04 controller-1 --profile k8s-controller
* lxc launch ubuntu:18.04 controller-2 --profile k8s-controller
* lxc launch ubuntu:18.04 worker-0 --profile k8s-worker
* lxc launch ubuntu:18.04 worker-1 --profile k8s-worker
* lxc launch ubuntu:18.04 workstation --profile k8s-worker

### Install haproxy
* login into haproxy container
* lxc exec haproxy bash
* yum install haproxy net-tools -y
* edit /etc/haproxy/haproxy.cfg - refer haproxy.cfg file
* systemctl enable haproxy
* systemctl start haproxy
* systemctl status haproxy

### Install client tools
* lxc exec workstation bash
* apt update
* wget -q --show-progress --https-only --timestamping \
  https://storage.googleapis.com/kubernetes-the-hard-way/cfssl/linux/cfssl \
  https://storage.googleapis.com/kubernetes-the-hard-way/cfssl/linux/cfssljson
* chmod +x cfssl cfssljson
* sudo mv cfssl cfssljson /usr/local/bin/
* wget https://storage.googleapis.com/kubernetes-release/release/v1.15.3/bin/linux/amd64/kubectl
* chmod +x kubectl
* 