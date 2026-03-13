<meta http-equiv="Content-type" content='text/html; charset="ISO-8859-1"' />
<meta http-equiv="pragma" content="nocache">
<?php 
		$directorioBase = "";
		include("../FCKEditor/fckeditor.php") ;
		require_once('rutina.coneccion.php');	
?>
<html>
<head></head>
<body>
<form method="POST">

<?php

	foreach($_POST as $nombre_campo => $valor){
	   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
	   eval($asignacion);
	} 
	
	if ($Accion=="actualizar") {
		$miSQL='UPDATE '.$Tabla.' SET '.$Campo.' = "'.$Texto.'" WHERE id='.$id;
		$result = mysql_query($miSQL);
		if (!$result) {
			die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . htmlspecialchars( stripslashes( $miSQL)));
		}	
	} else {
	
		$Tabla 	= $_GET["Tabla"];
		$Campo 	= $_GET["Campo"];
		$id 		= $_GET["id"];

		$miSQL = "SELECT $Campo	FROM $Tabla WHERE id=$id";
		$datos = mysql_query($miSQL);
		$dato = mysql_fetch_array($datos);	
				
		$Texto = $dato[0];

		$oFCKeditor = new FCKeditor('Texto') ;
		$oFCKeditor->BasePath = '../FCKEditor/';
		$oFCKeditor->Width = '600';
		$oFCKeditor->Height = '300';
		$oFCKeditor->Config["CustomConfigurationsPath"] = '../../quality-courses/miFCKEditor.Config.js';
		$oFCKeditor->Value = "$Texto";
		$oFCKeditor->Create();
	}
?>
<input type="text" name="Tabla" value="<? echo $Tabla; ?>">
<input type="text" name="Campo" value="<? echo $Campo; ?>">
<input type="text" name="id" value="<? echo $id; ?>">
<input type="text" name="Accion" value="actualizar">
<input type="submit">
</form>
</body>
</html>