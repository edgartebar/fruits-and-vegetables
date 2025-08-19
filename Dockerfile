FROM php:8.3-apache

SHELL ["/bin/bash", "-ec"]

RUN apt-get update && apt-get install -y \
    git \
    curl \
    vim \
    unzip \
    libssh-dev

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

COPY . /var/www/html/

WORKDIR /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir -p /var/www/html/var

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/var

EXPOSE 80

CMD ["apache2-foreground"]