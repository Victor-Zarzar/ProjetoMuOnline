<?php
/*
   Author:	Jamie Telin (jamie.telin@gmail.com), currently at employed Zebramedia.se
*/

class GoogleTranslateApi{

	var $BaseUrl = 'http://ajax.googleapis.com/ajax/services/language/translate';
	var $FromLang = 'kr';
	var $ToLang = 'es';
	var $Version = '1.0';
	
	var $CallUrl;
	
	var $Text = '';
	
	var $TranslatedText;
	var $DebugMsg;
	var $DebugStatus;
	
	function GoogleTranslateApi(){
		$this->CallUrl = $this->BaseUrl . "?v=" . $this->Version . "&q=" . urlencode($this->Text) . "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
	}
	
	function makeCallUrl(){
		$this->CallUrl = $this->BaseUrl . "?v=" . $this->Version . "&q=" . urlencode($this->Text) . "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
	}
	
	function translate($text = ''){
		if($text != ''){
			$this->Text = $text;
		}
		$this->makeCallUrl();
		if($this->Text != '' && $this->CallUrl != ''){
			$handle = fopen($this->CallUrl, "rb");
			$contents = '';
			while (!feof($handle)) {
			$contents .= fread($handle, 8192);
			}
			fclose($handle);
			
			$json = json_decode($contents, true);
			
			if($json['responseStatus'] == 200){ //If request was ok
				$this->TranslatedText = $json['responseData']['translatedText'];
				$this->DebugMsg = $json['responseDetails'];
				$this->DebugStatus = $json['responseStatus'];
				return $this->TranslatedText;
			} else { //Return some errors
				return false;
				$this->DebugMsg = $json['responseDetails'];
				$this->DebugStatus = $json['responseStatus'];
			}
		} else {
			return false;
		}
	}
}
$num   = $_REQUEST['cantidad'];
$text  = $_REQUEST['text_tran'];
$id    = $_REQUEST['text_id'];
$from  = $_REQUEST['from'];
$to    = $_REQUEST['to'];

$translate = new GoogleTranslateApi;
$translate->FromLang = $from;
$translate->ToLang = $to;
$l_translated = "";
for($i=1;$i<=$num;$i++){
	$text = $_REQUEST["text_tran".$i];
	$t_translated  = str_replace("% ", "%", $translate->translate($text));
	$t_translated  = str_replace("%D", "%d", $t_translated);
	$l_translated .= "|".str_replace("%S", "%s", $t_translated);
}
echo $id.$l_translated;
?>