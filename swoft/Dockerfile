# @description php image base on the debian 9.x
#
#                       Some Information
# ------------------------------------------------------------------------------------
# @link https://hub.docker.com/_/debian/      alpine image
# @link https://hub.docker.com/_/php/         php image
# @link https://github.com/docker-library/php php dockerfiles
# @see https://github.com/docker-library/php/tree/master/7.2/stretch/cli/Dockerfile
# ------------------------------------------------------------------------------------
# @build-example docker build . -f Dockerfile -t swoft/swoft
#
FROM php:7.4

# --build-arg timezone=Asia/Shanghai
ARG timezone
# app env: prod pre test dev
ARG app_env=test
# default use www-data user
ARG work_user=www-data

ENV APP_ENV=${app_env:-"test"} \
    TIMEZONE=${timezone:-"Asia/Taipei"} \
    PHPREDIS_VERSION=4.3.0 \
    SWOOLE_VERSION=4.5.2 \
    COMPOSER_ALLOW_SUPERUSER=1

# Libs -y --no-install-recommends
RUN apt-get update \
    && apt-get install -y \
        curl wget git zip unzip less vim procps lsof tcpdump htop openssl apt-utils automake libtool \
        libz-dev \
        libssl-dev \
        libnghttp2-dev \
        libpcre3-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
# Install oniguruma 
    && wget https://github.com/kkos/oniguruma/archive/v6.9.5.tar.gz -O oniguruma-6.9.5.tar.gz  \
    && tar -zxvf oniguruma-6.9.5.tar.gz \
    && ( \
        cd oniguruma-6.9.5 \
        && ./autogen.sh && ./configure \
        && make && make install \
    ) \
    && rm oniguruma-6.9.5.tar.gz && rm -r oniguruma-6.9.5 \
# Install libzip 
    && wget https://nih.at/libzip/libzip-1.2.0.tar.gz -O libzip-1.2.0.tar.gz  \
    && tar -zxvf libzip-1.2.0.tar.gz \
    && ( \
        cd libzip-1.2.0 \
        && ./configure \
        && make && make install \
    ) \
    && export PKG_CONFIG_PATH="/usr/local/lib/pkgconfig/" \
    && rm libzip-1.2.0.tar.gz && rm -r libzip-1.2.0 \
# Install PHP extensions
    && docker-php-ext-install \
       bcmath gd pdo_mysql mbstring sockets zip sysvmsg sysvsem sysvshm

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups \
# 如果是中国区，加上这个国内源
    # && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ \

# Install redis extension
    && wget http://pecl.php.net/get/redis-${PHPREDIS_VERSION}.tgz -O /tmp/redis.tar.tgz \
    && pecl install /tmp/redis.tar.tgz \
    && rm -rf /tmp/redis.tar.tgz \
    && docker-php-ext-enable redis \
# Install swoole extension
    && wget https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
        cd swoole \
        && phpize \
        && ./configure --enable-mysqlnd --enable-sockets --enable-openssl --enable-http2 \
        && make -j$(nproc) \
        && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole \
# Clear dev deps
    && apt-get clean \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
# Timezone
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && echo "[Date]\ndate.timezone=${TIMEZONE}" > /usr/local/etc/php/conf.d/timezone.ini

# Install composer deps
# ADD . /var/www/swoft
# RUN  cd /var/www/swoft \
#     && composer install \
#     && composer clearcache

WORKDIR /var/www/swoft
EXPOSE 18306 18307 18308

# ENTRYPOINT ["php", "/var/www/swoft/bin/swoft", "http:start"]
# CMD ["php", "/var/www/swoft/bin/swoft", "http:start"]
CMD ["php", "-S", "127.0.0.1:13333"]