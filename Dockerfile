FROM php:8.2-apache

# Habilitar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar todo o site para o Apache
COPY . /var/www/html/

# Dar permissão ao diretório do Apache
RUN chown -R www-data:www-data /var/www/html
