<?php
//	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	
	include ("../_obtener.variables.php");

	$miSQL="UPDATE nptidiomapais 
					SET nombre = '$txtNombrePais', 
							nombreLocal = '$txtNombreEnlace', 
							descripcion = '$txtDescripcion', 
							directorio = '$txtDirectorio',
							html_superior2 = '$txthtml_superior2',
							html_direccion = '$txthtml_direccion',
							html_pie = '$txthtml_pie',
							html_contenido = '$txthtml_contenido',
							textoIdiomas = '$txtIdiomas',
							html_marquesina = '$txtMarquesina',
							nombreBarraNavegacion = '$txtNombreBarraNavegacion',
							prefijoCiudad = '$txtPrefijoCiudad',
							prefijoCursoPrecios = '$txtPrefijoCursoPrecios',
							prefijoAcomodacion = '$txtPrefijoAcomodacion',
							prefijoActividades = '$txtPrefijoActividades', 
							title = '$txtTitle',
							html_superior1 = '$txthtml_superior1',
							html_superior3 = '$txthtml_superior3'
					WHERE idIdioma = $idIdioma
						AND idPais = $idPais";
	
	$result = mysql_query($miSQL);
	
	if (!$result) {
		die('Ha ocurrido un error (1) en la actualización: ' . mysql_error() . '<hr>' . $miSQL);
	}	else {
		// Todo se ha grabado bien
	}

	header ('Location: editor.Idioma.Pais.php?idIdioma='.$idIdioma.'&idPais='.$idPais);
	
?>