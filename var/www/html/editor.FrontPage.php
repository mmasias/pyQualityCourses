<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('_rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/
	
	$miSQL="SELECT * FROM msitio";
	$sitio = mysql_query($miSQL);	

	if ($sitio) {
		while($parametros = mysql_fetch_array($sitio)){
			$txtSitioWeb		= $parametros["nombre"];
			$html_superior1	= $parametros["html_superior1"];
			$html_menu			= $parametros["html_menu"];
			$html_inferior	= $parametros["html_inferior"];
			$txtTitle				= $parametros["title"];
			$txtMetaTitle		= $parametros["metatitle"];
			$txtKeyWords		= $parametros["keywords"];
			$txtDescription	= $parametros["description"];
			$txtTopicos			= $parametros["pagetopic"];
			$txtHeadline		= $parametros["headline"];
		}	
	}
	
	$t = new TemplatePower("./editor.FrontPage_tp.htm");
	$t->prepare();
	
	$t->assign("txtSitioWeb",$txtSitioWeb);
	$t->assign("txtTitle",$txtTitle);
	$t->assign("txtMetaTitle",$txtMetaTitle);
	$t->assign("txtKeyWords",$txtKeyWords);
	$t->assign("txtDescription",$txtDescription);
	$t->assign("txtTopicos",$txtTopicos);	
	$t->assign("txtHeadline",$txtHeadline);	
	$t->assign("html_superior1",htmlspecialchars(stripslashes($html_superior1)));
	$t->assign("html_menu",htmlspecialchars(stripslashes($html_menu)));
	$t->assign("html_inferior",htmlspecialchars(stripslashes($html_inferior)));
	
	$t->printToScreen(); 	
	
?>
