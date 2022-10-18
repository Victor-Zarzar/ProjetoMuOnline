<?php
include("lang.php");
include("i18n/".$lang."/locale/text.php");
include("i18n/l_langs.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>MagicHand Mu Editor</title>
	<link rel="stylesheet" type="text/css" href="css/ext-all.css">
	<script type="text/javascript" src="work/ext-base.js"></script>
	<script type="text/javascript" src="work/ext-all.js"></script>
	<script type="text/javascript" src="work/js_pagina.php"></script>
	<script type="text/javascript" src="work/pagina_ini.php"></script>
</head>
<body>
    <div id="header"><h1><b>MagicHand Mu Editor</b></h1></div>
	<div id="uso" class="x-hidden"></div>
	<div id="todo" class="x-hidden"></div>
	<div id="aportes" class="x-hidden"></div>
	<div id="carpetas" class="x-hidden"></div>
	<div id="buffeffect" class="x-hidden"></div>
	<div id="credit" class="x-hidden"></div>
	<div id="filter" class="x-hidden"></div>
	<div id="dialog" class="x-hidden"></div>
	<div id="filtername" class="x-hidden"></div>
	<div id="gate" class="x-hidden"></div>
	<div id="item" class="x-hidden"></div>
	<div id="itemaddoption" class="x-hidden"></div>
	<div id="itemsetoption" class="x-hidden"></div>
	<div id="itemsettype" class="x-hidden"></div>
	<div id="joho" class="x-hidden"></div>
	<div id="johs" class="x-hidden"></div>
	<div id="npcdialogue" class="x-hidden"></div>
	<div id="mst" class="x-hidden"></div>
	<div id="minimap" class="x-hidden"></div>
	<div id="mix" class="x-hidden"></div>
	<div id="monsterskill" class="x-hidden"></div>
	<div id="movereq" class="x-hidden"></div>
	<div id="pet" class="x-hidden"></div>
	<div id="quest" class="x-hidden"></div>
	<div id="serverlist" class="x-hidden"></div>
	<div id="skill" class="x-hidden"></div>
	<div id="slide" class="x-hidden"></div>
	<div id="socketitem" class="x-hidden"></div>
	<div id="text" class="x-hidden"></div>
	<div id="deco_gra" class="x-hidden"></div>
	<div id="message" class="x-hidden"></div>
	<div id="gatetxt" class="x-hidden"></div>
	<div id="movereqtxt" class="x-hidden"></div>
	<div id="creditos" class="x-hidden"></div>
	<div id="questprogress" class="x-hidden"></div>
	<div id="questwords" class="x-hidden"></div>
	<div id="shopui" class="x-hidden"></div>
	<div id="shopcategoryitems" class="x-hidden"></div>
	<div id="clang" class="x-hidden"></div>
	<div id="main" class="x-hidden"></div>
	<div id="decatt" class="x-hidden"></div>
	<div id="inicio" class="x-hidden">
	<div class="x-window-header">
		<img src="images/default/magichand_1.jpg">
		<div style="margin-top:5px;"></div>
		<select id="lang_id">
<?php
foreach($l_langs AS $m_lang){
	($lang==$m_lang[1]) ? ($o_select = "selected") : ($o_select="");
	echo "			<option value=\"$m_lang[1]\" $o_select>$m_lang[2]</option>";
}
?>
		</select>
	</div>
</div>
</body>
</html>
