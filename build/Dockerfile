# Dockerfile for build image
FROM ubuntu:20.04
RUN apt update
RUN DEBIAN_FRONTEND=noninteractive TZ=Europe/Moscow apt-get -y install tzdata
RUN apt install mc net-tools nginx php-common php-fpm php-ldap php php-opcache php-xml php-xmlreader php-xmlwriter php-gd php-json php-gmp php-zip php-iconv php-intl php-mbstring -y
# change TZ to your needs
#RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
WORKDIR /
ADD start.sh /
RUN chmod +x /start.sh
COPY ./addressbook /var/www/html/
COPY ./etc /etc/
#COPY ./usr/share/ldap-account-manager/config /etc/ldap-account-manager/config
# uncomment to append your ca cert for TLS connections i.e. LDAPS, place crt file in folder with Dockerfile
#COPY ca.crt /usr/local/share/ca-certificates/ca.crt
#RUN cat /usr/local/share/ca-certificates/ca.crt >> /etc/ssl/certs/ca-certificates.crt
STOPSIGNAL SIGTERM
CMD ["/start.sh"]