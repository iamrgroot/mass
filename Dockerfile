FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG uid

RUN echo $uid

USER root

# Install system dependencies
RUN apt-get update > /dev/null && \
    apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmagickwand-dev \
    > /dev/null

# Install Imagick
RUN pecl install imagick > /dev/null || echo "^"

# Clear cache
RUN apt-get clean > /dev/null && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    > /dev/null

# Enable Imagick
RUN docker-php-ext-enable imagick > /dev/null

# Get latest Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer > /dev/null

# Install Node.js
RUN curl --silent --location https://deb.nodesource.com/setup_14.x | bash - > /dev/null
RUN apt-get install --yes nodejs build-essential > /dev/null

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/mass mass || echo ""
RUN mkdir -p /home/mass/.composer || echo ""
RUN chown -R mass:mass /home/mass || echo ""

# Set working directory
WORKDIR /var/www

USER mass