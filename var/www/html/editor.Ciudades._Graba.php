<?PHP

	require_once('rutina.coneccion.php');	
	
	foreach($_POST as $nombre_campo => $valor){
	   //$asignacion = "\$" . $nombre_campo . "='" . htmlspecialchars(stripslashes($valor)) . "';";
		 $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
	   //echo htmlspecialchars(stripslashes($asignacion));
		 eval($asignacion);
	} 

	$miSQL = "SELECT MAX(orden) as ultimo FROM mciudad";
	$result = mysql_query($miSQL);
	$dato_ciudad = mysql_fetch_array($result);
	$orden = $dato_ciudad["ultimo"] + 1;
	
	$miSQL="INSERT INTO mciudad (Nombre, Descripcion, Orden, visible)";
	$miSQL=$miSQL."VALUES";
	$miSQL=$miSQL."('".$txtNombreCiudad."','".$txtDescripcion."',".$orden.",1)";
	
	$result = mysql_query($miSQL);
	
	if (!$result) {
		
		die('Ha ocurrido un error (1) en el ingreso de la ciudad: ' . mysql_error() . '<hr>' . $miSQL);
		
	}

	header ('Location: editor.ListaCiudades.php');

?>