#!/bin/bash
# Instalar extensiones PHP necesarias
docker-php-ext-install mysql mysqli pdo_mysql

# Activar mod_rewrite
a2enmod rewrite

# Apache ya está iniciado por defecto en esta imagen
# No necesitamos ejecutar apache2-foreground manualmente
