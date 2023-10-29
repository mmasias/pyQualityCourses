<?php
//	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("../_obtener.variables.php");
/*----------------------------------------------------------*/

// Ver si hay metatag definido
	$miSQL="SELECT idMetas 
					FROM nptidiomapaisciudad 
					WHERE idIdioma = $txtIdIdioma 
						AND idCiudad = $txtIdCiudad 
						AND idPais   = $txtIdPais";
	$recordset = mysql_query($miSQL);
	if ($recordset){
			$registro = mysql_fetch_array($recordset);	
			$idMetas = $registro["idMetas"];
		} 
		if ($idMetas<=0) {$idMetas = -1;}
	
	$miSQL	=	"DELETE FROM nptidiomapaisciudad 
							WHERE idIdioma = $txtIdIdioma 
								AND idCiudad = $txtIdCiudad 
								AND idPais = $txtIdPais";
	//echo "$miSQL <hr />";
	$result = mysql_query($miSQL);
	
	$miSQL="INSERT INTO nptidiomapaisciudad 
					(	idIdioma,
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
	if (!$result) die('Ha ocurrido un error (1) en el ingreso: <hr />' . mysql_error() . '<hr />' . $miSQL);

	header ('Location: editor.Idioma.Pais.php?idIdioma='.$txtIdIdioma.'&idPais='.$txtIdPais);
	
?>