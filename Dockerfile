FROM php

EXPOSE 80
ENV APP_PORT 80

# php
RUN apt-get update -q \
  && apt-get install -yq wget git zlib1g-dev libpq-dev \
  && docker-php-ext-install zip pdo_pgsql

# composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/bin --filename=composer

# add app dir
ENV APP_DIR /srv/app
COPY ./app $APP_DIR
WORKDIR $APP_DIR

# add log dir
ENV APP_LOG_DIR /srv/app/log
VOLUME $APP_LOG_DIR

# install deps
RUN composer config -g github-oauth.github.com 9ab3e221b5267e45a22f9ab3067df8076653e094 \
  && composer install -q

CMD ["./bin/run-app"]
