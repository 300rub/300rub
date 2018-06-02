FROM bitnami/minideb-runtimes:jessie-php

# Install required system packages and dependencies
RUN install_packages ca-certificates libbz2-1.0 libc6 libcomerr2 libcurl3 libffi6 libfreetype6 libgcc1 libgcrypt20 libgmp10 libgnutls-deb0-28 libgpg-error0 libgssapi-krb5-2 libhogweed2 libicu52 libidn11 libjpeg62-turbo libk5crypto3 libkeyutils1 libkrb5-3 libkrb5support0 libldap-2.4-2 liblzma5 libncurses5 libnettle4 libp11-kit0 libpng12-0 libpq5 libreadline6 librtmp1 libsasl2-2 libssh2-1 libssl1.0.0 libstdc++6 libsybdb5 libtasn1-6 libtidy-0.99-0 libtinfo5 libxml2 libxslt1.1 wget zlib1g
RUN wget -nc -P /tmp/bitnami/pkg/cache/ https://downloads.bitnami.com/files/stacksmith/php-7.2.6-4-linux-x64-debian-8.tar.gz && \
    echo "574d31facf028f57d4bdb72b143e8b335d9ed179e0c433ebf1449f87df3997c9  /tmp/bitnami/pkg/cache/php-7.2.6-4-linux-x64-debian-8.tar.gz" | sha256sum -c - && \
    tar -zxf /tmp/bitnami/pkg/cache/php-7.2.6-4-linux-x64-debian-8.tar.gz -P --transform 's|^[^/]*/files|/opt/bitnami|' --wildcards '*/files' && \
    rm -rf /tmp/bitnami/pkg/cache/php-7.2.6-4-linux-x64-debian-8.tar.gz
RUN mkdir -p /bitnami && ln -sf /bitnami/php /bitnami/php-fpm
RUN mkdir /opt/bitnami/php/logs && touch /opt/bitnami/php/logs/php-fpm.log

ENV BITNAMI_APP_NAME="php-fpm" \
    BITNAMI_IMAGE_VERSION="7.2.6-r8" \
    PATH="/opt/bitnami/php/bin:/opt/bitnami/php/sbin:$PATH"

EXPOSE 9000

# Source list update
ADD sources.list /etc/apt/
RUN apt-get update

# Ant
RUN apt-get install -y --force-yes --no-install-recommends --fix-missing ant

# Tools
RUN apt-get install -y --force-yes --no-install-recommends --fix-missing curl unzip less

# Memcached
RUN apt-get install -y --force-yes --no-install-recommends --fix-missing php-memcached

WORKDIR /app
CMD ["php-fpm","-F","--pid","/opt/bitnami/php/tmp/php-fpm.pid","-y","/opt/bitnami/php/etc/php-fpm.conf"]




#echo '<?php ini_set('error_reporting', E_ALL); ini_set('display_errors', 'On'); echo \Memcached::RES_SUCCESS; ?>' > /var/www/infophp.php;  php -f /var/www/infophp.php;



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