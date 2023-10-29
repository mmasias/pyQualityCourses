<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	

	$t = new TemplatePower("./editor.ListaPaises_tp.htm");
	$t->prepare(); 
	
	$miSQL = "SELECT COUNT(id) FROM mpais";
	$result = mysql_query($miSQL);
	$dato_pais = mysql_fetch_row($result);
	$NumeroDePaises=$dato_pais[0];	
	$t->assign("NumeroDePaises",$NumeroDePaises);
	
	$consulta = "SELECT id, nombre, principal, visible FROM mpais ORDER BY orden";
	$paises = mysql_query($consulta);	
	$orden = 0;
	
	if($paises) {
			while($un_pais = mysql_fetch_object($paises)){
			
				$id = $un_pais->id;
				$nombre = $un_pais->nombre;
				$principal = $un_pais->principal;
				$visible = $un_pais->visible;
				if ($visible=="0") {$nombre="<strike>$nombre</strike>";}
				if ($principal=="1") {$nombre="<b>$nombre</b>";}
				
			
				$t->newBlock("listaPaises");
				$t->assign(array(	
													orden => $orden,
													id => $id,
													pais => $nombre,
													visible => $visible
												)
									); 	
					$orden = $orden + 1;
				}
			}
	
	$t->printToScreen(); 

?>
