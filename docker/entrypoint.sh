#!/bin/sh

if [ ! -f "/var/installed" ]; then

    sleep 60

    mysql -h mysql -u root -e "DROP DATABASE IF EXISTS magento2;"
    mysql -h mysql -u root -e "CREATE DATABASE magento2;"
    mysql -h mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'springbot'@'%'; FLUSH PRIVILEGES;"

    touch /var/installed

fi

exec /sbin/my_init