<?php
$archivo = $_REQUEST['archivo'];
include("funciones.php");
include("../config.php");

if($archivo=="deco"){
	$directorio=dir($path_oz);
	while ($archivo = $directorio->read()){
		deco_gmu($archivo);
	}
}
else{
	$directorio=dir($path_graf);
	while ($archivo = $directorio->read()){
		enco_gmu($archivo);
	}
}
$directorio->close();
?>