# Setup Kubernets cluster with 1 master and 2 worker nodes
* create 3 vms [1 master, 2 nodes]
* instal docker on all 3 vms

```
cat >>/etc/hosts<<EOF
192.168.33.10 master.example.com master
192.168.33.11 node01.example.com node01
192.168.33.12 node02.example.com node02
EOF

kubeadm join 192.168.33.10:6443 --token 7kv24k.t89226md2oow7fuy \
    --discovery-token-ca-cert-hash sha256:8ed7fdcdda805b0d43da4825b5940a79bbba9280444a2df78c11ec8a382b0329

```

### Dashboard setup
* Reference URL [https://github.com/kubernetes/dashboard] [https://github.com/kubernetes/dashboard/blob/master/docs/user/access-control/creating-sample-user.md]
* kubectl apply -f dashboard.yaml [ Expose service type as nodePort and mention port as 30001]
* kubectl create serviceaccount dashboard-user --namespace=kube-system
* kubectl create clusterrolebinding dashboard-admin --clusterrole=cluster-admin --serviceaccount=kube-system:dashboard-user
* kubectl describe secrets -n kube-system dashboard-user-token-l6vrd  -  Get the access token

### Metric Server Setup
* Reference URL - [https://github.com/kubernetes-incubator/metrics-server]
* git clone https://github.com/kubernetes-incubator/metrics-server.git
* Edit file metrics-server-deployment.yaml under metrics-server/deploy/1.8+. Add args
```
      - name: metrics-server
        image: k8s.gcr.io/metrics-server-amd64:v0.3.3
        imagePullPolicy: Always
        args: [ "--kubelet-insecure-tls","--kubelet-preferred-address-types=InternalIP" ]
```
* kubectl apply -f metrics-server/deploy/1.8+/
* kubectl top nodes
* kubectl top pods

### Horizontal Pod AutoScaler
* kubectl get hpa
* kubectl apply -f my-apache.yaml
* kubectl autoscale deployment my-apache --min=1 --max=3 --cpu-percent=50
* kubectl run -i --tty load-generator --image=busybox /bin/sh
* while true; do wget http://my-apache ; done
* kubectl delete hpa my-apache

### Namespace and Context
* kubectl get ns
* kubectl create ns test
* kubectl confid view
* kubectl config get-contexts
* kubectl config set-context kube-sys-ctx --namespace=kube-system --user=kubernetes-admin --cluster=kubernetes
* kubectl config use-context kube-sys-ctx
* kubectl get pods - list pods under kube-system namespace
* kubectl config delete-context kube-sys-ctx 

### Node Selector
* kubectl label nodes node02 ssdDisk=true - label a node
* kubectl apply -f node-selector.yaml
* kubectl scale deployment basic-httpd --replicas=2

### Daemonset
* Same as Deployment but it will run on all the nodes
* By mentioning nodeSelector we can restrict
* kubectl apply -f daemonsets.yaml
* kubectl get ds
* kubectl delete ds httpd-daemonset

### Jobs & CronJobs
* It just run the task in the pod and completes it. It will not run forever
* completions 4 - If the completions is 2, it will create 2 pods sequentialy to run the task [ based on the paralelism ]
* parallesim - 2 Runs the parallel task [ if completions 4, then it will run 2 task at a time]
* backoffLimit - If error while running job, it will try to create the number of times mentioned in the backoffLimit
* activeDeadlineSeconds - if the tasks running more than activeDeadlineSeconds then kill the task
* cronjob - can be schedule to run on [minute, hour, daily, weekly, monthly ]
* suspend - true means suspend the cron job 
* 