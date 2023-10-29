<?php
//	include ("_SEC.seguridad.php");
	$directorioBase = "";
	include("../FCKeditor/fckeditor.php") ;
	require_once('../_rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("../_obtener.variables.php");
/*----------------------------------------------------------*/	

	$t = new TemplatePower("./editor.ListaIdiomaServicioCiudadesPais_tp.htm");
	$t->prepare();	

	$miSQL 		= "SELECT nombre FROM npmidioma WHERE id=$idIdioma";
	$idiomas = mysql_query($miSQL);
	$idioma 	= mysql_fetch_array($idiomas);	
	$txtIdioma = $idioma["nombre"];
	
	$miSQL="SELECT nombre FROM npmservicio WHERE id=$idServicio";
	$servicios = mysql_query($miSQL);
	$servicio = mysql_fetch_array($servicios);	
	$txtServicio = $servicio["nombre"];
	
	$miSQL="SELECT nombre FROM npmpais WHERE id=$idPais";
	$paises = mysql_query($miSQL);
	$pais = mysql_fetch_array($paises);	
	$txtPais = $pais["nombre"];	
	
	$t->assign("txtNombreIdioma",$txtIdioma);
	$t->assign("txtNombreServicio",$txtServicio);
	$t->assign("txtNombrePais",$txtPais);
	
	$miSQL="SELECT id, nombre FROM npmciudad WHERE idPais=$idPais ORDER BY orden";
	$ciudades = mysql_query($miSQL);
	if($ciudades) {
		while($una_ciudad = mysql_fetch_array($ciudades)){

				$idCiudad				= $una_ciudad["id"];
				$ciudadNombre 	= $una_ciudad["nombre"];
				
				$miSQL = "SELECT nombreLocal 
									FROM nptidiomapaisserviciociudad 
									WHERE idPais = $idPais
										AND idServicio = $idServicio
										AND idCiudad = $idCiudad";
				$registros = mysql_query($miSQL);
				$registro = mysql_fetch_array($registros);	
				$definir = $registro["nombreLocal"];	
				if ($definir=="") {$definir="<font color='#999999'><i>No definido</i></font>";}
				
				$t->newBlock("listaServiciosCiudadesPais");
				$t->assign(array(	
													ciudadIdIdioma => $idIdioma,
													ciudadIdCiudad => $idCiudad,
													ciudadNombre => $ciudadNombre,
													ciudadDefinida => $definida,
													ciudadPublicada => $publicado,
													ciudadIdPais => $idPais,
													ciudadIdServicio => $idServicio,
													txtDefinir => $definir
												)
									); 					
				
		}
	}

	$t->printToScreen(); 

?>