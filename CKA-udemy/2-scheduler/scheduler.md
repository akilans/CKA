# Scheduler
* Responsible for seleting node and placing containers. if there is no scheduler then pod will be in pending state
* Manually mention nodeName in pod definition. Refer nginx-pod.yaml file
* kubectl get pods --selector env=dev
* Resource Requests - minimum amount of cpu and memory

## DaemonSets
* It runs one on each node. Use case for DeamonSet is monitoring, Logging info
* Same as Deployment definition. Refer daemonset.yaml