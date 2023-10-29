<?PHP
	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	
	
	foreach($_GET as $nombre_campo => $valor){
		 
		 $miSQL="UPDATE mpais SET visible=not(visible) WHERE id=$valor";
		 $result = mysql_query($miSQL);
		 if (!$result) {die('No se ha podido eliminar el país. Error: ' . mysql_error());}
		 
		 header ('Location: editor.ListaPaises.php');
	} 
	
?>

