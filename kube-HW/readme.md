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
* lxc launch images:centos/7 haproxy --profile k8s-worker
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

### Generate certificates for all clients from workstation
* Refer [https://github.com/kelseyhightower/kubernetes-the-hard-way/blob/master/docs/04-certificate-authority.md]
* lxc info controller-2 | grep -i  inet | head -n 1 | awk '{print $3 }' - to get ip address
* Generate CA - certificate
* Generate admin client certificate
* Generate kubelet client certificate for all workers - refer kubelet-certificate.sh
* Generate kube-controller client certificate
* Generate kube-proxy client certificate
* Generate scheduler client certificate
* Generate kubernetes api-server server certificate
* Generate Service Account key pair

### Copy the certicates to worker and controller
* pull all the certificates from workstation to host
* lxc file pull workstation/root/certificates . --recursive
* copy ca.pem, worker.pem,worker-key.pem files to all worker nodes
```
for instance in worker-0 worker-1; do
  lxc file push ca.pem ${instance}-key.pem ${instance}.pem ${instance}/root/
done
```
* copy ca,kube-api-server, service account keys and certificates to all controllers
```
for instance in controller-0 controller-1 controller-2; do
  lxc file push ca.pem ca-key.pem kubernetes-key.pem kubernetes.pem \
    service-account-key.pem service-account.pem ${instance}/root/
done
```
* The kube-proxy, kube-controller-manager, kube-scheduler, and kubelet client certificates will be used to generate client authentication configuration files in the next lab.

### Generating Kubernetes Configuration Files for Authentication
* In this section you will generate kubeconfig files for the controller manager, kubelet, kube-proxy, and scheduler clients and the admin user.
* Generate kubelet kubeconfig file
* Generate kube-proxy kubeconfig file
* Generate kube-controller kubeconfig file
* Generate kube-scheduler kubeconfig file
* Generate admin kubeconfig file

### Copy kubeconfig to workers and controllers
* copy kube-proxy and worker kubeconfig to workers
```
for instance in worker-0 worker-1; do
  lxc file push ${instance}.kubeconfig kube-proxy.kubeconfig ${instance}/root/
done
```
* Copy admin, kube-controller, kube-scheduler config to all controllers
```
for instance in controller-0 controller-1 controller-2; do
  lxc file push admin.kubeconfig kube-controller-manager.kubeconfig kube-scheduler.kubeconfig ${instance}/root/
done
```
### Encryprt etcd data
* Refer encrypt.sh
* copy the generated encryption yaml file to all controller
```
for instance in controller-0 controller-1 controller-2; do
  lxc file push encryption-config.yaml ${instance}/root/
done
```

### 