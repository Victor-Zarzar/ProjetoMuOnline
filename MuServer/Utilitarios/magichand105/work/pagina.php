<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
?>
<html>
 <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Editor de <?php echo $_REQUEST['archivo']?>.bmd</title>
	<link rel="stylesheet" type="text/css" href="../css/ext-all.css" />
	<script type="text/javascript" src="ext-base.js"></script>
	<script type="text/javascript" src="ext-all.js"></script>
	<script type="text/javascript" src="BufferView.js"></script>
<?php
if(strlen($_REQUEST['file'])>4){
?>
	<script type="text/javascript" src="SearchField.js"></script>
	<script type="text/javascript" src="js.php?archivo=<?php  echo $_REQUEST['archivo']?>&file=<?php echo $_REQUEST['file']?>&tipo=<?php echo $_REQUEST['tipo']?>"></script>
	<script type="text/javascript" src="../i18n/locale/<?php  echo $lang?>/ext-lang.js"></script>
<?php
}else{
?>
	<script type="text/javascript" src="sel_files.php?archivo=<?php echo $_REQUEST['archivo']?>&tarea=pagina&tipo=<?php echo $_REQUEST['tipo']?>"></script>
<?php
}
?>
</head>
<body>
<div id="editor-grid"></div>
</body>
</html>
