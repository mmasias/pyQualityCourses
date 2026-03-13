# pyQualityCourses - Versión Docker Lista para Usar

Este directorio contiene todo lo necesario para ejecutar pyQualityCourses (el proyecto de 2007) en cualquier ordenador con Docker instalado.

## Contenido

- `Dockerfile` - Configuración de la imagen Docker
- `docker-compose.yml` - Orquestación de servicios (web + base de datos)
- `instalar.sh` - Script de instalación automatizada
- `inicializar-bd.sh` - Script para inicializar la base de datos
- `README.md` - Documentación general del proyecto
- `README.DOCKER.md` - Documentación específica de Docker
- `FORTALEZAS.md` - Análisis de fortalezas de desarrollo

## Requisitos Previos

### Docker Desktop (Recomendado)

1. Descarga Docker Desktop desde:
   - https://www.docker.com/products/docker-desktop
   - Elige la versión para tu sistema operativo

2. Instala Docker Desktop siguiendo las instrucciones del instalador

3. Después de la instalación, abre una terminal y verifica:
   ```bash
   docker --version
   docker-compose --version
   ```

### Docker Engine (Alternativa para Linux)

**Fedora:**
```bash
sudo dnf install docker docker-compose
sudo systemctl enable docker
sudo systemctl start docker
```

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install docker.io docker-compose
sudo systemctl enable docker
sudo systemctl start docker
```

## Instrucciones de Instalación

### Método 1: Usar el script automatizado (Recomendado)

1. Abre una terminal en este directorio
2. Ejecuta el script de instalación:
   ```bash
   chmod +x instalar.sh
   ./instalar.sh
   ```

3. El script automáticamente:
   - Verifica que Docker está instalado
   - Inicia los contenedores
   - Muestra los enlaces para acceder al sitio

### Método 2: Manual

1. Abre una terminal en este directorio
2. Inicia los contenedores:
   ```bash
   docker-compose up -d --build
   ```

3. Espera a que se descarguen las imágenes y se construya el contenedor

## Acceso al Sitio

### Sitio Principal
```
http://localhost:8080/
```

### Panel de Administración - Editor 1 (Estructura Base)
```
http://localhost:8080/editor.FrontPage.php
```

### Panel de Administración - Editor 2 (Multilingüe)
```
http://localhost:8080/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php
```

## Inicialización de la Base de Datos

La primera vez que inicies los contenedores, la base de datos tendrá las tablas pero sin datos completos.

Para inicializar la base de datos:

1. Asegúrate de que los contenedores estén corriendo:
   ```bash
   docker-compose ps
   ```

2. Ejecuta el script de inicialización:
   ```bash
   chmod +x inicializar-bd.sh
   ./inicializar-bd.sh
   ```

3. El script importará el esquema SQL y verificará los datos

## Gestión de los Contenedores

### Ver el estado de los contenedores
```bash
docker-compose ps
```

### Ver los logs en tiempo real
```bash
docker-compose logs -f                    # Todos los contenedores
docker-compose logs web --tail=50      # Solo web (últimas 50 líneas)
docker-compose logs db --tail=50       # Solo base de datos (últimas 50 líneas)
```

### Detener los contenedores
```bash
docker-compose down
```

### Reiniciar los contenedores
```bash
docker-compose restart
```

### Eliminar contenedores y datos
```bash
docker-compose down -v    # Elimina también el volumen de MySQL
```

## Acceso a la Base de Datos

### Desde la línea de comandos
```bash
docker-compose exec db mysql -u root quality_courses
```

### Ver las tablas
```bash
docker-compose exec db mysql -u root quality_courses -e "SHOW TABLES;"
```

### Hacer una consulta
```bash
docker-compose exec db mysql -u root quality_courses -e "SELECT * FROM mpais;"
docker-compose exec db mysql -u root quality_courses -e "SELECT COUNT(*) as total FROM mpais;"
```

### Exportar la base de datos
```bash
docker-compose exec db mysqldump -u root quality_courses > backup-$(date +%Y%m%d).sql
```

### Importar un backup de la base de datos
```bash
docker-compose exec -T db mysql -u root quality_courses < backup-YYYYMMDD.sql
```

## Solución de Problemas

### Los contenedores no se inician
1. Verifica que Docker esté corriendo:
   ```bash
   sudo systemctl status docker
   ```
   o si usas Docker Desktop, verifica que la aplicación esté abierta

2. Verifica los logs:
   ```bash
   docker-compose logs
   ```

### El sitio no carga (Forbidden)
1. Verifica que los contenedores estén corriendo
2. Verifica los logs de Apache:
   ```bash
   docker-compose logs web
   ```

### Errores de conexión a la base de datos
1. Verifica que el contenedor de base de datos esté corriendo
   ```bash
   docker-compose ps
   ```

2. Verifica los logs de MySQL:
   ```bash
   docker-compose logs db
   ```

3. Verifica las variables de entorno:
   ```bash
   docker-compose config
   ```

### Los caracteres se ven mal (M�laga en lugar de Málaga)
Esto es un problema de codificación conocido. El sistema usa ISO-8859-1 en lugar de UTF-8. Para el contexto histórico de 2007, esto es correcto. El código funciona como fue diseñado.

### Error: "Toolbar qualityCourses no definida"
Este error ya está resuelto en la configuración actual. Si aparece, verifica que el contenedor se haya reconstruido correctamente.

## Notas Importantes

### Puerto 8080
El puerto 8080 se usa por defecto. Si está ocupado por otro servicio, puedes cambiarlo en `docker-compose.yml`:
```yaml
ports:
  - "9090:80"  # Cambiar 8080 por 9090
```

### Datos Persistentes
Los cambios que hagas en el panel de administración se guardan en la base de datos, que persiste en el volumen `mysql-data`. Los datos se mantendrán aunque detengas y reinicies los contenedores.

### Cambiar el Código
Si necesitas hacer cambios en el código del proyecto:

1. Modifica los archivos en el directorio padre (`pyQualityCourses/`)
2. Recarga los contenedores:
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

## Para Copiar a USB y Usar en Otro Ordenador

### Paso 1: Copiar a USB
```bash
cp -r /ruta/a/proyectoDockerizado /media/tu_usb/proyectoDockerizado
```

### Paso 2: En el otro ordenador
1. Copia el directorio desde el USB a tu disco
2. Sigue las instrucciones de "Requisitos Previos" para instalar Docker
3. Navega a este directorio
4. Ejecuta: `./instalar.sh`
5. Si es la primera vez, ejecuta: `./inicializar-bd.sh`
6. Abre tu navegador en: http://localhost:8080/

## Documentación Adicional

- **README.md** - Documentación general del proyecto original
- **README.DOCKER.md** - Documentación técnica de Docker
- **FORTALEZAS.md** - Análisis de fortalezas de desarrollo del proyecto

## Soporte

Si encuentras problemas que no están cubiertos en esta documentación:

1. Revisa los logs: `docker-compose logs`
2. Verifica que los contenedores estén corriendo: `docker-compose ps`
3. Consulta la documentación técnica: `README.DOCKER.md`

## Limpieza

Para eliminar todo y empezar de cero:

```bash
docker-compose down -v
```
