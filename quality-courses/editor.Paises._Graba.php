<?PHP

	require_once('rutina.coneccion.php');	
	
	foreach($_POST as $nombre_campo => $valor){
		 $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
		 eval($asignacion);
	} 
	
	$miSQL="INSERT INTO mpais (	Nombre, 
															NombreLocal, 
															Descripcion, 
															Directorio,
															HTML_Superior2,
															HTML_Direccion,
															HTML_Contenido,
															HTML_Pie, 
															visible, 
															textoIdiomas, 
															html_marquesina, 
															nombreBarraNavegacion,
															prefijoCiudad,
															prefijoCursoPrecios,
															prefijoAcomodacion,
															prefijoActividades, 
															title
														)	
													VALUES
														(	'$txtNombrePais',
															'$txtNombreEnlace',
															'$txtDescripcion',
															'$txtDirectorio',
															'$html_superior',
															'$html_direccion',
															'$html_contenido',
															'$html_pie', 
															1,
															'$txtIdiomas',
															'$txtMarquesina', 
															'$txtNombreBarraNavegacion',
															'$txtPrefijoCiudad,',
															'$txtPrefijoCursoPrecios',
															'$txtPrefijoAcomodacion'
															'$txtPrefijoActividades', 
															'$txtTitle'
														)";
	
	$result = mysql_query($miSQL);
	
	if (!$result) {
		
		die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		
	}	else {
		//EsSubdominio, EsPrincipal, ponerlo al último
		$idIngresado=mysql_insert_id();
		
		$miSQL="SELECT MAX(orden) as ultimo FROM mpais";
		$result = mysql_query($miSQL);
		$dato_pais = mysql_fetch_row($result);
		$orden=$dato_pais[0];
		
		$miSQL="UPDATE mpais SET orden=".($orden+1).", principal=0 WHERE id=".$idIngresado;
		$result = mysql_query($miSQL);	
		if (!$result) {die('Ha ocurrido un error (2) en el ingreso: ' . mysql_error());}		
		
		if ($chkSubdominio!="") {
			$miSQL="UPDATE mpais SET subDominio=1 WHERE id=".$idIngresado;
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (3) en el ingreso: ' . mysql_error());}
		}

		if ($chkPrincipal!="") {
			$miSQL="UPDATE mpais SET principal=0";
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (4-a) en el ingreso: ' . mysql_error());}
			
			$miSQL="UPDATE mpais SET principal=1 WHERE id=".$idIngresado;
			$result = mysql_query($miSQL);	
			if (!$result) {die('Ha ocurrido un error (4-b) en el ingreso: ' . mysql_error());}
		}
		
	}

	header ('Location: editor.ListaPaises.php');
	
?>