<?php
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];
$extra   = $_REQUEST['extra'];
include("funciones.php");
$prueba1 = str_replace("\\\\\\\"", "", $_REQUEST['dato2']);
$lDatos2 = JDecode(str_replace("\\", "", $prueba1));
$prueba1 = str_replace("\\\\\\\"", "", $_REQUEST['dato3']);
$lDatos3 = JDecode(str_replace("\\", "", $prueba1));

$id			= $_REQUEST['id'];
$l_datos[0]	= $_REQUEST['hc'];
$l_datos[1]	= $_REQUEST['mdm1'];
$l_datos[2]	= $_REQUEST['mdm2'];
$l_datos[3]	= $_REQUEST['mdm3'];
$l_datos[4]	= $_REQUEST['bmn1'];
$l_datos[5]	= $_REQUEST['bmn2'];
$l_datos[6]	= $_REQUEST['bmn3'];
$l_datos[7]	= $_REQUEST['gmn1'];
$l_datos[8]	= $_REQUEST['gmn2'];
$l_datos[9]	= $_REQUEST['gmn3'];
$l_datos[10]	= $_REQUEST['he'];
$l_datos[11]	= $_REQUEST['wi'];
$l_datos[12]	= $_REQUEST['ml'];
$l_datos[13]	= $_REQUEST['mr'];
$l_datos[14]	= $_REQUEST['rm'];
$msr		= $_REQUEST['msr'];
$ub1		= $_REQUEST['ub1'];
$atl		= $_REQUEST['atl'];
$ub2		= $_REQUEST['ub2'];
$ruu		= $_REQUEST['ruu'];
$miu		= $_REQUEST['miu'];

include("../config.php");
require_once ("BinaryParser.php");
$contenido = abrir($path_bmd.$file);

if($id=="NUEVO"){
//tengo que decir nuevo en que categoria
//agregar uno a la categoria
//hacer espacio vacio para guardar los datos
/*
	  4 	a 	 63
	 64	a	 67
	 68	a	195
	324	a	327
	328	a	330
	332	a	651
	652	a	655

	  0	a	195
	324	a	330
	332	a	655

 
*/
}
	$largo  = strlen($contenido);
	$l_head = ($largo % 656)/4;
	for($i=0;$i<15;$i++){
		$dato	= encoBmd2(1, $l_datos[$i], 4 + $i * 4, 4, 0);
		for($j=0;$j<4;$j++)
			$contenido[$id * 656 + $l_head * 4 + 4 + $i * 4 + $j] = chr($dato[$j]);
	}
	$dato	= encoBmd2(1, $msr, 324, 4, 0);
	for($j=0;$j<4;$j++)
		$contenido[$id * 656 + $l_head * 4 + 324 + $j] = chr($dato[$j]);

	$dato1	= encoBmd2(1, $ub1, 328, 1, 0);
	$contenido[$id * 656 + $l_head * 4 + 328] = chr($dato1[0]);
	$dato1	= encoBmd2(1, $atl, 329, 1, 0);
	$contenido[$id * 656 + $l_head * 4 + 329] = chr($dato1[0]);
	$dato1	= encoBmd2(1, $ub2, 330, 1, 0);
	$contenido[$id * 656 + $l_head * 4 + 330] = chr($dato1[0]);

	$dato	= encoBmd2(1, $ruu, 64, 4, 0);
	for($j=0;$j<4;$j++)
		$contenido[$id * 656 + $l_head * 4 + 64 + $j] = chr($dato[$j]);
	$dato	= encoBmd2(1, $miu, 652, 4, 0);
	for($j=0;$j<4;$j++)
		$contenido[$id * 656 + $l_head * 4 + 652 + $j] = chr($dato[$j]);

	$parser = new BinaryParser;
	for($j=0;$j<16;$j++){
		$valor	= encoBmd2(1, $lDatos2[$j]['o0'], 2 + $j * 8, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[ $id * 656 + $l_head * 4 + 68 + $j * 8 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(0, $parser->fromFloat($lDatos2[$j]['o1']), 0 + $j * 8, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + 72 + $j * 8 + $h] = chr($valor[$h]);
	}

	for($j=0;$j<8;$j++){
		$valor	= encoBmd2(1, $lDatos3[$j]['o0'],  332 + $j * 40, 2, 0);
		for($h=0;$h<2;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 332 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o1'],  334 + $j * 40, 2, 0);
		for($h=0;$h<2;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 334 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o2'],  336 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 336 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o3'],  340 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 340 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o4'],  344 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 344 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o5'],  348 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 348 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o6'],  352 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 352 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o7'],  356 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 356 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o8'],  360 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 360 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o9'],  364 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 364 + $h] = chr($valor[$h]);
		$valor	= encoBmd2(1, $lDatos3[$j]['o10'], 368 + $j * 40, 4, 0);
		for($h=0;$h<4;$h++)
			$contenido[$id * 656 + $l_head * 4 + $j * 40 + 368 + $h] = chr($valor[$h]);
	}

$fp = fopen($path_bmd.$archivo.$extra.".bmd","w+");
fwrite($fp, $contenido);
fclose($fp);
echo "OK";
?>