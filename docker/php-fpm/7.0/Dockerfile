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

# Node install

RUN groupadd --gid 1000 node \
  && useradd --uid 1000 --gid node --shell /bin/bash --create-home node

# gpg keys listed at https://github.com/nodejs/node#release-team
RUN set -ex \
  && for key in \
    94AE36675C464D64BAFA68DD7434390BDBE9B9C5 \
    FD3A5288F042B6850C66B31F09FE44734EB7990E \
    71DCFD284A79C3B38668286BC97EC7A07EDE3FC1 \
    DD8F2338BAE7501E3DD5AC78C273792F7D83545D \
    C4F0DFFF4E8C1A8236409D08E73BC641CC11F4C8 \
    B9AE9905FFD7803F25714661B63B535A4C206CA9 \
    56730D5401028683275BD23C23EFEFE93C4CFFFE \
    77984A986EBC2AA786BC0F66B01FBB92821C587A \
  ; do \
    gpg --keyserver pgp.mit.edu --recv-keys "$key" || \
    gpg --keyserver keyserver.pgp.com --recv-keys "$key" || \
    gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key" ; \
  done

ENV NODE_VERSION 9.2.1

RUN ARCH= && dpkgArch="$(dpkg --print-architecture)" \
  && case "${dpkgArch##*-}" in \
    amd64) ARCH='x64';; \
    ppc64el) ARCH='ppc64le';; \
    s390x) ARCH='s390x';; \
    arm64) ARCH='arm64';; \
    armhf) ARCH='armv7l';; \
    i386) ARCH='x86';; \
    *) echo "unsupported architecture"; exit 1 ;; \
  esac \
  && curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-$ARCH.tar.xz" \
  && curl -SLO --compressed "https://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
  && gpg --batch --decrypt --output SHASUMS256.txt SHASUMS256.txt.asc \
  && grep " node-v$NODE_VERSION-linux-$ARCH.tar.xz\$" SHASUMS256.txt | sha256sum -c - \
  && tar -xJf "node-v$NODE_VERSION-linux-$ARCH.tar.xz" -C /usr/local --strip-components=1 --no-same-owner \
  && rm "node-v$NODE_VERSION-linux-$ARCH.tar.xz" SHASUMS256.txt.asc SHASUMS256.txt \
  && ln -s /usr/local/bin/node /usr/local/bin/nodejs

ENV YARN_VERSION 1.3.2

RUN set -ex \
  && for key in \
    6A010C5166006599AA17F08146C2130DFD2497F5 \
  ; do \
    gpg --keyserver pgp.mit.edu --recv-keys "$key" || \
    gpg --keyserver keyserver.pgp.com --recv-keys "$key" || \
    gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key" ; \
  done \
  && curl -fSLO --compressed "https://yarnpkg.com/downloads/$YARN_VERSION/yarn-v$YARN_VERSION.tar.gz" \
  && curl -fSLO --compressed "https://yarnpkg.com/downloads/$YARN_VERSION/yarn-v$YARN_VERSION.tar.gz.asc" \
  && gpg --batch --verify yarn-v$YARN_VERSION.tar.gz.asc yarn-v$YARN_VERSION.tar.gz \
  && mkdir -p /opt/yarn \
  && tar -xzf yarn-v$YARN_VERSION.tar.gz -C /opt/yarn --strip-components=1 \
  && ln -s /opt/yarn/bin/yarn /usr/local/bin/yarn \
  && ln -s /opt/yarn/bin/yarn /usr/local/bin/yarnpkg \
  && rm yarn-v$YARN_VERSION.tar.gz.asc yarn-v$YARN_VERSION.tar.gz

# Install less-compiler
RUN npm install -g \
    less \
    lesshint \
    uglify-js \
    uglifycss

CMD [ "node" ]

# Jshint
RUN npm install -g jshint