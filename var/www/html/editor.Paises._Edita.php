<?PHP

	require_once('_rutina.coneccion.php');	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/

	$miSQL="UPDATE mpais 
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
							title = '$txtTitle'
					WHERE id = $id";	
	$result = mysql_query($miSQL);
	
	if (!$result) {
		
		die('Ha ocurrido un error (1) en la actualización: ' . mysql_error() . '<hr>' . $miSQL);
		
	}	else {
		//EsSubdominio, EsPrincipal, ponerlo al último
		$idIngresado=mysql_insert_id();
						
		if ($chkSubdominio=="") {$subDominio=0;} else {$subDominio=1;}
			$miSQL="UPDATE mpais SET subDominio=".$subDominio." WHERE id=".$id;
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (3) en el ingreso: ' . mysql_error());}


		if ($chkPrincipal=="") {
			$miSQL="UPDATE mpais SET principal=0 WHERE id=".$id;
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (4-b) en el ingreso: ' . mysql_error());}		
		} else {
			$miSQL="UPDATE mpais SET principal=0";
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (4-a) en el ingreso: ' . mysql_error());}
			
			$miSQL="UPDATE mpais SET principal=1 WHERE id=".$id;
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (4-b) en el ingreso: ' . mysql_error());}
		}
		
	}

	header ('Location: editor.Paises.php?idPais='.$id);
	
?>