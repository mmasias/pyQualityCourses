<?php

	$modoDepuracion 			= 0; 	// Poner a 1 para ver todos los mensajes
	$dominioBase 					= "estrategiasmoviles.dyndns.org/quality-courses";
	$directorioBase = "";
	
	include ("index.correccion_subdominio.php");
	
	//include($correccionSubdominio."../FCKeditor/fckeditor.php") ;
	require_once($correccionSubdominio.'_rutina.coneccion.php');	
	require $correccionSubdominio."../class.TemplatePower/class.TemplatePower.inc.php"; 	

	/*Obtener las variables para ambos casos: Agregado y Edici�n
	----------------------------------------------------------*/
	include ($correccionSubdominio."_obtener.variables.php");
/*----------------------------------------------------------*/	

if ($modoDepuracion==1) {
echo "
<p><font face='Verdana' size='3'><b>Proyecto Quality Courses - Fase final</b></font><br />
<font face='Verdana' size='1'>Fase final del desarrollo del sitio de Quality Courses |
Editor -><b><a href='editor.FrontPage.php'>aqu�</a></b> |
Punto de partida (temporal) -> <b><a href='spanish-course-barcelona.htm'>spanish-course-barcelona.htm</a></b><br />
A partir de aqui quiza vea algunos c�digos de programaci�n y -finalmente- la p�gina que se mostrar� |
Comentarios y Sugerencias: <b><a href='mailto:manuel@estrategiasmoviles.com'>Manuel Mas�as</a></b></font>
<br />
<font face='Verdana' size='1'><p>
Se pidi� la p�gina [<b>$pagina</b>] desde el directorio <b>[".getcwd()."]</b> | ";
}

//	***************************************************************
// 	Ver si pide el sitio principal del pais
//	***************************************************************
if ($pagina=="") {

	if ($modoDepuracion==1) {echo "Pide el sitio raiz | ";}

	$miSQL = "SELECT *
						FROM mpais 
						WHERE directorio='".basename(getcwd())."'";
	$registros 	= mysql_query($miSQL);	
	$registro 	= mysql_fetch_array($registros);
	
	$idPais 					= $registro["id"];
	$html_contenido		= $registro["html_contenido"];
	$idMetas 					= $registro["idMetas"];
	$html_marquesina	= $registro["html_marquesina"];
	
	} 
else 
//	***************************************************************
// 	Si no es el sitio raiz, ver si es una ciudad
//	***************************************************************
	{
	if ($idPais==""){
		$miSQL = "SELECT idCiudad, idPais, html_contenido, html_menu, idMetas, html_marquesina 
							FROM tciudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		$registro 	= mysql_fetch_array($registros);	
		
		$idPais 					= $registro["idPais"];
		$idCiudad 				= $registro["idCiudad"];
		$html_contenido		= $registro["html_contenido"];
		$html_menu				= $registro["html_menu"];
		$idMetas 					= $registro["idMetas"];
		$html_marquesina	= $registro["html_marquesina"];
	}
	
	if ($modoDepuracion==1) {
		if ($idCiudad!="") {echo "Ciudad $idCiudad del Pais $idPais | ";} else {echo "No es ciudad|";}
	}
	
//	***************************************************************	
// 	Si no es ciudad, ver si es Servicio
//	***************************************************************
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idPais, html_contenido, html_menu,idMetas, html_marquesina 
							FROM tserviciopais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		$registro 	= mysql_fetch_array($registros);	
		
		$idPais 					= $registro["idPais"];
		$idServicio 			= $registro["idServicio"];
		$html_contenido		= $registro["html_contenido"];
		$html_menu				= $registro["html_menu"];
		$idMetas 					= $registro["idMetas"];
		$html_marquesina	= $registro["html_marquesina"];
		
	}
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") {echo "Servicio $idServicio del Pais $idPais | ";} else {echo "No es servicio | ";}
	}

//	***************************************************************		
// 	Si no es ciudad ni servicio, ver si es Seccion
//	***************************************************************	
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idCiudad, idPais, html_contenido, html_menu,idMetas, html_marquesina 
							FROM tserviciociudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		$registro 	= mysql_fetch_array($registros);	
		
		$idPais 					= $registro["idPais"];
		$idCiudad 				= $registro["idCiudad"];
		$idServicio 			= $registro["idServicio"];
		$html_contenido		= $registro["html_contenido"];
		$html_menu				= $registro["html_menu"];
		$idMetas 					= $registro["idMetas"];
		$esServicio				=	true; // Ultimo cambio 14/02/2007
		$html_marquesina	= $registro["html_marquesina"]; // Ultimo cambio 15/02/2007
			if ($html_marquesina=="") {$html_marquesina=$html_marquesina."&nbsp;";}	// Comentario de Manuel 22-02-07
	}
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") {echo "Servicio $idServicio en la ciudad $idCiudad del Pais $idPais | ";} else {echo "No es extensi�n de servicio | ";}
	}
}

//	***************************************************************
// 	Si no existe
//	***************************************************************
if ($idPais=="" && $idCiudad=="" && $idServicio==""){
		echo "La p�gina solicitada no existe | </p></font>";
	}
		else
//	***************************************************************
// 	La p�gina existe!!!
//	***************************************************************
	{
		if ($modoDepuracion==1) {echo "Construyendo la p�gina...</p></font><hr />";}
		
		$t = new TemplatePower($correccionSubdominio."./plantilla_tp2.htm");
		$t->prepare(); 

// 	*********************************************************************		
// 	Navegador superior 
// 	Descripci�n del Pais + Descripcion del Servicio/Ciudad + [Descripcion del Servicio]
// 	*********************************************************************		
		$miSQL = "SELECT nombreBarraNavegacion, directorio, subdominio, principal
							FROM mpais 
							WHERE id=$idPais";
		$registros = mysql_query($miSQL);
		
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			
			$directorio = $un_registro["directorio"];
			$principal = $un_registro["principal"];
			
			/*if ($un_registro["subdominio"]==1) {
				$link = $directorio.'.'.$dominioBase.'/';
			} else {*/
				$link = $dominioBase.'/'.$directorio;
			/*}*/
			
			if ($principal==1) {$link=$dominioBase.'/';}
			$link = 'http://'.$link;	

			$miNavegador = "<a class='navegador' href='".$link."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
		
		$miSQL = "SELECT nombreBarraNavegacion, nombreHTML 
							FROM tciudadpais 
							WHERE idciudad=$idCiudad AND idPais=$idPais";
		$registros = mysql_query($miSQL);
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			$miNavegador = $miNavegador." � <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
		
		$miSQL = "SELECT nombreBarraNavegacion, nombreHTML 
							FROM tserviciopais 
							WHERE idServicio=$idServicio AND idPais=$idPais";
		$registros = mysql_query($miSQL);
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			$miNavegador = $miNavegador." � <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
		
		$miSQL = "SELECT nombreBarraNavegacion, nombreHTML 
							FROM tserviciociudadpais 
							WHERE idServicio=$idServicio AND idciudad=$idCiudad AND idPais=$idPais";
		$registros = mysql_query($miSQL);
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			$miNavegador = $miNavegador." � <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
// 	*********************************************************************			





// *********************************************************************
// INICIO DATOS GENERALES DEL SITIO
// *********************************************************************
		$consulta = "SELECT * FROM msitio";
		$sitio = mysql_query($consulta);
		if($sitio){
			$datos_sitio = mysql_fetch_array($sitio);
			$titleSitio = $datos_sitio["title"];
			
			$html_superior = $datos_sitio["html_superior1"];
			if ($html_menu=="") {$html_menu = $datos_sitio["html_menu"];}
			$html_inferior = $datos_sitio["html_inferior"];
			
			$t->assign("html_superior",$html_superior);
			$t->assign("html_menu",$html_menu);
			$t->assign("html_inferior",$html_inferior);	
			$t->assign("html_marquesina",$html_marquesina);	
			$t->assign("miNavegador",$miNavegador);
			
			$t->assign("html_contenido",$html_contenido);	
			
		}	
		
// *********************************************************************
// METATAGS 
// *********************************************************************
	// SACAR EL NOMBRE DEFINIDO
	$miSQL = "SELECT descripcion FROM tmetas WHERE id = $idMetas";
	$metatags = mysql_query($miSQL);
	if ($metatags) {
		$metatag = mysql_fetch_array($metatags);
		list($nombreTabla,$criterio)= split("-",$metatag["descripcion"]);
		$miSQL = "SELECT title FROM $nombreTabla WHERE $criterio";
			$titles = mysql_query($miSQL);	
			$title = mysql_fetch_array($titles);
			$titleSitio = $title["title"];
	}

	$miSQL = "SELECT	mmetas.nombre as nombre, 
										mmetas.descriptor as descriptor, 
										tmetasextendido.descripcion as descripcion
						FROM mmetas, tmetasextendido
						WHERE tmetasextendido.idMeta=mmetas.id
						AND tmetasextendido.idtMetas=$idMetas
						AND tmetasextendido.descripcion<>''";
	$miMetatag="";
	$metatags = mysql_query($miSQL);			
	if ($metatags) {
    while($metatag = mysql_fetch_array($metatags)){	
			$miMetatag=$miMetatag."<META ".$metatag["nombre"]." ".$metatag["descriptor"]."=\"".$metatag["descripcion"]."\">\r\n";
			// SI EL NOMBRE NO HA SIDO DEFINIDO, SACARLO DEL META-TAG TITLE
			if (($metatag["nombre"]=="name=\"title\"") && ($titleSitio=="")) {
				$titleSitio=$metatag["descripcion"];
			}
		}
	}
	$t->assign("miMetatag",$miMetatag);
	$t->assign("titleSitio",$titleSitio);	

// *********************************************************************
// CONTENIDO DEL PAIS SOLICITADO
// *********************************************************************
	$miSQL = "SELECT 	html_superior2, html_direccion, html_pie, textoIdiomas, 
										prefijoCiudad, prefijoCursoPrecios, prefijoAcomodacion, prefijoActividades
						FROM mpais
						WHERE id = $idPais";

	$paises = mysql_query($miSQL);			
	$pais 	= mysql_fetch_array($paises);	
	
	$html_superior2	= $pais["html_superior2"];
	$html_direccion	= $pais["html_direccion"];
	$html_pie				= $pais["html_pie"];	
	$textoIdiomas		= $pais["textoIdiomas"];
	
	$prefijoCiudad				= $pais["prefijoCiudad"];
	$prefijoCursoPrecios	= $pais["prefijoCursoPrecios"];
	$prefijoAcomodacion		= $pais["prefijoAcomodacion"];
	$prefijoActividades		= $pais["prefijoActividades"];

	$t->assign("html_superior2",$html_superior2);
	$t->assign("html_direccion",$html_direccion);
	$t->assign("html_pie",$html_pie);
	$t->assign("textoIdiomas",$textoIdiomas);
// *********************************************************************

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


// 	*********************************************************************
//	MENU DE CIUDADES / SECCIONES
// 	*********************************************************************		
/* 
		Cambio hecho a pedido de Quality Courses: para los servicios definidos
		mostrar el menu al lado izquierdo (y no en la parte superior)
*/
/*
		Nuevo cambio del 14/02/2007: el menu de ciudades debe volver al elegir un servicio
*/
	if (($idServicio!="") && !($esServicio)) {
			$miSQL = "SELECT nombreLocal, textoEnlace, nombreHTML 
							  FROM tserviciociudadpais
							  WHERE idPais = $idPais
							    AND idServicio = $idServicio";	
			$registros = mysql_query($miSQL);
			$definidos = 0;
			while($un_registro = mysql_fetch_array($registros)){
			
			$nombre 			= $un_registro["nombreLocal"];
			$link					= $un_registro["nombreHTML"];
			$textoEnlace	= $un_registro["textoEnlace"];
			
			switch ($idServicio) {
				case 1:
					$prefijo = $prefijoCursoPrecios;
					break;
				case 2:
					$prefijo = $prefijoAcomodacion;
					break;
				case 10:
					$prefijo = $prefijoActividades;
					break;
				default:
					$prefijo = "";
			}
			
			$t->newBlock("ciudades");
			$t->assign(array(	
												nombre => $nombre,
												link => $link,
												prefijo => $prefijo,
												textoEnlace => $textoEnlace
											)
								);				
			$definidos = $definidos + 1;
			}
	}	

	if ($definidos==0)
	{	
	$miSQL_ciudades = "SELECT tciudadpais.nombreLocal, tciudadpais.textoEnlace, tciudadpais.nombreHTML, mciudad.orden
											FROM tciudadpais, mciudad
											WHERE mciudad.id = tciudadpais.idciudad
											AND idPais = $idPais
											AND visible=1
											ORDER BY mciudad.orden ASC";
	$ciudades = mysql_query($miSQL_ciudades);		
	if($ciudades) {
    while($una_ciudad = mysql_fetch_object($ciudades)){
			$nombreCiudad 	= $una_ciudad->nombreLocal;
			$linkCiudad			= $una_ciudad->nombreHTML;
			$textoEnlace		= $una_ciudad->textoEnlace;
			$t->newBlock("ciudades");
			$t->assign(array(	
												nombre => $nombreCiudad,
												link => $linkCiudad,
												prefijo => $prefijoCiudad,
												textoEnlace => $textoEnlace
											)
								);			
			}
		}										 
	}

// *********************************************************************
//	MENU DE SERVICIOS (DERECHA
// *********************************************************************		
		$miSQL_servicios = "SELECT tserviciopais.nombreLocal, tserviciopais.nombreHTML
												FROM tserviciopais, mservicio
												WHERE mservicio.id = tserviciopais.idServicio
												  AND idPais = $idPais
													AND visible=1
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