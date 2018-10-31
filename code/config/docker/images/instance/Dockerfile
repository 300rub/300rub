FROM ubuntu:18.04

RUN apt-get update

RUN apt-get install -y nginx

RUN apt-get install -y software-properties-common
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y tzdata

RUN apt-get install -y php7.2

RUN apt-get install -y php7.2-mysql
RUN apt-get install -y php7.2-fpm
RUN apt-get install -y php7.2-mbstring
RUN apt-get install -y php7.2-xml
RUN apt-get install -y php7.2-curl
RUN apt-get install -y php7.2-memcached
RUN apt-get install -y php7.2-gd

RUN apt-get install -y --fix-missing ant
RUN apt-get install -y mysql-client
RUN apt-get install -y less

RUN apt-get install -y git
RUN apt-get install -y zip unzip php7.2-zip
RUN apt-get install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer