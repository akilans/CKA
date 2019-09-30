# Cluster Maintenence
* kubectl drain node1 --ignore-daemonsets [ Terminate all the pods and marked as cordon]
* kubectl cordon node1 [ Mark as unschedulable ]
* kubectl uncordon node1
* kubectl get pods -o wide
* kubectl drain node1 --ignore-daemonsets --force [if any pods not managed by replicasets]

### Cluster upgrade
* kubeadm upgrade plan - list available stable version and commands to upgrade
* upgrade kubeadm first - apt install kubeadm=1.12.0-00
* kubeadm upgrade apply v1.12.0 [ one minor version at a time don't jump to v1.15]
* apt install kubelet=1.12.0-00
* kubectl uncordon master
* kubectl drain node01 --ignore-daemonsets - Next node
* login to node and run - apt install kubelet=1.12.0-00
* kubeadm upgrade node config --kubelet-version v1.12.0
* kubectl uncordon node01

### Backup and restore
* Backup all the resources [Pods,deployments, services etc]
* Backup Etcd cluster [ Before back up stop API server]
* Backup - ETCDCTL_API=3 etcdctl --endpoints=https://[127.0.0.1]:2379 --cacert=/etc/kubernetes/pki/etcd/ca.crt \
     --cert=/etc/kubernetes/pki/etcd/server.crt --key=/etc/kubernetes/pki/etcd/server.key \
     snapshot save /tmp/snapshot-pre-boot.db
* Restore - ETCDCTL_API=3 etcdctl --endpoints=https://[127.0.0.1]:2379 --cacert=/etc/kubernetes/pki/etcd/ca.crt \
     --name=master \
     --cert=/etc/kubernetes/pki/etcd/server.crt --key=/etc/kubernetes/pki/etcd/server.key \
     --data-dir /var/lib/etcd-from-backup \
     --initial-cluster=master=https://127.0.0.1:2380 \
     --initial-cluster-token etcd-cluster-1 \
     --initial-advertise-peer-urls=https://127.0.0.1:2380 \
     snapshot restore /tmp/snapshot-pre-boot.db
* Update /etc/kubernetes/manifests/etcd.yaml with --data-dir=/var/lib/etcd-from-backup & --initial-cluster-token=etcd-cluster-1
* Update volume, mountPath: /var/lib/etcd-from-backup &   - hostPath:
      path: /var/lib/etcd-from-backup
* Refer this URL - https://github.com/mmumshad/kubernetes-the-hard-way/blob/master/practice-questions-answers/cluster-maintenance/backup-etcd/etcd-backup-and-restore.md 

### References

* https://kubernetes.io/docs/tasks/administer-cluster/configure-upgrade-etcd/#backing-up-an-etcd-cluster

* https://github.com/etcd-io/etcd/blob/master/Documentation/op-guide/recovery.md

* https://www.youtube.com/watch?v=qRPNuT080Hk