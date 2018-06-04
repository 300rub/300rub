FROM ubuntu:16.04

RUN apt-get update
RUN apt-get install -y python-software-properties
RUN apt-get install -y software-properties-common
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN apt-get install -y php7.2

RUN apt-get install -y php7.2-mysql
RUN apt-get install -y php7.2-fpm
RUN apt-get install -y php7.2-mbstring
RUN apt-get install -y php7.2-xml
RUN apt-get install -y php7.2-curl
RUN apt-get install -y php7.2-memcached

RUN apt-get install -y --fix-missing ant

EXPOSE 9000
