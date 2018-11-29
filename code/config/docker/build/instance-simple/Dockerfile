FROM ss/instance-full

COPY nginx/nginx.conf /etc/nginx/

COPY php/config.ini /etc/php/7.2/fpm/conf.d/
COPY php/php-fpm.conf /etc/php/7.2/fpm/

COPY docker-entrypoint.sh /usr/local/bin/
CMD ["docker-entrypoint.sh"]
