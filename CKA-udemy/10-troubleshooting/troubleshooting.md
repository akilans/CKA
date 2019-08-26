# Troubleshooting

### Application Failure
* kubectl logs web -f
* kubectl logs web -f --previous
* Check for port, labels, env variable
* access app using curl

### Control plane Failure
* sudo journalctl -u kube-apiserver
* see the manifest files /etc/kubernetes/manifests
* kube-controller.yaml, kube-scheduler.yaml
 
### Worker node failure
* kubectl get node -o wide
* status of kubelet service
* kubectl describe node worker-01
* df -h - check free spaces
* ps -aux
* sudo systemctl status kubelet
* tls certificate expire date
* cat /etc/systemd/system/kubelet.service.d/10-kubeadm.conf
* cat /var/lib/kubelet/config.yaml
* cat /etc/kubernetes/kubelet.conf