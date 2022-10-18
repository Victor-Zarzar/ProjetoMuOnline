<?php
include("../lang.php");
include("funciones.php");

$lang_id = $_REQUEST['lang_id'];
if(strlen($lang_id)>1) $lang =$lang_id;

$lang_load = $_REQUEST['lang_load'];
if(strlen($lang_load)>1) $load_txt_lang =$lang_load;

$lang_save = $_REQUEST['lang_save'];
if(strlen($lang_save)>1) $save_txt_lang =$lang_save;

$salvar = "<?php
\$lang          = \"".$lang."\"; // español=\"es\", english=\"en\", portuges=\"pt\"
\$load_txt_lang = \"".$load_txt_lang."\"; // coreano = \"EUC-KR\", JAPONES =\"EUC-JP\", CIRILICO= \"windows-1251\", ETC
\$save_txt_lang = \"".$save_txt_lang."\"; // coreano = \"EUC-KR\", JAPONES =\"EUC-JP\", CIRILICO= \"windows-1251\", ETC
?>";
$fp = fopen("../lang.php","w+");
fwrite($fp, $salvar);
fclose($fp);
?>