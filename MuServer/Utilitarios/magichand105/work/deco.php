<?php
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];
$busqueda = $_REQUEST['busqueda'];

include("funciones.php");
$archivo = version_file($archivo, $file);
include("../config.php");
include("../lang.php");
($archivo=="message") ? ($path_file=$path_wtf) : ($path_file=$path_bmd);
$contenido = abrir($path_file.$file);

if($archivo=="text"){
	$largo  = strlen($contenido);
	$limit	= cantidad( $contenido, 2, 4);
	$inicio = 6;
	$i 		= 0;
	while($inicio<$largo){
		$nTexto   = cantidad( $contenido, $inicio, 4);
		$lTexto   = cantidad( $contenido, $inicio + 4, 4);
		$arrastre = (1 - $inicio) % 3;
		$pasar = array();
		for($j=0;$j<$lTexto;$j++)
			$pasar[$j] = substr($contenido, $inicio + 8 + $j, 1);
		if(strlen($busqueda)>0){
			$res_busqueda = decoBmd2(0, $pasar, $inicio + 8, $lTexto, $arrastre);
			if(stripos($res_busqueda, $busqueda)!==false)
				$r .= "{o0:".$nTexto.",o1:'".addslashes(iconv($load_txt_lang, "UTF-8", $res_busqueda))."'},\n";
		}
		else{
			$r .= "{i:".$i.",o0:".$nTexto.",o1:'".addslashes(iconv($load_txt_lang, "UTF-8", decoBmd2(0, $pasar, $inicio + 8, $lTexto, $arrastre)))."'},\n";
		}
		$inicio += $lTexto + 8;
		$i++;
	}
}
elseif($archivo=="message"){
	$inicio  = 28;
	$cuantos = cantidad( $contenido, 24, 4);
	for($i=0;$i<$cuantos;$i++){
		$dato1  = cantidad( $contenido, $inicio, 1);
		$dato2  = cantidad( $contenido, $inicio + 1, 1);
		$lTexto = cantidad( $contenido, $inicio + 2, 2);
		$pasar = array();
		for($j=0;$j<$lTexto;$j++)
			$pasar[$j] = substr($contenido, $inicio + 4 + $j, 1);
		if(strlen($busqueda)>0){
			$res_busqueda = decoWtf($pasar, $lTexto);
			if(stripos($res_busqueda, $busqueda)!==false)
				$r .= "{i:".$i.",o0:".$dato1.",o1:".$dato2.",o2:'".addslashes(iconv($load_txt_lang, "UTF-8", $res_busqueda))."'},\n";
		}
		else{
			$r .= "{i:".$i.",o0:".$dato1.",o1:".$dato2.",o2:'".addslashes(iconv($load_txt_lang, "UTF-8", decoWtf($pasar, $lTexto)))."'},\n";
		}
		$inicio += $lTexto + 4;
	}
}
elseif($archivo=="QuestWords"){
	$largo  = strlen($contenido);
	$inicio = 0;
	$pasar1 = array();
	$pasar2 = array();
	$pasar3 = array();
	$i=0;
	while($inicio<$largo){
		for($j=0;$j<4;$j++)
			$pasar1[$j] = substr($contenido, $inicio + $j, 1);
		$dato1  = decoBmd2(1, $pasar1, 0, 4, 0);
		for($j=0;$j<2;$j++)
			$pasar2[$j] = substr($contenido, $inicio + 4 + $j, 1);
		$dato2  = decoBmd2(1, $pasar2, 4, 2, 0);
		for($j=0;$j<$dato2;$j++)
			$pasar3[$j] = substr($contenido, $inicio + 6 + $j, 1);

		if(strlen($busqueda)>0){
			$res_busqueda = decoBmd2(0, $pasar3, 6, $dato2, 0);
			if(stripos($res_busqueda, $busqueda)!==false)
				$r .= "{i:".$i.",o0:".$dato1.",o1:'".addslashes(iconv($load_txt_lang, "UTF-8", $res_busqueda))."'},\n";
		}
		else{
			$r .= "{i:".$i.",o0:".$dato1.",o1:'".addslashes(iconv($load_txt_lang, "UTF-8", decoBmd2(0, $pasar3, 6, $dato2, 0)))."'},\n";
		}
		$inicio += $dato2 + 6;
		$i++;
	}
}
elseif($archivo=="ServerList"){
	$inicio = 0;
	$largo  = strlen($contenido);
	$r      = "";
	$i      = 0;
	while($inicio<$largo){
		$valor0 = decoBmd2(1, substr($contenido, $inicio, 2), 0, 2, 0);
		$nombre = decoBmd2(0, substr($contenido, $inicio + 2, 32), 2, 32, 0);

		$valor1a = decoBmd2(1, substr($contenido, $inicio + 34, 1), 34, 1, 0);
		$valor1b = decoBmd2(1, substr($contenido, $inicio + 35, 1), 35, 1, 0);
		$valor1c = decoBmd2(1, substr($contenido, $inicio + 36, 1), 36, 1, 0);
		$valor1d = decoBmd2(1, substr($contenido, $inicio + 37, 1), 37, 1, 0);
		$valor2  = decoBmd2(1, substr($contenido, $inicio + 50, 1), 50, 1, 0);
		$valor3  = decoBmd2(1, substr($contenido, $inicio + 51, 2), 51, 2, 0);
		$valor4 = decoBmd2(0, substr($contenido, $inicio + 53, $valor3), 53, $valor3, 1);

		$inicio += 53 + $valor3;
		$r .= "{i:".$i.",o0:".$valor0.",o1:'".addslashes(iconv($load_txt_lang, "UTF-8", $nombre))."',o2:'".addslashes(iconv($load_txt_lang, "UTF-8", $valor4))."'},\n";
		$i++;
	}
}
else{
	$start = ($_REQUEST["start"] == null)? 0 : $_REQUEST["start"];
	if($conf[6]==1){
		$contenido = substr($contenido, $conf[9] + $conf[7] * $start, $conf[8]);
		$etapa = $start;
		$start = 0;
	}
	else
		$etapa = 0;
	$limit = ($_REQUEST["limit"] == null)? intval((strlen($contenido)) / $conf[1]) : $start + $_REQUEST["limit"];
	$r         = "";
	for($i=$start;$i<$limit;$i++){
		$posicion = $i * $conf[1];
		$arrastre = $conf[2] * $i + $conf[3];
		$t        = "";
		for($h = 0;$h < count($col); $h++){
			$pasar = array();
			for($j=0;$j<$col[$h][3];$j++)
				$pasar[$j] = substr($contenido, $posicion + $col[$h][2] + $j, 1);
			$dato = decoBmd2($col[$h][1], $pasar, $posicion+$col[$h][2], $col[$h][3], $arrastre);
			if($col[$h][1]==0)
				$dato = "'".addslashes(iconv($load_txt_lang, "UTF-8", $dato))."'";
			($col[$h][1]==1 && $col[$h][7]==1) ? ($t .= "o".$h.":".neg_simple($col[$h][1],$dato,$col[$h][3]).",") : ($t .= "o".$h.":".$dato.",");
		}
		if(strlen($busqueda)>1){
			if(stripos($t , $busqueda)!==false)
				$r .= "{e:".$etapa.",i:".$i.",".substr_replace($t, '', -1)."},\n";
		}else{
			$r .= "{e:".$etapa.",i:".$i.",".substr_replace($t, '', -1)."},\n";
		}
	}
}
echo  '{"datos": ['.substr_replace ($r, '', -2).']}';
?>