<?php
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];
include("funciones.php");
$archivo = version_file($archivo, $file);
include("../config.php");
include("../lang.php");
($archivo=="message") ? ($path_file=$path_wtf) : ($path_file=$path_bmd);
$contenido = abrir($path_file.$file);

	$top  = "/////////////////////////////////////////////////////////////////////////////////\r\n";
	$top .= "// Creado con Mu Editor MagicHand\r\n";
	$top .= "/////////////////////////////////////////////////////////////////////////////////\r\n";
	$top .= "\r\n";
	$top .= "\r\n";
	
	$start = ($_REQUEST["start"] == null)? 0 : $_REQUEST["start"];

if($archivo=="text"){
	$limit  = cantidad( $contenido, 2, 4);
	$inicio = 6;
	$datos = $top;
	for($i=0;$nTexto<=$limit;$i++){
		$nTexto   = cantidad( $contenido, $inicio, 4);
		$lTexto   = cantidad( $contenido, $inicio + 4, 4);
		$arrastre = (1 - $inicio) % 3;
		$datos .= $nTexto."\t";
		$pasar = array();
//		($lTexto>255) ? ($largo = 255) : ($largo = $lTexto);
		for($j=0;$j<$lTexto;$j++)
			$pasar[$j] = substr($contenido, $inicio + 8 + $j, 1);
		$datos .= iconv($txt_lang, "UTF-8", decoBmd2(0, $pasar, $inicio + 8, $lTexto, $arrastre))."\r\n";
		$inicio += $lTexto + 8;
	}
}
elseif($archivo=="message"){
	$inicio  = 28;
	$cuantos = cantidad( $contenido, 24, 4);

	$datos = $top;

	for($i=0;$i<$cuantos;$i++){
		$dato1  = cantidad( $contenido, $inicio, 1);
		$dato2  = cantidad( $contenido, $inicio + 1, 1);
		$lTexto = cantidad( $contenido, $inicio + 2, 2);
		$pasar = array();
		for($j=0;$j<$lTexto;$j++)
			$pasar[$j] = substr($contenido, $inicio + 4 + $j, 1);
		$datos .= $dato1."\t";
		$datos .= $dato2."\t";
		$datos .= decoWtf($pasar, $lTexto)."\r\n";
		$inicio += $lTexto + 4;
	}
}
elseif($archivo=="JewelOfHarmonySmelt"){
	if($conf[6]==1){
		$contenido = substr($contenido, $conf[9] + $conf[7] * $start, $conf[8]);
		$start = 0;
	}
	$limit = ($_REQUEST["limit"] == null)? intval((strlen($contenido)) / $conf[1]) : $start + $_REQUEST["limit"];
	
	$datos .= "ORDEN\t";
	for($h = 0;$h < count($col); $h++)
		$datos .= $col[$h][0]."\t";
	$datos = substr_replace($datos, '', -1);
	$datos .= "\n";

	for($i=$start;$i<$limit;$i++){
		$posicion = $i * $conf[1];
		$arrastre = $conf[2] * $i + $conf[3];
		$datos .= $i."\t";
		for($h = 0;$h < count($col); $h++){
			$pasar = array();
			for($j=0;$j<$col[$h][3];$j++)
				$pasar[$j] = substr($contenido, $posicion + $col[$h][2] + $j, 1);
			$dato = decoBmd2($col[$h][1], $pasar, $posicion+$col[$h][2], $col[$h][3], $arrastre);
			$datos .= $dato."\t";
		}
		$datos = substr_replace($datos, '', -1);
		$datos .= "\n";
	}
	$datos = substr_replace($datos, '', -1);
}
else{
	if($conf[6]==1){
		$contenido = substr($contenido, $conf[9] + $conf[7] * $start, $conf[8]);
		$start = 0;
	}
	$limit = ($_REQUEST["limit"] == null)? intval((strlen($contenido)) / $conf[1]) : $start + $_REQUEST["limit"];
	
	$datos = $top;

	for($h = $start;$h < count($col); $h++){
		if($col[$h][10] == 1){
			$extra_space = " ";
			for($j=strlen($col[$h][0]);$j<$col[$h][3];$j++)
				$extra_space .= " ";
			$datos .= $col[$h][0].$extra_space."\t";
		}
	}
	$datos = substr_replace($datos, '', -1);
	$datos .= "\n";

	for($i=$start;$i<$limit;$i++){
		$posicion = $i * $conf[1];
		$arrastre = $conf[2] * $i + $conf[3];
		for($h = 0;$h < count($col); $h++){
			if($col[$h][10] == 1){
				$pasar = array();
				for($j=0;$j<$col[$h][3];$j++)
					$pasar[$j] = substr($contenido, $posicion + $col[$h][2] + $j, 1);
				$dato = iconv($txt_lang, "UTF-8", decoBmd2($col[$h][1], $pasar, $posicion+$col[$h][2], $col[$h][3], $arrastre));
	//			if($h==0 && (strlen($dato)==0) && $archivo=="skill")
	//				$vacio = 1;
				$extra_space = " ";
				if($col[$h][1]==0){
					for($j=strlen($dato);$j<$col[$h][3];$j++){
						$extra_space .= " ";
					}
					$datos .= $dato."$extra_space\t";
				}
				else{
					($col[$h][1]==1 && $col[$h][7]==1) ? ($datos .= neg_simple($col[$h][1],$dato,$col[$h][3])."$extra_space\t") : ($datos .= $dato."$extra_space\t");
				}
			}
		}
		$datos = substr_replace($datos, '', -1);
		$datos .= "\n";
	}
	$datos = substr_replace($datos, '', -1);
}

$file = substr_replace($file, '', -4);
$fp = fopen($path_bmd_txt.$file.".txt","wb");
fwrite($fp, $datos);
fclose($fp);
echo "Archivo $file pasado a formato txt";
?>