{"datos": [
<?php
include("funciones.php");
$archivo = $_REQUEST['archivo'];
$tipo    = $_REQUEST['tipo'];
include("../config.php");

if($tipo=="xls")
	$path_file = $path_xls;
elseif($tipo=="bmd")
	$path_file = $path_bmd;
else
	$path_file = $path_wtf;

$archivo = ereg_replace("[^A-Za-z]", "", $archivo);

$directorio=dir($path_file);
while ($file = $directorio->read()){
//	if(eregi($archivo, $file)!==false){
	if(strpos(strtolower($file), strtolower($archivo))===0){
		if($archivo!="Filter") {
			if($archivo!="item") {
				if($archivo!="Quest") {
					$cadena .= "{file: \"<a class='linkarchivo' href=".$_REQUEST['tarea'].".php?archivo=".$_REQUEST['archivo']."&file=$file&tipo=$tipo>$file</a>\"},";
				}
				else{
					if(strpos(strtolower($file), "questprogress")===0 || strpos(strtolower($file), "questwords")===0){
					}
					else{
						$cadena .= "{file: \"<a class='linkarchivo' href=".$_REQUEST['tarea'].".php?archivo=".$_REQUEST['archivo']."&file=$file&tipo=$tipo>$file</a>\"},";
					}
				}
			}
			else{
				if(strpos(strtolower($file), "itemadd")===0 || strpos(strtolower($file), "itemset")===0){
				}
				else{
					$cadena .= "{file: \"<a class='linkarchivo' href=".$_REQUEST['tarea'].".php?archivo=".$_REQUEST['archivo']."&file=$file>$file</a>\"},";
				}
			}
		}
		else{
			if(eregi("FilterName", $file)==false){
				$cadena .= "{file: \"<a class='linkarchivo' href=".$_REQUEST['tarea'].".php?archivo=".$_REQUEST['archivo']."&file=$file>$file</a>\"},";
			}
		}
	}
		
}
$directorio->close();
$cadena = substr_replace($cadena, '', -1);
echo $cadena;
?>
]}