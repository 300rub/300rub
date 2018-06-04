FROM ubuntu:16.04

RUN apt-get update

RUN apt-get install -y python-software-properties

RUN apt-get install -y software-properties-common

RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

RUN apt-get update

RUN apt-get install -y php7.2
RUN apt-get install -y php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl

EXPOSE 9000

RUN apt-get -y install php-memcached 