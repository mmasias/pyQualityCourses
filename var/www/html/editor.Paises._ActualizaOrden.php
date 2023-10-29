<?PHP

	require_once('rutina.coneccion.php');	
	
	$miOrden=0;
	
	foreach($_POST as $nombre_campo => $valor){
	   //$asignacion = "\$" . $nombre_campo . "='" . htmlspecialchars(stripslashes($valor)) . "';";
		 $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
		 
		 $miSQL="UPDATE mpais SET orden=$miOrden WHERE id=$valor";
		 $result = mysql_query($miSQL);
		 if (!$result) {die('No se ha podido definir el orden de los paises. Error: ' . mysql_error());}
		 
		 $miOrden=$miOrden+1;
	   //echo htmlspecialchars(stripslashes($asignacion));
		 header ('Location: editor.ListaPaises.php');
	} 
	
?>

