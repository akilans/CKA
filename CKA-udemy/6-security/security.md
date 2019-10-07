# Security
* kube-api-server is the main part of accessing kubernetes cluster
* Who can Access ? - Authentication. What they can access ? - Authorization [RBAC]
* Various components connected via TLS certificates
* Network Policies

### Authentication
* Admin - Full access to cluster, Developer - Only Deployment access, 3rd party services by serviceAccounts
* Static file with user name and password or token, certificate, 3rd party services like LDAP, Kerbros
* Basic Authentication is not recommended for production - user name and password, token
* Create csv file with 4 values. PASSWORD,USERNAME,USER_ID,GROUP
* Feed that file in api-server. U need to restart API-server to activate authentication
* --basic-auth-file=/tmp/users/user-details.csv [Using volume if kube-api-server is running as a pod]
* In case of token, --token-auth-file=/tmp/users/user-details.csv
* Refer role-bindings.yaml file
* After creating role and role bindings test it by following command
* curl -v -k https://localhost:6443/api/v1/pods -u "user1:password123"

### TLS certificate concepts
* Server Components - kupe-apiserver, etcd server, kubelet server
* Client components - admin using kubectl and restapi, kube scheduler, kube controll manager, kube proxy, kube-apiserver[ to etcd server and to kubelet server ]
* Private key name [*.key or *-key.pem]
* public key name [*.crt, *.pem]
* refer certificates diagrams under certificates folder
* There are many ways to generate certificates. EASYRSA, OPENSSL, CFSSL

#### Generate certificate Steps for CA 
* Genereate key - openssl genrsa -out ca.key 2048
* Certificate signing Request[CSR] - openssl req -new -key ca.key -subj "/CN=KUBERNETES-CA" -out ca.csr
* Sign certificate - openssl x509 -req -in ca.csr -signkey ca.key -out ca.crt

#### Generate certificate Steps for kube admin [ using common CA from above]
* follow the same steps to create admin.key, admin.crt
* Genereate key - openssl genrsa -out admin.key 2048
* Certificate signing Request[CSR] - openssl req -new -key admin.key "/CN=kube-admin/O=system:masters" -out admin.csr
* Sign certificate - openssl x509 -req -in admin.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out admin.crt

* Access kube-server by calling API with necessary certificate details
* curl https://kube-apiserver:6443/api/v1/pods --key admin.key --cert admin.crt --cacert ca.crt


### View details of certificate

* View expiry date, issuer, name everything by running the below command
* openssl x509 -in /etc/kubernetes/pki/ca.crt -text
* Generate a certificate in case if it expired
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

### kube config
* kubectl config view 
* kubectl config view --kubeconfig=my-custom
* kubectl config use-context prod-user@production
* kubectl config use-context --kubeconfig=my-kube-config dev-user@test-cluster-1

### API group
* kubectl proxy
* curl http://localhost:8001 -k
* curl http://localhost:8001/apis -k | grep "name"
* curl http://localhost:8001/apis -k | grep "name"
* curl https://localhost:6443/version -k

### Role Based Access Control - RBAC
* kubectl auth can-i delete pod|deployments|nodes
* kubectl auth can-i delete pod --as dev-user
* kubectl create role developer --resource=pods --verb=list,create --dry-run -o yaml
* kubectl create rolebinding dev-user-binding --role=developer --user=dev-user --dry-run -o yaml
* Create role and role bindings
* kubectl get role [mention resource and verbs(list,delete,create)]
* kubectl get rolebindings
* kubectl edit role developer -n blue

### ClusterRole and ClusterRolebindings
* kubectl api-resources --namespaced=true [pods,secrets,deployments,role,rolebindings,services,volumeclaim] all are namespaced
* kubectl api-resources --namespaced=false [volume,node,namespace,clusterRole,ClusterRolebindings,certificateSiginingRequest] all are namespaced
* kubectl create clusterrole storage-admin --resource=persistentvolumes --verb=list,get,create,delete,watch --dry-run -o yaml > storage-cr.yaml
* kubectl create clusterrolebinding michelle-storage-admin --clusterrole=storage-admin  --user=michelle --dry-run -o yaml > storage-crb.yaml

### Image Security
* To pull image from private docker registry create secret by passing docker credentials
* kubectl create secret docker-registry regcred --docker-server=<your-registry-server> --docker-username=<your-name> --docker-password=<your-pword> --docker-email=<your-email>
* kubectl create secret docker-registry private-reg-cred --docker-server=myprivateregistry.com:5000 --docker-username=dock_user --docker-password=dock_password --docker-email=dock_user@myprivateregistry.com
* add imagePullSecrets:
      - name: regcred


### Network Policies
* Ingress and Egress
* Refer egress.yaml file
* 