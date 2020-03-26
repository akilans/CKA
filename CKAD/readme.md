# Certified Kubernetes Application Developer
* kubectl run --generator=run-pod/v1 nginx --image=nginx --dry-run -o yaml
* kubectl create deployment --image=nginx nginx --dry-run -o yaml
* kubectl create deployment --image=nginx nginx --dry-run -o yaml > nginx-deployment.yaml
* kubectl run --generator=run-pod/v1 webapp-green --image=kodekloud/webapp-color --dry-run -o yaml --command -- "echo" > cmd.yaml
* kubectl config set-context $(kubectl config current-context) --namespace=dev
* kubectl create configmap webapp-config-map --from-literal=APP_COLOR=darkblue
* kubectl create secret generic --from-literal=password=admin123
* kubectl create secret generic db-secret --from-literal=DB_Host=sql01 --from-literal=DB_User=root --from-literal=DB_Password=password123 --dry-run -o yaml > db-secret.yaml