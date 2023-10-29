<?php
//	include ("_SEC.seguridad.php");
	require_once('../_rutina.coneccion.php');	

/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("../_obtener.variables.php");	
/*----------------------------------------------------------*/	

	$miSQL="SELECT idMetas FROM $txtTabla WHERE $txtCriterio";
	$registros 	= mysql_query($miSQL);
	$registro		= mysql_fetch_array($registros);
	$idMetas		= $registro["idMetas"];
	
	if (is_null($idMetas) || ($idMetas==-1)){
		
		$miSQL="INSERT INTO tmetas (descripcion) VALUES ('$txtTabla - $txtCriterio') ";
		$result = mysql_query($miSQL);
		if (!$result) die('Ha ocurrido un error (1-1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		
		$idIngresado=mysql_insert_id();
		
		$miSQL="UPDATE $txtTabla SET idMetas=$idIngresado WHERE $txtCriterio";
		$result = mysql_query($miSQL);
		if (!$result) die('Ha ocurrido un error (1-2) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
		
		for($i=0;$i<$numero2;$i++){
			if (is_numeric($tags2[$i])) {
				$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idIngresado,$tags2[$i],'$valores2[$i]')";
				$result = mysql_query($miSQL);
				if (!$result) die('Ha ocurrido un error (1-3) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);
			}
		
		}			
	}else{
		
		for($i=0;$i<$numero2;$i++){
			if (is_numeric($tags2[$i])) {
				$miSQL="DELETE FROM tmetasextendido WHERE idtMetas=$idMetas AND idMeta=$tags2[$i]";
				$result = mysql_query($miSQL);
				if (!$result) die('Ha ocurrido un error (2-1a) en la actualización: ' . mysql_error() . '<hr>' . $miSQL);
				
				$miSQL="INSERT INTO tmetasextendido (idtMetas,idMeta,descripcion) VALUES ($idMetas,$tags2[$i],'$valores2[$i]')";
				$result = mysql_query($miSQL);
				if (!$result) die('Ha ocurrido un error (2-1b) en la actualización: ' . mysql_error() . '<hr>' . $miSQL);
			}	
		
		}
	}
	
	header ("Location: editor.MetaTags.php?tabla=$txtTabla&criterio=$txtCriterio");
	
?>