# Demo

http://ruetoc-ruetoc.apps.us-east-1.starter.openshift-online.com/


# Online-Compiler

This is an online compiler that can compile and run C\C++ And Java Program. This online compiler is a part of my 5th semester project
"RUET Online Judge" . This Online Compiler is Developed By <a href="http://fb.com/ashadullah.shawon">Ashadullah Shawon</a>

# Languages
C , C++ And Java

# Requirements

Linux, gcc, g++ , Java Compilers And Lampp


# Install Projects And Compilers

```
git clone https://github.com/shawon100/Online-Compiler.git

```

C/C++
```
sudo add-apt-repository ppa:ubuntu-toolchain-r/test
sudo apt-get update
sudo apt-get install g++-4.8


sudo ln -f -s /usr/bin/g++-4.8 /usr/bin/g++

```

Java
```
sudo add-apt-repository ppa:openjdk-r/ppa  
sudo apt-get update   
sudo apt install openjdk-8-jre
```
# Change Permission
```
chmod -R 777 Online-Compiler
```

# Windows Version
https://github.com/shawon100/Online-Compiler-Windows-Server


# DevOps Features 

## Docker Build Image

Copy Dockerfile to Outside of Online-Compiler Folder. Then Run docker build command.

```
docker build -t online-compiler .
```
## Docker Run Container
```
docker run -p 80:80 online-compiler
```
## Video Tutorial
https://www.youtube.com/watch?v=bf-inYN2V-k

## Kubernetes

Create deployment.yaml file
```
apiVersion: v1
kind: Service
metadata:
  name: onlinecompiler-service
spec:
  selector:
    app: onlinecompiler
  ports:
  - protocol: "TCP"
    port: 80
    targetPort: 80
  type: NodePort

---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: onlinecompiler
spec:
  selector:
    matchLabels:
      app: onlinecompiler
  replicas: 1
  template:
    metadata:
      labels:
        app: onlinecompiler
    spec:
      containers:
      - name: onlinecompiler
        image: shawon10/online-compiler
        imagePullPolicy: Always
        ports:
        - containerPort: 80
 ```
 Run 
 ```
 kubectl apply -f deployment.yaml
 ```
Check IP and Ports
```
 kubectl get svc
```
 
## Openshift Deploy (Online)

Check this video: https://www.youtube.com/watch?v=QnA0QidkWSM

