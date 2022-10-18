<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
?>
Ext.onReady(function(){
	Ext.QuickTips.init();

	var treePanel = new Ext.tree.TreePanel({
		id: 'tree-panel',
		title: '<?php echo $arch_mod?>',
		region:'west',
		split: true,
		height: 300,
		minSize: 250,
		width: 200,
		autoScroll: true,
		rootVisible: false,
		lines: false,
		singleExpand: true,
		useArrows: true,
		loader: new Ext.tree.TreeLoader({
			dataUrl:'work/tree-data.php'
		}),
		root: new Ext.tree.AsyncTreeNode()
	});

	var contentPanel = {
		id: 'content-panel',
		region: 'center',
		layout: 'card',
		margins: '0',
		border: false,
		frame: true,
		activeItem: 0,
		items: [
			uso, todo, aportes, carpetas, buffeffect, credit, dialog, filter, filtername, gate, item, itemaddoption, itemsetoption, itemsettype, joho, johs, mst, monsterskill, movereq, pet, quest, skill, slide, socketitem, text, deco_gra, message, gatetxt, movereqtxt, creditos, questprogress, shopui, shopcategoryitems, serverlist, npcdialogue, questwords, main, decatt, minimap, mix, skilltxt
		]
	};

	treePanel.on('click', function(n){
		var sn = this.selModel.selNode || {};
		if(n.leaf && n.id != sn.id){
			Ext.getCmp('content-panel').layout.setActiveItem(n.id + '-panel');
		}
	}); 

	var entrar = new Ext.Action({
		text: '<?php echo $tentrar?>',
		defaultType: 'button',
		baseCls: 'x-plain',
		cls: 'btn-panel',
		handler: function(){
			new Ext.Viewport({
				layout: 'border',
				items: [{
					xtype: 'box',
					region: 'north',
					applyTo: 'header',
					height: 30
				},
				treePanel,contentPanel
				], 
				renderTo: Ext.getBody()
			});
			v_ini.hide();
		}
	});

	var v_ini
	function ven_inicio(){
        if(!v_ini){
            v_ini = new Ext.Window({
                applyTo:'inicio',
                layout:'fit',
                width:360,
                height:0,
				closable : false,
				buttons: [entrar],
                plain: false
            });
        }
        v_ini.show(this);
    };
	ven_inicio();
	var list_lang = new Ext.form.ComboBox({
		typeAhead: true,
		triggerAction: 'all',
		transform:'lang_id',
		width:135,
		forceSelection:true
	});
	list_lang.on('select', function(newValue) {
		var con = new Ext.data.Connection();
		con.request({
			url: 'work/change_lang.php',
			params: {'lang_id': newValue.value},
			method: 'POST'
		});
		setTimeout("window.location='index.php'", 500);
	});
});