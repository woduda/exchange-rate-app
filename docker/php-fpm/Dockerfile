FROM php:7.4-fpm-alpine
RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql bcmath
WORKDIR /var/www
CMD php-fpm
EXPOSE 9000
