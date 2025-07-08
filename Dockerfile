FROM php:7.3-apache

RUN apt-get update && apt-get install -y \
	libpng-dev \
	libjpeg-dev \
	libfreetype6-dev \
	libonig-dev \
	libzip-dev \
	zip \
	unzip \
	&& docker-php-ext-install mysqli mbstring zip gd

COPY ./www /var/www/html
