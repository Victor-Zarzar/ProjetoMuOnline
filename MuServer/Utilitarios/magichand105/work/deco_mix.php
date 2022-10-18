<?php
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];
$dato	 = $_REQUEST['dato'];
$id		 = $_REQUEST['id'];

include("funciones.php");
require_once ("BinaryParser.php");
include("../config.php");
include("../lang.php");
$contenido = abrir("../archivos/bmd/".$file);

if($dato=="lista"){
	$heads	= array();
	$largo  = strlen($contenido);
	$l_head = ($largo % 656)/4;
	$r		= "";

	for($i=0;$i<($l_head);$i++){
		$heads[$i] = decoBmd2(1, substr($contenido, $i*4, 4), $i*4, 4, 0);
	}
	$k	= 0;
	for($j=0;$j<count($heads);$j++){
		if($j==0) $cat = "Chaos Machine<br />";
		elseif($j==4) $cat = "Pet Trainer<br />";
		else $cat = $j;
		for($h=0;$h<$heads[$j];$h++){
			$r .= "{e:0,i:".$k.",o0:".decoBmd2(1, substr($contenido, $k * 656 + $l_head * 4, 4), 0, 4, 0).",o1:'".$cat."'},\n";
			$k++;
		}
	}
	echo  '{"datos": ['.substr_replace ($r, '', -2).']}';
}
elseif($dato=="datos"){
	$largo  = strlen($contenido);
	$l_head = ($largo % 656)/4;
	$r	= "";
	$r	.= decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4     , 4), 0, 4, 0);
	for($i=1;$i<16;$i++){
		$r	   .= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + $i*4, 4), $i*4, 4, 0);
	}
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 324, 4), 324, 4, 0);
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 328, 1), 328, 1, 0);
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 329, 1), 329, 1, 0);
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 330, 1), 330, 1, 0);
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 +  64, 4),  64, 4, 0);
	$r	.= "|".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 652, 4), 652, 4, 0);
	echo $r;
}
elseif($dato=="lista2"){
	$heads	= array();
	$largo  = strlen($contenido);
	$l_head = ($largo % 656)/4;
	$r		= "";
	$parser = new BinaryParser;

	if($id=='NUEVO'){
		for($j=0;$j<16;$j++){
			$r .= "{e:0,i:".$j.",o0: 0,o1: 0},\n";
		}
	}
	else{
		for($j=0;$j<16;$j++){
			$valor1 = $parser->toFloat(decoBmd4(substr($contenido, $id * 656 + $l_head * 4 + 72 + $j * 8, 4), 0 + $j * 8, 4));
			$r .= "{e:0,i:".$j.",o0:".decoBmd2(1, substr($contenido, $id * 656 + $l_head * 4 + 68 + $j * 8, 4), 2 + $j * 8, 4, 0).",o1:".$valor1."},\n";
		}
	}
	echo  '{"datos": ['.substr_replace ($r, '', -2).']}';
}
elseif($dato=="lista3"){
	$heads	= array();
	$largo  = strlen($contenido);
	$l_head = ($largo % 656)/4;
	$r		= "";

	if($id=='NUEVO'){
		for($j=0;$j<8;$j++){
			$r .= "{e:0,i:".$j.",o0: 0,o1: 0,o2: 0,o3: 0,o4: 0,o5: 0,o6: 0,o7: 0,o8: 0,o9: 0,o10: 0},\n";
		}
	}
	else{

		for($j=0;$j<8;$j++){
			$valor1 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 332, 2), 332 + $j * 40, 2, 0);
			$valor2 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 334, 2), 334 + $j * 40, 2, 0);
			$valor3 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 336, 4), 336 + $j * 40, 4, 0);
			$valor4 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 340, 4), 340 + $j * 40, 4, 0);
			$valor5 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 344, 4), 344 + $j * 40, 4, 0);
			$valor6 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 348, 4), 348 + $j * 40, 4, 0);
			$valor7 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 352, 4), 352 + $j * 40, 4, 0);
			$valor8 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 356, 4), 356 + $j * 40, 4, 0);
			$valor9 = decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 360, 4), 360 + $j * 40, 4, 0);
			$valor10= decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 364, 4), 364 + $j * 40, 4, 0);
			$valor11= decoBmd2(1,substr($contenido, $id * 656 + $l_head * 4 + $j * 40 + 368, 4), 368 + $j * 40, 4, 0);
			$r .= "{e:0,i:".$j.",o0:".$valor1.",o1:".$valor2.",o2:".$valor3.",o3:".$valor4.",o4:".$valor5.",o5:".$valor6.",o6:".$valor7.",o7:".$valor8.",o8:".$valor9.",o9:".$valor10.",o10:".$valor11."},\n";
		}
	}
	echo  '{"datos": ['.substr_replace ($r, '', -2).']}';
}?>