<?php

//	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	
	require_once('../class.TemplatePower/class.TemplatePower.inc.php'); 	
	include ("../_obtener.variables.php");

	if ($txtNombreCiudad!="") {
		
		$miSQL="INSERT INTO npmciudad 
							(idPais, nombre) 
						VALUES 
							($idPais,'$txtNombreCiudad')";
		
		$result = mysql_query($miSQL);
		if (!$result) {
			die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		} else {
			header ('Location: editor.Lista.Ciudades.php?idPais='.$idPais);
		}
	}
	
	$miSQL = "SELECT * FROM npmciudad WHERE idPais = $idPais";
	$ciudades = mysql_query($miSQL);

	if ($ciudades){
		echo "<ul>";
		while($una_ciudad = mysql_fetch_array($ciudades)){
			echo "<li>".$una_ciudad["nombre"]."</li>";
		}
		echo "</ul>";
	}
	
	
?>
<hr />
<a href="editor.Mapa.Idiomas.php">Volver al mapa general</a>
<hr />
<form>
<input type="text" name="txtNombreCiudad">
<input type="submit" value="Agregar ciudad"> 
<input type="text" name="idPais" value="<? echo $idPais; ?>">
</form>