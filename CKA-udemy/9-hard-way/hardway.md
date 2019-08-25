# Kubernetes the Hardway
* 5 vms needed. 2 master, 2 nodes, 1 for load balancer
* Kubernetes master - kube-apiserver and etcd both should be running. control-manager and sheduler one should be running and one should be standby mode
* etcd 2379, kube-apiserver 6443

### Setup

* clone the repo - https://github.com/mmumshad/kubernetes-the-hard-way.git
* go to kubernetes-the-hard-way/vagrant folder and run "vagrant up"
* ssh to the master - vagrant ssh master-1
* ssh-keygen - Generate public and private keys. Copy the id_rsa.pub key content
* login to master-2, worker-1, worker-2, lb and add the public key in ./.ssh/authorized_keys
* Below command
``` SHELL 
cat >> ./.ssh/authorized_keys <<EOF
> ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCl1v6hHWdqvtBU7r9C0QgL2m/UdYyHLs0ao9b4LSIge5xHgI4eLwgpEhQa2WAAONFmL110LKZvli1FONmpoCWNmtwNfX5TlTkbdq4xwJ1CJoZKrJwjf6JxWNVvYZB9yqUP6dmEkyPWGg7mefv9SDVW/Pzfwwv8w8VHfTojaglQ6WK+MsvHspQiHbZCP7AVSawDBegWEMS17uKBhgqYGM5LStHssURYuGAmmBkJtCKwGWM4v1XL3qsE9sjBVc0903QQ72zh0afpHPTUbjvzkychNJEizyiTO+emJItTuQ4IEaXe6h2qR2vzKoTz0e4qGYZH3wEVsVwuFv3GJ vagrat@master-1
> EOF
```
* Install kubectl

#### Certificates
* Create certificates for the following
  - ca - /CN=KUBERNETES-CA
  - admin - /CN=admin/O=system:masters
  - kube-controller-manager - /CN=system:kube-controller-manager
  - kube-proxy - /CA=system:kube-proxy
  - kube-scheduler - /CA=system:kube-scheduler
  - kube-apiserver - /CN=kube-apiserver [ by config file]
  - etcd - /CN=etcd-server [ by config file]
  - service-account - /CN=service-accounts
  - worker-1 - /CN=system:node:worker-1/O=systems:nodes
* copy the following certificates to all master nodes
  - ca.key, ca.crt
  - kube-apiserver.key, kube-apiserver.crt
  - service-account.key, service-account.crt
  - etcd-server.key, etcd-server.crt
* create kube-config files for kube-controller-manager, kube-schedulet, kubelet, kube-proxy, admin by seeting following values for each clients [ Refer kube-config.md]
  - kubectl config set-cluster
  - kubectl config set-credentials
  - kubectl config set-context
  - kubectl config use-context
* copy kube-proxy.kubeconfig to all workers
* copy kube-scheduler.kubeconfig ,kube-controller-manager.kubeconfig and admin.kubeconfig to all masters
* Create encryption config file for encrypting data and copy to all masters
* Install and configure etcd on both masters
* Install and configure Kubernetes API Server, Scheduler, and Controller Manager and external loadbalancer
* kubectl get componentstatuses --kubeconfig admin.kubeconfig

### Worker setup - Manual setup
* Generate certificate
* create kubeconfig for kubelet
* copy ca.crt, worker-1.key, worker-1.crt, worker-1.kubeconfig to worker-1 node
* 

### Worker setup - TLS bootstrapping
* 