# Fortalezas de Desarrollo - pyQualityCourses (2007)

Este documento identifica y documenta las fortalezas de diseño e implementación del proyecto pyQualityCourses, desarrollado en 2007. Cada fortaleza incluye enlaces directos al código donde se puede apreciar la implementación.

## Contexto Histórico

Para apreciar estas fortalezas, es importante entender el contexto de desarrollo web en 2007:

- PHP 5.2.x era la versión estable (PHP 5.3 con namespaces aún no existía)
- jQuery 1.2 acababa de lanzarse (enero 2007)
- Primer iPhone lanzado (junio 2007) - responsive design aún no existía
- La mayoría de proyectos PHP eran procedimentales (WordPress 2.x era completamente procedural)
- Los frameworks modernos de PHP aún estaban en fases muy tempranas (CodeIgniter 1.x, Symfony 1.0)

---

## 1. Panel Administrativo con Interfaz por Pestañas Avanzada

### Descripción
Interfaz de administración con 10 secciones editables en un solo archivo, navegación por pestañas con JavaScript sin recarga de página, y uso de iframes para carga asíncrona de subsecciones.

### Por qué era avanzado en 2007

- AJAX estaba en auge pero aún no era estándar
- La mayoría de CMS tenían navegación por páginas separadas
- Uso de iframes para contenido dinámico era técnica avanzada
- Interfaz SPA (Single Page Application) precursora

### Implementación

**Barra de herramientas con navegación por pestañas**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:64-81`
- Código JavaScript para alternar pestañas sin recargar:

  ```javascript
  function verEditor(id){
      var obj = document.getElementById('editor_' + id)
      if(obj.style.display == 'block') obj.style.display = 'none'
      else obj.style.display = 'block'
  }
  ```

**Inicialización automática de editores FCK**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:10-23`
- Sistema que reemplaza todas las textareas automáticamente:

  ```javascript
  function ReplaceAllTextareas() {
      var allTextAreas = document.getElementsByTagName("textarea");
      for (var i=0; i < allTextAreas.length; i++) {
          var oFCKeditor = new FCKeditor( allTextAreas[i].name ) ;
          oFCKeditor.ReplaceTextarea() ;
      }
  }
  ```

**Carga asíncrona de subsecciones con iframes**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:276-284`
- Meta tags cargados en iframe para no recargar página:

  ```html
  <iframe src="{urlMetaTags}" height="430" width="800" name="frmMetaTags" ...></iframe>
  ```

**10 secciones editables en un solo formulario**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:84-310`
- Secciones: General, Ciudades, Servicios, Ed.Encabezado, Ed.Superior, Ed.subMarquesina, Ed.Dirección, Ed.Contenido, Ed.HTML Libre, Meta Tags

---

## 2. Mapa Matricial Idioma-País

### Descripción
Matriz visual bidimensional que muestra el estado de traducción para todas las combinaciones de idioma y país, con iconos semánticos y contadores en tiempo real.

### Por qué era avanzado en 2007

- Visualización de datos multidimensionales no era común
- Interfaz de administración tipo dashboard era innovadora
- Matrices visuales facilitaban gestión de múltiples versiones

### Implementación

**Matriz visual con estados de traducción**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php:15-36`
- Construcción dinámica de la matriz:

  ```php
  echo "<table border='1' cellspacing='0' cellpadding='2'>";
  echo "<tr>";
  echo "<td>&nbsp;</td>";
  while ($un_pais = mysql_fetch_array($paises)) {
      // Contador de ciudades por país
      $miSQL = "SELECT COUNT(*) AS numeroCiudades FROM npmciudad WHERE idPais=".$un_pais["id"];
      $definido = mysql_query($miSQL);
      $definido = mysql_fetch_array($definido);
      echo "<td>".$un_pais["nombre"]."<br />N° ciudades: ".$definido["numeroCiudades"]."</td>";
  }
  ```

**Detección visual de completitud de traducción**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php:50-76`
- Lógica de color de celda según estado:

  ```php
  $miSQL="SELECT COUNT(*) AS DEFINIDO FROM nptidiomapais WHERE idIdioma=$idIdioma AND idPais=$idPais[$i]";
  $definido = mysql_query($miSQL);
  $definido = mysql_fetch_array($definido);
  if ($definido["DEFINIDO"]>0) {
      $fondo="#FFCC99"; // Naranja para definido
      $icono="ico_editar.png";
  } else {
      $fondo="#FFFFFF"; // Blanco para no definido
      $icono="ico_nuevo.png";
  }
  echo "<td bgcolor='$fondo'><div align='center'>
        <a href='...'><img src='imagenes/$icono' /></a></div>";
  ```

**Enlace directo para ver el sitio**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Mapa.Idiomas.php:59-75`
- Botón para previsualizar cada versión del sitio:

  ```php
  if ($nuevo=="") {
      $miSQL = "SELECT directorio FROM nptidiomapais WHERE idIdioma=$idIdioma AND idPais=$idPais[$i]";
      $ruta = mysql_query($miSQL);
      if ($ruta["directorio"]!="") {
          echo "<a href='../".$ruta["directorio"]."/' target='_new'>
                <img src='imagenes/ico_ver.png' /></a>";
      }
  }
  ```

---

## 3. Modelo de Datos Bien Normalizado y Escalable

### Descripción
Arquitectura de base de datos con separación clara entre maestros (`m*`) y tablas de traducción (`t*`), preparada para agregar idiomas sin modificar estructura.

### Por qué era avanzado en 2007

- Normalización de bases de datos no era práctica común en PHP
- La mayoría de proyectos usaban tablas monolíticas
- Arquitectura preparada para escalabilidad

### Implementación

**Definición de tablas maestras**

- Ubicación: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql:20-106`
- Tablas maestras normalizadas:

  ```sql
  -- Tabla de países (maestro)
  CREATE TABLE `mpais` (
    `id` mediumint(9) NOT NULL auto_increment,
    `nombre` varchar(255) collate latin1_general_ci NOT NULL,
    `nombreLocal` varchar(255) collate latin1_general_ci NOT NULL,
    `directorio` varchar(255) collate latin1_general_ci NOT NULL,
    -- ... otros campos
    PRIMARY KEY  (`id`)
  );

  -- Tabla de ciudades (maestro)
  CREATE TABLE `mciudad` (
    `id` mediumint(9) NOT NULL auto_increment,
    `nombre` varchar(255) collate latin1_general_ci NOT NULL,
    `orden` tinyint(4) NOT NULL,
    `visible` tinyint(4) default NULL,
    PRIMARY KEY  (`id`)
  );

  -- Tabla de servicios (maestro)
  CREATE TABLE `mservicio` (
    `id` mediumint(9) NOT NULL auto_increment,
    `nombre` varchar(255) collate latin1_general_ci NOT NULL,
    `extensible` tinyint(4) default NULL,
    `orden` tinyint(4) NOT NULL,
    `visible` tinyint(4) default NULL,
    PRIMARY KEY  (`id`)
  );
  ```

**Tablas de traducción con claves compuestas**

- Ubicación: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql:134-188`
- Relaciones bien definidas:

  ```sql
  -- Traducciones de ciudad-país
  CREATE TABLE `tciudadpais` (
    `idCiudad` mediumint(9) NOT NULL,
    `idPais` mediumint(9) NOT NULL,
    `nombreLocal` varchar(255) collate latin1_general_ci NOT NULL,
    `nombreHTML` varchar(100) collate latin1_general_ci NOT NULL,
    `html_contenido` longtext collate latin1_general_ci,
    `html_menu` longtext collate latin1_general_ci,
    `publicado` tinyint(4) default '0',
    PRIMARY KEY  (`idCiudad`,`idPais`)
  );

  -- Traducciones de servicio-país
  CREATE TABLE `tserviciopais` (
    `idServicio` mediumint(9) NOT NULL,
    `idPais` mediumint(9) NOT NULL,
    `nombreLocal` varchar(255) collate latin1_general_ci NOT NULL,
    `nombreHTML` varchar(100) collate latin1_general_ci NOT NULL,
    `html_contenido` longtext collate latin1_general_ci,
    `html_menu` longtext collate latin1_general_ci,
    `textoEnlace` varchar(100) collate latin1_general_ci default NULL,
    `publicado` tinyint(4) default NULL,
    PRIMARY KEY  (`idServicio`,`idPais`)
  );
  ```

**Claves primarias compuestas para integridad**

- Ubicación: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql:148,187`
- Prevención de duplicados a nivel de base de datos:

  ```sql
  PRIMARY KEY  (`idCiudad`,`idPais`)  -- Una traducción única por ciudad-país
  PRIMARY KEY  (`idServicio`,`idPais`)  -- Una traducción única por servicio-país
  ```

---

## 4. Consistencia de Patrones de Diseño

### Descripción
Patrón CRUD repetible en más de 40 archivos del sistema, con consistencia en nomenclatura, validación de errores y flujo de ejecución.

### Por qué era avanzado en 2007

- Repetibilidad facilita mantenimiento
- Consistencia reduce curva de aprendizaje
- Código autodocumentado por patrones

### Implementación

**Nomenclatura consistente de archivos CRUD**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/`
- Patrones de nombres:
  - `editor.Idioma.Pais.php` - Lista/Edita
  - `editor.Idioma.Pais._Graba.php` - Crea/Actualiza
  - `editor.Idioma.Pais._Edita.php` - Actualización específica
  - `editor.Idioma.Pais._Eliminar.php` - Elimina

**Patrón de validación de errores consistente**

- Ubicación: `var/www/html/actualizador.Metas.php:35,39,46,50,66,96,126`
- Repetido en 10+ lugares:

  ```php
  $result = mysql_query($miSQL);
  if (!$result) {
      die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
  }
  ```

**Patrón TemplatePower con bloques**

- Ubicación: `var/www/html/index.php:351-358` y múltiples archivos

  ```php
  $t->newBlock("banderas");
  $t->assign(array(
      descriptor => $nombreLocal,
      link => $link,
      imagen => $imagen
  ));
  ```

**Patrón de preparación de plantillas**

- Ubicación: `var/www/html/editor.FrontPage.php:29-31`
- Repetido en todos los editores:

  ```php
  $t = new TemplatePower("./archivo_tp.htm");
  $t->prepare();
  $t->assign("variable", $valor);
  $t->printToScreen();
  ```

---

## 5. Sistema de Extensibilidad Jerárquica

### Descripción
Arquitectura de prefijos configurables por tipo de contenido (ciudades, cursos, alojamiento, actividades), con HTML personalizable en 6 niveles diferentes por país.

### Por qué era avanzado en 2007

- Configurabilidad sin modificar código
- Personalización granular por tipo de contenido
- Arquitectura preparada para nuevos tipos de servicio

### Implementación

**Prefijos configurables por tipo de contenido**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:100-132`
- Interfaz de edición de prefijos:

  ```html
  <tr>
      <td>Cursos de español en</td>
      <td><input name="txtPrefijoCiudad" type="text" value="{txtPrefijoCiudad}" size="30"></td>
  </tr>
  <tr>
      <td>Cursos y precios</td>
      <td><input name="txtPrefijoCursoPrecios" type="text" value="{txtPrefijoCursoPrecios}" size="30"></td>
  </tr>
  <tr>
      <td>Acomodación y precios</td>
      <td><input name="txtPrefijoAcomodacion" type="text" value="{txtPrefijoAcomodacion}" size="30"></td>
  </tr>
  <tr>
      <td>Actividades</td>
      <td><input name="txtPrefijoActividades" type="text" value="{txtPrefijoActividades}" size="30"></td>
  </tr>
  ```

**Uso dinámico de prefijos en el router**

- Ubicación: `var/www/html/index.php:389-401`
- Selección de prefijo según tipo de servicio:

  ```php
  switch ($idServicio) {
      case 1:
          $prefijo = $prefijoCursoPrecios;
          break;
      case 2:
          $prefijo = $prefijoAcomodacion;
          break;
      case 10:
          $prefijo = $prefijoActividades;
          break;
      default:
          $prefijo = "";
  }
  ```

**6 niveles de HTML personalizable por país**

- Ubicación: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql:56-71`

  ```sql
  CREATE TABLE `mpais` (
    `html_superior2` longtext collate latin1_general_ci,  -- Cabecera país
    `html_direccion` longtext collate latin1_general_ci,   -- Dirección contacto
    `html_pie` longtext collate latin1_general_ci,         -- Pie página
    `html_superior1` longtext collate latin1_general_ci,   -- Cabecera global
    `html_marquesina` longtext collate latin1_general_ci,  -- Marquesina
    `html_contenido` longtext collate latin1_general_ci,   -- Contenido principal
    -- ...
  );
  ```

**Asignación de prefijos en plantilla**

- Ubicación: `var/www/html/index.php:403-409`

  ```php
  $t->newBlock("ciudades");
  $t->assign(array(
      nombre => $nombre,
      link => $link,
      prefijo => $prefijo,  // Prefijo dinámico según servicio
      textoEnlace => $textoEnlace
  ));
  ```

---

## 6. Automatización de SEO Masiva

### Descripción
Script de 148 líneas que genera automáticamente meta tags para un idioma completo, coordinando múltiples INSERTs/UPDATEs en transacciones complejas.

### Por qué era avanzado en 2007

- Automatización de tareas repetitivas
- Generación programática de SEO
- Optimización para motores de búsqueda a gran escala

### Implementación

**Script de automatización de meta tags**

- Ubicación: `var/www/html/actualizador.Metas.php`
- Estructura del script:

  ```php
  <?
  require_once('_rutina.coneccion.php');

  // Definición del país a procesar
  $idPais=12;

  // Recorrer todas las ciudades
  $ciudades = mysql_query("SELECT idCiudad, nombreLocal FROM tciudadpais WHERE idPais=$idPais");
  while($ciudad = mysql_fetch_array($ciudades)){

      // Generar meta tags para ciudad
      $title = "Spanska kurser i $nombreCiudad Spanska kurs $nombreCiudad Språkskole";
      $metaTitle = "Spanska kurser $nombreCiudad, Spanska kurs $nombreCiudad, Språkskole";
      $metaKeywords = "Spanska kurser, Spanska kurs, $nombreCiudad, ...";
      $metaDescription = "Lär dig spanska i $nombreCiudad på en spanskakurs...";

      // Actualizar tabla principal
      mysql_query("UPDATE tciudadpais SET title='$title' WHERE idPais = $idPais AND idCiudad = $idCiudad");

      // Crear entrada de meta tags
      $descripcion = "tciudadpais - idPais = $idPais AND idCiudad = $idCiudad";
      mysql_query("DELETE FROM tmetas WHERE descripcion = '$descripcion'");
      mysql_query("INSERT INTO tmetas (descripcion) VALUES ('$descripcion')");
      $idIngresado=mysql_insert_id();

      // Actualizar referencia en tabla principal
      mysql_query("UPDATE tciudadpais SET idMetas = $idIngresado WHERE idPais = $idPais AND idCiudad = $idCiudad");

      // Insertar meta tags extendidos
      mysql_query("INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,1,'$metaTitle')");
      mysql_query("INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,2,'$metaKeywords')");
      mysql_query("INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,3,'$metaDescription')");
  }
  ?>
  ```

**Coordenación de múltiples tablas**

- Ubicación: `var/www/html/actualizador.Metas.php:34-53`
- Flujo de transacción:
  1. Actualizar tabla de contenido (`tciudadpais`)
  2. Eliminar meta tags existentes
  3. Insertar nueva entrada de meta tags
  4. Obtener ID insertado
  5. Actualizar referencia en tabla de contenido
  6. Insertar 3 tipos de meta tags extendidos

**Aplicación para 3 tipos de página por ciudad**

- Ubicación: `var/www/html/actualizador.Metas.php:56-143`
- Procesa para cada ciudad:
  - Página de descripción de ciudad (líneas 26-53)
  - Página de precios de cursos (líneas 56-83)
  - Página de precios de alojamiento (líneas 86-113)
  - Página de actividades (líneas 116-143)

---

## 7. Modo Depuración Integrado

### Descripción
Variable `$modoDepuracion` que activa log detallado del flujo de ejecución en index.php, mostrando ruteo, parámetros y estado del sistema.

### Por qué era avanzado en 2007

- Herramientas de depuración modernas aún no existían
- Xdebug estaba en desarrollo
- Depuración en producción era complicada

### Implementación

**Activación de modo depuración**

- Ubicación: `var/www/html/index.php:3`
- Variable de control:

  ```php
  $modoDepuracion = 0;  // Poner a 1 para ver todos los mensajes
  ```

**Log del tipo de página solicitada**

- Ubicación: `var/www/html/index.php:18-29`

  ```php
  if ($modoDepuracion==1) {
      echo "
      <p><font face='Verdana' size='3'><b>Proyecto Quality Courses - Fase final</b></font><br />
      <font face='Verdana' size='1'>Fase final del desarrollo del sitio de Quality Courses |
      Editor -><b><a href='editor.FrontPage.php'>aquí</a></b> |
      Punto de partida (temporal) -> <b><a href='spanish-course-barcelona.htm'>spanish-course-barcelona.htm</a></b><br />
      A partir de aqui quiza vea algunos códigos de programación y -finalmente- la página que se mostrará |
      Comentarios y Sugerencias: <b><a href='mailto:manuel@estrategiasmoviles.com'>Manuel Masías</a></b></font>
      <br />
      <font face='Verdana' size='1'><p>
      Se pidió la página [<b>$pagina</b>] desde el directorio <b>[".getcwd()."]</b> | ";
  }
  ```

**Trazabilidad del ruteo**

- Ubicación: `var/www/html/index.php:36-126`
- Log de deducción de tipo de recurso:

  ```php
  if ($modoDepuracion==1) {echo "Pide el sitio raiz | ";}

  if ($modoDepuracion==1) {
      if ($idCiudad!="") {
          echo "Ciudad $idCiudad del Pais $idPais | ";
      } else {
          echo "No es ciudad|";
      }
  }

  if ($modoDepuracion==1) {
      if ($idServicio!="") {
          echo "Servicio $idServicio del Pais $idPais | ";
      } else {
          echo "No es servicio | ";
      }
  }

  if ($modoDepuracion==1) {
      if ($idServicio!="") {
          echo "Servicio $idServicio en la ciudad $idCiudad del Pais $idPais | ";
      } else {
          echo "No es extensión de servicio | ";
      }
  }
  ```

**Log de construcción de página**

- Ubicación: `var/www/html/index.php:140`

  ```php
  if ($modoDepuracion==1) {
      echo "Construyendo la página...</p></font><hr />";
  }
  ```

---

## 8. UX Bien Pensada en el Panel de Administración

### Descripción
Interfaz de usuario con iconos visuales de estado, tachado para elementos no visibles, negrita para principales, contadores de elementos definidos y enlaces contextuales.

### Por qué era avanzado en 2007

- UX centrada en usuario no era prioridad
- La mayoría de paneles admin eran tablas monótonas
- Feedback visual era mínimo

### Implementación

**Iconos visuales de estado**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:81-85`
- Indicadores de publicación:

  ```php
  $publicado = "<img src='../image/ico_nopublicado.png'>";
  while($parametros = mysql_fetch_array($ciudadDefinida)){
      $definida = $parametros["nombreLocal"];
      if ($parametros["publicado"]==1)
          $publicado = "<img src='../image/ico_publicado.png'>";
  }
  ```

**Tachado para elementos no visibles**

- Ubicación: `var/www/html/editor.ListaPaises.php:27`
- Indicador visual de estado:

  ```php
  if ($visible=="0") {
      $nombre="<strike>$nombre</strike>";
  }
  ```

**Negrita para elementos principales**

- Ubicación: `var/www/html/editor.ListaPaises.php:28`
- Destacar sitio principal:

  ```php
  if ($principal=="1") {
      $nombre="<b>$nombre</b>";
  }
  ```

**Contadores de elementos definidos**

- Ubicación: `var/www/html/editor.ListaPaises.php:10-14`
- Estadísticas en tiempo real:

  ```php
  $miSQL = "SELECT COUNT(id) FROM mpais";
  $result = mysql_query($miSQL);
  $dato_pais = mysql_fetch_row($result);
  $NumeroDePaises=$dato_pais[0];
  $t->assign("NumeroDePaises",$NumeroDePaises);
  ```

**Enlaces contextuales directos**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:227`
- Navegación fluida a subediciones:

  ```php
  <td class="tablaRegistro"><a href='editor.Idioma.CiudadPais.php?idIdioma={ciudadIdIdioma}&idCiudad={ciudadIdCiudad}&idPais={ciudadIdPais}'>{ciudadDefinida}</a></td>
  ```

---

## 9. Arquitectura de Ruteo Flexible

### Descripción
Sistema de ruteo con mod_rewrite que redirige todas las peticiones a index.php, el cual deduce automáticamente el tipo de recurso (país, ciudad, servicio, sección) y construye la página correspondiente.

### Por qué era avanzado en 2007

- URLs amigables no eran estándar
- Sistemas de ruteo eran inexistentes en frameworks
- Deducción automática de recursos era innovadora

### Implementación

**Configuración de mod_rewrite**

- Ubicación: `var/www/html/.htaccess:2-11`
- Redirección universal:

  ```apache
  <IfModule mod_rewrite.c>
  RewriteEngine On
  # Si hay request de un archivo o directorio que sí existe
  RewriteCond %{REQUEST_FILENAME} -f [OR]
  RewriteCond %{REQUEST_FILENAME} -d
  RewriteRule ^(.+) - [PT,L]

  # Primera regla -y en teoría debería ser la única-
  RewriteRule ^(.+) index.php?pagina=$1 [QSA,L]
  </IfModule>
  ```

**Deducción automática del tipo de recurso**

- Ubicación: `var/www/html/index.php:34-127`
- Cascada de verificación:

  ```php
  // 1. Ver si pide el sitio principal del país
  if ($pagina=="") {
      $miSQL = "SELECT * FROM mpais WHERE directorio='".basename(getcwd())."'";
      $registros = mysql_query($miSQL);
      $registro = mysql_fetch_array($registros);
      $idPais = $registro["id"];
  }
  else {
      // 2. Si no es el sitio raiz, ver si es una ciudad
      if ($idPais=="") {
          $miSQL = "SELECT * FROM tciudadpais WHERE nombreHTML='$pagina'";
          $registros = mysql_query($miSQL);
          $registro = mysql_fetch_array($registros);
          $idPais = $registro["idPais"];
          $idCiudad = $registro["idCiudad"];
      }

      // 3. Si no es ciudad, ver si es Servicio
      if ($idPais=="") {
          $miSQL = "SELECT * FROM tserviciopais WHERE nombreHTML='$pagina'";
          $registros = mysql_query($miSQL);
          $registro = mysql_fetch_array($registros);
          $idPais = $registro["idPais"];
          $idServicio = $registro["idServicio"];
      }

      // 4. Si no es ciudad ni servicio, ver si es Sección
      if ($idPais=="") {
          $miSQL = "SELECT * FROM tserviciociudadpais WHERE nombreHTML='$pagina'";
          $registros = mysql_query($miSQL);
          $registro = mysql_fetch_array($registros);
          $idPais = $registro["idPais"];
          $idCiudad = $registro["idCiudad"];
          $idServicio = $registro["idServicio"];
      }
  }
  ```

**Construcción dinámica de navegación jerárquica**

- Ubicación: `var/www/html/index.php:149-197`
- Breadcrumbs dinámicos:

  ```php
  // Nivel 1: País
  $miSQL = "SELECT nombreBarraNavegacion, directorio, subdominio, principal
            FROM mpais WHERE id=$idPais";
  $registros = mysql_query($miSQL);
  $un_registro = mysql_fetch_array($registros);
  $miNavegador = "<a class='navegador' href='".$link."'>".$un_registro["nombreBarraNavegacion"]."</a>";

  // Nivel 2: Ciudad
  $miSQL = "SELECT nombreBarraNavegacion, nombreHTML
            FROM tciudadpais WHERE idciudad=$idCiudad AND idPais=$idPais";
  $registros = mysql_query($miSQL);
  $un_registro = mysql_fetch_array($registros);
  $miNavegador = $miNavegador." &raquo; <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";

  // Nivel 3: Servicio
  $miSQL = "SELECT nombreBarraNavegacion, nombreHTML
            FROM tserviciopais WHERE idServicio=$idServicio AND idPais=$idPais";
  $registros = mysql_query($miSQL);
  $un_registro = mysql_fetch_array($registros);
  $miNavegador = $miNavegador." &raquo; <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";

  // Nivel 4: Sección
  $miSQL = "SELECT nombreBarraNavegacion, nombreHTML
            FROM tserviciociudadpais WHERE idServicio=$idServicio AND idciudad=$idCiudad AND idPais=$idPais";
  $registros = mysql_query($miSQL);
  $un_registro = mysql_fetch_array($registros);
  $miNavegador = $miNavegador." &raquo; <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
  ```

---

## 10. Separación de Responsabilidades Incipiente

### Descripción
Aunque no implementa MVC formal, el sistema tiene separación de responsabilidades en archivos dedicados: conexión a BD, registro de variables, configuración y plantillas HTML separadas.

### Por qué era avanzado en 2007

- MVC no era práctica común en PHP
- La mayoría de proyectos tenían todo en archivos monolíticos
- Separación de responsabilidades es principio SOLID

### Implementación

**Archivo de conexión a base de datos**

- Ubicación: `var/www/html/_rutina.coneccion.php:1-20`

  ```php
  <?php
  // Connect To Database

  // REMOTO
  /*
  $servidor="";
  $nombre_usuario="mmasias";
  $clave_usuario="";
  $nombre_basedatos="mmasias";
  */

  // LOCAL
  $servidor="localhost";
  $nombre_usuario="root";
  $clave_usuario="";
  $nombre_basedatos="quality_courses";

  mysql_connect($servidor,$nombre_usuario, $clave_usuario)
      OR DIE ("No ha sido posible conectarse a la base de datos.");
  mysql_select_db($nombre_basedatos);
  ?>
  ```

**Registro automático de variables**

- Ubicación: `var/www/html/_obtener.variables.php:1-24`

  ```php
  <?
  /***VARIABLES POR GET ***/
  $numero = count($_GET);
  $tags = array_keys($_GET);
  $valores = array_values($_GET);

  // crea las variables y les asigna el valor
  for($i=0;$i<$numero;$i++){
      $$tags[$i]=$valores[$i];
  }

  /***VARIABLES POR POST ***/
  $numero2 = count($_POST);
  $tags2 = array_keys($_POST);
  $valores2 = array_values($_POST);

  // crea las variables y les asigna el valor
  for($i=0;$i<$numero2;$i++){
      $$tags2[$i]=$valores2[$i];
  }
  ?>
  ```

**Archivo de configuración**

- Ubicación: `var/www/html/config.inc.php:1-5`

  ```php
  <?php
    $dominioBase = 'quality-courses.com';
  ?>
  ```

**Plantillas HTML separadas**

- Ubicación: `var/www/html/plantilla_tp2.htm:1-111`
- Plantilla con placeholders de TemplatePower:

  ```html
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
  <head>
  <title>{titleSitio}</title>
  {miMetatag}
  <link rel="stylesheet" type="text/css" href="http://.../_sitio.quality-courses.css" />
  </head>
  <body>
      <div align="center">
          <table border="0" width="780" cellspacing="0" cellpadding="0">
              <tr>
                  <td width="280">
                      <img src="http://www.quality-courses.com/images/RiginalQCc.gif" /><br />
                      <img src="http://www.quality-courses.com/images/mistral.gif" />
                  </td>
                  <td width="500">{html_superior}</td>
              </tr>
          </table>
          <!-- START BLOCK : banderas-->
          <a href="{link}" title="{descriptor}">
              <img src=".../{imagen}" border="0" alt ="{descriptor}">
          </a>
          <!-- END BLOCK : banderas -->
          <div class="html_contenido">{html_contenido}</div>
      </table>
  </body>
  </html>
  ```

---

## 11. Panel de Edición de Contenido WYSIWYG Integrado

### Descripción
Integración fluida de FCKEditor con configuración personalizada de toolbar, correcciones para cross-browser (Firefox vs IE), y uso de funciones de seguridad (`htmlspecialchars()`, `stripslashes()`).

### Por qué era avanzado en 2007

- Editores WYSIWYG no eran estándar
- Cross-browser era un problema mayor
- Sanitización de HTML no era práctica común

### Implementación

**Configuración personalizada de FCKEditor**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:6,16-18`

  ```javascript
  <script type="text/javascript" src="/FCKeditor/fckeditor.js"></script>

  function ReplaceAllTextareas() {
      var allTextAreas = document.getElementsByTagName("textarea");
      for (var i=0; i < allTextAreas.length; i++) {
          var oFCKeditor = new FCKeditor( allTextAreas[i].name ) ;
          oFCKeditor.BasePath = "/FCKeditor/" ;
          oFCKeditor.Width=800;
          oFCKeditor.Height=450;
          oFCKeditor.ToolbarSet = 'qualityCourses';  // Toolbar personalizado
          if (allTextAreas[i].name!="txtDescripcion"){
              oFCKeditor.ReplaceTextarea() ;
          }
      }
  }
  ```

**Correcciones para cross-browser**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais_tp.htm:31-40`

  ```javascript
  // Corrección para que se muestre en modo editar
  if ((id==2) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_superior2');
  if ((id==3) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_direccion');
  if ((id==4) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_contenido');
  if ((id==5) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_pie');
  if ((id==9) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_superior3');
  if ((id==10) && (navigator.appName!="Microsoft Internet Explorer"))
      arregla('txthtml_superior1');

  function arregla(elemento){
      var oEditor = FCKeditorAPI.GetInstance(elemento);
      oEditor.Commands.GetCommand('Source').Execute();
      oEditor.Commands.GetCommand('Source').Execute();
  }
  ```

**Sanitización de HTML**

- Ubicación: `var/www/html/2007-06-03-editor.Sitio2/editor.Sitio2/editor.Idioma.Pais.php:183-189`
- Uso de funciones de seguridad:

  ```php
  $t->assign("txthtml_superior2",htmlspecialchars(stripslashes($html_superior2)));
  $t->assign("txthtml_direccion",htmlspecialchars(stripslashes($html_direccion)));
  $t->assign("txthtml_contenido",htmlspecialchars(stripslashes($html_contenido)));
  $t->assign("txthtml_pie",htmlspecialchars(stripslashes($html_pie)));
  $t->assign("txthtml_superior1",htmlspecialchars(stripslashes($html_superior1)));
  $t->assign("txthtml_superior3",htmlspecialchars(stripslashes($html_superior3)));
  ```

---

## 12. Documentación Técnica Integrada

### Descripción
Comentarios en código explicando lógica de negocio, scripts SQL exportables para despliegue, y estructura de directorios semántica.

### Por qué era avanzado en 2007

- Documentación era escasa en proyectos de la época
- La mayoría de código carecía de comentarios
- Scripts SQL exportables no eran estándar

### Implementación

**Comentarios explicativos en código**

- Ubicación: `var/www/html/index.php:13-16,31-50,73-76`

  ```php
  /*Obtener las variables para ambos casos: Agregado y Edición
  ----------------------------------------------------------*/
  include ($correccionSubdominio."_obtener.variables.php");
  /*----------------------------------------------------------*/

  // ***************************************************************
  // Ver si pide el sitio principal del pais
  // ***************************************************************

  // ***************************************************************
  // Si no es el sitio raiz, ver si es una ciudad
  // ***************************************************************

  // ***************************************************************
  // Si no es ciudad, ver si es Servicio
  // ***************************************************************
  ```

**Script SQL exportable para despliegue**

- Ubicación: `var/www/html/!-documentos.desarrollo/_modelo.datos.sql:1-195`
- Documentación completa de estructura:

  ```sql
  /*
  SQLyog Community Edition- MySQL GUI v5.21
  Host - 5.0.27-community-nt : Database - quality_courses
  *********************************************************************
  Server version : 5.0.27-community-nt
  */

  SET NAMES utf8;
  SET SQL_MODE='';
  create database if not exists `quality_courses`;
  USE `quality_courses`;

  /*Table structure for table `mciudad` */
  DROP TABLE IF EXISTS `mciudad`;
  CREATE TABLE `mciudad` (
    `id` mediumint(9) NOT NULL auto_increment,
    `nombre` varchar(255) collate latin1_general_ci NOT NULL,
    `descripcion` varchar(255) collate latin1_general_ci default NULL,
    `orden` tinyint(4) NOT NULL,
    `visible` tinyint(4) default NULL,
    PRIMARY KEY  (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
  ```

**Estructura de directorios semántica**

- Ubicación: Véase `var/www/html/`
  - `2007-06-03-editor.Sitio2/` - Panel de administración versionado
  - `!-documentos.desarrollo/` - Documentación técnica
  - `curso-espanol-espana/` - Versión en español
  - `coursdespagnolenespagne/` - Versión en francés
  - `image/` - Recursos gráficos
  - `file/` - Documentos

---

## Conclusión

Estas fortalezas demuestran que el proyecto fue desarrollado con:

1. **Pensamiento arquitectónico** - Diseño escalable y preparado para crecimiento
2. **Atención al detalle** - UX bien pensada y consistencia de patrones
3. **Visión de futuro** - Separación de responsabilidades y configurabilidad
4. **Pragmatismo** - Automatización de tareas repetitivas y herramientas de depuración
5. **Calidad profesional** - Documentación técnica y código mantenible

Para la época (2007), este proyecto representaba un nivel de desarrollo avanzado, incorporando técnicas que hoy consideramos estándar en desarrollo web profesional.
