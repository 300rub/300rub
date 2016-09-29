# Toolkit app container -  docker file copied from library/php:5.4-fpm but based on buildpack-deps:jessie
FROM buildpack-deps:jessie
MAINTAINER Marc Easen <marc.easen@ee.co.uk>

ENV DEBIAN_FRONTEND noninteractive

# persistent / runtime deps
RUN apt-get update && apt-get install -y ca-certificates curl libxml2 --no-install-recommends && rm -r /var/lib/apt/lists/*

# phpize deps
RUN apt-get update && apt-get install -y autoconf gcc make pkg-config --no-install-recommends && rm -r /var/lib/apt/lists/*

ENV PHP_INI_DIR /usr/local/etc/php

RUN mkdir -p $PHP_INI_DIR/conf.d

RUN gpg --keyserver pool.sks-keyservers.net --recv-keys 1A4E8B7277C42E53DBA9C7B9BCAA30EA9C0D5763

ENV PHP_VERSION 7.0.8
ENV PHP_FILENAME php-7.0.8.tar.xz

# Install base packages

RUN export http_proxy=$PROXY
RUN export https_proxy=$PROXY

COPY docker-php-ext-* /usr/local/bin/
RUN	 chmod ogu+x /usr/local/bin/docker-php-ext-*

#Build php
RUN curl -SL "http://php.net/get/php-$PHP_VERSION.tar.bz2/from/this/mirror" -o php.tar.bz2 \
	&& curl -SL "http://php.net/get/php-$PHP_VERSION.tar.bz2.asc/from/this/mirror" -o php.tar.bz2.asc \
	&& gpg --verify php.tar.bz2.asc \
	&& mkdir -p /usr/src/php \
	&& tar -xf php.tar.bz2 -C /usr/src/php --strip-components=1 \
	&& rm php.tar.bz2*

RUN buildDeps=" \
		ant \
		bzip2 \
                unzip \
		file \
		g++ \
		gearman-tools \
		less \
		libcurl4-openssl-dev \
		libfreetype6-dev \
		libgearman-dev \
		libicu-dev \
		libjpeg62-turbo-dev \
		libldap2-dev \
		libmcrypt-dev \
		libmemcached-dev \
		libpcre3 \
		libpng12-dev \
		libreadline6-dev \
		libssl-dev \
		libxml2-dev \
		mlocate \
		mysql-client \
		php-soap \
#		php5-ldap \
#		php5-mysql \
		readline-common \
	"; \
	set -x \
	&& apt-get update && apt-get install -y --force-yes $buildDeps --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN cd /usr/src/php \
	&& ./configure \
		--disable-cgi \
		--enable-bcmath \
		--enable-fpm \
		--enable-gd-native-ttf \
		--enable-json \
                --enable-intl \
		--enable-mbstring \
		--enable-mysqlnd \
		--enable-pcntl \
		--enable-soap \
		--enable-sockets \
		--with-config-file-path="$PHP_INI_DIR" \
		--with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
		--with-curl \
		--with-fpm-group=www-data \
		--with-fpm-user=www-data \
		--with-freetype-dir=/usr/include/ \
		--with-gd \
		--with-iconv \
		--with-jpeg-dir=/usr/include/ \
		--with-ldap \
		--with-libdir=lib/x86_64-linux-gnu/ \
		--with-libmemcached \
                --with-mcrypt \
		--with-mysql=mysqlnd \
		--with-mysqli=mysqlnd \
		--with-openssl \
		--with-pcre-regex \
		--with-pdo-mysql=mysqlnd \
		--with-pear \
		--with-png-dir=/usr/include/ \
		--with-readline \
		--with-xsl \
		--with-zlib \
	&& make -j"$(nproc)" \
	&& make install \
	&& { find /usr/local/bin /usr/local/sbin -type f -executable -exec strip --strip-all '{}' + || true; } \
	&& make clean

#memcached extensions
RUN cd /usr/src/php \
	&& curl -SLO https://github.com/php-memcached-dev/php-memcached/archive/php7.zip \
	&& unzip php7.zip \
	&& mv php-memcached-php7 /usr/src/php/ext/memcached \
	&& rm /usr/src/php/php7.zip \
	&& docker-php-ext-configure memcached \
	&& docker-php-ext-install memcached \
	&& updatedb

#gearman extensions
RUN cd /usr/src/php \
	&& curl -SLO https://github.com/wcgallego/pecl-gearman/archive/master.zip \
	&& unzip master.zip \
	&& mv pecl-gearman-master /usr/src/php/ext/gearman \
	&& docker-php-ext-configure gearman \
	&& docker-php-ext-install gearman

#node for assetic/less
# verify gpg and sha256: http://nodejs.org/dist/v0.10.31/SHASUMS256.txt.asc
# gpg: aka "Timothy J Fontaine (Work) <tj.fontaine@joyent.com>"
# gpg: aka "Julien Gilli <jgilli@fastmail.fm>"
RUN gpg --keyserver pool.sks-keyservers.net --recv-keys 7937DFD2AB06298B2293C3187D33FF9D0246406D 114F43EE0176B71C7BC219DD50A3051F888C628D

ENV NODE_VERSION 0.10.36
ENV NPM_VERSION 2.5.0

RUN curl -SLO "http://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.gz" \
	&& curl -SLO "http://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
	&& gpg --verify SHASUMS256.txt.asc \
	&& grep " node-v$NODE_VERSION-linux-x64.tar.gz\$" SHASUMS256.txt.asc | sha256sum -c - \
	&& tar -xzf "node-v$NODE_VERSION-linux-x64.tar.gz" -C /usr --strip-components=1 \
	&& rm "node-v$NODE_VERSION-linux-x64.tar.gz" SHASUMS256.txt.asc \
	&& npm install -g npm@"$NPM_VERSION" \
	&& npm cache clear

# NC & ZIP
RUN apt-get update && apt-get install -y netcat zip unzip --no-install-recommends

ADD timezone.ini /usr/local/etc/php/conf.d/
ADD memory_limit.ini /usr/local/etc/php/conf.d/
ADD errors.ini /usr/local/etc/php/conf.d/

COPY php-fpm.conf /usr/local/etc/

# LDAPS - Ignore invalid TLS certs
RUN echo 'TLS_REQCERT never' >> /etc/ldap/ldap.conf

VOLUME /var/www

WORKDIR /var/www
