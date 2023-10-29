<meta http-equiv="Content-type" content='text/html; charset="ISO-8859-1"' />
<?php
	$directorioBase = "";
	include("../FCKEditor/fckeditor.php");
?>
<html>
	<head>
	<title>Proyecto Quality-Courses - Pruebas de manejo de comillas</title>
	</head>
<body>
	<form action="sampleposteddataSQL.php" method="POST">
	<table width="100%" cellspacing="0">
		<tr>
			<td colspan="2">
				<h3>Editor general</h3>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" >
				<hr />
			</td>
		</tr>
		<tr><td colspan="2"><hr/></td></tr>
		<tr>
			<td colspan="2" align="center">
				<hr />
			</td>
		</tr>
		<tr><td colspan="2"><hr/></td></tr>
		<tr>
			<td width="20%" align="center" valign="top"><em>HTML Libre</em> <strong>Superior</strong> <br />
		  <img src="Image/imgSeccionesHTMLSuperior.gif"/></td>
			<td width="80%" valign="top">
				<?php
				$oFCKeditor = new FCKeditor('prueba') ;
				$oFCKeditor->BasePath = '../FCKEditor/';
				$oFCKeditor->Height = '300';
				$oFCKeditor->Config["CustomConfigurationsPath"] = '../../quality-courses/miFCKEditor.Config.js';
				$oFCKeditor->Value = $html_superior1;
				$oFCKeditor->Create();
				?>			
			</td>
		</tr>		
		<tr><td colspan="2"><hr/></td></tr>
	</table>
	<input type="submit">
	</form>
</body>
</html>