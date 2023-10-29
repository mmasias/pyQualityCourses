<?PHP

	require_once('_rutina.coneccion.php');	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/
	
	$miSQL="TRUNCATE TABLE msitio";
	$result = mysql_query($miSQL);
	
	$miSQL="INSERT INTO msitio 
					(nombre, html_superior1, html_menu, html_inferior, title, metatitle, keywords, description, pagetopic, headline)
					VALUES
					(	'$txtSitioWeb', 
						'$html_superior1', 
						'$html_menu',
						'$html_inferior',
						'$txtTitle',
						'$txtMetaTitle',
						'$txtKeyWords',
						'$txtDescription',
						'$txtTopicos',
						'$txtHeadline')";
//	echo $miSQL;
	$result = mysql_query($miSQL);
	
	if (!$result) {
		
		die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		
	} else {
		
		header ('Location: editor.FrontPage.php');
		
	}

?>