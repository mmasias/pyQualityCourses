FROM php:5.6-apache

# Instalar dependencias para mysql extension
RUN docker-php-ext-install mysql mysqli pdo_mysql

# Activar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    echo "AddDefaultCharset ISO-8859-1" >> /etc/apache2/apache2.conf

# Configurar PHP para forzar ISO-8859-1 y ocultar warnings
RUN echo "default_charset = 'ISO-8859-1'" > /usr/local/etc/php/php.ini && \
    echo "mbstring.internal_encoding = 'ISO-8859-1'" >> /usr/local/etc/php/php.ini && \
    echo "mbstring.http_output = 'pass'" >> /usr/local/etc/php/php.ini && \
    echo "mbstring.encoding_translation = 'off'" >> /usr/local/etc/php/php.ini && \
    echo "mbstring.func_overload = 0" >> /usr/local/etc/php/php.ini && \
    echo "error_reporting = E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_ERROR" >> /usr/local/etc/php/php.ini && \
    echo "display_errors = Off" >> /usr/local/etc/php/php.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/php.ini && \
    echo "error_log = /var/log/apache2/php-error.log" >> /usr/local/etc/php/php.ini

# Copiar archivos del proyecto
COPY var/www/html /var/www/html

# Copiar FCKEditor
COPY _herramientas/fckeditor /var/www/html/FCKEditor

# Crear enlace con mayúsculas para compatibilidad
RUN ln -s /var/www/html/FCKeditor /var/www/html/FCKEditor

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Configurar VirtualHost
RUN echo "<VirtualHost *:80>" > /etc/apache2/sites-available/000-default.conf && \
    echo "    DocumentRoot /var/www/html" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    <Directory /var/www/html>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "        Options Indexes FollowSymLinks" >> /etc/apache2/sites-available/000-default.conf && \
    echo "        AllowOverride All" >> /etc/apache2/sites-available/000-default.conf && \
    echo "        Require all granted" >> /etc/apache2/sites-available/000-default.conf && \
    echo "    </Directory>" >> /etc/apache2/sites-available/000-default.conf && \
    echo "</VirtualHost>" >> /etc/apache2/sites-available/000-default.conf
