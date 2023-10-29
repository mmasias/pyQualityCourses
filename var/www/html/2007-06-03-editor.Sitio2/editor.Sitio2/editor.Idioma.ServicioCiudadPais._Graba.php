<?php
//	include ("_SEC.seguridad.php");
	$directorioBase = "";
	require_once('../_rutina.coneccion.php');	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("../_obtener.variables.php");
/*----------------------------------------------------------*/

// Ver si hay metatag definido
	$miSQL="SELECT idMetas 
					FROM nptidiomapaisserviciociudad 
					WHERE idIdioma		=	$txtIdIdioma 
						AND idServicio	=	$txtIdServicio 
						AND idCiudad		=	$txtIdCiudad 
						AND idPais 			=	$txtIdPais";
	$recordset = mysql_query($miSQL);
	if ($recordset){
			$registro = mysql_fetch_array($recordset);	
			$idMetas = $registro["idMetas"];
		} 
		if ($idMetas<=0) {$idMetas = -1;}

	$miSQL="DELETE 	
					FROM nptidiomapaisserviciociudad 
					WHERE idIdioma		= $txtIdIdioma 
						AND idServicio	=	$txtIdServicio 
						AND idCiudad		=	$txtIdCiudad 
						AND idPais 			=	$txtIdPais";
	$result = mysql_query($miSQL);
	
	$miSQL="INSERT 
					INTO nptidiomapaisserviciociudad 
					(	idIdioma,
						idServicio,
						idCiudad,
						idPais,
						nombreLocal,
						descripcion,
						nombreHTML,
						textoEnlace,
						html_contenido,
						html_menu,
						publicado,
						html_marquesina,
						nombreBarraNavegacion,
						idMetas,
						title,
						html_pieLocal)
					VALUES
					(	$txtIdIdioma,
						$txtIdServicio,
						$txtIdCiudad,
						$txtIdPais,
						'$txtNombreLocal',
						'$txtDescripcion',
						'$txtNombreHTML',
						'$txtNombreEnlace',
						'$txthtml_contenido',
						'$txthtml_menu',
						1,
						'$txtMarquesina',
						'$txtNombreBarraNavegacion',
						$idMetas,
						'$txtTitle',
						'$txthtml_pieLocal')";
	
	$result = mysql_query($miSQL);	
	if (!$result) die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);

	header ('Location: editor.Idioma.Pais.php?idIdioma='.$txtIdIdioma.'&idPais='.$txtIdPais);
	
?>