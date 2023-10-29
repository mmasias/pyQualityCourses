<?php
//	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	
	include ("../_obtener.variables.php");
	
	$miSQL="INSERT INTO nptidiomapais 
														(	idPais,
															idIdioma,
															nombre, 
															nombreLocal, 
															descripcion, 
															directorio,
															html_superior2,
															html_direccion,
															html_contenido,
															html_pie, 
															visible, 
															textoIdiomas, 
															html_marquesina, 
															nombreBarraNavegacion,
															prefijoCiudad,
															prefijoCursoPrecios,
															prefijoAcomodacion,
															prefijoActividades, 
															title,
															html_superior1,
															html_superior3
														)	
													VALUES
														(	$idPais, 
															$idIdioma,
															'$txtNombrePais',
															'$txtNombreEnlace',
															'$txtDescripcion',
															'$txtDirectorio',
															'$txthtml_superior2',
															'$txthtml_direccion',
															'$txthtml_contenido',
															'$txthtml_pie', 
															1,
															'$txtIdiomas',
															'$txtMarquesina', 
															'$txtNombreBarraNavegacion',
															'$txtPrefijoCiudad,',
															'$txtPrefijoCursoPrecios',
															'$txtPrefijoAcomodacion',
															'$txtPrefijoActividades', 
															'$txtTitle',
															'$txthtml_superior1',
															'$txthtml_superior3'
														)";

	$result = mysql_query($miSQL);
	
	if (!$result) {
		
		die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		
	}	

	header ('Location: editor.Idioma.Pais.php?idIdioma='.$idIdioma.'&idPais='.$idPais);
	
?>