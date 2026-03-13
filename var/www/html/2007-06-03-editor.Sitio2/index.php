<?php


/*
	********************************************************************************
		Script de carga de la página de Quality-Courses
		Programado por el equipo de Estrategias Moviles
	********************************************************************************
		v1.0 12 Enero 2007
		v0.9 Diciembre 2006
		v0.5 Noviembre 2006
	********************************************************************************
 */

	$modoDepuracion 			= 0; 	// Poner a 1 para ver todos los mensajes
	$dominioBase 					= "estrategiasmoviles.dyndns.org";//"quality-courses.com"; //"estrategiasmoviles.dyndns.org/quality-courses";
	$directorioBase 			= "/home/d150210/public_html/";
	
	include ("./index.correccion_subdominio.php");
	
	require_once($correccionSubdominio.'_rutina.coneccion.php');	
	require $correccionSubdominio."class.TemplatePower/class.TemplatePower.inc.php"; 	
	

	/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ($correccionSubdominio."_obtener.variables.php");
/*----------------------------------------------------------*/	

if ($modoDepuracion==1) {
echo "
<p><font face='Verdana' size='1'><b><font size='2'>Sitio Quality Courses - Modo de depuración</font></b><br /><br />
Sitio de Quality Courses | Editor -><b><a href='editor.FrontPage.php'>aquí</a></b> <br />
Punto de partida (temporal) -> <b><a href='spanish-course-barcelona.htm'>spanish-course-barcelona.htm</a></b><br /><br />
Depuración activada - Se mostrará información antes de la página. 
Comentarios y Sugerencias: <b><a href='mailto:manuel@estrategiasmoviles.com'>Manuel Masías</a></b></font><br />
<font face='Verdana' size='1'><p>Se pidió la página [<b>$pagina</b>] desde el directorio <b>[".getcwd()."]</b> <br />";
}

//correcció del ridícul caracter castellà [enye] ("ñ")
$pagina = str_replace("Ã±", "ñ", "$pagina");

//correcció del caracter alemany ä
$pagina = str_replace("Ã¤", "ä", "$pagina");

//	***************************************************************
// 	Ver si pide el sitio principal del pais
//	***************************************************************
if ($pagina=="") {

	if ($modoDepuracion==1) 
		{echo "Pide el sitio raiz <br />";}

	$miSQL = "SELECT *
						FROM mpais 
						WHERE directorio='".basename(getcwd())."'";
	$registros 	= mysql_query($miSQL);	
	$registro 	= mysql_fetch_array($registros);
	
	$idPais 					= $registro["id"];
	$html_contenido		= $registro["html_contenido"];
	$idMetas 					= $registro["idMetas"];
	$html_marquesina	= $registro["html_marquesina"];
	$titleSitio				= $registro["title"];
	$html_pieLocal		= $registro["html_pie"]; // <-- MMV - Agregado 11/04/07 
	
	} 
else 
//	***************************************************************
// 	Si no es el sitio raiz, ver si es una ciudad
//	***************************************************************
	{
	if ($idPais==""){
		$miSQL = "SELECT idCiudad, idPais, html_contenido, html_menu, idMetas, html_marquesina, title, html_pieLocal 
							FROM tciudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		if ($registros){
			$registro 	= mysql_fetch_array($registros);	
			
			$idPais 					= $registro["idPais"];
			$idCiudad 				= $registro["idCiudad"];
			$html_contenido		= $registro["html_contenido"];
			$html_menu				= $registro["html_menu"];
			$idMetas 					= $registro["idMetas"];
			$html_marquesina	= $registro["html_marquesina"];
			$titleSitio				= $registro["title"];
			$html_pieLocal		= $registro["html_pieLocal"];
		}
	}
	
	if ($modoDepuracion==1) {
		if ($idCiudad!="") 
			{echo "- Ciudad $idCiudad del Pais $idPais <br />";} 
		else 
			{echo "- No es ciudad <br />";}
	}
	
//	***************************************************************	
// 	Si no es ciudad, ver si es Servicio
//	***************************************************************
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idPais, html_contenido, html_menu,idMetas, html_marquesina, title, html_pieLocal 
							FROM tserviciopais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		if ($registros) {
			$registro 	= mysql_fetch_array($registros);	
			
			$idPais 					= $registro["idPais"];
			$idServicio 			= $registro["idServicio"];
			$html_contenido		= $registro["html_contenido"];
			$html_menu				= $registro["html_menu"];
			$idMetas 					= $registro["idMetas"];
			$html_marquesina	= $registro["html_marquesina"];
			$titleSitio				= $registro["title"];
			$html_pieLocal		= $registro["html_pieLocal"];		
		}
	}
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") 
			{echo "- Servicio $idServicio del Pais $idPais <br />";} 
		else 
			{echo "- No es servicio <br />";}
	}

//	***************************************************************		
// 	Si no es ciudad ni servicio, ver si es Seccion
//	***************************************************************	
	if ($idPais==""){
		$miSQL = "SELECT idServicio, idCiudad, idPais, html_contenido, html_menu,idMetas, html_marquesina, title, html_pieLocal 
							FROM tserviciociudadpais 
							WHERE nombreHTML='$pagina'";
		$registros 	= mysql_query($miSQL);
		if ($registros) {
			$registro 	= mysql_fetch_array($registros);	
			
			$idPais 					= $registro["idPais"];
			$idCiudad 				= $registro["idCiudad"];
			$idServicio 			= $registro["idServicio"];
			$html_contenido		= $registro["html_contenido"];
			$html_menu				= $registro["html_menu"];
			$idMetas 					= $registro["idMetas"];
			$esServicio				=	true; // Ultimo cambio 14/02/2007
			$html_marquesina	= $registro["html_marquesina"]; // Ultimo cambio 15/02/2007
			$titleSitio				= $registro["title"];
			$html_pieLocal		= $registro["html_pieLocal"]; // Se dedujo de solicitud del 06/03/2007
		}
	}
	
	if ($modoDepuracion==1) {
		if ($idServicio!="") 
			{echo "- Servicio $idServicio en la ciudad $idCiudad del Pais $idPais <br />";} 
		else 
			{echo "- No es extensión de servicio <br /><br />";}
	}
}

//	***************************************************************
// 	Si no existe, viene el SEGUNDO análisis de la URL
//	***************************************************************
if ($idPais=="" && $idCiudad=="" && $idServicio==""){
		
	//	Deteccion de expresiones regulares
			if ($modoDepuracion==1) {	echo "<b>Expresiónes regulares:</b> Analizando <i>$pagina</i><br/>"; }
			if (ereg ("^(cursos-)([[:alpha:]]+)\.(htm$|html$)", $pagina, $mi_array)) {
				if ($modoDepuracion==1) {	echo "- Detectado patrón $mi_array[2] <br />"; }
				include ("index.pagina.idioma.php");
			} else 
			//if (ereg ("^(cursos-)([[:alpha:]]+)(-escuelas-)([[:alpha:]]+)\/([[:alpha:]]+\.(htm$|html$))", $pagina, $mi_array)) {
			if (ereg ("^(cursos-)([[:alpha:]]+)(-escuelas-)([[:alpha:]]+)\/(.+\.(htm$|html$))", $pagina, $mi_array)) {
				if ($modoDepuracion==1) {	echo "- Detectado patrón $mi_array[2] + $mi_array[4] + $mi_array[5] <br />"; }
				include ("index.pagina.idioma.escuela.php");
			} else
			if (ereg ("^(cursos-)([[:alpha:]]+)(-escuelas-)([[:alpha:]]+)[\/]*$", $pagina, $mi_array)) {
				if ($modoDepuracion==1) {	echo "- Detectado patrón $mi_array[2] + $mi_array[4] <br />"; }
				include ("index.pagina.idioma.escuela.php");
			} else {
			
			//	************************************************
			//	Si no se ha encontrado el patrón, en este punto, intentar
			//	encontrar una página con ese nombre
			//	************************************************
					if ($modoDepuracion==1) {echo "- No se ha detectado ningún patrón <br />";}
					$i=0;
					if($lineas = @file($pagina))
					{
						
						while($lineas[$i])
						{
						   echo "$lineas[$i]";
						   $i++;
						}
						exit;
					}

					if ($i==0){
						echo "<html><head><title>Documento no encontrado</title></head><body>";
						echo "<h1>Documento no encontrado</h1>
									El documento: <b>$pagina</b> no ha sido encontrado en nuestro servidor.<br>
									El error ha sido comunicado al administrador del sitio. 
									Disculpe las molestias ocasionadas.";
						echo "</body></head></html>";
					}
			//	************************************************
			//	INTENTAR ENCONTRAR UN ARCHIVO CON ESE NOMBRE
	    //	************************************************
			
			}  
		
	}
		else
//	***************************************************************
// 	La página existe!!!
//	***************************************************************
	{
		if ($modoDepuracion==1) {echo "Construyendo la página...</p></font><hr />";}
		
		$t = new TemplatePower($correccionSubdominio."./plantilla_tp2.htm");
		$t->prepare(); 

// 	*********************************************************************		
// 	Navegador superior 
// 	Descripción del Pais + Descripcion del Servicio/Ciudad + [Descripcion del Servicio]
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
			$miNavegador = $miNavegador." » <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
		
		$miSQL = "SELECT nombreBarraNavegacion, nombreHTML 
							FROM tserviciopais 
							WHERE idServicio=$idServicio AND idPais=$idPais";
		$registros = mysql_query($miSQL);
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			$miNavegador = $miNavegador." » <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
if ($un_registro["nombreHTML"]=="") {$noMostrarBarra = 1;}
		}
		
		$miSQL = "SELECT nombreBarraNavegacion, nombreHTML 
							FROM tserviciociudadpais 
							WHERE idServicio=$idServicio AND idciudad=$idCiudad AND idPais=$idPais";
		$registros = mysql_query($miSQL);
		if($registros) {
			$un_registro = mysql_fetch_array($registros);
			$miNavegador = $miNavegador." » <a class='navegador' href='".$un_registro["nombreHTML"]."'>".$un_registro["nombreBarraNavegacion"]."</a>";
		}
// 	*********************************************************************			

// *********************************************************************
// INICIO DATOS GENERALES DEL SITIO
// *********************************************************************
		$consulta = "SELECT * FROM msitio";
		$sitio = mysql_query($consulta);
		if($sitio){
			$datos_sitio = mysql_fetch_array($sitio);
			//	$titleSitio = $datos_sitio["title"];
			
			// Cambios del 05 de Abril: 
					$html_superior1_global = $datos_sitio["html_superior1"]; 
					$html_superior3_global = $datos_sitio["html_superior3"]; 
			
			if ($html_menu=="") {$html_menu = $datos_sitio["html_menu"];}
			$html_inferior = $datos_sitio["html_inferior"];
			
			$t->assign("html_superior",$html_superior);
			$t->assign("html_menu",$html_menu);
			$t->assign("html_inferior",$html_inferior);	
			
			$t->assign("html_pieLocal",$html_pieLocal);
			
			if (trim($html_marquesina)=="") {$html_marquesina="&nbsp;";}	// Comentario de Manuel 22-02-07
			$t->assign("html_marquesina",$html_marquesina);	
			
//			$t->assign("miNavegador",$miNavegador);
if ($noMostrarBarra!=1) {$t->assign("miNavegador",$miNavegador);}
			
			$t->assign("html_contenido",$html_contenido);	
			
		}	
		
// *********************************************************************
// METATAGS 
// *********************************************************************
	$miSQL = "SELECT * FROM mmetas WHERE visible=1 ORDER BY id";
	$metatags = mysql_query($miSQL);			
	if ($metatags) {
    while($metatag = mysql_fetch_array($metatags)){
			$idMeta = $metatag["id"];
			$miSQL_mt = "SELECT * FROM tmetasextendido WHERE idMeta = $idMeta AND idtMetas = $idMetas";
			$metaDefinido = mysql_query($miSQL_mt);

			if ($metaDefinido) {
					$metaDefinido_r = mysql_fetch_array($metaDefinido);
					$descripcionMetaDefinido = $metaDefinido_r["descripcion"];
				} 
			
			if (trim($descripcionMetaDefinido)=="") {
					$descripcionMetaDefinido = $metatag["valorGenerico"];
				}
			if ($descripcionMetaDefinido!=""){
			$miMetatag=$miMetatag."<META ".$metatag["nombre"]." ".$metatag["descriptor"]."=\"".$descripcionMetaDefinido."\">\r\n";
			}
			
			
			if (($metatag["nombre"]=="name=\"title\"") && (trim($titleSitio)=="")) {
					$titleSitio=$descripcionMetaDefinido;
				}
			
		}
	}	
	
	$t->assign("miMetatag",$miMetatag);
	$t->assign("titleSitio",$titleSitio);	

// *********************************************************************
// CONTENIDO f(PAIS)
// *********************************************************************
	$miSQL = "SELECT 	html_superior2, html_direccion, html_pie, textoIdiomas, 
										prefijoCiudad, prefijoCursoPrecios, prefijoAcomodacion, prefijoActividades,
										html_superior1, html_superior3
						FROM mpais
						WHERE id = $idPais";

	$paises = mysql_query($miSQL);			
	$pais 	= mysql_fetch_array($paises);	
	
	$html_superior2	= $pais["html_superior2"];
	$html_direccion	= $pais["html_direccion"];
	//$html_pie				= $pais["html_pie"];	
	$textoIdiomas		= $pais["textoIdiomas"];
	
	$prefijoCiudad				= $pais["prefijoCiudad"];
	$prefijoCursoPrecios	= $pais["prefijoCursoPrecios"];
	$prefijoAcomodacion		= $pais["prefijoAcomodacion"];
	$prefijoActividades		= $pais["prefijoActividades"];

	$html_superior1 = $pais["html_superior1"];
	$html_superior3 = $pais["html_superior3"];
	if ($html_superior1=="") {$html_superior1=$html_superior1_global;}
	if ($html_superior3=="") {$html_superior3=$html_superior3_global;}
	
	$t->assign("html_superior2",$html_superior2);
	$t->assign("html_direccion",$html_direccion);
	$t->assign("html_pie",$html_pie);
	$t->assign("textoIdiomas",$textoIdiomas);
	$t->assign("html_superior1",$html_superior1);
	$t->assign("html_superior3",$html_superior3);
	
	
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
			
		// **********************************************************************
		// NOTA: Liberar el siguiente bloque if() en el servidor de producción
		// **********************************************************************

			if ($subdominio==1) {
//if ($directorio=="") {$directorio="www";}
				$link = $directorio.'.'.$dominioBase.'/';
			} else {
				$link = $dominioBase.'/'.$directorio;
			}



			if ($principal==1) {$link="www.".$dominioBase.'/';}
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
//	MENU DE SERVICIOS (DERECHA)
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






