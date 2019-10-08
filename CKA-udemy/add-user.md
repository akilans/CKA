# Adding new user to the cluster

### Method 1
* openssl genrsa -out akilan.key 2048
* openssl req -new -key akilan.key -subj "/CN=akilan/O=kube" -out akilan.csr
* openssl x509 -req -in akilan.csr -CA /etc/kubernetes/pki/ca.crt -CAkey /etc/kubernetes/pki/ca.key -CAcreateserial -out akilan.crt -days 500
* kubectl config set-credentials akilan --client-certificate=/root/akilan.crt --client-key=/root/akilan.key
* kubectl config view
* kubectl config set-context akilan-context --cluster=kubernetes --user=akilan
* kubectl config view
* kubectl --context=akilan-context get pods
* kubectl create clusterrolebinding akilan-cluster-rb --clusterrole=cluster-admin --user=akilan
* kubectl --context=akilan-context get pods
* kubectl --context=akilan-context get pods --all-namespaces

### Method 2
    3  kubectl get csr
    4  openssl genrsa -out akilan.key 2048
    8  openssl req -new -key akilan.key -subj "/CN=akilan/O=kube" -out akilan.csr
   10  cat akilan.csr | tr -d "\n"
   11  cat akilan.csr | base64 | tr -d "\n"
   12  vi akilan-csr.yaml
   13  kubectl create role developer --resource=pod,deployment --verb=list,create,update,get,delete
   15  kubectl get role developer -o yaml
   18  kubectl create rolebinding dev-rb --role=developer --user=akilan
   20  kubectl get csr
   22  cat akilan-csr.yaml
   24  kubectl apply -f akilan-csr.yaml
   25  kubectl get csr
   27  kubectl certificate approve akilan-csr
   28  kubectl get csr
   30  kubectl get csr -o yaml akilan-csr
   32  kubectl get csr
   33  kubectl get csr akilan-csr -o json | less
   34  kubectl get csr akilan-csr -o=jsonpath='{.status.certificate}'
   35  kubectl get csr akilan-csr -o=jsonpath='{.status.certificate}' | base64 --decode
   36  kubectl get csr akilan-csr -o=jsonpath='{.status.certificate}' | base64 --decode > akilan.crt
   39  kubectl config view
   41  kubectl auth can-i get pods --as=akilan
   42  kubectl auth can-i get svc --as=akilan
   43  kubectl auth can-i get deploy --as=akilan
