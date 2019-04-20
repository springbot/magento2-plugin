FROM alexcheng/magento2:latest

WORKDIR /var/www/html

COPY ./config/docker/docker-install.sh /springbot/docker-install.sh

RUN su www-data -s /bin/bash -c 'composer require springbot/magento2-plugin'

RUN chmod +x /springbot/*.sh

