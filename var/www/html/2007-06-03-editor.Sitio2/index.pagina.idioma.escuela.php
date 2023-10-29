<?	
	$modoDepuracion=0;
	
//	El código será el mismo que el del index, pero: 
//		-	apuntando a las nuevas tablas y 
//		- especificando el pais y el idioma.	
	$nombreIdioma = $mi_array[2];
	$nombrePais		= $mi_array[4];
	$nombrePagina	= $mi_array[5];

//	VER ID IDIOMA	
		$miSQL = "SELECT * FROM npmidioma WHERE nombreLocal='$nombreIdioma'";
		$registros 	= mysql_query($miSQL); $registro 	= mysql_fetch_array($registros);	
		
		$idIdioma = $registro["id"];
		$plantilla = $registro["plantilla"];
//	FIN VER ID IDIOMA	

//	VER ID PAIS
		$miSQL = "SELECT * FROM nptidiomapais WHERE nombreLocal='$nombrePais' AND idIdioma = $idIdioma";
		$registros 	= mysql_query($miSQL); $registro 	= mysql_fetch_array($registros);	
		
		$idPais								= $registro["idPais"];
		$prefijoCiudad				= $registro["prefijoCiudad"];
		$prefijoCursoPrecios	= $registro["prefijoCursoPrecios"];
		$prefijoAcomodacion		= $registro["prefijoAcomodacion"];
		$prefijoActividades		= $registro["prefijoActividades"];
		
		$html_superior1				= $registro["html_superior1"];
		$html_superior2				= $registro["html_superior2"];
		$html_superior3				= $registro["html_superior3"];
		
		$html_direccion				= $registro["html_direccion"];
		$html_pie							= $registro["html_pie"];
		
		
//	FIN VER ID PAIS	

	if ($modoDepuracion==1)	
		echo "Idioma: $nombreIdioma | Pais: $nombrePais | Página: $nombrePagina <br />
					Idioma: $idIdioma | Pais: $idPais | Plantilla: $plantilla<hr />";

//	SACAR LISTA DE CIUDADES
		$miSQL = "SELECT nombreLocal, nombreHTML, textoEnlace FROM nptidiomapaisciudad 
							WHERE idIdioma = $idIdioma AND idPais = $idPais";
		$listaCiudades = mysql_query($miSQL);
//	FIN DE SACAR LISTA DE CIUDADES
		
//	SACAR LISTA DE SERVICIOS
		$miSQL = "SELECT nombreLocal, nombreHTML, textoEnlace FROM nptidiomapaisservicio 
							WHERE idIdioma = $idIdioma AND idPais = $idPais";
		$listaServicios = mysql_query($miSQL);
//	FIN DE SACAR LISTA DE SERVICIOS

//	VER SI SE PIDE LA PAGINA PRINCIPAL DEL PAIS EN EL IDIOMA
		if (($nombrePagina=="") || ($nombrePagina=="index.html") || ($nombrePagina=="index.htm")) {
		//	La página principal consulta la tabla nptIdiomaPais
				if ($modoDepuracion==1) echo "Página principal<hr />";
				$miSQL = "SELECT * FROM nptidiomapais
									WHERE idPais = $idPais AND idIdioma = $idIdioma";
				$registros 	= mysql_query($miSQL);
				if ($registros){
					$registro 	= mysql_fetch_array($registros);		
					
					$html_contenido	=	$registro["html_contenido"];
					$prefijo = $prefijoCiudad;
				}				
		} else {
//	VER SI ES CIUDAD
				$miSQL 	= "SELECT * FROM nptidiomapaisciudad
									WHERE nombreHTML='$nombrePagina' AND idPais = $idPais AND idIdioma = $idIdioma";
				$registros 	= mysql_query($miSQL);
				if ($registros){
					
					$registro 	= mysql_fetch_array($registros);		
					
					$idCiudad				=	$registro["idCiudad"];
					$html_contenido	=	$registro["html_contenido"];
					
					$html_menu				= $registro["html_menu"];
					$idMetas 					= $registro["idMetas"];
					$html_marquesina	= $registro["html_marquesina"]; 
					$titleSitio				= $registro["title"];
					$html_pieLocal		= $registro["html_pieLocal"]; 
					
					
					
					if ($idCiudad!="") {
						if ($modoDepuracion==1) echo "Página Ciudad<hr />";
						$prefijo = $prefijoCiudad;
					} else {
//	VER SI ES SERVICIO
							$miSQL 	= "SELECT * FROM nptidiomapaisservicio
												WHERE nombreHTML='$nombrePagina' AND idPais = $idPais AND idIdioma = $idIdioma";
							$registros 	= mysql_query($miSQL);
							if ($registros){
								
								$registro 			= mysql_fetch_array($registros);		
								
								$idServicio			=	$registro["idServicio"];
								$html_contenido	=	$registro["html_contenido"];
					
								$html_menu				= $registro["html_menu"];
								$idMetas 					= $registro["idMetas"];
								$html_marquesina	= $registro["html_marquesina"]; 
								$titleSitio				= $registro["title"];
								$html_pieLocal		= $registro["html_pieLocal"];								
								
								$prefijo 				= $prefijoCiudad;
								
								if ($idServicio!="") {
									if ($modoDepuracion==1) echo "Página Servicio<hr />";
							//	Cargar -si los tiene- la lista de SubServicios
									$miSQL = "SELECT * FROM nptidiomapaisserviciociudad
														WHERE idServicio=$idServicio AND idPais = $idPais AND idIdioma = $idIdioma";
									$registros 	= mysql_query($miSQL);
									if ($registros){
										while ($un_subServicio = mysql_fetch_array($registros)){
											$i=$i+1;
										}
										if ($i>0) {
											
											$listaCiudades = mysql_query($miSQL);
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
											}
										} 
									}
									
								}	else {
//	VER SI ES SERVICIO@CIUDAD
									
									$miSQL = "SELECT * 
														FROM nptidiomapaisserviciociudad
														WHERE nombreHTML='$nombrePagina' 
															AND idPais = $idPais 
															AND idIdioma = $idIdioma";
									if ($modoDepuracion==1) echo "Página SubServicio <hr />$miSQL<hr />";
									
									$registros 	= mysql_query($miSQL);
									if ($registros){
										
										$registro 			= mysql_fetch_array($registros);		
										
										$idServicio			=	$registro["idServicio"];
										$html_contenido	=	$registro["html_contenido"];
										
										$html_menu				= $registro["html_menu"];
										$idMetas 					= $registro["idMetas"];
										$html_marquesina	= $registro["html_marquesina"]; 
										$titleSitio				= $registro["title"];
										$html_pieLocal		= $registro["html_pieLocal"];										
										
										$prefijo 				= $prefijoCiudad;
									}		
								} 
							}
						}					
					}
				}

// 	BB - PREPARACION DE LA PLANTILLA
		if ($plantilla=="") {$plantilla="plantilla_tp2.htm";}
		$t = new TemplatePower($correccionSubdominio."./".$plantilla);
		$t->prepare(); 	
		
		$t->assign("html_contenido",$html_contenido);	
		
		$t->assign("html_superior",$html_superior);
		$t->assign("html_menu",$html_menu);
		$t->assign("html_inferior",$html_inferior);
		
		$t->assign("html_superior1",$html_superior1);
		$t->assign("html_superior2",$html_superior2);
		$t->assign("html_superior3",$html_superior3);		

		$t->assign("html_direccion",$html_direccion);
		$t->assign("html_pie",$html_pie);
			
		$t->assign("html_pieLocal",$html_pieLocal);
		
		if (trim($html_marquesina)=="") $html_marquesina="&nbsp;";
		$t->assign("html_marquesina",$html_marquesina);
		
// 	FIN DE BB


// TITLE Y METATAGS
		include "./index.METAS.php";
		$t->assign("miMetatag",$miMetatag);
		$t->assign("titleSitio",$titleSitio);
// FIN DE TITLE Y METATAGS


//	DD - LISTA CIUDADES
		if($listaCiudades) {
	    while($una_ciudad = mysql_fetch_array($listaCiudades)){
				$nombreLocal	= $una_ciudad["nombreLocal"];
				$nombreHTML 	= $una_ciudad["nombreHTML"];
				$textoEnlace	= $una_ciudad["textoEnlace"];
				
				$t->newBlock("ciudades");
				$t->assign(array(	
													nombre => $nombreLocal,
													link => $nombreHTML,
													prefijo => $prefijo,
													textoEnlace => $textoEnlace
												)
									);							
			}
		}
//	DD


//	EE - LISTA SERVICIOS
		if($listaServicios) {
	    while($un_servicio = mysql_fetch_array($listaServicios)){
				$nombreLocal	= $un_servicio["nombreLocal"];
				$nombreHTML 	= $un_servicio["nombreHTML"];
				$textoEnlace	= $un_servicio["textoEnlace"];
				
				$t->newBlock("servicios");
				$t->assign(array(	
													nombreServicio => $nombreLocal,
													linkServicio => $nombreHTML,
													textoEnlace => $textoEnlace
												)
									);							
			}
		}
//	EE


// 	CC - IMPRESION DE LA PLANTILLA
		$t->printToScreen();
//	CC

?>