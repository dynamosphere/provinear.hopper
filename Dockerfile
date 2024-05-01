FROM php:8.0-fpm

# Copy application files
COPY . /var/www/html

# Image config
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV DB_CONNECTION sqlite
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install additional PHP extensions if needed
# For example, if your Laravel app requires additional extensions:
# RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change working directory
WORKDIR /var/www/html

# Run Composer install
RUN composer install --no-dev --optimize-autoloader

CMD ["/start.sh"]
