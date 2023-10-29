<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php") ;
	require_once('rutina.coneccion.php');	
	require "../class.TemplatePower/class.TemplatePower.inc.php"; 	
/*Obtener las variables para ambos casos: Agregado y Edición
	----------------------------------------------------------*/
	include ("_obtener.variables.php");
/*----------------------------------------------------------*/	


/*
	Preparación de la plantilla respectiva
	--------------------------------------
*/	
	$t = new TemplatePower("./editor.ListaServicioCiudadesPais_tp.htm");
	$t->prepare();	
	
	$miSQL="SELECT nombre FROM mservicio WHERE id=$idServicio";
	$servicios = mysql_query($miSQL);
	$servicio = mysql_fetch_array($servicios);	
	$txtServicio = $servicio["nombre"];
	
	$miSQL="SELECT nombre FROM mpais WHERE id=$idPais";
	$paises = mysql_query($miSQL);
	$pais = mysql_fetch_array($paises);	
	$txtPais = $pais["nombre"];	
	
	$t->assign("txtNombreServicio",$txtServicio);
	$t->assign("txtNombrePais",$txtPais);
		
	
	$miSQL="SELECT id, nombre FROM mciudad WHERE visible=1 ORDER BY orden";
	$ciudades = mysql_query($miSQL);
	if($ciudades) {
		while($una_ciudad = mysql_fetch_array($ciudades)){

				$idCiudad				= $una_ciudad["id"];
				$ciudadNombre 	= $una_ciudad["nombre"];
				
				
				
				$miSQL = "SELECT nombreLocal 
									FROM tserviciociudadpais 
									WHERE idPais = $idPais
										AND idServicio = $idServicio
										AND idCiudad = $idCiudad";
				$registros = mysql_query($miSQL);
				$registro = mysql_fetch_array($registros);	
				$definir = $registro["nombreLocal"];	
				if ($definir=="") {$definir="<font color='#999999'><i>No definido</i></font>";}
				
				$t->newBlock("listaServiciosCiudadesPais");
				$t->assign(array(	
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