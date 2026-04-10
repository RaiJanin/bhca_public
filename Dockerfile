FROM php:7.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-install mysqli zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working dir
WORKDIR /var/www/html

# Copy project
COPY . /var/www/html/

# Create sessions directory
RUN mkdir -p /var/www/html/application/cache/sessions

# Set permissions (CRITICAL)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/application/cache

# Allow .htaccess overrides
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>" >> /etc/apache2/apache2.conf

# Set PHP session path (fallback)
RUN echo "session.save_path = \"/var/www/html/application/cache/sessions\"" \
    > /usr/local/etc/php/conf.d/session.ini