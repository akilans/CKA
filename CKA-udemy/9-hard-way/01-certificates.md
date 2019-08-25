
#### Certificate Authority
* openssl genrsa -out ca.key 2048
* openssl req -new -key ca.key -subj "/CN=KUBERNETES-CA" -out ca.csr
* openssl x509 -req -in ca.csr -signkey ca.key -CAcreateserial  -out ca.crt -days 1000

#### Admin Client Certificate
* openssl genrsa -out admin.key 2048
* openssl req -new -key admin.key -subj "/CN=admin/O=system:masters" -out admin.csr
* openssl x509 -req -in admin.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out admin.crt -days 1000

#### Kube control manager
* openssl genrsa -out kube-controller-manager.key 2048
* openssl req -new -key kube-controller-manager.key -subj "/CN=system:kube-controller-manager" -out kube-controller-manager.csr
* openssl x509 -req -in kube-controller-manager.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out kube-controller-manager.crt -days 1000

#### Kube proxy certification
* openssl genrsa -out kube-proxy.key 2048
* openssl req -new -key kube-proxy.key -subj "/CA=system:kube-proxy" -out kube-proxy.csr
* openssl x509 -req -in kube-proxy.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out kube-proxy.crt -days 1000


#### Kube scheduler certificate
* openssl genrsa -out kube-scheduler.key 2048
* openssl req -new -key kube-scheduler.key -subj "/CA=system:kube-scheduler" -out kube-scheduler.csr
* openssl x509 -req -in kube-scheduler.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out kube-scheduler.crt -days 1000

#### Kube Apiserver certification
* openssl genrsa -out kube-apiserver.key 2048
* openssl req -new -key kube-apiserver.key -subj "/CN=kube-apiserver" -out kube-apiserver.csr -config openssl.cnf
* openssl x509 -req -in kube-apiserver.csr -CA ca.crt -CAkey ca.key -CAcreateserial  -out kube-apiserver.crt -extensions v3_req -extfile openssl.cnf -days 1000

#### ETCD certificate 

* openssl genrsa -out etcd-server.key 2048
* openssl req -new -key etcd-server.key -subj "/CN=etcd-server" -out etcd-server.csr -config etcd.cnf
* openssl x509 -req -in etcd-server.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out etcd-server.crt -extensions v3_req -extfile etcd.cnf -days 1000

#### Service Account Certificate
* openssl genrsa -out service-account.key 2048
* openssl req -new -key service-account.key -subj "/CN=service-accounts" -out service-account.csr
* openssl x509 -req -in service-account.csr -CA ca.crt -CAkey ca.key -CAcreateserial  -out service-account.crt -days 1000

#### Copy to master nodes
```
for instance in master-1 master-2; do
  scp ca.crt ca.key kube-apiserver.key kube-apiserver.crt \
    service-account.key service-account.crt \
    etcd-server.key etcd-server.crt \
    ${instance}:~/
done
```

### Worker-1 certification
* 
```
 cat > openssl-worker-1.cnf <<EOF
> [req]
> req_extensions = v3_req
> distinguished_name = req_distinguished_name
> [req_distinguished_name]
> [ v3_req ]
> basicConstraints = CA:FALSE
> keyUsage = nonRepudiation, digitalSignature, keyEncipherment
> subjectAltName = @alt_names
> [alt_names]
> DNS.1 = worker-1
> IP.1 = 192.168.5.21
> EOF
```

* openssl genrsa -out worker-1.key 2048
* openssl req -new -key worker-1.key -subj "/CN=system:node:worker-1/O=system:nodes" -out worker-1.csr -config openssl-worker-1.cnf
* openssl x509 -req -in worker-1.csr -CA ca.crt -CAkey ca.key -CAcreateserial -extensions v3_req -extfile openssl-worker-1.cnf -out worker-1.crt -days 1000


openssl genrsa -out worker-1.key 2048
openssl req -new -key worker-1.key -subj "/CN=system:node:worker-1/O=system:nodes" -out worker-1.csr -config openssl-worker-1.cnf
openssl x509 -req -in worker-1.csr -CA ca.crt -CAkey ca.key -CAcreateserial  -out worker-1.crt -extensions v3_req -extfile openssl-worker-1.cnf -days 1000
