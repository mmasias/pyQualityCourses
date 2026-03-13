#!/bin/bash

# Script de instalación para pyQualityCourses (versión Docker)
# Este script verifica e instala los requisitos necesarios

echo "=========================================="
echo "pyQualityCourses - Instalación Docker"
echo "=========================================="
echo ""

# Colores para mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Error:${NC} Docker no está instalado."
    echo ""
    echo "Por favor instala Docker:"
    echo "  - Fedora: sudo dnf install docker docker-compose"
    echo "  - Ubuntu/Debian: sudo apt install docker.io docker-compose"
    echo ""
    echo "O descarga Docker Desktop desde https://www.docker.com/products/docker-desktop"
    exit 1
fi

# Verificar si docker-compose está instalado
if ! command -v docker-compose &> /dev/null && ! command -v docker &> /dev/null compose &> /dev/null; then
    echo -e "${RED}Error:${NC} Docker Compose no está instalado."
    echo ""
    echo "Por favor instala Docker Compose:"
    echo "  - Fedora: sudo dnf install docker-compose"
    echo "  - Ubuntu/Debian: sudo apt install docker-compose"
    exit 1
fi

echo -e "${GREEN}✓${NC} Docker está instalado"
echo -e "${GREEN}✓${NC} Docker Compose está instalado"
echo ""

# Crear directorio para datos de MySQL si no existe
echo "Verificando directorio de datos..."
if [ ! -d "mysql-data" ]; then
    mkdir -p mysql-data
    echo -e "${GREEN}✓${NC} Directorio mysql-data creado"
else
    echo -e "${GREEN}✓${NC} Directorio mysql-data ya existe"
fi

echo ""
echo "Iniciando contenedores..."
echo ""

# Iniciar los contenedores en segundo plano (detach)
docker-compose up -d

if [ $? -eq 0 ]; then
    echo ""
    echo -e "${GREEN}✓${NC} Contenedores iniciados correctamente"
    echo ""
    echo "=========================================="
    echo "Servicios disponibles:"
    echo "  - Sitio web: http://localhost:8080/"
    echo "  - Editor principal: http://localhost:8080/editor.FrontPage.php"
    echo "  - Editor multilingüe: http://localhost:8080/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php"
    echo "=========================================="
    echo ""
    echo "Para detener los contenedores:"
    echo "  docker-compose down"
    echo ""
    echo "Para ver los logs:"
    echo "  docker-compose logs -f"
    echo "  docker-compose logs web  # Solo contenedor web"
    echo "  docker-compose logs db  # Solo base de datos"
    echo ""
    echo "Para acceder a la base de datos:"
    echo "  docker-compose exec db mysql -u root quality_courses"
    echo ""
else
    echo ""
    echo -e "${RED}✗${NC} Error al iniciar los contenedores"
    echo "Verifica los logs con: docker-compose logs"
    exit 1
fi
