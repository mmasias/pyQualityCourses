<?php
require_once('config.inc.php');
require_once('rutina.coneccion.php');
require "../class.TemplatePower/class.TemplatePower.inc.php"; 

//Configuración del Template

	$t = new TemplatePower("./plantilla_tp2.htm");
	$t->prepare(); 

	$consulta = "SELECT * FROM msitio";
	$sitio = mysql_query($consulta);
	if($sitio){
		$datos_sitio = mysql_fetch_array($sitio);
		
		$titleSitio = $datos_sitio["title"];
		
		$html_superior = $datos_sitio["html_superior1"];
		$html_menu = $datos_sitio["html_menu"];
		$html_inferior = $datos_sitio["html_inferior"];
		
		$t->assign("titleSitio",$titleSitio);
		
		$t->assign("html_superior",$html_superior);
		$t->assign("html_menu",$html_menu);
		$t->assign("html_inferior",$html_inferior);
		
	}
	
	$consulta = "SELECT nombreLocal, directorio, icono, subdominio, principal FROM mpais WHERE visible=1 ORDER BY orden";
	$paginas = mysql_query($consulta);

	if($paginas) {
    while($una_pagina = mysql_fetch_object($paginas)){
		
			$nombreLocal 	= $una_pagina->nombreLocal;
			$subdominio 	= $una_pagina->subdominio;
			$directorio 	= $una_pagina->directorio;
			$principal 		= $una_pagina->principal;
			$imagen 			= $una_pagina->icono;

			if ($subdominio==1) {
				$link = $directorio.'.'.$dominioBase.'/';
			} else {
				$link = 'www.'.$dominioBase.'/'.$directorio;
			}
			
			if ($principal==1) {$link='www.'.$dominioBase.'/';}
			$link = 'http://'.$link;
	
			$t->newBlock("banderas");
			$t->assign(array(	
												descriptor => $nombreLocal,
												link => $link,
												imagen => $imagen
											)
								); 			
			}
		}

	$consulta = "SELECT nombre FROM mciudad WHERE visible=1 ORDER BY orden";
	$ciudades = mysql_query($consulta);		
	if($ciudades) {
    while($una_ciudad = mysql_fetch_object($ciudades)){
		
			$nombreCiudad 	= $una_ciudad->nombre;
			$t->newBlock("ciudades");
			$t->assign(array(	
												nombreCiudad => $nombreCiudad,
												linkCiudad => $nombreCiudad
											)
								);			
			
		}
	}

	$consulta = "SELECT nombre FROM mservicio WHERE visible=1 ORDER BY orden";
	$servicios = mysql_query($consulta);		
	if($servicios) {
    while($un_servicio = mysql_fetch_object($servicios)){
		
			$nombreServicio 	= $un_servicio->nombre;
			$t->newBlock("servicios");
			$t->assign(array(	
												nombreServicio => $nombreServicio,
												linkServicio => $nombreServicio
											)
								);			
			
		}
	}	

	
	$t->printToScreen(); 	
?>