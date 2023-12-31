<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2006 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: sampleposteddata.php
 * 	This page lists the data posted by a form.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 * 		Jim Michaels (jmichae3@yahoo.com)
 */
?>
<meta http-equiv="Content-type" content='text/html; charset="ISO-8859-1"' />
<html>
	<head>
		<title>Test de POST</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow">
		<link href="../sample.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h1>Test de POST</h1>
		Datos recibidos.
		<hr>
		<table width="100%" border="1" cellspacing="0" bordercolor="#999999">
			<tr style="FONT-WEIGHT: bold; COLOR: #dddddd; BACKGROUND-COLOR: #999999">
				<td nowrap>Campo&nbsp;&nbsp;</td>
				<td>Valor</td>
			</tr>
<?php

if ( isset( $_POST ) )
   $postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
   $postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	$postedValue = htmlspecialchars( stripslashes( $value ) ) ;

?>
			<tr>
				<td valign="top" nowrap><b><?=$sForm?></b></td>
				<td width="100%"><?=$postedValue?></td>
			</tr>
<?php
}
?>
		</table>
	</body>
</html>
