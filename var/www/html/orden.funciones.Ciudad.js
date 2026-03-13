function editar(i){
	id=elementos[i].split("value='")[1];
	id=id.split("'")[0];
	window.top.location="editor.Ciudades.php?idCiudad="+id;
}

function eliminar(i){
	id=elementos[i].split("value='")[1];
	id=id.split("'")[0];

	nombre=elementos[i].split("<input")[0];
		nombre=nombre.replace("<strike>","");
		nombre=nombre.replace("</strike>","");	
	
	if (confirm('Cambiar visibilidad de -> '+nombre)){
		location = "editor.Ciudades._Eliminar.php?idCiudad="+id 
	}
}