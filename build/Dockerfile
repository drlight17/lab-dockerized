# Dockerfile for build image
FROM ubuntu:24.04
ENV DEBIAN_FRONTEND=noninteractive

RUN sed -i 's|http://ubuntu.com|https://mirror.yandex.ru/ubuntu|g; s|http://ubuntu.com|https://mirror.yandex.ru/ubuntu|g' /etc/apt/sources.list.d/ubuntu.sources \
    && apt-get update && apt-get install -y --no-install-recommends \
    locales \
    ca-certificates \
    tzdata \
    nginx \
    supervisor \
    && echo "deb [trusted=yes] https://mirror.yandex.ru/mirrors/launchpad/ondrej/php/ noble main" \
       > /etc/apt/sources.list.d/ondrej-php.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    php7.4 \
    php7.4-fpm \
    php7.4-ldap \
    php7.4-opcache \
    php7.4-gettext \
    php7.4-xml \
    php7.4-gd \
    php7.4-json \
    php7.4-gmp \
    php7.4-zip \
    php7.4-iconv \
    php7.4-intl \
    php7.4-mbstring \
    && ln -sf /usr/sbin/php-fpm7.4 /usr/sbin/php-fpm \
    && mkdir -p /run/php \
    && sed -i 's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
    && sed -i 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen \
    && rm -rf /var/lib/apt/lists/*

# change TZ to your needs
RUN ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime && echo "Europe/Moscow" > /etc/timezone
WORKDIR /
ADD start.sh /
RUN chmod +x /start.sh
COPY ./addressbook /var/www/html/
COPY ./etc /etc/

RUN printf "session.upload_progress.enabled = 0\n" > /etc/php/7.4/fpm/conf.d/99-security.ini \
    && printf "session.upload_progress.enabled = 0\n" > /etc/php/7.4/cli/conf.d/99-security.ini

# uncomment to append your ca cert for TLS connections i.e. LDAPS, place crt file in folder with Dockerfile
#COPY ca.crt /usr/local/share/ca-certificates/ca.crt
#RUN cat /usr/local/share/ca-certificates/ca.crt >> /etc/ssl/certs/ca-certificates.crt
STOPSIGNAL SIGTERM
CMD ["/start.sh"]
