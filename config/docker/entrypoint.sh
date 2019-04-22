#!/bin/sh

# this script is for testing and development purposes only

if [ ! -f "/var/installed" ]; then

    # the install script needs the webserver to be running, so run it in the background
    /springbot/docker-install.sh &

fi

# run the webserver
/sbin/my_init