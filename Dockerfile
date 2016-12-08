FROM php

EXPOSE 8080

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

# add user
ENV APP_USER pho-sho
RUN useradd -ms /bin/bash $APP_USER
USER $APP_USER

# add app dir
ENV APP_DIR /home/$APP_USER/app
RUN mkdir $APP_DIR
RUN mkdir $APP_DIR/log
COPY ./app $APP_DIR
WORKDIR $APP_DIR

# install deps
RUN composer config -g github-oauth.github.com 9ab3e221b5267e45a22f9ab3067df8076653e094 \
  && composer install -q

CMD ["php", "-S", "0.0.0.0:8080", "-t", "web", "./web/index.php"]
