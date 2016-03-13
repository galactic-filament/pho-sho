FROM php

EXPOSE 80

# php
RUN apt-get update -q \
  && apt-get install -yq wget git zlib1g-dev libpq-dev netcat \
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
RUN composer config -g github-oauth.github.com 9ab3e221b5267e45a22f9ab3067df8076653e094 \
  && composer install -q

CMD ["php", "-S", "0.0.0.0:80", "-t", "web", "web/index.php"]
