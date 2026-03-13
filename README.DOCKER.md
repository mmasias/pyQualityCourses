# Docker - pyQualityCourses (2007)

Este entorno Docker permite ejecutar el proyecto pyQualityCourses tal como fue diseñado en 2007, usando las versiones de software de la época.

## Tecnologías Utilizadas

- **PHP 5.6** (última versión con funciones mysql_*)
- **MySQL 5.7** (última versión compatible con el esquema original)
- **Apache 2.4** con mod_rewrite activado
- **Codificación ISO-8859-1** (como en el original)

## Estructura del Proyecto

```
pyQualityCourses/
├── docker/
│   ├── start.sh                      # Script de inicio del contenedor web
│   └── apache/
│       ├── apache2.conf              # Configuración de Apache
│       └── 000-default.conf          # VirtualHost principal
├── var/www/html/                    # Código PHP del proyecto
│   ├── index.php                    # Router principal
│   ├── editor.*.php                 # Panel de administración (Editor 1)
│   ├── 2007-06-03-editor.Sitio2/    # Panel multilingüe (Editor 2)
│   └── curso-espanol-espana/         # Versión en español
├── docker-compose.yml                # Definición de servicios Docker
└── README.DOCKER.md                  # Este archivo
```

## Instrucciones de Uso

### 1. Requisitos Previos

- Docker instalado
- Docker Compose instalado

### 2. Iniciar los Contenedores

```bash
docker-compose up -d
```

Este comando:
- Crea e inicia 2 contenedores: `pyqualitycourses-web` y `pyqualitycourses-db`
- Instala las extensiones de PHP necesarias (mysql, mysqli, pdo_mysql)
- Activa mod_rewrite en Apache
- Inicializa la base de datos con el esquema original
- Monta el código del proyecto en `/var/www/html`

### 3. Acceder al Sitio

**Sitio principal:**
```
http://localhost:8080/
```

**Versiones por idioma:**
```
http://localhost:8080/curso-espanol-espana/     # Español
http://localhost:8080/coursdespagnolenespagne/   # Francés
http://localhost:8080/corsodispagnoloinspagna/   # Italiano
http://localhost:8080/cursos-espanhol-espanha/   # Portugués
http://localhost:8080/spanischkurseinspanien/    # Alemán
http://localhost:8080/spaanse-cursussen-spanje/   # Holandés
http://localhost:8080/spanskakurserspanien/      # Sueco
http://localhost:8080/kursyhiszpanskiegohiszpanii/ # Polaco
```

**Panel de administración:**
```
http://localhost:8080/editor.FrontPage.php       # Editor 1 (Estructura)
http://localhost:8080/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php  # Editor 2 (Multilingüe)
```

### 4. Ver Logs

**Logs del servidor web:**
```bash
docker-compose logs -f web
```

**Logs de la base de datos:**
```bash
docker-compose logs -f db
```

**Logs de Apache (dentro del contenedor):**
```bash
docker-compose exec web tail -f /var/log/apache2/error.log
docker-compose exec web tail -f /var/log/apache2/access.log
```

### 5. Acceder a la Base de Datos

```bash
docker-compose exec db mysql -u root quality_courses
```

O usando un cliente MySQL externo:
- Host: `localhost`
- Port: `3306`
- User: `root`
- Password: (vacía)
- Database: `quality_courses`

### 6. Detener los Contenedores

```bash
docker-compose down
```

### 7. Limpiar Todo (incluyendo datos)

```bash
docker-compose down -v
```

**Advertencia:** Esto elimina todos los datos de la base de datos.

## Troubleshooting

### Problema: Error de conexión a la base de datos

El contenedor web puede intentar conectarse antes de que MySQL esté completamente listo. Si ocurre este error:

```bash
docker-compose restart web
```

### Problema: Página en blanco

Verificar que las extensiones de PHP están instaladas:

```bash
docker-compose exec web php -m | grep mysql
```

Debería mostrar:
- mysql
- mysqli
- pdo_mysql

### Problema: Mod_rewrite no funciona

Verificar que el módulo esté activado:

```bash
docker-compose exec web a2enmod rewrite
docker-compose restart web
```

### Problema: Charset incorrecto (caracteres especiales mal mostrados)

El sistema usa ISO-8859-1. Si ves caracteres mal mostrados en el navegador:
- Configura el navegador para usar ISO-8859-1
- O verifica que el archivo `.htaccess` en `var/www/html/` tiene: `AddDefaultCharset iso-8859-1`

### Problema: Faltan imágenes

Las imágenes están en `var/www/html/image/`. Si no se cargan:
- Verifica que los archivos tengan permisos de lectura: `chmod -R 644 var/www/html/image/`
- Revisa los logs de Apache para ver rutas incorrectas

## Modo Depuración

Para activar el modo de depuración (muestra información detallada del flujo de ejecución):

1. Edita `var/www/html/index.php`
2. Cambia la línea 3:
   ```php
   $modoDepuracion = 1;  // Poner a 1 para ver todos los mensajes
   ```

## Observaciones Importantes

### Código Legacy

Este proyecto utiliza:
- **Funciones mysql_*** (obsoletas desde PHP 5.5, eliminadas en PHP 7.0)
- **Register globals** (variables _GET/_POST se convierten automáticamente en variables)
- **HTML 4.01 Transitional** (HTML5 aún no existía)
- **FCKEditor** (precursor de CKEditor)

### Seguridad

Este código fue escrito en 2007 y **NO es seguro por estándares modernos**:
- Vulnerable a SQL injection
- Usa `eval()` para crear variables dinámicamente
- No tiene sanitización de entrada
- No tiene autenticación en el panel admin

**No use este código en producción.** Es solo para fines educativos y de demostración.

### Limitaciones Conocidas

1. **Falta TemplatePower:** El código usa la librería `class.TemplatePower` que no está incluida en el repositorio. Necesitarás agregarla:
   ```bash
   # Descargar TemplatePower (si está disponible)
   # O instalar una librería compatible
   ```

2. **Falta FCKEditor:** La librería `FCKEditor` no está incluida. Puedes usar la versión histórica disponible en el repositorio original si la encuentras.

3. **Datos de ejemplo:** El esquema de base de datos incluye datos de prueba, pero puede faltar contenido completo.

## Para Estudiantes

Este proyecto es un excelente caso de estudio para:

1. **Evolución histórica del desarrollo web:** Comparar prácticas de 2007 vs 2026
2. **Refactorización de código legacy:** Ejercicio práctico de modernización
3. **Análisis de seguridad:** Identificación de vulnerabilidades (OWASP Top 10)
4. **Arquitectura de sistemas:** Evaluación de patrones de diseño
5. **Gestión del ciclo de vida:** Técnicas de mantenimiento de sistemas heredados

Vea también:
- `README.md` - Documentación general del proyecto
- `FORTALEZAS.md` - Análisis de fortalezas de desarrollo
- `!-documentos.desarrollo/_modelo.datos.sql` - Esquema de base de datos completo

## Referencias

- Sitio original (Wayback Machine): https://web.archive.org/web/20070701050123/http://www.quality-courses.com/spanish-course-nerja.htm
- Documento de base de datos: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql`
- Configuración del router: `var/www/html/.htaccess`

## Licencia

Este repositorio es conservado con fines educativos como caso de estudio de ingeniería de software.
