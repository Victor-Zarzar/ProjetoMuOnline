<?php
function abrir($archivo){
	$fp = fopen($archivo,"rb");
	$contenido = fread($fp, filesize($archivo));
	fclose($fp);
	return $contenido;
}

function decoBmd($tipo, $valor){
	switch ($tipo) {
		case 2:
			$resultado = $valor ^ 171;
			break;
		case 1:
			$resultado = $valor ^ 207;
			break;
		case 0:
			$resultado = $valor ^ 252;
			break;
	    default:
			$resultado = 0;
			break;
	}
	return $resultado;
}

function decoBmd2($modo, $pasar, $inicio, $cantidad, $arrastre){
	$resultado = '';
	for($i=0;$i<$cantidad;$i++){
		$tipo = ($inicio + $i + $arrastre) % 3;
		$valor =ord($pasar[$i]);
		if($modo == 1){
			$resultado += decoBmd($tipo, $valor)*pow( 256, $i);
			if($resultado>2147483647)
				$resultado -= 4294967296;
		}
		else{
			$res_aux = decoBmd($tipo, $valor);
			if(($res_aux == 0 || $res_aux == 11 || $res_aux == 10))
				break;
			if($res_aux!=255)
				$resultado .= chr($res_aux);
		}
	}
	return $resultado;
}

function decoBmd3($pasar, $cantidad){
	$resultado = '';
	for($i=0;$i<$cantidad;$i++){
		$tipo = ($i) % 3;
		$valor =ord($pasar[$i]);
		$res_aux = decoBmd($tipo, $valor);
//		if($res_aux!=255)
			$resultado .= chr($res_aux);
	}
	return $resultado;
}

function decoBmd4($pasar, $inicio, $cantidad){
	$resultado = '';
	for($i=0;$i<$cantidad;$i++){
		$tipo = ($inicio + $i + $arrastre) % 3;
		$valor =ord($pasar[$i]);
		$resultado .= chr(decoBmd($tipo, $valor));
	}
	return $resultado;
}

function decoWtf($pasar, $cantidad){
	$resultado = '';
	for($i=0;$i<$cantidad;$i++){
		$valor =ord($pasar[$i]);
		$valor = $valor ^ 202;
		$resultado .= chr($valor);
	}
	return $resultado;
}

function encoBmd2($modo, $cambio, $inicio, $cantidad, $arrastre){
	if($modo == 1)
		if($cambio==-1){
			($cantidad==1) ? ($cambio = 255) : ($cambio = 4294967295);
		}
	for($i=0;$i<$cantidad;$i++){
		if($modo == 0)
			$resultado[$i] = decoBmd(($inicio + $i + $arrastre) % 3, ord($cambio[$i]));
		else{
			$resultado[$i] = decoBmd(($inicio + $i + $arrastre) % 3, calModulo($cambio));
			$cambio        = intval($cambio/256);
		}
	}
	return $resultado;
}

function encoBmd3($cambio, $inicio, $arrastre){
	for($i=0;$i<strlen($cambio);$i++)
		$resultado .= chr(decoBmd(($inicio + $i + $arrastre) % 3, ord($cambio[$i])));
	return $resultado;
}

function orderArray ($toOrderArray, $field, $inverse = false) {  
	$position = array();  
	$newRow = array();  
	foreach ($toOrderArray as $key => $row) {
		$position[$key]  = $row[$field];
		$newRow[$key] = $row;
    }
	asort($position);
	$returnArray = array();
	foreach ($position as $key => $pos) {
		$returnArray[] = $newRow[$key];
	}
	return $returnArray;
}

function pasarHex($numero, $cantidad){
	for($i=0;$i<$cantidad;$i++){
		$a = $numero % 256;
		$numero = intval($numero/256);
		$resultado .= chr($a);
	}
	return $resultado;
}

function cantidad( $contenido, $inicio, $cantidad){
	$resultado = '';
	for($i=0;$i<$cantidad;$i++){
		$valor =ord(substr($contenido, $inicio + $i, 1));
		$resultado += $valor*pow( 256, $i);
	}
	return $resultado;
}

function neg_simple($modo, $valor, $cantidad){
	if($modo == 1)
		($valor == 255 && $cantidad == 1 || $valor == 65535 && $cantidad == 2) ? ($resultado=  -1) :($resultado = $valor);
	else
		$resultado = str_replace("ÿ", "", $valor);
	return $resultado;
}

function calModulo($valor){
	$resultado = $valor % 256;
	if($resultado<0)
		$resultado += 256;
	return $resultado;
}

function xlsBOF() {
    return pack("vvvvvv", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
}
			
function xlsEOF() { 
    return pack("ss", 0x0A, 0x00);
}
			
function xlsWriteNumber($Row, $Col, $Value) { 
    $a  = pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
    $a .= pack("d", $Value); 
    return $a; 
} 

function xlsWriteLabel($Row, $Col, $Value ) { 
    $L  = strlen($Value); 
    $a  = pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
    $a .= $Value; 
return $a; 
} 

function convXLS($tipo, $Value, $Row, $Col){
	($tipo == 1) ? $a = xlsWriteNumber($Row, $Col, $Value) : ($a = xlsWriteLabel($Row, $Col, $Value ));
return $a;
}

function deco_gmu($archivo,$medio){
	global $path_oz;
	global $path_graf;
	$nombre = explode(".", $archivo);
	$size = (sizeof($nombre)-1);
	$ext  = strtolower($nombre[$size]);
	switch ($ext) {
		case "ozb":
			$sacar   = 4;
			$formato = "bmp";
		break;
		case "ozj":
			$sacar   = 24;
			$formato = "jpg";
		break;
		case "ozt":
			$sacar   = 4;
			$formato = "tga";
		break;
		default:
		break;
	}
	if(isset($sacar)){
		$contenido = abrir($path_oz.$archivo);
		$contenido = substr($contenido, $sacar, strlen($contenido)-$sacar);
		if($medio==1){
			if($formato == "tga"){
				$contenido = imagepng(imagecreatefromtga($contenido));
			}
			return $contenido;
		}
		else{
			$fp = fopen($path_graf.$nombre[0].".".$formato,"w+");
			fwrite($fp, $contenido);
			fclose($fp);
		}
	}
}

function enco_gmu($archivo, $medio){
	global $path_oz;
	global $path_graf;
	$nombre = explode(".", $archivo);
	$size = (sizeof($nombre)-1);
	$ext  = strtolower($nombre[$size]);
	switch ($ext) {
		case "bmp":
			$poner   = 4;
			$formato = "ozb";
		break;
		case "jpg":
			$poner   = 24;
			$formato = "ozj";
		break;
		case "tga":
			$poner   = 4;
			$formato = "ozt";
		break;
		default:
		break;
	}
	if(isset($poner)){
		$contenido  = abrir($path_graf.$archivo);
		$poner_temp = substr($contenido, 0, $poner);
		if($medio==1){
			if($formato == "ozt"){
				$contenido = imagepng(imagecreatefromtga($contenido));
			}
			return $contenido;
		}
		else{
			$contenido  = $poner_temp.$contenido; 
			$fp = fopen($path_oz.$nombre[0].".".$formato,"w+");
			fwrite($fp, $contenido);
			fclose($fp);
		}
	}
}

function imagecreatefromtga ( $data, $return_array = 0 )
{
    $pointer = 18;
    $x = 0;
    $y = 0;
    $w = base_convert ( bin2hex ( strrev ( substr ( $data, 12, 2 ) ) ), 16, 10 );
    $h = base_convert ( bin2hex ( strrev ( substr ( $data, 14, 2 ) ) ), 16, 10 );
    $img = imagecreatetruecolor( $w, $h );

    while ( $pointer < strlen ( $data ) )
    {
        imagesetpixel ( $img, $x, $h - $y, base_convert ( bin2hex ( strrev ( substr ( $data, $pointer, 3 ) ) ), 16, 10 ) );
        $x++;

        if ($x == $w)
        {
            $y++;
            $x=0;
        }

        $pointer += 4;
    }
   
    if ( $return_array )
        return array ( $img, $w, $h );
    else
        return $img;
}

function version_file($archivo, $file){
	($archivo==message) ? ($patha="../archivos/wtf/") : ($patha="../archivos/bmd/");
	$largo = filesize($patha.$file);
	switch ($archivo) {
		case "gate":
			switch ($largo) {
				case 7168:
					return "gate3";
				break;
				case 6144:
					return "gate";
				break;
				case 5120:
					return "gate4";
				break;
				case 2304:
					return "gate2";
				break;
				case 900:
					return "gate2";
				break;
				default:
					return "gate";
				break;
			}
		break;
		case "item":
			switch ($largo) {
				case 38916:
					return "item2";
				break;
				case 688132:
					return "item";
				break;
				default:
					return "item";
				break;
			}
		break;
		case "itemsetoption":
			switch ($largo) {
				case 4868:
					return "itemsetoption2";
				break;
				case 6980:
					return "itemsetoption";
				break;
				default:
					return "itemsetoption";
				break;
			}
		break;
		case "itemsettype":
			switch ($largo) {
				case 2052:
					return "itemsettype2";
				break;
				case 32772:
					return "itemsettype";
				break;
				default:
					return "itemsettype";
				break;
			}
		break;
		case "message":
			switch ($largo) {
				case 1444:
					return "message";
				break;
				default:
					return "message";
				break;
			}
		break;
		case "MonsterSkill":
			switch ($largo) {
				case 1444:
					return "MonsterSkill";
				break;
				case 452:
					return "MonsterSkill2";
				break;
				case 228:
					return "MonsterSkill2";
				break;
				default:
					return "MonsterSkill";
				break;
			}
		break;
		case "movereq":
			switch ($largo) {
				case 4204:
					return "movereq2";
				break;
				case 4004:
					return "movereq";
				break;
				case 2884:
					return "movereq";
				break;
				default:
					return "movereq";
				break;
			}
		break;
		case "quest":
			switch ($largo) {
				case 116800:
					return "questa";
				break;
				case 136000:
					return "questb";
				break;
				case 142400:
					return "quest";
				break;
				default:
					return "quest";
				break;
			}
		break;
		case "quest2":
			switch ($largo) {
				case 116800:
					return "quest2a";
				break;
				case 136000:
					return "quest2b";
				break;
				case 142400:
					return "quest2";
				break;
				default:
					return "quest2";
				break;
			}
		break;
		case "quest3":
			switch ($largo) {
				case 116800:
					return "quest3a";
				break;
				case 136000:
					return "quest3b";
				break;
				case 142400:
					return "quest3";
				break;
				default:
					return "quest3";
				break;
			}
		break;
		case "skill":
			switch ($largo) {
				case 48004:
					return "skill";
				break;
				case 13316:
					return "skill2";
				break;
				case 15364:
					return "skill3";
				break;
				case 27204:
					return "skill4";
				break;
				case 2564:
					return "skill5";
				break;
				default:
					return "skill";
				break;
			}
		break;
		case "text":
			switch ($largo) {
				case 299925:
					return "text2";
				break;
				default:
					return "text";
				break;
			}
		break;
		default:
			return $archivo;
		break;
	}
}

function CrcCalc($buffer, $CheckVal, $salteo)
{
	$CrcKey = $CheckVal * 512;
	$tmpbuff = 0;
	$var_temp = array(0xFFFFFFFF, 0x7FFFFFFF, 0x3FFFFFFF, 0x1FFFFFFF, 0x0FFFFFFF, 0x07FFFFFF, 0x03FFFFFF, 0x01FFFFFF, 0x00FFFFFF);
	if($salteo>0) $buffer = substr($buffer, $salteo);
	$size = strlen($buffer);
	for( $i = 0 ; $i <= ($size-8); $i+=4){
		$tmpbuff = cantidad($buffer, $i, 4);
		((($i / 4) + $CheckVal) % 2) ? ($CrcKey += $tmpbuff) : ($CrcKey ^= $tmpbuff);
		if(($i % 16) == 0) $CrcKey ^= ($CheckVal + $CrcKey) >> ((($i /4) % 8) + 1) & $var_temp[(($i /4) % 8) + 1];
	}
	return $CrcKey;
}

function ver_crc($archivo, $buffer){
	$salteo = 0;
	$CheckVal = 0;
	switch ($archivo) {
		case "BuffEffect":
			$CheckVal = 0xE2F1;
			$salteo   = 4;
		break;
		case "Filter":
			$CheckVal = 0x3E7D;
		break;
		case "FilterName":
			$CheckVal = 0x2BC1;
		break;
		case "item":
			$CheckVal = 0xE2F1;
		break;
		case "itemsetoption":
			$CheckVal = 0xA2F1;
		break;
		case "itemsettype":
			$CheckVal = 0xE5F1;
		break;
		case "Minimap":
			$CheckVal = 0x2BC1;
		break;
		case "pet":
			$CheckVal = 0x7F1D;
			$salteo   = 12;
		break;
		case "shopcategoryitems":
			$CheckVal = 0xE2F1;
		break;
		case "shopui":
			$CheckVal = 0xE2F1;
		break;
		case "skill":
			$CheckVal = 0x5A18;
		break;
	}
	if($CheckVal!=0){
		$valor = CrcCalc($buffer,$CheckVal, $salteo);
		$datos = "";
		for($i=0;$i<4;$i++){
			$datos .= chr(calModulo($valor));
			$valor  = ($valor) >> (8);
		}
		return $datos;
	}
	else{
		return "no";
	}
}
function buff_desa($i, $tmpbuff, $XorKey, $Key)
{
	$tmpdest = $tmpbuff^$XorKey;
	($tmpdest>=$Key) ? ($tmpdesa = decoBmd($i%3, ($tmpdest - $Key))) : ($tmpdesa = decoBmd($i%3, 0x100 - ($Key - $tmpdest)));
	$Key = ($tmpbuff + 0x3D) & 0x000000ff;
	$valor[0] = $tmpdesa;
	$valor[1] = $Key;
	return $valor;
}

function DecodeATT($srcBuf)
{
	$dstBuf = '     ';
	$XorKeys = array(0xD1, 0x73, 0x52, 0xF6, 0xD2, 0x9A, 0xCB, 0x27, 0x3E, 0xAF, 0x59, 0x31, 0x37, 0xB3, 0xE7, 0xA2);
	$Key = 0x5E;
	$largo_file = strlen($srcBuf);
	$dstBuf[0] = chr(0);
	$dstBuf[1] = chr(255);
	$dstBuf[2] = chr(255);
	
	if($largo_file == 131076){
		for($i=0; $i < $largo_file; $i++)
		{
			list($tmpdesa, $Key) = buff_desa($i, ord(substr($srcBuf, $i, 1)), $XorKeys[($i)%16], $Key);
			if(($i>3) && ($i%2==0))
				$dstBuf[$i/2+1] = chr($tmpdesa);
		}
	}
	if($largo_file == 65540){
		for($i=0; $i < $largo_file; $i++)
		{
			list($tmpdesa, $Key) = buff_desa($i, ord(substr($srcBuf, $i, 1)), $XorKeys[($i)%16], $Key);
			if(($i>3))
				$dstBuf[$i-1] = chr($tmpdesa);
		}
	}
    return $dstBuf;
}

function DecodeMAP($srcBuf)
{
	$dstBuf = '     ';
	$XorKeys = array(0xD1, 0x73, 0x52, 0xF6, 0xD2, 0x9A, 0xCB, 0x27, 0x3E, 0xAF, 0x59, 0x31, 0x37, 0xB3, 0xE7, 0xA2);
	$Key = 0x5E;
	$largo_file = strlen($srcBuf);
	$dstBuf[0] = chr(0);
	
	for($i=0; $i < $largo_file; $i++)
	{
		list($tmpdesa, $Key) = buff_desa($i, ord(substr($srcBuf, $i, 1)), $XorKeys[($i)%16], $Key);
		if($i>1)
			$dstBuf[$i-2] = chr($tmpdesa);
	}
    return $dstBuf;
}

function object2array($object) {
	if (is_object($object) || is_array($object)) {
		foreach ($object as $key => $value) {
			$array[$key] = object2array($value);
		}
	}else {
		$array = $object;
	}
	return $array;
}

function JDecode($arr){
    if (version_compare(PHP_VERSION,"5.2","<"))
    {    
        require_once("JSON.php"); //if php<5.2 need JSON class
        $json = new Services_JSON();
        $data2=$json->decode($arr);
    } else
    {
        $data2 = json_decode($arr, true);
    }
	$data = object2array($data2);
    return $data;
}
?>