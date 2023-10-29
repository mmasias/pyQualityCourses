<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	

	$t = new TemplatePower("./editor.ListaServicios_tp.htm");
	$t->prepare(); 

	$consulta = "SELECT id, nombre, descripcion, visible FROM mservicio ORDER BY orden";
	$servicios = mysql_query($consulta);	
	$orden = 0;
	
	if($servicios) {
			while($un_servicio = mysql_fetch_object($servicios)){
				
				$id = $un_servicio->id;
				$visible = $un_servicio->visible;
				$nombre = $un_servicio->nombre;
				if ($visible=="0") {$nombre="<strike>$nombre</strike>";}
				
				$t->newBlock("listaServicios");
				$t->assign(array(	
													orden => $orden,
													id => $id,
													servicio => $nombre
												)
									); 	
					$orden = $orden + 1;
				}
			}
	
	$t->printToScreen(); 

?>
