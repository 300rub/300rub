FROM ubuntu:18.04

RUN apt-get upgrade
RUN apt-get update

ENV DEBIAN_FRONTEND=noninteractive

# Simple instance
RUN apt-get install -y php7.2 php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl php7.2-memcached php7.2-gd
RUN apt-get install -y nginx

# Libs
RUN apt-get install -y apt-utils python-pip gnupg git zip unzip curl php7.2-zip mysql-client wget nano

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Selenium
RUN apt-get install -y firefox xvfb
RUN pip install selenium

# Java
RUN apt-get install -y openjdk-8-jre-headless

# Jenkins
RUN wget -q -O - https://pkg.jenkins.io/debian/jenkins-ci.org.key | apt-key add -
RUN sh -c 'echo deb http://pkg.jenkins.io/debian-stable binary/ > /etc/apt/sources.list.d/jenkins.list'
RUN apt-get update
RUN apt-get install -y jenkins

# Ant
RUN apt-get install -y ant ant-contrib ant-optional

# NodeJS
RUN curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs

# Static validators
RUN npm install -g less lesshint lesshint-reporter-stylisher jshint htmlhint
