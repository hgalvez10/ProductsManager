FROM php:7.2.6-apache-stretch 
RUN apt-get update -y && apt-get install -y openssl zip unzip vim git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo mbstring

# Apache config for Lumen 
COPY Apache-lumen.conf /etc/apache2/sites-available/lumen.conf 
RUN a2dissite 000-default.conf && a2ensite lumen.conf && a2enmod rewrite

WORKDIR /var/www/html

COPY composer.json composer.lock /var/www/html/
RUN composer install --dev
COPY . /var/www/html/

RUN chown -R www-data:www-data vendor 
RUN chown -R www-data:www-data storage