FROM alexcheng/magento2:latest

# this script is for testing and development purposes only

WORKDIR /var/www/html

ARG ASSETS_DOMAIN
ARG APP_URL
ARG ETL_URL

ENV ASSETS_DOMAIN=$ASSETS_DOMAIN
ENV APP_URL=$APP_URL
ENV ETL_URL=$ETL_URL

RUN apt-get update && apt-get install -y mysql-client

COPY ./config/docker/* /springbot/

RUN su www-data -s /bin/bash -c 'composer require springbot/magento2-plugin'

RUN chmod +x /springbot/*.sh

