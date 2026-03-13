<?	
	$nombreIdioma = $mi_array[2];
	
//	VER ID IDIOMA	
		$miSQL = "SELECT * 
							FROM npmidioma
							WHERE nombreLocal='$nombreIdioma'";
		$registros 	= mysql_query($miSQL);
		$registro 	= mysql_fetch_array($registros);	
		
		$idIdioma = $registro["id"];
		$plantilla = $registro["plantilla"];
//	FIN VER ID IDIOMA	

	$html_contenido = $registro["html_contenido"];
	$prefijo_paises = $registro["prefijoPaises"];

// 	BB - PREPARACION DE LA PLANTILLA
		if ($plantilla=="") {$plantilla="plantilla_tp2.htm";}
		$t = new TemplatePower($correccionSubdominio."./".$plantilla);
		$t->prepare(); 	
		$t->assign("html_contenido",$html_contenido);
// 	FIN DE BB

//	AA - EXTRAER LOS PAISES DEL IDIOMA
		$miSQL = "SELECT * FROM nptIdiomaPais WHERE idIdioma=$idIdioma";
		$paises	= mysql_query($miSQL);
		if($paises) {
	    while($un_pais = mysql_fetch_array($paises)){
				$pais = $un_pais["nombre"];
				$linkPais = "cursos-".$nombreIdioma."-escuelas-".$un_pais["nombreLocal"]."/index.html";
				
				$t->newBlock("ciudades");
				$t->assign(array(	
													prefijo => $prefijo_paises,
													nombre => $pais,
													link => $linkPais
												)
									);							
			}
		}
		
//	FIN DE AA
		
// 	CC - IMPRESION DE LA PLANTILLA
		$t->printToScreen();
//	CC

?>