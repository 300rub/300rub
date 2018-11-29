FROM ss/instance-full

RUN echo $PWD

ADD /var/www/code/config/dev/nginx/.htpasswd /etc/nginx/
COPY /var/www/code/config/dev/nginx/nginx.conf /etc/nginx/

COPY config.ini /etc/php/7.2/fpm/conf.d/
COPY php-fpm.conf /etc/php/7.2/fpm/

COPY docker-entrypoint.sh /usr/local/bin/
CMD ["docker-entrypoint.sh"]
