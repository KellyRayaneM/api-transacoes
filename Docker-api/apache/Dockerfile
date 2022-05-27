ARG APACHE_VERSION
FROM httpd:$APACHE_VERSION-alpine

RUN apk update; \
    apk upgrade;

RUN apk add \
  bash \
  apache2 \
  curl \
  git \
  php8 \
  php8-json \
  php8-iconv \
  openssl \
  #ftp \
  php8-xdebug \
  #mcrypt \
  #mbstring \
  php8-soap \
  #gmp \
  #pdo_odbc \
  #dom \
  #pdo \
  #zip \
  #mysqli \
  #sqlite3 \
  #bcmath \
  #gd \
  #odbc \
  php8-pdo_mysql;
  #pdo_sqlite \
  #gettext \
  #xmlreader \
  #xmlwriter \
  #tokenizer \
  #xmlrpc \
  #bz2 \
  #pdo_dblib \
  #ctype \
  #session
  #exif;

RUN sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /usr/local/apache2/conf/httpd.conf;

# COPY .bashrc /root/.bashrc

# Copy apache vhost file to proxy php requests to php-fpm container
COPY demo.apache.conf /usr/local/apache2/conf/demo.apache.conf
RUN echo "Include /usr/local/apache2/conf/demo.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf
