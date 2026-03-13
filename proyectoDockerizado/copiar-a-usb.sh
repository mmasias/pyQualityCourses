#!/bin/bash

# Script para copiar pyQualityCourses a USB

echo "=========================================="
echo "pyQualityCourses - Copia a USB"
echo "=========================================="
echo ""

# Directorio a copiar
DIR_ORIGEN="."
DIR_DESTINO="/media/pyQualityCourses-USB"

# Verificar si el directorio destino existe
if [ ! -d "$DIR_DESTINO" ]; then
    echo "Error: Directorio destino no encontrado: $DIR_DESTINO"
    echo "Por favor inserta tu USB y verifica el punto de montaje"
    exit 1
fi

echo "Copiando archivos desde: $DIR_ORIGEN"
echo "Hacia: $DIR_DESTINO"
echo ""

# Copiar archivos
rsync -av --progress "$DIR_ORIGEN/proyectoDockerizado/" "$DIR_DESTINO/proyectoDockerizado/"

# Copiar también los archivos del proyecto original
rsync -av --progress "$DIR_ORIGEN/var/www/html/" "$DIR_DESTINO/var-www-html/"

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Copia completada correctamente"
    echo ""
    echo "Archivos copiados:"
    ls -lh "$DIR_DESTINO/proyectoDockerizado/"
    echo ""
    echo "Para usar en otro ordenador:"
    echo "1. Conecta el USB al otro ordenador"
    echo "2. Navega a: $DIR_DESTINO/proyectoDockerizado"
    echo "3. Sigue las instrucciones en README.md dentro de proyectoDockerizado"
else
    echo ""
    echo "✗ Error durante la copia"
    echo "Verifica que tengas permisos suficientes"
    exit 1
fi
