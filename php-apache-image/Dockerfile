# Dockerfile for building PHP Apache image with
# PDO will be installed 
# Added REDIS install

FROM php:apache
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql

ADD ../app /var/www/html
