#!/bin/bash

env | sed "s/\(.*\)=\(.*\)/env[\1]='\2'/" >> /etc/php/7.2/fpm/php-fpm.conf

service php7.2-fpm start
service nginx start

tail -f /dev/null
