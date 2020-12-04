FROM alexcheng/magento2:latest

# this script is for testing and development purposes only

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y default-mysql-client

COPY ./config/docker/* /springbot/

RUN chmod +x /springbot/*.sh

RUN su www-data -s /bin/bash -c 'composer require springbot/magento2-plugin'
