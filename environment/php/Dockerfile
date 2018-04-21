FROM php:7.2-fpm

RUN apt-get update
RUN apt-get install -y libpng-dev git \
    libgearman-dev mysql-client libmagickwand-dev \
    imagemagick libgearman-dev --no-install-recommends

RUN pecl install imagick

RUN docker-php-ext-enable imagick \
   && docker-php-ext-install pdo_mysql zip exif gd

RUN cd /tmp \
    && git clone https://github.com/wcgallego/pecl-gearman.git \
    && cd pecl-gearman \
    && git checkout gearman-2.0.3 \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && rm -r /tmp/pecl-gearman \
    && docker-php-ext-enable gearman

# startup
WORKDIR /var/www/html

COPY ./docker-entrypoint /usr/local/bin/
RUN ln -s /usr/local/bin/docker-entrypoint / && chmod +x /docker-entrypoint

COPY ./startup.sh /usr/local/bin/startup
RUN ln -s /usr/local/bin/startup / && chmod +x /startup

# composer
RUN curl -s -f -L -o /tmp/installer.php 'https://getcomposer.org/installer' \
    && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
