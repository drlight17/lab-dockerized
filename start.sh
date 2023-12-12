#!/bin/bash


apt-get install -y locales && \
    sed -i -e "s/# $LANG.*/$LANG UTF-8/" /etc/locale.gen && \
    dpkg-reconfigure --frontend=noninteractive locales && \
    update-locale LANG=$LANG

sed -i 's/location \/lab/location \/'${LAB_NGINX_PATH}'/g' /etc/nginx/sites-available/default
if [ ! -z "$LAB_NGINX_PATH" ]; then
    sed -i 's/root/alias/g' /etc/nginx/sites-available/default
fi
sed -i 's/server_name _placeholder_/server_name '${LAB_HOSTNAME}'/g' /etc/nginx/sites-available/default
sed -i 's/listen 8080/listen '${LAB_LISTEN_PORT}'/g' /etc/nginx/sites-available/default
sed -i 's/listen \[\:\:\]\:8080/listen \[\:\:\]\:'${LAB_LISTEN_PORT}'/g' /etc/nginx/sites-available/default
service php7.4-fpm start
nginx -g "daemon off;"
