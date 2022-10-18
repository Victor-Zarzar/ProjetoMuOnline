<?php
include("funciones.php");
include("../config.php");
$file = $_REQUEST['file'];
$deco = $_REQUEST['deco'];
$images = array();
$d = dir($path_att);
if(strlen($file)<5){
	$i = 0;
	while($name = $d->read()){
		if(!preg_match('/\.(att)$/', $name)) continue;
		$images[] = array('id'=>$i, 'name'=>$name);
		$i++;
	}
	$d->close();
	$o = array('images'=>$images);
	echo json_encode($o);
}
else{
	
	$contenido = DecodeATT(abrir($path_att.$file));
	if($deco=="ok"){
		$file_save = str_replace("Enc", "Dec", $file);
		$fp = fopen($path_dec_att.$file_save,"w+");
		fwrite($fp, $contenido);
		fclose($fp);
		echo "OK";
	}
	else{
		Header("Content-type: image/png"); 

		$cell_size = 1;

		$image = ImageCreate($cell_size*256, $cell_size*256);  

		$col0  = ImageColorAllocate($image, 0, 0, 0);
		$col1  = ImageColorAllocate($image, 255, 0, 0);
		$col4  = ImageColorAllocate($image, 0, 0, 255);
		$col5  = ImageColorAllocate($image, 255, 0, 255);
		$col8  = ImageColorAllocate($image, 224, 255, 224);
		$col12 = ImageColorAllocate($image, 149, 37, 0);
		$col13 = ImageColorAllocate($image, 0, 0, 0);
		$col14 = ImageColorAllocate($image, 120, 120, 0);
		$col32 = ImageColorAllocate($image, 245, 120, 24);
		$col36 = ImageColorAllocate($image, 25, 120, 240);

		for($i=0;$i<256;$i++){
			for($h=0;$h<256;$h++){
				$color = 'col'.ord($contenido[256*$i+$h+3]);
				$pintar = $$color;
				imagefilledrectangle($image, $cell_size*$h, $cell_size*(255 - $i), $cell_size*$h+$cell_size-1, $cell_size*(255 - $i)+$cell_size - 1, $pintar);  
			}
		}
		ImagePng($image); 
	}
}