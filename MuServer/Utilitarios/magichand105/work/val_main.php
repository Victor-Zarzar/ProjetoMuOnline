<?php
include("funciones.php");
$save = $_REQUEST['save'];
$main = $_REQUEST['main'];
$ver  = $_REQUEST['ver'];
$ser  = $_REQUEST['ser'];
$ip   = $_REQUEST['ip'];

include("../config.php");
$contenido = abrir($path_main.$main);
$ver_ser = stripos($contenido, 'ip address');

if($save == "ok"){
	for($i=0;$i<5;$i++)
		$contenido[$ver_ser-132+$i] = $ver[$i];
	for($i=0;$i<16;$i++)
		$contenido[$ver_ser-124+$i] = $ser[$i];
	$ver_ip  = stripos($contenido, 'connect.muonline.webzen.net');
	if($ver_ip<1){
		$ver_ip  = stripos($contenido, 'connection.muonline.com.tw');
		for($i=0;$i<50;$i++)
			if($i<strlen($ip))
				$contenido[$ver_ip - 100 + $i] = $ip[$i];
			else
				$contenido[$ver_ip - 100 + $i] = chr(0);
	}
	else{
		for($i=0;$i<50;$i++)
			if($i<strlen($ip))
				$contenido[$ver_ip - 50 + $i] = $ip[$i];
			else
				$contenido[$ver_ip - 50 + $i] = chr(0);
	}
	$fp = fopen($path_main.$main,"w+");
	fwrite($fp, $contenido);
	fclose($fp);
	echo "OK";
}
else{
	$version = substr($contenido, $ver_ser - 132, 5);
	$serial  = substr($contenido, $ver_ser - 124, 16);
	$ver_ip  = stripos($contenido, 'connect.muonline.webzen.net');
	$ip      = substr($contenido, $ver_ip - 50, 50);
	if($ver_ip<1){
		$ver_ip  = stripos($contenido, 'connection.muonline.com.tw');
		$ip      = substr($contenido, $ver_ip - 100, 50);
	}
	$ip = trim($ip);
	echo $main."|".$version."|".$serial."|".$ip;
}
?>
