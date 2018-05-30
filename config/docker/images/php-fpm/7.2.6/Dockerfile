FROM bitnami/php-fpm:7.2.6

# Source list update
ADD sources.list /etc/apt/
RUN apt-get update

# Ant
RUN apt-get install -y --force-yes --no-install-recommends --fix-missing ant

# Tools
RUN apt-get install -y --force-yes --no-install-recommends --fix-missing curl unzip less



RUN apt-get install -y --force-yes --no-install-recommends --fix-missing php-memcached

RUN php-fpm restart

# Install base packages
#RUN export http_proxy=$PROXY
#RUN export https_proxy=$PROXY
#COPY docker-php-ext-* /usr/local/bin/
#RUN	 chmod ogu+x /usr/local/bin/docker-php-ext-*

# Memcached extensions
#RUN cd /opt/bitnami/php \
#	&& curl -SLO https://github.com/php-memcached-dev/php-memcached/archive/php7.zip \
#	&& unzip php7.zip \
#	&& mv php-memcached-php7 /opt/bitnami/php/include/php/ext \
#	&& rm /opt/bitnami/php/php7.zip
#	&& docker-php-ext-configure memcached \
#	&& docker-php-ext-install memcached \
#	&& updatedb