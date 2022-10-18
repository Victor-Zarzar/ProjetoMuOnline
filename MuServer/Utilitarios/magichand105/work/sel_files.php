<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
?>
var store = new Ext.data.JsonStore(
	{
		id:'datos'
		,root:'datos'
		,url:'files.php?archivo=<?php echo $_REQUEST['archivo']?>&tarea=<?php echo $_REQUEST['tarea']?>&tipo=<?php echo $_REQUEST['tipo']?>'
		,fields:[{name:'file', type:'string'}]
	}
);

var cm = new Ext.grid.ColumnModel([
	{
		dataIndex:'file'
		,width:200
		,menuDisabled: true
	}
]);

var Grid = Ext.extend(Ext.grid.GridPanel, {
	border:false
	,store: store
	,cm: cm
	,viewConfig:{forceFit:true,scrollOffset:0}
});
store.load(); 

Ext.reg('examplegrid', Grid);
 
Ext.onReady(function() {
	Ext.QuickTips.init();
 
	var win = new Ext.Window({
		width:250
		,height:300
		,id:'one2many-win'
		,layout:'fit'
		,autoScroll:true
		,title: '<?php echo $sfile?>'
		,items:[{xtype:'examplegrid', id:'one2many-grid'}]
	});
	win.show();
 }); 