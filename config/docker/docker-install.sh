#!/bin/sh

# this script is for testing and development purposes only

# wait for mysql server to become available
while ! mysqladmin ping -h"mysql" --silent; do
    echo "waiting for mysql to become available.."
    sleep 5
done

# create the database
mysql -h mysql -u root -e "CREATE DATABASE magento2;"
mysql -h mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'springbot'@'%'; FLUSH PRIVILEGES;"

# install magento and sample data
install-magento
install-sampledata

# enable our plugin and clean the cache
su www-data -s /bin/bash -c 'php bin/magento module:enable Springbot_Queue'
su www-data -s /bin/bash -c 'php bin/magento module:enable Springbot_Main'
su www-data -s /bin/bash -c 'php bin/magento setup:upgrade'
su www-data -s /bin/bash -c 'php bin/magento cache:clean'

# Override the default plugin settings to point to our docker hosts
mysql -h mysql -uspringbot -ppassword magento2 -e "INSERT INTO core_config_data (config_id, scope, scope_id, path, value) VALUES (NULL , 'default', '0', 'springbot/configuration/assets_domain', '$ASSETS_DOMAIN');"
mysql -h mysql -uspringbot -ppassword magento2 -e "INSERT INTO core_config_data (config_id, scope, scope_id, path, value) VALUES (NULL , 'default', '0', 'springbot/configuration/app_url', '$APP_URL');"
mysql -h mysql -uspringbot -ppassword magento2 -e "INSERT INTO core_config_data (config_id, scope, scope_id, path, value) VALUES (NULL , 'default', '0', 'springbot/configuration/api_url', '$ETL_URL');"

touch /var/installed
