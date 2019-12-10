# Important points

### Generate CA
* openssl genrsa -out ca.key 2048
* openssl req -new -key ca.key -subj "/CN=KUBERNETES-CA" -out ca.csr
* openssl x509 -req -in ca.csr -signkey ca.key -out ca.crt

### Generate admin certificate
* openssl genrsa -out admin.key 2048
* openssl req -new -key admin.key -subj "/CN=kube-admin/O=system:masters" -out admin.csr
* openssl x509 -req -in admin.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out admin.crt
* curl https://kube-apiserver:6443/api/v1/pods --key admin.key --cert admin.crt --cacert ca.crt

### View certificate details [CA, Dates etc]
* openssl x509 -in /etc/kubernetes/pki/ca.crt -text
* openssl x509 -req -in /etc/kubernetes/pki/apiserver-etcd-client.csr -CA /etc/kubernetes/pki/etcd/ca.crt -CAkey /etc/kubernetes/pki/etcd/ca.key -CAcreateserial -out /etc/kubernetes/pki/apiserver-etcd-client.crt


#### Grant access for new admin user
* new user has to generate key and raise csr
* openssl genrsa -out akilan.key 2048
* openssl req -new -key akilan.key -subj "/CN=akilan" -out akilan.csr
* Admin has to create CertificateSigningRequest object with above csr certificate
* kubectl get csr
* kubectl certificate approve akilan | kubectl certificate deny akilan
* kubectl delete csr akilan
* kubectl get csr akilan -o yaml - Extract base64 encoded certificate and decode. share that one with akilan
* kubectl get csr csr-mcb6b -o jsonpath='{.status.certificate}' | base64 --decode > server.crt