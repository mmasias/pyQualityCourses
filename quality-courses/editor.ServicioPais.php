<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('_rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/	

	$miSQL 		= "SELECT nombre FROM mservicio WHERE id=".$idServicio;
	$servicios = mysql_query($miSQL);
	$servicio 	= mysql_fetch_array($servicios);	
	$nombreServicio = $servicio["nombre"];
	
	$miSQL 		= "SELECT nombre FROM mpais WHERE id=".$idPais;
	$paises 	= mysql_query($miSQL);
	$pais 		= mysql_fetch_array($paises);	
	$nombrePais = $pais["nombre"];
	
	$miSQL = "SELECT * FROM tserviciopais WHERE idServicio=$idServicio AND idPais=$idPais";
	$ciudadpais = mysql_query($miSQL);
	$datos			= mysql_fetch_array($ciudadpais);

	$txtNombreLocal						= $datos["nombreLocal"];
	$txtNombreHTML						= $datos["nombreHTML"];
	$txtTextoEnlace						= $datos["textoEnlace"];
	$txtDescripcion						= $datos["descripcion"];
	$txthtml_contenido				= $datos["html_contenido"];
	$txthtml_menu							= $datos["html_menu"];
	$txtMarquesina						= $datos["html_marquesina"];
	$txtNombreBarraNavegacion = $datos["nombreBarraNavegacion"];
	$txtTitle 								= $datos["title"];
	$txthtml_pieLocal 				= $datos["html_pieLocal"];
	
	$urlMetaTags="editor.MetaTags.php?tabla=tserviciopais&criterio=idServicio=$idServicio AND idPais=$idPais";
	
/*
	Preparación de la plantilla respectiva
	--------------------------------------
*/	
	$t = new TemplatePower("./editor.ServicioPais_tp.htm");
	$t->prepare();		
	
	$t->assign("txtIdPais",$idPais);
	$t->assign("txtIdServicio",$idServicio);
	$t->assign("NombrePais",$nombrePais);
	$t->assign("NombreServicio",$nombreServicio);
	
	$t->assign("txtNombreLocal",$txtNombreLocal);
	$t->assign("txtNombreHTML",$txtNombreHTML);
	$t->assign("txtNombreEnlace",$txtTextoEnlace);
	$t->assign("txtDescripcion",$txtDescripcion);
	$t->assign("urlMetaTags",$urlMetaTags);
	$t->assign("txtMarquesina",$txtMarquesina);
	$t->assign("txtNombreBarraNavegacion",$txtNombreBarraNavegacion);
	$t->assign("txtTitle",$txtTitle);

	$t->assign("txthtml_contenido",htmlspecialchars(stripslashes($txthtml_contenido)));
	$t->assign("txthtml_menu",htmlspecialchars(stripslashes($txthtml_menu)));
	$t->assign("txthtml_pieLocal",htmlspecialchars(stripslashes($txthtml_pieLocal)));
	
	$t->printToScreen(); 
?>
