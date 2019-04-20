#!/bin/sh

su www-data -s /bin/bash -c 'php bin/magento module:enable Springbot_Queue'
su www-data -s /bin/bash -c 'php bin/magento module:enable Springbot_Main'
su www-data -s /bin/bash -c 'php bin/magento setup:upgrade'
su www-data -s /bin/bash -c 'php bin/magento cache:clean'
