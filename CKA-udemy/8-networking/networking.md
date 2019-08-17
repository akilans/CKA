## Networking

* ip link - see all the interfaces
* ip addr - see the address of all interfaces
* ip addr add 192.168.1.0/24 dev eth0 [Assigning IP to the interface]
* Router helps to connect to different networks
* route - See the routing table[Gateway]
* ip route add 192.168.1.0/24 via 192.168.2.0 [Machines in 192.168.2.0 network can connect to machines in 192.168.1.0 networks. Now route added]
* ip route add default via 192.168.2.0 [Route all via router 192.168.2.0]
* echo 1 > /proc/sys/net/ipv4/ip_forward [Allows 2 diff networks to communicate]

#### DNS server
* Instead of adding hostname in each server [/etc/hosts] host name with ip address are stored in DNS server. It makes life easier
* After adding in DNS server, mention that DNS namespace in /etc/resolv.conf
* nslookup [ignores /etc/hosts]

### Namespaces
* Container completely isolated and can't see host process but host system can see the all the process including container as a process
* Network Namespaces [Container should have isolated network interface and routing table]
* ip netns add red - Adds network namespace called red
* ip netns add blue - Adds network namespace called blue
* ip netns - list all the ns
* ip netns exec red ip link, ip -n red link - list interface of red nns[network namespace]
* arp - address resolution protocol
* After adding network namespace we need to create virtual interface and map it to namespace and assign ip address for each virtual interface
* ip link add veth-red type veth peer name veth-blue [Created 2 virtual interfaces]
* ip link set veth-red netns red
* ip link set veth-blue netns blue
* ip -n red addr add 192.168.15.1 dev veth-red
* ip -n blue addr add 192.168.15.2 dev veth-blue
* ip -n red link set veth-red up
* ip -n blue link set veth-blue up

### Access container network by host virtual interface
* At this time Host system has no idea about veth-red,veth-blue.To access container we need to create another virual interface[bridge] for host
* ip link add v-net-o type bridge
* ip link -list virtual interface
* ip link set dev v-net-0 up
* After creating this virtual interface we no more need veth-red and veth-blue
* ip -n red link del veth-red [It deleted veth-blue as well]
* ip link add veth-red type veth peer name veth-red-br
* ip link add veth-blue type veth peer name veth-blue-br
* ip link set veth-red netns red
* ip link set veth-red-br master v-net-0
* ip link set veth-blue netns blue
* ip link set veth-blue-br master v-net-0
* ip -n red addr add 192.168.15.1 dev veth-red
* ip -n blue addr add 192.168.15.2 dev veth-blue
* ip -n red link set veth-red up
* ip -n blue link set veth-blue up
* ip addr add 192.168.15.0/24 dev v-net-0
* ping any container from host system now :) 
* ip -n red ip route add 192.168.1.0/24 via 192.168.2.0 [add host system as default gateway. So that it will communicate with external network via host]
* iptables -t nat -A POSTROUTING -s 192.168.15.0/24 -j MASQUERADE [ping from container to external ip gets response back]
* ip -n red ip route add default via 192.168.2.0 - connect to internet
* ip -t nat -A PREROUTING --dport 80 --to-destination 192.168.15.1:8080 -j DNAT - Internet can access container app via host port forward

### Container Network Interface [CNI]
* CNI came as a standard to solve the above steps

### Commands
* ip link -list all the interface
* ip addr - see the ip address
* ip link show $NI - show mac address
* ifconfig - Shows all the details
* arp node01 - List ip address and mac address of node01
* arp - list all
* ip link - can see the status of interface as well
* ip route - Lists all the gateways
* netstat -nplt  [PORT of all running applications]
* netstat -anp | grep etcd

### Pod Networking
* ps -aux | grep kubelet - See the CNI 
* ls /opt/cni/bin - List of all supported cni
* ls /etc/cni/net.d/ - Which plugin configured in kubernetes cluster
* kubectl apply -f "https://cloud.weave.works/k8s/net?k8s-version=$(kubectl version | base64 | tr -d '\n')"
* cat /etc/cni/net.d/net-script.conf

### Service Networking
* ps -aux | grep kube-apiserver - See the service cluster ip range
* 10.244.0.0/16 - means ip from 10.244.0.0 to 10.244.255.255
* 10.96.0.0/12 -means ip fro 10.96.0.0 to 10.111.255.255
* iptables -L -t net | grep db-service
* cat /var/log/kube-proxy.log
* kubectl logs weave-net-bxptv weave -n kube-system - IP range for pods
* ps -aux | grep kube-apiserver - IP range for services
* kubectl logs kube-proxy-7dvhj -n kube-system - Proxy type by default iptables

### DNS
* db-service.dev.svc.cluster.local - Access any service from different namespace
* $POD_IP.dev.pod.cluster.local - Access any pod from different namespace [Replace '.' in the IP address with '-']

### Core-DNS
* cat /etc/coredns/Corefile - This core file passed to kubernetes as configmap
* coredns - kubectl get configmap -n kube-system
* kubectl get configmap coredns -n kube-system -o yaml - See it here
* coredns run as a service - kube-dns
* kubectl describe configmap coredns -n kube-system - Check the root domain here

### Ingress
* kubectl create namespace ingress-space
* kubectl create configmap nginx-configuration --namespace ingress-space
* kubectl create serviceaccount ingress-serviceaccount --namespace ingress-space
* create role and rolebindings
* https://github.com/kubernetes/ingress-nginx/blob/master/docs/deploy/index.md
* create ingress service. refer ingress-service.yaml
* 