# Mock Exam 1
1. kubectl run --generator=run-pod/v1 nginx-pod --image=nginx:alpine --dry-run -o yaml
2. kubectl run --generator=run-pod/v1 messaging --image=redis:alpine --labels=tier=msg --dry-run -o yaml > redis.yaml
3. kubectl create namespace apx-x9984574
4. kubectl expose pod messaging --name=messaging-service --port=6379 --type=ClusterIP --selector=tier=msg --dry-run
5. kubectl run --generator=deployment/v1beta1 hr-web-app --replicas=2 --image=kodekloud/webapp-color --dry-run -o yaml
6. kubectl run --generator=run-pod/v1 static-busybox --image=busybox --dry-run -o yaml --command -- sleep 1000
7.
8. 
9. Edit pod
10. kubectl expose deployment hr-web-app --name=hr-web-app-service --type=NodePort --port=8080 --target-port=30082 --dry-run -o yaml
11. kubectl get nodes -o=jsonpath='{.items[*].status.nodeInfo.osImage}'
12. refer pv.yaml