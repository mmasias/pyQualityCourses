<?
	require_once('_rutina.coneccion.php');	

// DEFINICION DEL PAIS 
	$idPais=12;
	
	$miSQL =	"SELECT nombre FROM mpais WHERE id=$idPais";
	$registros = mysql_query($miSQL);
	$registro  = mysql_fetch_array($registros);
	$nombrePais = $registro["nombre"];

	echo "<h1>$nombrePais</h1>";
	
	$tabla = "tciudadpais";
	$miSQL = "SELECT idCiudad, nombreLocal FROM tciudadpais WHERE idPais=$idPais";
	$ciudades = mysql_query($miSQL);
	
	if ($ciudades) {
		while($ciudad = mysql_fetch_array($ciudades)){	
			
			$idCiudad = $ciudad["idCiudad"];
			$nombreCiudad = trim($ciudad["nombreLocal"]);
			
			echo "<h2>·".$nombreCiudad."·</h2>";
			
	//	INGRESO DE ELEMENTOS DE LA PAGINA DE DESCRIPCION - tciudadpais
	//	*********************************************************************************
			$title 						= "Spanska kurser i $nombreCiudad Spanska kurs $nombreCiudad Spr&aring;kskole";
			$metaTitle 				= "Spanska kurser $nombreCiudad, Spanska kurs $nombreCiudad, Spr&aring;kskole";
			$metaKeywords 		= "Spanska kurser, Spanska kurs, $nombreCiudad, Spanskakurser, Spanskakurs, Spanien, Spr&aring;kskole, Spr&aring;kresor i spanska, Studera spanska, Spansk Spr&aring;kskola, Spr&aring;kresor, spr&aring;kkurser, spr&aring;kresa, spr&aring;kkurs, spr&aring;kskolor";
			$metaDescription 	= "Lär dig spanska i $nombreCiudad p&aring; en spanskakurs p&aring; en av QualityCourses Spr&aring;kskolor. Spanska kurser i $nombreCiudad, Spr&aring;kskole";
	//	*********************************************************************************
	
			$miSQL="UPDATE tciudadpais SET title='$title' WHERE idPais = $idPais AND idCiudad = $idCiudad";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
				
			$descripcion = "tciudadpais - idPais = $idPais AND idCiudad = $idCiudad";
			$miSQL = "DELETE FROM tmetas WHERE descripcion = '$descripcion'";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetas (descripcion) VALUES ('$descripcion')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$idIngresado=mysql_insert_id();
			
			$miSQL="UPDATE tciudadpais SET idMetas = $idIngresado WHERE idPais = $idPais AND idCiudad = $idCiudad";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,1,'$metaTitle')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,2,'$metaKeywords')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,3,'$metaDescription')";
			$result = mysql_query($miSQL);//echo "$miSQL<hr>";
			
			
	//	INGRESO DE ELEMENTOS DE LA PAGINA DE PRECIOS DE CURSOS - tserviciociudadpais / idServicio = 1
	//	*********************************************************************************
			$idServicio = 1;
			$title 						= "Spanskakurser i $nombreCiudad Spanska spr&aring;kkurser i $nombreCiudad Spanskakurs";
			$metaTitle 				= "Spanskakurser $nombreCiudad, Spanska spr&aring;kkurser, $nombreCiudad, Spanskakurs";
			$metaKeywords 		= "Spanskakurser, $nombreCiudad, Spanska kurser, Spanskakurs, Spanska kurs, Spanien, Spr&aring;kskole, Spr&aring;kresor i spanska, spr&aring;kkurser, Studera spanska, Spansk Spr&aring;kskola, Spr&aring;kresor $nombreCiudad, spr&aring;kkurs, spr&aring;kskolor, spr&aring;kresa";
			$metaDescription 	= "Spanskakurser i $nombreCiudad. Lär dig spanska i $nombreCiudad p&aring; en spanskakurs p&aring; en av QualityCourses Spr&aring;kskolor. Spanska spr&aring;kkurser i $nombreCiudad";
	//	*********************************************************************************
	
			$miSQL="UPDATE tserviciociudadpais SET title='$title' WHERE idPais = $idPais AND idCiudad = $idCiudad AND idServicio = 1";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$descripcion = "tserviciociudadpais - idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$miSQL = "DELETE FROM tmetas WHERE descripcion = '$descripcion'";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}			
			$miSQL="INSERT INTO tmetas (descripcion) VALUES ('$descripcion')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$idIngresado=mysql_insert_id();
			
			$miSQL="UPDATE tserviciociudadpais SET idMetas = $idIngresado WHERE idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,1,'$metaTitle')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,2,'$metaKeywords')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,3,'$metaDescription')";
			$result = mysql_query($miSQL);//echo "$miSQL<hr>";
			
			
	//	INGRESO DE ELEMENTOS DE LA PAGINA DE PRECIOS DE ALOJAMIENTOS - tserviciociudadpais / idServicio = 2
	//	*********************************************************************************
			$idServicio = 2;
			$title 						= "Studera spanska i $nombreCiudad Spr&aring;kresor $nombreCiudad Spr&aring;kskola $nombreCiudad";
			$metaTitle 				= "Studera spanska i $nombreCiudad, Spr&aring;kresor, Spr&aring;kskola $nombreCiudad";
			$metaKeywords 		= "Studera spanska i $nombreCiudad, $nombreCiudad, Spanska kurser, Spanska kurs, Spanien, Spr&aring;kskole, Spr&aring;kresor i spanska, spr&aring;kkurser, Studera spanska, Spansk Spr&aring;kskola, Spanien, Spr&aring;kresor, spr&aring;kkurs, $nombreCiudad, spr&aring;kskolor";
			$metaDescription 	= "Studera Spanska i $nombreCiudad: QualityCourses Spr&aring;kskola. Här hittar du de bästa spr&aring;kskolorna i de mest attraktiva städerna i Spanien";
	//	*********************************************************************************
	
			$miSQL="UPDATE tserviciociudadpais SET title='$title' WHERE idPais = $idPais AND idCiudad = $idCiudad AND idServicio = 2";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}					

			$descripcion = "tserviciociudadpais - idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$miSQL = "DELETE FROM tmetas WHERE descripcion = '$descripcion'";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetas (descripcion) VALUES ('$descripcion')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$idIngresado=mysql_insert_id();
			
			$miSQL="UPDATE tserviciociudadpais SET idMetas = $idIngresado WHERE idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,1,'$metaTitle')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,2,'$metaKeywords')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,3,'$metaDescription')";
			$result = mysql_query($miSQL);//echo "$miSQL<hr>";			
			
			
	//	INGRESO DE ELEMENTOS DE LA PAGINA DE PRECIOS DE ACTIVIDADES - tserviciociudadpais / idServicio = 10
	//	*********************************************************************************
			$idServicio = 10;
			$title 						= "Spansk Spr&aring;kskola i $nombreCiudad Spr&aring;kskole i $nombreCiudad";
			$metaTitle 				= "Spansk Spr&aring;kskola $nombreCiudad Spr&aring;kskole i $nombreCiudad";
			$metaKeywords 		= "Spansk Spr&aring;kskola, Spr&aring;kskole $nombreCiudad Spr&aring;kskole, Spr&aring;kresor, spr&aring;kkurser, $nombreCiudad, spr&aring;kskolor Spr&aring;kresor i spanska, spr&aring;kkurser, Studera spanska, Spansk Spr&aring;kskola, Spanien";
			$metaDescription 	= "Spansk Spr&aring;kskola i $nombreCiudad. QualityCourses erbjuder det mest prisvärda sättet att lära dig spanska i Spanien";
	//	*********************************************************************************
	
			$miSQL="UPDATE tserviciociudadpais SET title='$title' WHERE idPais = $idPais AND idCiudad = $idCiudad AND idServicio = 10";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}		

			$descripcion = "tserviciociudadpais - idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$miSQL = "DELETE FROM tmetas WHERE descripcion = '$descripcion'";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetas (descripcion) VALUES ('$descripcion')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			
			$idIngresado=mysql_insert_id();
			
			$miSQL="UPDATE tserviciociudadpais SET idMetas = $idIngresado WHERE idServicio=$idServicio AND idCiudad=$idCiudad AND idPais=$idPais";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,1,'$metaTitle')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,2,'$metaKeywords')";
			$result = mysql_query($miSQL); if (!$result) {die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);}
			$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,3,'$metaDescription')";
			$result = mysql_query($miSQL);//echo "$miSQL<hr>";
			
		}
	}
	
?>