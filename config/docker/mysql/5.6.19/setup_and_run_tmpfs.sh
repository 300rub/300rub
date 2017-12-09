#!/bin/bash
set -eu

TIMEZONE=${TIMEZONE:-"America/New_York"}
MYSQLD_RAM_SIZE=${MYSQLD_RAM_SIZE:-"256"}
MYSQLD_ARGS=${MYSQLD_ARGS:-"--skip-name-resolve --skip-host-cache"}
MYSQL_SQL_TO_RUN=${MYSQL_SQL_TO_RUN:-"GRANT ALL ON \`%_test\`.* TO testrunner@'%' IDENTIFIED BY 'testrunner';"}

echo "Setting timezone to ${TIMEZONE}."
ln -sf "/usr/share/zoneinfo/${TIMEZONE}" /etc/localtime

echo "Mounting MySQL with ${MYSQLD_RAM_SIZE}MB of RAM."
if [[ ! -d /var/lib/mysql_template ]]; then
	mv /var/lib/mysql /var/lib/mysql_template
	mkdir /var/lib/mysql
fi
mount -t tmpfs -o size="${MYSQLD_RAM_SIZE}m" tmpfs /var/lib/mysql
cp -a /var/lib/mysql_template/* /var/lib/mysql/

tfile=`mktemp`
if [[ ! -f "$tfile" ]]; then
    return 1
fi

cat << EOF > $tfile
FLUSH PRIVILEGES;
$MYSQL_SQL_TO_RUN
EOF

/usr/sbin/mysqld --bootstrap --verbose=0 $MYSQLD_ARGS < $tfile
rm -f $tfile

exec /usr/sbin/mysqld $MYSQLD_ARGS