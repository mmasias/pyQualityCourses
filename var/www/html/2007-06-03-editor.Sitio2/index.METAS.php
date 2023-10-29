<?PHP

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

?>