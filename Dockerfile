FROM php:7.4-fpm

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
#RUN usermod -a -G root www


# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

RUN apt-get update && apt-get install -y apt-utils

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    zlib1g-dev \
    libzip-dev \
    iputils-ping \
    nmap \
    libmcrypt-dev \
    lynx \
    libxml2-dev

RUN pecl install mcrypt-1.0.1

RUN apt-get update

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

#RUN chmod uga+x /usr/local/bin/ins tall-php-extensions && sync && install-php-extensions gd xdebug

RUN apt-get install -y autoconf pkg-config libssl-dev
RUN pecl install mongodb
#RUN pecl install mongodb-1.5.3
RUN docker-php-ext-install bcmath
RUN chmod 777 /usr/local/etc/php/conf.d
RUN docker-php-ext-enable mongodb


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-enable mcrypt
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install soap

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN echo "extension=pdo_mysql.so" >> /usr/local/etc/php/conf.d/pdo_mysql.ini

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN chown -R www:www /var/www

# Change current user to root
USER root

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
