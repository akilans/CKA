# Mock Exam 2
* kubectl describe pod etcd-master -n kube-system
* ETCDCTL_API=3 etcdctl --endpoints=https://[127.0.0.1]:2379 --cacert=/etc/kubernetes/pki/etcd/ca.crt --cert=/etc/kubernetes/pki/etcd/healthcheck-client.crt --key=/etc/kubernetes/pki/etcd/healthcheck-client.key snapshot save /tmp/etcd-backup.db
* Refer emptyDir.yaml for emptyDir volume
* kubectl run --generator=run-pod/v1 super-user-pod --image=busybox:1.28 --dry-run -o yaml --command -- sleep 4800 > super-user-pod.yaml
* 
```
kubectl run nginx-deploy --image=nginx:1.16 --replicas=1
kubectl rollout status deployment nginx-deploy
kubectl rollout history deployment nginx-deploy
```
* kubectl create role developer --verb=create,get,list,delete --resource=pods --namespace=development
* kubectl create rolebinding dev-user-role-binding --role=developer --namespace=development --user=john 
* kubectl auth can-i get pods --as john -n development