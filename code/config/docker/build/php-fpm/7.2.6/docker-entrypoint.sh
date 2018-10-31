#!/bin/bash

mkdir -p -m 0777 /var/www/logs
mkdir -p -m 0777 /var/www/backups

env | sed "s/\(.*\)=\(.*\)/env[\1]='\2'/" >> /etc/php/7.2/fpm/php-fpm.conf

service php7.2-fpm start

node

tail -f /dev/null
