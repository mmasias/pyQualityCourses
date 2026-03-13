<?php

	$directorioBase = "";
	require_once('_rutina.coneccion.php');	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/

	if ($optVisible!=1) {$optVisible=0;}

	if ($txtId!=""){
			$miSQL="UPDATE mmetas 
								SET nombre = '$txtNombre', 
										descriptor = '$txtDescriptor', 
										valorGenerico = '$txtValorGenerico', 
										visible = $optVisible
							WHERE id=$txtId";
			$result = mysql_query($miSQL);
		} else {
			$miSQL="INSERT INTO mmetas 
								(	nombre, 
									descriptor, 
									valorGenerico
								) 
							VALUES 
								(	'$txtNombre',
									'$txtDescriptor',
									'$txtValorGenerico'
								)";
		}

	$result = mysql_query($miSQL);	
	if (!$result) die('Ha ocurrido un error (1) en el ingreso: ' . mysql_error() . '<hr>' . $miSQL);

	header ('Location: editor.lista.metaTags.php');
	
?>