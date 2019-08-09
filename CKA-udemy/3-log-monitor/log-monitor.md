# Loggind and Monitoring
* Clone this repo - https://github.com/kubernetes-incubator/metrics-server
* kubectl apply -f metrics-server/deploy/1.8+/
* kubectl top nodes
* kubectl top pods
* kubectl logs -f $POD_NAME
* if 2 container are running in single pod - kubectl logs -f $POD_NAME $CONTAINER_NAME [ kubectl logs -f webapp-2 simple-webapp ]