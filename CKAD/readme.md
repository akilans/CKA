# Certified Kubernetes Application Developer
* kubectl run --generator=run-pod/v1 nginx --image=nginx --dry-run -o yaml
* kubectl create deployment --image=nginx nginx --dry-run -o yaml
* kubectl create deployment --image=nginx nginx --dry-run -o yaml > nginx-deployment.yaml
* kubectl config set-context $(kubectl config current-context) --namespace=dev
* kubectl create configmap webapp-config-map --from-literal=APP_COLOR=darkblue
* kubectl create secret generic --from-literal=password=admin123
* 