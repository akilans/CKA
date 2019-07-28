# Kubernetes Concepts

# Docker basics
* Components - Docker cli, Deamon
* Install Docker
* Run container - docker run busybox echo "Hello Docker"
* Run container interactively - docker run -it busybox --sh
* List all the images - docker images
* List all the containers - docker ps -a
* Kill all the containers - docker rm $(docker ps -aq)
* Kill all the containers - docker container rm $(docker container ps -aq)
* Remove all the images not using by container - docker image prune --all
* Remove all the images not using - docker image rm $(docker images -q)
* Run container in background - docker run -d --name http-server httpd
* Login into running container - docker container exec -it http-server bash
* Stop the container - docker container stop http-server
* Kill the container - docker container rm http-server
* Port mapping - docker container run -d --name http-server -p 8000:80 httpd
* Kill the container once exits - docker container run --rm --name hello-rm-container -p 8000:80 httpd
* Inspect docker container - docker container inspect http-server
* Get logs from a container - docker container logs http-server -f
* Build an image from a Dockerfile - docker image build -t akilan/httpd-server:latest -f Dockerfile .
* Login into running container - docker container exec -it httpd-server --bash
* Create image from a container - docker container commit akilan-http-new akilan/httpd-server-new
* Tag a new image - docker image tag akilan/httpd-server httpd-modified

# Kubernetes Architeture
* Master - Etcd , API server, Scheduler & Control Manager
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
* Rollout Deployment - kubectl rollout status deployment/http-hello & kubectl set image deployment/http-hello httpd-containers=httpd:2.4-alpine 
* History of rollout - kubectl rollout history deployment/http-hello
* Labeling - kubectl label node minikube distribution=ubuntu.Use nodeSelector option to place the deployment only on node which labeled as distribution=ubuntu
* Healthcheck - Readiness Probes & Liveness Probes 
* Readiness Probes - Once pod deployed to check it is ready or not.
* Liveness Probes - After pod is ready, checking the application whether it is live or not
* Accessing Dashboard in secure way- kubectl proxy - http://localhost:8001/api/v1/namespaces/kube-system/services/kubernetes-dashboard/proxy

# Demo Commands
* kubectl run hello-http --image=httpd --replicas=2 --port=80
* kubectl get pods
* kubectl get deployments
* kubectl expose deployment hello-http --type=NodePort
* kubectl get service
* curl $(minikube service hello-http --url)
* kubectl scale --replicas=3 deployment/http-hello
* kubectl create -f file.yaml
* kubectl rollout status deployment/http-hello
* kubectl set image deployment/http-hello httpd-containers=httpd:2.4-alpine
* kubectl rollout history deployment/http-hello
* kubectl rollout history deployment/http-hello --revision=2
* kubectl describe node minikube
* kubectl label node minikube distribution=ubuntu

# DNS - Service Discovery
* Built-in DNS service
* $SERVICE_NAME.$NAMESPACE.svc.cluster.local
* cat /etc/resolv.conf
```bash
nameserver 10.96.0.10
search default.svc.cluster.local svc.cluster.local cluster.local
options ndots:5
```
* curl http-service.aki-test.svc.cluster.local

# Secrets
* kubectl create secret generic mysql-secret --from-literal=mysql_root_pwd=root

# Volume
* 