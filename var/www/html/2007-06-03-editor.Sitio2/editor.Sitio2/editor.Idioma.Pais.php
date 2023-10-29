<?php

//	include ("_SEC.seguridad.php");
	include("../FCKeditor/fckeditor.php") ;
	require_once('../_rutina.coneccion.php');	
	require_once('../class.TemplatePower/class.TemplatePower.inc.php'); 	
	include ("../_obtener.variables.php");	

//	Preparación de la plantilla respectiva

	$t = new TemplatePower("./editor.Idioma.Pais_tp.htm");
	$t->prepare();		

	//	Agregado
	if ($txtAgregaPais!="") {
		$Titulo = "Definiendo: <b>".$txtAgregaPais."</b>";	
		$Agregando=1;
		$AccionFormulario='editor.Idioma.Pais._Graba.php';
	}
	//	Edición
	else{
		$idPais 	= $_GET["idPais"];
		$idIdioma = $_GET["idIdioma"];
		
		$Agregando=0;
		$AccionFormulario='editor.Idioma.Pais._Edita.php';
		
		$miSQL = "SELECT *
							FROM nptidiomapais 
							WHERE idIdioma = $idIdioma
								AND idPais = $idPais";

		$paises = mysql_query($miSQL);
		$pais = mysql_fetch_array($paises);	
		
		$Titulo 									= "Editando: <b>".$pais["nombre"]."</b> - Idioma <b>$idIdioma</b>";
		$txtAgregaPais 						= $pais["nombre"];
		$txtNombreEnlace 					= $pais["nombreLocal"];
		$txtDirectorio 						= $pais["directorio"];
		$txtDescripcion 					= $pais["descripcion"];
		$txtIdiomas 							= $pais["textoIdiomas"];
		$txtMarquesina 						= $pais["html_marquesina"];
		$txtNombreBarraNavegacion = $pais["nombreBarraNavegacion"];
		
		$txtPrefijoCiudad 				= $pais["prefijoCiudad"];
		$txtPrefijoCursoPrecios 	= $pais["prefijoCursoPrecios"];
		$txtPrefijoAcomodacion 		= $pais["prefijoAcomodacion"];
		$txtPrefijoActividades		= $pais["prefijoActividades"];
		
		$txtTitle 								= $pais["title"];

		$html_superior1 = $pais["html_superior1"];
		$html_superior2 = $pais["html_superior2"];
		$html_superior3 = $pais["html_superior3"];
		
		$html_direccion = $pais["html_direccion"];
		$html_pie 			= $pais["html_pie"];
		$html_contenido = $pais["html_contenido"];
		


//	*****************************************************************
//	Definición de las Ciudades
//	*****************************************************************
		$miSQL = "SELECT id, nombre FROM npmciudad WHERE idPais = $idPais ORDER BY orden";
		$ciudades = mysql_query($miSQL);
		if($ciudades) {
			while($una_ciudad = mysql_fetch_array($ciudades)){

					$idCiudad				= $una_ciudad["id"];
					$ciudadNombre 	= $una_ciudad["nombre"];
					
					$miSQL = "SELECT nombreLocal 
										FROM nptidiomapaisciudad 
										WHERE idIdioma=$idIdioma 
											AND idPais=$idPais 
											AND idCiudad=$idCiudad";
											
					$ciudadDefinida = mysql_query($miSQL);
					$definida = "<font color='#999999'><i>No definida</i></font>";
					$publicado = "<img src='../image/ico_nopublicado.png'>";
					while($parametros = mysql_fetch_array($ciudadDefinida)){
						$definida = $parametros["nombreLocal"];
						if ($parametros["publicado"]==1) $publicado = "<img src='../image/ico_publicado.png'>";
					}
				
				$t->newBlock("listaCiudades");
				$t->assign(array(	
													ciudadNombre => $ciudadNombre,
													ciudadDefinida => $definida,
													ciudadPublicada => $publicado,
													ciudadIdCiudad => $idCiudad,
													ciudadIdIdioma => $idIdioma,
													ciudadIdPais => $idPais
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
		$miSQL = "SELECT id, nombre FROM npmservicio ORDER BY orden";
		$servicios = mysql_query($miSQL);
		if($servicios) {
			while($un_servicio = mysql_fetch_array($servicios)){

					$idServicio			= $un_servicio["id"];
					$servicioNombre = $un_servicio["nombre"];
					
					$miSQL = "SELECT nombreLocal 
										FROM nptidiomapaisservicio 
										WHERE idPais = $idPais 
											AND idServicio = $idServicio
											AND idIdioma = $idIdioma";
					$servicioDefinido = mysql_query($miSQL);
					$definido = "<font color='#999999'><i>No definido</i></font>";
					while($parametros = mysql_fetch_array($servicioDefinido)){
						$definido = $parametros["nombreLocal"];
					}
					
					$miSQL = "SELECT COUNT(*) as cuenta 
										FROM nptidiomapaisserviciociudad
										WHERE idPais = $idPais 
											AND idServicio = $idServicio
											AND idIdioma = $idIdioma"; 
					$ServiciosDefinidos = mysql_query($miSQL);
					while($parametros = mysql_fetch_array($ServiciosDefinidos)){
						$numeroServiciosDefinidos = $parametros["cuenta"];
					}
					
				$t->newBlock("listaServicios");
				$t->assign(array(	
													servicioNombre => $servicioNombre,
													servicioDefinido => $definido,
													servicioIdServicio => $idServicio,
													servicioIdIdioma => $idIdioma,
													servicioIdPais => $idPais,
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
		$urlMetaTags="editor.MetaTags.php?tabla=nptidiomapais&criterio=idPais=$idPais AND idIdioma=$idIdioma";
	}
	
	
	$t->gotoBlock( "_ROOT" );
	
	$t->assign("AccionFormulario",$AccionFormulario);
	$t->assign("idPais",$idPais);
	$t->assign("idIdioma",$idIdioma);
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
	
	$t->assign("txthtml_superior1",htmlspecialchars(stripslashes($html_superior1)));
	$t->assign("txthtml_superior3",htmlspecialchars(stripslashes($html_superior3)));
	
	$t->printToScreen(); 
?>
