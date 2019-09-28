# Scheduler
* Responsible for selecting node and placing containers. if there is no scheduler then pod will be in pending state
* Manually mention nodeName in pod definition. Refer nginx-pod.yaml file
* kubectl get pods --selector=env=dev
* kubectl get pods --selector=tier,env,bu
* Resource Requests - minimum amount of cpu and memory

# Taints and Tollerations
* Make node to accept only particular pods
* kubectl taint node node01 spray=mortein:NoSchedule
* refer ngins-tolerations.yaml file
* kubectl taint node master node-role.kubernetes.io/master:NoSchedule- - untaint master node
* kubectl label nodes node01 color=blue
* 

## DaemonSets
* It runs one on each node. Use case for DeamonSet is monitoring, Logging info
* Same as Deployment definition. Refer daemonset.yaml

## Static Pods
* without kubernetes cluster setup and components, kubelet on any node with docker runtime can run a pod and update the pod.It ensures the pod is always running.
* Use case -All control plane components are static pods
* Location of manifest files can be find here - /etc/kubernetes/manifests
* Static pod adds node name at the end of pod name - kube-apiserver-master, kube-scheduler-master, kube-controller-manager-master, etcd-master
* kubectl run --restart=Never --image=busybox static-busybox --dry-run -o yaml --command -- sleep 1000 > /etc/kubernetes/manifests/static-busybox.yaml

## Multiple Scheduler
* We can create multiple scheduler by running scheduler binary. Copy /etc/kubernetes/ to my-custom-scheduler.yaml and add the below in command section and change the pod name

- --scheduler-name my-custom-scheduler, --lock-object-name=my-custom-scheduler