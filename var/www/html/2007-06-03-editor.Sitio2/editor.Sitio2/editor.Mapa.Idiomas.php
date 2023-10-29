<?php
//	include ("_SEC.seguridad.php");
	include("../FCKeditor/fckeditor.php") ;
	require_once('../_rutina.coneccion.php');	
	require_once('../class.TemplatePower/class.TemplatePower.inc.php'); 	
	include ("../_obtener.variables.php");	

	$miSQL = "SELECT * FROM npmidioma";
	$idiomas	= mysql_query($miSQL);
	
	$miSQL = "SELECT * FROM npmpais";
	$paises	= mysql_query($miSQL);

	$numeroDePaises=0;
	echo "<table border='1' cellspacing='0' cellpadding='2'>";
	
	echo "<tr>";
	echo "<td>&nbsp;</td>";
	while ($un_pais = mysql_fetch_array($paises)) {
	
		$miSQL = "SELECT COUNT(*) AS numeroCiudades FROM npmciudad WHERE idPais=".$un_pais["id"];
		$definido	= mysql_query($miSQL);
		$definido = mysql_fetch_array($definido);
	
		echo "<td align='center'>
						<a href='editor.Lista.Ciudades.php?idPais=".$un_pais["id"]."'>
							<font size='2' face='Trebuchet MS'>
								".$un_pais["nombre"]."
							</font>
						</a><br />
						<font size='1' face='Trebuchet MS'>Nº ciudades: ".$definido["numeroCiudades"]."</font>
					</td>";
		$numeroDePaises++;
		$idPais[$numeroDePaises]=$un_pais["id"];
		$nombrePais[$numeroDePaises]=$un_pais["nombre"];
	}
	echo "</tr>";
	
	while ($un_idioma = mysql_fetch_array($idiomas)) {		
		$idIdioma=$un_idioma["id"];
		echo "<tr>
						<td>
							<a href='editor.Idioma.php?idIdioma=$idIdioma'>
							<font size='2' face='Trebuchet MS'>".$un_idioma["nombre"]."</font>
							<a>
						</td>";
		
		for ($i=1;$i<=$numeroDePaises;$i++){
			
			$miSQL="SELECT COUNT(*) AS DEFINIDO FROM nptidiomapais WHERE idIdioma=$idIdioma AND idPais=$idPais[$i]";
			$definido	= mysql_query($miSQL);
			$definido = mysql_fetch_array($definido);
			if ($definido["DEFINIDO"]>0) {$fondo="#FFCC99";$nuevo="";$icono="ico_editar.png";} else { $fondo="#FFFFFF";$nuevo="&txtAgregaPais=$nombrePais[$i]";$icono="ico_nuevo.png";}
			
			echo "<td bgcolor='$fondo'>
							<div align='center'>
							<a href='editor.Idioma.Pais.php?idIdioma=$idIdioma&idPais=$idPais[$i]$nuevo'><img src='imagenes/$icono' border='0' hspace='5' /></a>";
							
			if ($nuevo=="") {
				$miSQL = "SELECT directorio FROM nptidiomapais WHERE idIdioma=$idIdioma AND idPais=$idPais[$i]";
				$ruta	= mysql_query($miSQL);
				if ($ruta) {
					$ruta = mysql_fetch_array($ruta);
					if ($ruta["directorio"]!=""){
						echo "<a href='../".$ruta["directorio"]."/' target='_new'><img src='imagenes/ico_ver.png' border='0' hspace='5' /></a>
									</div>
									<hr size='1' />
									<font face='Arial' size='1'>
										• Ciudades: <b>x</b><br />
										• Servicios: <b>y</b><br />
										• Serv/Ciud: <b>z</b><br />
									</font>";
					}
				}
			}
			echo "</td>";
		}
		echo "</tr>";
	}

	echo "</table>";
?>