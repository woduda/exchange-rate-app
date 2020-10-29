FROM php:7.4-cli-alpine
RUN apk --update --no-cache add yarn
RUN docker-php-ext-install pdo_mysql bcmath
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
