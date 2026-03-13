function imprime_listado(){
	texto="<table cellspacing='0' cellpadding='2' width='95%'>";
	for (i=0;i<elementos.length;i++){
		texto += "<tr>";
		texto += "<td width='18' class='tablaRegistro'><a href='#' onclick='editar("+ i +")'><img src='image/ico_editar.png' width='16' height='16' border='0'></a></td>"
		texto += "<td class='tablaRegistro'>" + elementos[i] + "</td>";
		if (i!=0){
			texto += "<td width='18' align='center' class='tablaRegistro'><a href='#' onclick='arriba(" + i + ")'><img src='image/ico_arriba.png' width='16' height='16' border='0'></a></td>";
		}else{
			texto += "<td width='18' align='center' class='tablaRegistro'>&nbsp;</td>";
		}
		if (i!=elementos.length-1){
			texto += "<td width='18' align='center' class='tablaRegistro'><a href='#' onclick='abajo(" + i + ")'><img src='image/ico_abajo.png' width='16' height='16' border='0'></a></td>";
		}else{
			texto += "<td width='18' align='center' class='tablaRegistro'>&nbsp;</td>";
		}
		texto += "<td width='18' align='center' class='tablaRegistro'><a href='#' onclick='eliminar("+ i +")'><img src='image/ico_eliminar.png' width='16' height='16' border='0'></a></td>"
		texto += "</tr>";
	}
	
	texto += "</table>";
	xInnerHtml('listado_elementos',texto);
}

function arriba(i){
	temporal = elementos[i];
	elementos[i]=elementos[i-1];
	elementos[i-1]=temporal;
	imprime_listado()
}

function abajo(i){
	temporal = elementos[i];
	elementos[i]=elementos[i+1];
	elementos[i+1]=temporal;
	imprime_listado()
}