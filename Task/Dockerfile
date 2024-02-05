FROM ubuntu:latest

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql mysql-client && \
    apt-get install -y php-mysqli && \
    apt-get install -y mysql-server

# Start MySQL service
RUN service mysql start

WORKDIR /var/www/html

COPY inc/dbcon.php /var/www/html/inc/
COPY uploads/ /var/www/html/uploads/
COPY users/*.php /var/www/html/users/

COPY crud.sql /var/www/html/

RUN a2enmod rewrite
RUN a2enmod headers

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/users|' /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY crud.sql /docker-entrypoint-initdb.d/

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]
