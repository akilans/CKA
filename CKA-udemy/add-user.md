# Adding new user to the cluster
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
