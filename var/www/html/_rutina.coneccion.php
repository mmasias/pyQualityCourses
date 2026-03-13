<?php
//Connect To Database

// DOCKER (prioridad si está definido)
if (getenv('DB_HOST')) {
    $servidor = getenv('DB_HOST');
    $nombre_usuario = getenv('DB_USER');
    $clave_usuario = getenv('DB_PASS');
    $nombre_basedatos = getenv('DB_NAME');
}
// REMOTO
elseif (false) {
    $servidor="";
    $nombre_usuario="mmasias";
    $clave_usuario="";
    $nombre_basedatos="mmasias";
}
// LOCAL (fallback)
else {
    $servidor="localhost";
    $nombre_usuario="root";
    $clave_usuario="";
    $nombre_basedatos="quality_courses";
}

mysql_connect($servidor,$nombre_usuario, $clave_usuario) OR DIE ("No ha sido posible conectarse a la base de datos.");
mysql_select_db($nombre_basedatos);
?>