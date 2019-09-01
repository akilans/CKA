# Application Life Cycle Management

### Rollng update and Rollback

* kubectl apply -f my-apache.yaml --record
* kubectl rollout status deployment/httpd-deployment
* Deployment Strategies - Recreate, RollingUpdate[default],
* kubectl set image deployment/httpd-deployment $CONTAINER_NAME=httpd:latest --record
* kubectl set image deployment/my-apache apache=httpd:alpine --record=true
* kubectl rollout history deployment/httpd-deployment
* kubectl rollout undo deployment/httpd-deployment
* kubectl rollout undo deployment/httpd-deployment --to-revision=2
* kubectl set image deployment/frontend simple-webapp=kodekloud/webapp-color:v2

### Horizontal Auto Scaler
* Install heapster or metrics server
* kubectl top nodes
* kubectl top pods
* mention cpu resource while deployment
* kubectl autoscale deployment my-apache --min=1 --max=5 --cpu-percent=50
* kubectl run -i --tty load-generator --image=busybox /bin/sh
* while true; do wget -q -O- http://my-apache; done



### Secrets, Environment vars, commands
* In docker, if u want to run ubuntu image by calling docker run ubuntu it exists immediately. Because it is not having any process and apps to run. Create new image called ubuntu-sleeper from the below Dockerfile
```
FROM ubuntu
CMD sleep 10
```
* Now run docker run ubuntu-sleeper. After 5 seconds it exits
* if you run docker run ubuntu-sleeper sleep 10.After 10 seconds it exits
```
FROM ubuntu
ENTRYPOINT sleep
CMD 10
```
* Entrypoint can be override by passing --entrypoint=echo or something else.[command in pod definition]
* CMD can be override by passing args [args in pod definition]
* docker run --entrypoint echo ubuntu-sleeper Akilan

### Config map
* kubectl get configmaps
* kubectl create configmap webapp-config-map --from-literal=APP_COLOR=darkblue
* kubectl create configmap app-properties --from-env-file=app.properties
* refer configmap.yaml, config-map.yaml,app.properties

### Secrets
* echo -n Akilan | base64 - convert to base64 encoded format
* echo -n "QWtpbGFu" | base64 --decode
* kubectl get secrets [ number of secret data can be seen here]
* kubectl create secret generic db-secret --from-literal=DB_Host=sql01 --from-literal=DB_User=root --from-literal=DB_Password=password123
* kubectl describe secret db-secret

### Multi Container pod
* 