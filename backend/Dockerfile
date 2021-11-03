FROM php:7.4-fpm

COPY composer.lock composer.json /var/www/

RUN apt-get update && apt-get install -y libpq-dev \
    libonig-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    webp \
    libwebp-dev \
    libfreetype6-dev \
    libgmp-dev \
    zlib1g-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    zip

RUN docker-php-ext-install pdo_pgsql mbstring bcmath
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install gd
RUN docker-php-ext-configure gmp
RUN docker-php-ext-install gmp
RUN docker-php-ext-install zip
RUN docker-php-ext-install curl



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Permission quirks
RUN chown -R 1000:1000 /var/www

# RUN composer i


# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
