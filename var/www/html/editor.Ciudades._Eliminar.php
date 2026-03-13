<?PHP
	require_once('rutina.coneccion.php');	
	
	foreach($_GET as $nombre_campo => $valor){
		 
		 $miSQL="UPDATE mciudad SET visible=not(visible) WHERE id=$valor";
		 $result = mysql_query($miSQL);
		 if (!$result) {die('No se ha podido eliminar la Ciudad. Error: ' . mysql_error());}
		 
		 header ('Location: editor.ListaCiudades.php');
	} 
	
?>

