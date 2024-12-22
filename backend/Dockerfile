
FROM php:8.3-fpm as php

# Install additional dependencies
RUN apt-get update && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN pecl install -o -f xdebug-3.4.0 \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear

# Set working directory
WORKDIR /var/www/backend

# Copy the application code
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# ENV PORT=8000
EXPOSE 9000
ENTRYPOINT [ "Docker/entrypoint.sh" ]
CMD ["php-fpm"]



