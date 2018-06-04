FROM ss/php-fpm:7.2.6

ADD config.ini /opt/bitnami/php/etc/conf.d/
COPY php-fpm.conf /opt/bitnami/php/etc/

COPY docker-entrypoint.sh /usr/local/bin/
CMD ["docker-entrypoint.sh"]
