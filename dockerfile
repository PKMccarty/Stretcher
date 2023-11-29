# Use an official PHP runtime as a parent image
FROM php:8.3-fpm

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install Nginx
RUN apt-get update && apt-get install -y nginx

# Remove the default Nginx configuration file
RUN rm /etc/nginx/sites-available/default
RUN rm /etc/nginx/sites-enabled/default

# Copy your Nginx configuration file from docker/nginx/conf.d
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Install PDO and the MySQL extension for PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copy your custom php.ini file
COPY docker/php/php.ini /usr/local/etc/php/php.ini

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variable
ENV NAME World

# Run PHP-FPM and Nginx when the container launches
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
