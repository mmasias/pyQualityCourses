<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	

/*
	Preparación de la plantilla respectiva
	--------------------------------------
*/	
	$t = new TemplatePower("./editor.Paises_tp.htm");
	$t->prepare();		
	
/* 
	Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------
*/
	foreach($_POST as $nombre_campo => $valor){
	   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
	   eval($asignacion);
	} 
	//	Agregado
	if ($txtAgregaPais!="") {
		$Titulo = "Definiendo: <b>".$txtAgregaPais."</b>";	
		$Agregando=1;
		$AccionFormulario='editor.Paises._Graba.php';
	}
	//	Edición
	else{
		$id = $_GET["idPais"];
		$Agregando=0;
		$AccionFormulario='editor.Paises._Edita.php';
		
		$miSQL = "SELECT 	*
							FROM mpais 
							WHERE id=$id";
		
		$paises = mysql_query($miSQL);
		$pais = mysql_fetch_array($paises);	
		
		$Titulo 									= "Editando: <b>".$pais["nombre"]."</b>";
		$txtAgregaPais 						= $pais["nombre"];
		$txtNombreEnlace 					= $pais["nombreLocal"];
		$txtDirectorio 						= $pais["directorio"];
		$txtDescripcion 					= $pais["descripcion"];
		$txtIdiomas 							= $pais["textoIdiomas"];
		$txtIdiomas 							= $pais["textoIdiomas"];
		$txtMarquesina 						= $pais["html_marquesina"];
		$txtNombreBarraNavegacion = $pais["nombreBarraNavegacion"];
		
		$txtPrefijoCiudad 				= $pais["prefijoCiudad"];
		$txtPrefijoCursoPrecios 	= $pais["prefijoCursoPrecios"];
		$txtPrefijoAcomodacion 		= $pais["prefijoAcomodacion"];
		$txtPrefijoActividades		= $pais["prefijoActividades"];
		
		$txtTitle 								= $pais["title"];
		
		if ($pais["subdominio"]==1) {$chkSubdominio = "checked='checked'";}
		if ($pais["principal"]==1) {$chkPrincipal = "checked='checked'";}

		$html_superior2 = $pais["html_superior2"];
		$html_direccion = $pais["html_direccion"];
		$html_pie 			= $pais["html_pie"];
		$html_contenido = $pais["html_contenido"];

//	*****************************************************************
//	Definición de las Ciudades
//	*****************************************************************
		$miSQL = "SELECT id, nombre FROM mciudad ORDER BY orden";
		$ciudades = mysql_query($miSQL);
		if($ciudades) {
			while($una_ciudad = mysql_fetch_array($ciudades)){

					$idCiudad				= $una_ciudad["id"];
					$ciudadNombre 	= $una_ciudad["nombre"];
					
					$miSQL = "SELECT nombreLocal,publicado FROM tciudadpais WHERE idPais=$id AND idCiudad=$idCiudad";
					$ciudadDefinida = mysql_query($miSQL);
					$definida = "<font color='#999999'><i>No definida</i></font>";
					$publicado = "<img src='Image/ico_nopublicado.png'>";
					while($parametros = mysql_fetch_array($ciudadDefinida)){
						$definida = $parametros["nombreLocal"];
						if ($parametros["publicado"]==1) $publicado = "<img src='Image/ico_publicado.png'>";
					}
				
				$t->newBlock("listaCiudades");
				$t->assign(array(	
													ciudadNombre => $ciudadNombre,
													ciudadDefinida => $definida,
													ciudadPublicada => $publicado,
													ciudadIdCiudad => $idCiudad,
													ciudadIdPais => $id
												)
									); 	
				}
			}	
//	*****************************************************************			
//	FIN - Definición de las Ciudades
//	*****************************************************************

//	*****************************************************************			
//	INICIO - Definición de los servicios
//	*****************************************************************
		$miSQL = "SELECT id, nombre FROM mservicio ORDER BY orden";
		$servicios = mysql_query($miSQL);
		if($servicios) {
			while($un_servicio = mysql_fetch_array($servicios)){

					$idServicio			= $un_servicio["id"];
					$servicioNombre = $un_servicio["nombre"];
					
					$miSQL = "SELECT nombreLocal FROM tserviciopais WHERE idPais=$id AND idServicio=$idServicio";
					$servicioDefinido = mysql_query($miSQL);
					$definido = "<font color='#999999'><i>No definido</i></font>";
					while($parametros = mysql_fetch_array($servicioDefinido)){
						$definido = $parametros["nombreLocal"];
					}
					
					$miSQL = "SELECT COUNT(*) as cuenta 
										FROM tserviciociudadpais
										WHERE idPais = $id 
											AND idServicio = $idServicio"; 
					$ServiciosDefinidos = mysql_query($miSQL);
					while($parametros = mysql_fetch_array($ServiciosDefinidos)){
						$numeroServiciosDefinidos = $parametros["cuenta"];
					}
					
				$t->newBlock("listaServicios");
				$t->assign(array(	
													servicioNombre => $servicioNombre,
													servicioDefinido => $definido,
													servicioIdServicio => $idServicio,
													servicioIdPais => $id,
													numeroServiciosDefinidos => $numeroServiciosDefinidos
												)
									);
				}
			}				
//	*****************************************************************			
//	FIN - Definición de los Servicios
//	*****************************************************************
			
	}

	if ($Agregando==0){
		$urlMetaTags="editor.MetaTags.php?tabla=mpais&criterio=id=$id";
	}
	
	
	$t->gotoBlock( "_ROOT" );
	
	$t->assign("AccionFormulario",$AccionFormulario);
	$t->assign("id",$id);
	$t->assign("TituloSeccion",$Titulo);
	$t->assign("txtNombrePais",$txtAgregaPais);
	$t->assign("txtNombreEnlace",$txtNombreEnlace);
	$t->assign("txtDirectorio",$txtDirectorio);
	$t->assign("txtIdiomas",$txtIdiomas);
	$t->assign("txtDescripcion",$txtDescripcion);
	$t->assign("chkSubdominio",$chkSubdominio);
	$t->assign("chkPrincipal",$chkPrincipal);
	$t->assign("urlMetaTags",$urlMetaTags);
	$t->assign("txtMarquesina",$txtMarquesina);
	$t->assign("txtNombreBarraNavegacion",$txtNombreBarraNavegacion);

	$t->assign("txtPrefijoCiudad",$txtPrefijoCiudad);
	$t->assign("txtPrefijoCursoPrecios",$txtPrefijoCursoPrecios);
	$t->assign("txtPrefijoAcomodacion",$txtPrefijoAcomodacion);
	$t->assign("txtPrefijoActividades",$txtPrefijoActividades);
	
	$t->assign("txtTitle",$txtTitle);
	
	$t->assign("txthtml_superior2",htmlspecialchars(stripslashes($html_superior2)));
	$t->assign("txthtml_direccion",htmlspecialchars(stripslashes($html_direccion)));
	$t->assign("txthtml_contenido",htmlspecialchars(stripslashes($html_contenido)));
	$t->assign("txthtml_pie",htmlspecialchars(stripslashes($html_pie)));	
	
	$t->printToScreen(); 
?>
