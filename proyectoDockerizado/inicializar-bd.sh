#!/bin/bash

# Script para inicializar la base de datos de pyQualityCourses
# Este script importa el esquema SQL si la base de datos está vacía

echo "=========================================="
echo "pyQualityCourses - Inicializar Base de Datos"
echo "=========================================="
echo ""

# Verificar si el archivo SQL existe
if [ ! -f "../var/www/html/!-documentos.desarrollo/_modelo.datos.sql" ]; then
    echo "Error: No se encuentra el archivo SQL"
    exit 1
fi

# Verificar si los contenedores están corriendo
CONTAINER_STATUS=$(docker-compose ps -q)
if [ "$CONTAINER_STATUS" != "true" ]; then
    echo "Error: Los contenedores no están corriendo"
    echo "Inicia primero: ./instalar.sh"
    exit 1
fi

# Verificar si la base de datos ya tiene tablas
TABLES=$(docker-compose exec -T db mysql -u root quality_courses -e "SHOW TABLES;" 2>/dev/null | tail -n +2)

if [ -n "$TABLES" ]; then
    echo "La base de datos ya tiene tablas."
    echo "Tablas existentes:"
    docker-compose exec -T db mysql -u root quality_courses -e "SHOW TABLES;"
    echo ""
    read -p "¿Deseas reinicializar la base de datos? (s/N): " respuesta
    if [ "$respuesta" != "s" ] && [ "$respuesta" != "S" ]; then
        echo "Cancelado."
        exit 0
    fi
    echo ""
    echo "Reinicializando base de datos..."
fi

# Importar el esquema SQL
echo "Importando esquema de base de datos..."
docker-compose exec -T db mysql -u root quality_courses < ../var/www/html/!-documentos.desarrollo/_modelo.datos.sql

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Base de datos inicializada correctamente"
    echo ""
    echo "Verificando tablas..."
    docker-compose exec -T db mysql -u root quality_courses -e "SHOW TABLES;"
    echo ""
    echo "Verificando datos..."
    docker-compose exec -T db mysql -u root quality_courses -e "SELECT COUNT(*) as total_paises FROM mpais;"
    docker-compose exec -T db mysql -u root quality_courses -e "SELECT COUNT(*) as total_ciudades FROM mciudad;"
    docker-compose exec -T db mysql -u root quality_courses -e "SELECT COUNT(*) as total_servicios FROM mservicio;"
else
    echo ""
    echo "✗ Error al importar el esquema SQL"
    echo "Verifica el archivo SQL y vuelve a intentarlo."
    exit 1
fi

echo ""
echo "=========================================="
echo "Inicialización completada"
echo "=========================================="
