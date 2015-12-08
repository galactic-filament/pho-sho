FROM php

EXPOSE 80

# php
RUN apt-get update -q \
  && apt-get install -yq wget git zlib1g-dev libpq-dev \
  && docker-php-ext-install zip pdo_pgsql

# phpunit
RUN wget -P /tmp https://phar.phpunit.de/phpunit.phar \
  && chmod +x /tmp/phpunit.phar \
  && mv /tmp/phpunit.phar /usr/bin/phpunit

# composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/bin --filename=composer

COPY ./app /srv/app
WORKDIR /srv/app
RUN composer install

CMD ["php", "-S", "0.0.0.0:80", "-t", "web", "web/index.php"]
