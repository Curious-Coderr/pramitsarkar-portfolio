FROM php:8.2-apache

RUN a2enmod rewrite expires

COPY . /var/www/html/

# Allow .htaccess overrides (pretty URLs, caching)
RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Render provides $PORT; make Apache listen on it (defaults to 80 locally)
ENV PORT=80
RUN sed -ri -e 's!Listen 80!Listen ${PORT}!g' /etc/apache2/ports.conf \
 && sed -ri -e 's!:80>!:${PORT}>!g' /etc/apache2/sites-available/000-default.conf

EXPOSE ${PORT}

CMD ["sh", "-c", "sed -ri \"s!Listen [0-9]+!Listen ${PORT}!g\" /etc/apache2/ports.conf; sed -ri \"s!:[0-9]+>!:${PORT}>!g\" /etc/apache2/sites-available/000-default.conf; apache2-foreground"]
