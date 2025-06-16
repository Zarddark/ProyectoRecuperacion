# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Copia los archivos del proyecto al directorio raíz de Apache
COPY public/ /var/www/html/
COPY src/ /var/www/src/
COPY data/ /var/www/data/

# Dar permisos de escritura a Apache en /var/www/data
RUN chown -R www-data:www-data /var/www/data && chmod -R 775 /var/www/data

# Establece la raíz del sitio
WORKDIR /var/www/html

# Expone el puerto 8080
EXPOSE 8080

# Cambiar el puerto que usa Apache (por defecto es 80 → ahora 8080)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf && \
    sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf
