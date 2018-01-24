FROM ubuntu:16.04

LABEL maintainer "kunze@earthlinginteractive.com"

RUN apt-get update && apt-get install -y python-software-properties wget curl git zip vim netcat supervisor cron rsyslog apache2 php libapache2-mod-php php-mysql php-dom php-simplexml php-curl php-intl php-xsl php-mbstring php-zip php-xml composer php-gd php-mcrypt php-redis && a2enmod rewrite remoteip;

ADD vhost /etc/apache2/sites-enabled/000-default.conf
ADD httpd-foreground /bin/httpd-foreground
ADD entrypoint.sh /entrypoint.sh

RUN wget -q 'https://getcomposer.org/installer' -O - | php; \
    mv composer.phar /usr/local/bin/composer;

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer install -d=/var/www/fssk-laravel

EXPOSE 80

CMD ["httpd-foreground"]
