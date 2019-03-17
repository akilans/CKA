# Kubernetes Concepts

# Kubernetes Architeture
* Master - API server, Scheduler & Control Manager
* Node - Docker, Kubelet, Kube-proxy

# Minikube
* Install kubectl
* Install Virtuabox
* Install Minikube
* Start Minikube - minikube start --memory=6144
* Show Dashboard - minikube dashboard
* List all the addons - minikube addons list
* Get URL of service - minikube service hello-htp --url --namespace=test-aki
* Login into minikube - minikube ssh

# Building Blocks
* Pods
* Deployment
* Service
* Namespace
* Secret
* ConfigMap
* StatefulSet
* Ingress

# Kubectl
* Create namespace - kubectl create namespace test-aki
* Create Deployment - kubectl run hello-http --image=httpd --port=8080
* Create Service - kubectl expose deployment hello-http --type=NodePort
* Get Pods, Service, Deployments - kubectl get pods | services | deployments
* Delete Pods, Service, Deployment, Namespace - kubectl delete pod | service | deployment | namespace $NAME
* Login into pod - kubectl exec -it $POD_NAME --namespace=test-aki -- bash
* Details - kubectl describe pod $POD_NAME | deployment $DEP_NAME | service $SVC_NAME
* Scale Deployment - kubectl scale --replicas=3 deployment/http-hello

# Demo Commands
* kubectl run hello-http --image=httpd --replicas=2 --port=80
* kubectl get pods
* kubectl get deployments
* kubectl expose deployment hello-http --type=NodePort
* kubectl get service
* curl $(minikube service hello-http --url)
* kubectl scale --replicas=3 deployment/http-hello
* kubectl create -f file.yaml