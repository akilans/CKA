# Steps to follow
* Create Secret - kubectl create secret generic mysql-secret --from-literal=mysql_root_pwd=root -n aki-test 
* Create Persistent Volume - kubectl apply -f volume.yaml
* kubectl apply -f mysql-dp-sv.yaml
* kubectl apply -f php-dp-sv.yaml
* kubectl apply -f adminer-dp-sv.yaml