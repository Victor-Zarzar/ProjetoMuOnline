<?
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];

include("funciones.php");

function parse_txt($file){
	include("../config.php");
	$path_file = "../archivos/txt/";
	$archivo = file($path_txt.$file);
	$ver_parte2 = "";
	foreach($archivo as $linea){
		$pos = strpos($linea, "//");
//		if ($pos !== false) {
			$comen = substr($linea,$pos);
			$linea = substr_replace($linea,'',$pos);
//		}
//		else
//			$comen = "";
		$linea = preg_replace('/\t+/', ' ', $linea);
		$linea = preg_replace('/\s+/', '	', $linea);
		$ver_parte2 .= trim($linea).$comen;
	}
	return $ver_parte2;
}

$textos = parse_txt('item(New).txt');
echo $textos;
?>