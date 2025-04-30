
FROM php:apache


WORKDIR /var/www/html


RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer


COPY ./negocio/composer.json .
COPY ./negocio/src /var/www/html/src
COPY ./negocio/public /var/www/html/public

RUN apt-get update && apt-get install -y zip && \
apt-get update && apt-get install -y git



RUN composer install


RUN composer dump-autoload

RUN sed -i 's/DocumentRoot.*$/DocumentRoot \/var\/www\/html\/public/' /etc/apache2/sites-enabled/000-default.conf
