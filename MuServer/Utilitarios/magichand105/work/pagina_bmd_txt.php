<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
?>
<html>
 <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Editor de <?php echo $_REQUEST['archivo']?>.bmd</title>
	<link rel="stylesheet" type="text/css" href="../css/ext-all.css" />
	<script type="text/javascript" src="ext-base.js"></script>
	<script type="text/javascript" src="ext-all.js"></script>
	<script type="text/javascript" src="sel_files.php?archivo=<?php echo $_REQUEST['archivo']?>&tarea=save_bmd_txt&tipo=<?php echo $_REQUEST['tipo']?>"></script>
</head>
<body>
<div id="editor-grid"></div>
</body>
</html>
