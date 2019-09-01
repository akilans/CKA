# Exam 3
* kubectl create serviceaccount pvviewer
* kubectl create clusterrole pvviewer-role --verb=list --resource=PersistentVolumes
* kubectl create clusterrolebinding pvviewer-role-binding --serviceaccount=default:pvviewer --clusterrole=pvviewer-role
* kubectl run --generator=run-pod/v1 pvviewer --image=redis --serviceaccount=pvviewer

* kubectl get nodes -o=jsonpath='{range.items[*]}{.metadata.name}{"\t"}{.status.addresses[0].address}{"\n"}{end}' > /root/node_ips

* kubectl get nodes -o=jsonpath='{range.items[*]}{.metadata.name}{"\t"}{.status.addresses[?(@.type=="InternalIP")].address}{"\n"}{end}'