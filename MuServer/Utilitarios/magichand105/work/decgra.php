<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
?>
<html>
 <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Decode Graphics Files</title>
	<link rel="stylesheet" type="text/css" href="../css/ext-all.css" />
	<script type="text/javascript" src="ext-base.js"></script>
	<script type="text/javascript" src="ext-all.js"></script>
    <script type="text/javascript" src="DataView-more.js"></script>
    <script type="text/javascript" src="view_gra.php?archivo=<?php echo $_REQUEST['archivo'];?>"></script>
    <link rel="stylesheet" type="text/css" href="../css/data-view.css" />
</head>
<body>
<div id="editor-grid"></div>
</body>
</html>