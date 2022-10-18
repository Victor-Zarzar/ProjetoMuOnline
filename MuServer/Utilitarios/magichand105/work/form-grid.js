Ext.onReady(function(){

    Ext.QuickTips.init();

    var bd = Ext.getBody();


	var ds = new Ext.data.JsonStore({
		url: 'files2.php?tipo=main',
		root: 'datos',
		fields: [
            {name: 'file'}
		]
	});
    ds.load();

    var colModel = new Ext.grid.ColumnModel([
        {id:'titulo', width: 193, sortable: true, locked:false, dataIndex: 'file', menuDisabled: true}
    ]);

    var gridForm = new Ext.FormPanel({
        id: 'company-form',
        frame: true,
        labelAlign: 'Left',
        bodyStyle:'padding:0px',
        width: 500,
		height: 300,
        layout: 'column',
        items: [{
            columnWidth: 0.40,
            layout: 'fit',
            items: {
                xtype: 'grid',
                ds: ds,
				id: 'tabla',
                cm: colModel,
                sm: new Ext.grid.RowSelectionModel({
                    singleSelect: true,
                    listeners: {
                        rowselect: function(sm, row, rec) {
							var con = new Ext.data.Connection();
							con.request({
								url: 'val_main.php',
								params: {'main': rec.data.file},
								method: 'POST',
								callback: function(opts, success, response)  {
									if (!success || ("error" == response.responseText)) {
										Ext.MessageBox.alert("Error", success ?
											response.responseText  :
											"Error - try again");
											return;
									}
									else{
										var partes = response.responseText.split("|");
										Ext.getCmp("main").setRawValue(partes[0]);
										Ext.getCmp("ver").setRawValue(partes[1]);
										Ext.getCmp("ser").setRawValue(partes[2]);
										Ext.getCmp("ip").setRawValue(partes[3]);
										return;
									}
								}
							});
                        }
                    }
                }),
                height: 280,
                title:'Main',
                border: true,
                listeners: {
                    viewready: function(g) {
                        g.getSelectionModel().selectRow(0);
                    }
                }
            }
        },{
            columnWidth: 0.6,
            xtype: 'fieldset',
            labelWidth: 60,
            defaults: {width: 200, border:false},
            autoHeight: true,
            bodyStyle: Ext.isIE ? 'padding:0 0 5px 15px;' : 'padding:10px 15px;',
            border: false,
            style: {
                "margin-left": "10px",
                "margin-right": Ext.isIE6 ? (Ext.isStrict ? "-10px" : "-13px") : "0"
            },
            items: [{
				fieldLabel: 'Main',
				xtype: 'textfield',
				height: 20,
				id: 'main',
				disabled: true,
				name: 't'
			},{
				fieldLabel: 'Versión',
				xtype: 'textfield',
				height: 20,
				id: 'ver',
				name: 't'
			},{
                fieldLabel: 'Serial',
				xtype: 'textfield',
				height: 20,
				id: 'ser',
                name: 'e'
            },{
                fieldLabel: 'IP',
				xtype: 'textfield',
				height: 20,
				id: 'ip',
                name: 'p'
            }],
			buttons: [{
				text: 'Guardar',
				handler: function(){
					var con2 = new Ext.data.Connection();
					con2.request({
						url: 'val_main.php',
						params: {'save': 'ok',
								'main': Ext.getCmp("main").getValue(),
								'ver': Ext.getCmp("ver").getValue(),
								'ser': Ext.getCmp("ser").getValue(),
								'ip': Ext.getCmp("ip").getValue()},
						method: 'POST',
						callback: function(opts, success, response)  {
							if (!success || ("OK" != response.responseText)) {
								Ext.MessageBox.alert("Error", success ? response.responseText : "Error Translating - try again");
								return;
							}
							else{
								Ext.MessageBox.alert("Main", "Main Saved");
							}
						}
					});
				}
			}]
        }],
        renderTo: bd
    });
});