# Core Concepts

* Master Nodes 
    - API Server, Scheduler, Control manager, ETCD
    - ETCD - Stores cluster data as key and values format [Nodes,ConfigMap, Secrets,Pods, Roles, Bindings]. Listen on 2379
    - Scheduler - Responsible for placing container based on resources, nodes availability. Decides which pods can go to which nodes [Filter, Rank nodes and place container]
    - Contoller - Node Controller, Replication controller responsible for monitoring nodes,containers and take remediate actions
    - API Server 
        - Perform manage operation through API manager
        - Authentication, Validate Request, Retrieve data, Update etcd, Trigger scheduler, Kubelet
* Worker Nodes
    - Kubelet, Docker, Kube Proxy KubeDNS
    - Kubelet - Sending reports to master, runs on each node, running containers
    - Kube proxies - Communication between container running on different nodes
### Common commands
* kubectl get all

### Pods - commands
* kubectl get pods
* kubectl describe pod $POD_NAME
* kubectl get pods -o wide
* kubectl apply -f redis-pod.yaml

### ReplicaSet - Commands
* kubectl get rs/replicaset
* kubectl describe rs $REPLICA_SET_NAME
* kubectl edit rs $REPLICA_SET_NAME
* kubectl apply -f rs.yaml
* kubectl scale rs $REPLICA_SET_NAME --replicas=5
* kubectl get rs $REPLICA_SET_NAME -o yaml > rs.yaml

### Deployment - Commands
* kubectl run httpd --image=httpd --port=80 --replicas=2

### Tips
* Generate YAML template definition for PODs and Deployments
* kubectl run --generator=run-pod/v1 nginx --image=nginx --dry-run -o yaml
* kubectl run --generator=deployment/v1beta1 nginx --image=nginx --dry-run -o yaml
* kubectl run --generator=deployment/apps.v1beta1 httpd-frontend --image=httpd:2.4-alpine --replicas=2 --port=80 --requests=cpu=100m,memory=256Mi --dry-run -o yaml

### Namespaces
* kubectl create namespace akilan
* kubectl config set-context $(kubectl config current-context) --namespace=akilan

### Services
* Types - NodePort, ClusterIP, LoadBalancer
* NodePort Range - [30000 - 32767]
* kubectl run httpd --generator=deployment/apps.v1beta1 --image=httpd --replicas=2 --port=80 --dry-run -o yaml > httpd.yaml
* kubectl apply -f httpd.yaml
* kubectl expose deployment httpd --port=80 --type=NodePort
* kubectl get svc httpd -o yaml
* kubectl run --generator=run-pod/v1 nginx-pod --image=nginx:alpine --dry-run -o yaml > nginx-pod.yaml
* kubectl run --generator=run-pod/v1 redis --image=redis:alpine --labels=tier=db --dry-run -o yaml > redis-pod.yaml
* kubectl expose pod redis --name=redis-service --type=ClusterIP --port=6379 --dry-run -o yaml > redis-service.yaml
* kubectl run  --generator=deployment/apps.v1beta1 webapp --image=kodekloud/webapp-color --replicas=3 --dry-run -o yaml > webapp-deployment.yaml