FROM ubuntu:18.04

RUN apt-get upgrade
RUN apt-get update

ENV DEBIAN_FRONTEND=noninteractive

# Simple instance
RUN apt-get install -y php7.2 php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl php7.2-memcached php7.2-gd
RUN apt-get install -y nginx
