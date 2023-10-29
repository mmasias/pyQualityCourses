<?php
	$directorioBase = "";
	require_once('_rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/
	$t = new TemplatePower("./editor.lista.metaTags_tp.htm");
	$t->prepare();
	
	$miSQL="SELECT * FROM mmetas";
	$metas = mysql_query($miSQL);

	if($metas) {
		while($un_meta = mysql_fetch_array($metas)){
			
			$txtId = $un_meta["id"];
			$txtNombre = $un_meta["nombre"];
			$txtDescriptor = $un_meta["descriptor"];
			$txtValorGenerico = $un_meta["valorGenerico"];
			$optVisible = $un_meta["visible"];
			
			if ($optVisible==1) {$optVisible="CHECKED";}
			
			$t->newBlock("elementoMeta");
			$t->assign("txtId",$txtId);
			$t->assign("txtNombre",$txtNombre);
			$t->assign("txtDescriptor",$txtDescriptor);
			$t->assign("txtValorGenerico",$txtValorGenerico);
			$t->assign("optVisible",$optVisible);
			
		}
	}
	$t->printToScreen(); 
?>