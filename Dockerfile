FROM php:7.3-apache
RUN apt-get update && \ 
	docker-php-ext-install mysqli pdo_mysql && \
	a2enmod rewrite && \
	sed -i 's/DocumentRoot.*$/DocumentRoot \/var\/www\/html\/public/' /etc/apache2/sites-enabled/000-default.conf