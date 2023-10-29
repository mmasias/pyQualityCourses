<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	

	$t = new TemplatePower("./editor.ListaCiudades_tp.htm");
	$t->prepare(); 

	$consulta = "SELECT id, nombre, descripcion, visible FROM mciudad ORDER BY orden";
	$ciudades = mysql_query($consulta);	
	$orden = 0;
	
	if($ciudades) {
			while($una_ciudad = mysql_fetch_object($ciudades)){

				$id = $una_ciudad->id;
				$visible = $una_ciudad->visible;
				$nombre = $una_ciudad->nombre;
				if ($visible=="0") {$nombre="<strike>$nombre</strike>";}
				
				$t->newBlock("listaCiudades");
				$t->assign(array(	
													orden => $orden,
													id => $id,
													ciudad => $nombre
												)
									); 	
					$orden = $orden + 1;
				}
			}
	
	$t->printToScreen(); 

?>
