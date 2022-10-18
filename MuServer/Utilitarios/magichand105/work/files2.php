{"datos": [
<?php
include("funciones.php");
$tipo    = $_REQUEST['tipo'];
include("../config.php");

if($tipo=="main")
	$path_file = $path_main;
if($tipo=="att"){
	$path_file = $path_att_map;
	$ext       = "att";
}
if($tipo=="map"){
	$path_file = $path_att_map;
	$ext       = "map";
}
$archivo = ereg_replace("[^A-Za-z]", "", $archivo);

$directorio=dir($path_file);
while ($file = $directorio->read()){
	if(isset($ext)){
		$res = explode(".", $file);
		if($res[count($res)-1]==$tipo)
			$cadena .= "{file: \"".$file."\"},";
	}
	else{
		if(strpos(strtolower($file), strtolower($tipo))===0){
			$cadena .= "{file: \"".$file."\"},";
		}
	}
}
$directorio->close();
$cadena = substr_replace($cadena, '', -1);
echo $cadena;
?>
]}