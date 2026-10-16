FROM php:8.2-apache

# 최신 Debian Bookworm 기반 (안정적, 최신 보안)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache 설정 (AllowOverride 활성화)
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# PHP 설정 (short_open_tag 활성화, 에러 리포팅 조정, UTF-8 기본 문자셋, 공통 부트스트랩)
RUN echo "short_open_tag = On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "default_charset = \"UTF-8\"" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "auto_prepend_file = /var/www/html/config/bootstrap.php" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_errors = Off" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "date.timezone = Asia/Seoul" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
