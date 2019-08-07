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