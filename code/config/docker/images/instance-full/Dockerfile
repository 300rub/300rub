FROM ubuntu:18.04

RUN apt-get upgrade
RUN apt-get update

ENV DEBIAN_FRONTEND=noninteractive

# Simple instance
RUN apt-get install -y php7.2 php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl php7.2-memcached php7.2-gd
RUN apt-get install -y nginx

# Libs
RUN apt-get install -y apt-utils python-pip gnupg git ant ant-contrib ant-optional libjsch-java zip unzip curl php7.2-zip mysql-client

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# NodeJS
RUN curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs

# Static validators
RUN npm install -g less lesshint lesshint-reporter-stylisher jshint htmlhint

# Selenium
RUN apt-get install -y firefox xvfb
RUN pip install selenium
