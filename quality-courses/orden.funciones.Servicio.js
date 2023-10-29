function editar(i){
	id=elementos[i].split("value='")[1];
	id=id.split("'")[0];
	nombre=elementos[i].split("<")[0];
	nuevoNombre = window.prompt('Ingrese el nuevo nombre para '+nombre,nombre);
	alert(nuevoNombre);
	alert("editor.Servicio.php?idServicio="+id+"&NombreServicio="+nuevoNombre);
	//location="editor.Servicio.php?idPais="+id;
}

function eliminar(i){
	id=elementos[i].split("value='")[1];
	id=id.split("'")[0];
	
	nombre=elementos[i].split("<input")[0];
		nombre=nombre.replace("<strike>","");
		nombre=nombre.replace("</strike>","");
	
	if (confirm('Cambiar visibilidad de -> '+nombre)){
		location = "editor.Servicios._Eliminar.php?idServicio="+id 
	}
}