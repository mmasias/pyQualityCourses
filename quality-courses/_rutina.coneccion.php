<?php
//Connect To Database

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

mysql_connect($servidor,$nombre_usuario, $clave_usuario) OR DIE ("No ha sido posible conectarse a la base de datos.");
mysql_select_db($nombre_basedatos);
?>