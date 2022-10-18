<?php
$archivo = $_REQUEST['archivo'];
$file    = $_REQUEST['file'];
$deco    = $_REQUEST['deco'];
include("funciones.php");
include("../config.php");
$images = array();
if($archivo == "deco"){
	$path  =$path_oz;
	$tipos = "ozt|ozj|ozb";
}
else{
	$path  =$path_graf;
	$tipos = "tga|jpg|bmp";
}
$d = dir($path);
if(strlen($file)<5){
	while($name = $d->read()){
		if(!preg_match('/\.('.$tipos.')$/', strtolower($name))) continue;
		$images[] = array('id'=>$name, 'name'=>$name);
	}
	$d->close();
	$o = array('images'=>$images);
	echo json_encode($o);
}
else{
	$res = explode(".", $file);
	$ext = $res[count($res)-1];
	switch ($ext) {
		case "bmp":
		case "ozb":
			$formato = "bmp"; 
		break;
		case "jpg":
		case "ozj":	
			$formato = "jpeg"; 
		break;
		case "tga":
		case "ozt": 
			$formato = "jpeg"; 
		break;
	}
	Header("Content-type: image/".$formato);
	if($archivo == "deco"){
		if($deco=="ok"){
			echo deco_gmu($file,0);
			echo "OK";
		}
		else
			echo deco_gmu($file,1);
	}
	else{
		if($deco=="ok"){
			echo enco_gmu($file,0);
			echo "OK";
		}
		else
			echo enco_gmu($file,1);
	}
}