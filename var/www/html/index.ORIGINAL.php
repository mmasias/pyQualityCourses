<?php

	$modoDepuracion 			= 0; 	// Poner a 1 para ver todos los mensajes
	
	$dominioBase 					= "estrategiasmoviles.dyndns.org/quality-courses";
	
	$directorioBase = "";
	
	include ("index.correccion_subdominio.php");
	
	include($correccionSubdominio."../FCKEditor/fckeditor.php") ;
	require_once($correccionSubdominio.'_rutina.coneccion.php');	
	require $correccionSubdominio."../class.TemplatePower/class.TemplatePower.inc.php"; 	

	/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ($correccionSubdominio."_obtener.variables.php");
/*----------------------------------------------------------*/	

if ($modoDepuracion==1) {
echo "
<p><font face='Verdana' size='3'><b>Proyecto Quality Courses - Fase final</b></font><br />
<font face='Verdana' size='1'>Fase final del desarrollo del sitio de Quality Courses |
Editor -><b><a href='editor.FrontPage.php'>aquí</a></b> |
Punto de partida (temporal) -> <b><a href='spanish-course-barcelona.htm'>spanish-course-barcelona.htm</a></b><br />
A partir de aqui quiza vea algunos códigos de programación y -finalmente- la página que se mostrará |
Comentarios y Sugerencias: <b><a href='mailto:manuel@estrategiasmoviles.com'>Manuel Masías</a></b></font>
<br />
<font face='Verdana' size='1'><p>
";

echo "Se pidió la página [<b>$pagina</b>] desde el directorio <b>[".getcwd()."]</b> | ";
}

// ***********************************************************************************
// Ver si pide el sitio principal del pais
// ***********************************************************************************
if ($pagina=="") {

	if ($modoDepuracion==1) {
		echo "Pide el sitio raiz | ";
	}

	$miSQL = "SELECT *
						FROM mpais 
						WHERE directorio='".basename(getcwd())."'";
	$registros 	= mysql_query($miSQL);	
	
	$registro 	= mysql_fetch_array($registros);
	
	$idPais 				= $registro["id"];
	$html_contenido	= $registro["html_contenido"];
	
} else {
// Si no es el sitio raiz, ver si es una ciudad
	if ($idPais==""){
		$miSQL = "SELECT idCiudad, idPais, html_contenido 
							FROM tciudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		
		$registro 	= mysql_fetch_array($registros);	
		$idPais 		= $registro["idPais"];
		$idCiudad 	= $registro["idCiudad"];
		$html_contenido	= $registro["html_contenido"];
	}
	
	if ($modoDepuracion==1) {
		if ($idCiudad!="") {echo "Ciudad $idCiudad del Pais $idPais | ";} else {echo "No es ciudad|";}
	}
	
// Ver si es Servicio (Sólo si no se ha encontrado como ciudad)
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idPais, html_contenido 
							FROM tserviciopais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		
		$registro 			= mysql_fetch_array($registros);	
		$idPais 				= $registro["idPais"];
		$idServicio 		= $registro["idServicio"];
		$html_contenido	= $registro["html_contenido"];



		
	}
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") {echo "Servicio $idServicio del Pais $idPais | ";} else {echo "No es servicio | ";}
	}
	
// Ver si es Seccion
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idCiudad, idPais, html_contenido 
							FROM tserviciociudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		
		$registro 			= mysql_fetch_array($registros);	
		$idPais 				= $registro["idPais"];
		$idCiudad 			= $registro["idCiudad"];
		$idServicio 		= $registro["idServicio"];
		$html_contenido	= $registro["html_contenido"];

	}

//	***************************************************************
//	Ver si es una sección EXTENSIBLE
//	***************************************************************
	if ($idServicio!="") {
			$miSQL = "SELECT nombreLocal, nombreHTML 
							  FROM tserviciociudadpais
							  WHERE idPais = $idPais
							    AND idServicio = $idServicio";	
			$registros 	= mysql_query($miSQL);
			$html_extension = "";
			while($un_registro = mysql_fetch_array($registros)){
				$html_extension = $html_extension."[<a href='".$un_registro['nombreHTML']."'>".$un_registro['nombreLocal']."</a>] ";
			}
		
		$html_contenido = "<center>".$html_extension."</center><br /><br /><br />".$html_contenido;
	}	
//	***************************************************************	
	
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") {echo "Servicio $idServicio en la ciudad $idCiudad del Pais $idPais | ";} else {echo "No es extensión de servicio | ";}
	}
}





// Si no existe
	if ($idPais=="" && $idCiudad=="" && $idServicio==""){

		echo "La página solicitada no existe | </p></font>";
		
	}
		else

// La página existe!!!
	{
		if ($modoDepuracion==1) {
			echo "Construyendo la página...</p></font><hr />";
		}
		
		$t = new TemplatePower($correccionSubdominio."./plantilla_tp2.htm");
		$t->prepare(); 

// *********************************************************************
// INICIO DATOS GENERALES DEL SITIO
// *********************************************************************
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
			
			$t->assign("html_contenido",$html_contenido);	
			
		}	
		
// *********************************************************************
// CONTENIDO DEL PAIS SOLICITADO
// *********************************************************************
	$miSQL = "SELECT html_superior2, html_direccion, html_pie
						FROM mpais
						WHERE id = $idPais";

	$paises = mysql_query($miSQL);			
	$pais 	= mysql_fetch_array($paises);	
	
	$html_superior2	= $pais["html_superior2"];
	$html_direccion	= $pais["html_direccion"];
	$html_pie				= $pais["html_pie"];	

	$t->assign("html_superior2",$html_superior2);
	$t->assign("html_direccion",$html_direccion);
	$t->assign("html_pie",$html_pie);
	
		
// *********************************************************************
//	LISTA DE PAISES
// *********************************************************************
	$consulta = "SELECT nombreLocal, directorio, icono, subdominio, principal 
							 FROM mpais 
							 WHERE visible=1 
							 ORDER BY orden";						 
	$paginas = mysql_query($consulta);

	if($paginas) {
    while($una_pagina = mysql_fetch_object($paginas)){
		
			$nombreLocal 	= $una_pagina->nombreLocal;
			$subdominio 	= $una_pagina->subdominio;
			$directorio 	= $una_pagina->directorio;
			$principal 		= $una_pagina->principal;
			$imagen 			= $una_pagina->icono;

			/*if ($subdominio==1) {
				$link = $directorio.'.'.$dominioBase.'/';
			} else {*/
				$link = $dominioBase.'/'.$directorio;
			/*}*/
			
			if ($principal==1) {$link=$dominioBase.'/';}
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

// *********************************************************************
//	FIN DATOS GENERALES DEL SITIO
// *********************************************************************	


										 
// *********************************************************************
//	CIUDADES
// *********************************************************************		
	$miSQL_ciudades = "SELECT tciudadpais.nombreLocal, tciudadpais.nombreHTML, mciudad.orden
											FROM tciudadpais, mciudad
											WHERE mciudad.id = tciudadpais.idciudad
											AND idPais = $idPais
											ORDER BY mciudad.orden ASC";
										 
	$ciudades = mysql_query($miSQL_ciudades);		
	if($ciudades) {
    while($una_ciudad = mysql_fetch_object($ciudades)){
		
			$nombreCiudad 	= $una_ciudad->nombreLocal;
			$linkCiudad			= $una_ciudad->nombreHTML;
			
			$t->newBlock("ciudades");
			$t->assign(array(	
												nombreCiudad => $nombreCiudad,
												linkCiudad => $linkCiudad
											)
								);			
			
		}
	}										 


// *********************************************************************
//	SERVICIOS
// *********************************************************************		
	$miSQL_servicios = "SELECT tserviciopais.nombreLocal, tserviciopais.nombreHTML
											FROM tserviciopais, mservicio
											WHERE mservicio.id = tserviciopais.idServicio
											  AND idPais = $idPais
											ORDER BY mservicio.orden";
											
	$servicios = mysql_query($miSQL_servicios);		
	if($servicios) {
    while($un_servicio = mysql_fetch_object($servicios)){
		
			$nombreServicio 	= $un_servicio->nombreLocal;
			$linkServicio 		= $un_servicio->nombreHTML;
			
			$t->newBlock("servicios");
			$t->assign(array(	
												nombreServicio => $nombreServicio,
												linkServicio => $linkServicio
											)
								);			
			
		}
	}	

	
	$t->printToScreen(); 
											
											
											
	}

	

?>