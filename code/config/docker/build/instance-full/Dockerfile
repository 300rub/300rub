FROM ss/instance-full

ADD .htpasswd /etc/nginx/
ADD nginx.conf /etc/nginx/

ADD config.ini /etc/php/7.2/fpm/conf.d/
COPY php-fpm.conf /etc/php/7.2/fpm/

COPY docker-entrypoint.sh /usr/local/bin/
CMD ["docker-entrypoint.sh"]
