#Use the Ubuntu base image

FROM php:7.2-apache

#Update all packages
RUN apt-get update

#Install tzdata and set timezone.
ENV TZ=America/Chicago
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get -y install tzdata

#Install Software Properties
RUN apt-get update -y
RUN apt-get install -y gnupg
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*

#Install C/C++ Compiler


RUN add-apt-repository ppa:ubuntu-toolchain-r/test
RUN echo "deb http://ftp.us.debian.org/debian/ jessie main contrib non-free" >>  /etc/apt/sources.list.d/toolchain.list
#RUN echo "deb-src http://ppa.launchpad.net/ubuntu-toolchain-r/test/ubuntu precise main" >> /etc/apt/sources.list.d/toolchain.list
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 1E9377A2BA9EF27F
RUN apt-get -y update && \
    apt-get -y install gcc-4.8 && \
    apt-get -y install g++-4.8 && \
    rm -rf /var/lib/apt/lists/
# RUN add-apt-repository ppa:ubuntu-toolchain-r/test

# RUN apt-get update -y
# RUN apt-get install -y gcc-4.8
# RUN apt-get install -y g++-4.8
RUN ln -f -s /usr/bin/gcc-4.8 /usr/bin/gcc
RUN ln -f -s /usr/bin/g++-4.8 /usr/bin/g++

#Remove any unnecessary files
RUN apt-get clean

#Copy files to webserver 
COPY . /var/www/html/

#Change Permission
RUN chmod -R 777 /var/www/html/

#Start services
CMD /usr/sbin/apache2ctl -D FOREGROUND
#Expose ports
EXPOSE 80

# Remove Default index.html
#RUN rm /var/www/html/index.html
