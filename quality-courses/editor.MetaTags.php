<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('_rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/	

/*
	editor.MetaTags.php?tabla=msitio&criterio=id=1
	editor.MetaTags.php?tabla=mpais&criterio=id=1
*/

/*	Obtener el ID del tMeta */
	$miSQL="SELECT idMetas FROM $tabla WHERE $criterio";
	$registros 	= mysql_query($miSQL);
	$registro		= mysql_fetch_array($registros);
	$idtMetas		= $registro["idMetas"];

/*
	Preparación de la plantilla respectiva
	--------------------------------------
*/	
	$t = new TemplatePower("./editor.MetaTags_tp.htm");
	$t->prepare();	
	
	$t->assign("tabla",$tabla);
	$t->assign("criterio",$criterio);

		$miSQL="SELECT * FROM mmetas";
		$metas = mysql_query($miSQL);
		if($metas) {
			while($un_meta = mysql_fetch_array($metas)){
				$idMeta 		= $un_meta["id"];
				$nombreMeta	= $un_meta["nombre"];
				$descriptor	= $un_meta["descriptor"];
				
				if (!(is_null($idtMetas))){
					$miSQL = "SELECT descripcion 
										FROM tmetasextendido 
										WHERE idMeta 	= $idMeta
											AND idtMetas= $idtMetas";
					$registros 	= mysql_query($miSQL);
					$registro		= mysql_fetch_array($registros);
					$descripcion= $registro["descripcion"];
				}
				
				$t->newBlock("listaElementosMeta");
				$t->assign("idMeta",$idMeta);
				$t->assign("nombreMeta",$nombreMeta);
				$t->assign("descriptor",$descriptor);
				$t->assign("valorMeta",$descripcion);
			}
		}	
	
	$t->printToScreen(); 
?>