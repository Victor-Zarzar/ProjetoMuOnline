<?php
$archivo  = $_REQUEST['archivo'];
$file     = $_REQUEST['file'];
$f_original= ereg_replace("[^A-Za-z]", "", $archivo);
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");

?>
Ext.onReady(function(){

    Ext.QuickTips.init();
	var archivo = '<?php echo $f_original?>';
	var file    = '<?php echo $file?>';
	
	var store = new Ext.data.GroupingStore({
    proxy: new Ext.data.HttpProxy({
                url: 'deco_mix.php?dato=lista&file='+file, 
                method: 'POST'
            }),            
    reader: new Ext.data.JsonReader({
        root: 'datos'
      },
	   [ 
		{name: 'i', type: 'int'},
		{name: 'e', type: 'int'},
		{name: 'o0', type: 'int'},
		{name: 'o1'}
      ]),
      sortInfo:{field: 'o0', direction: "ASC"},
	  groupField:'o1'
    });

	store.load();

	var store2 = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({
                url: 'deco_mix.php', 
                method: 'POST'
            }),            
      reader: new Ext.data.JsonReader({
        root: 'datos'
      },
	   [ 
		{name: 'i', type: 'int'},
		{name: 'e', type: 'int'},
		{name: 'o0', type: 'int'},
		{name: 'o1'}
      ])
    });

	var store3 = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({
                url: 'deco_mix.php', 
                method: 'POST'
            }),            
      reader: new Ext.data.JsonReader({
        root: 'datos'
      },
	   [ 
		{name: 'i', type: 'int'},
		{name: 'e', type: 'int'},
		{name: 'o0', type: 'int'},
		{name: 'o1', type: 'int'},
		{name: 'o2', type: 'int'},
		{name: 'o3', type: 'int'},
		{name: 'o4', type: 'int'},
		{name: 'o5', type: 'int'},
		{name: 'o6', type: 'int'},
		{name: 'o7', type: 'int'},
		{name: 'o8', type: 'int'},
		{name: 'o9', type: 'int'},
		{name: 'o10', type: 'int'}
      ])
    });

    var gridForm = new Ext.FormPanel({
        id: 'company-form',
        frame: true,
		title:'<span class="cleft">Mix.bmd</span><span class="cright">Magichand Mu Editor</span>',
        labelAlign: 'left',
        bodyStyle:'padding:0px',
        width: 1020,
		height: 600,
        layout: 'column',
		buttons: [{
			text: '<b>Guardar</b>',
			handler: function(){
				Ext.Msg.prompt(
				'<?php echo $save?>',
				'<b><?php echo $name?></b>: <span class=\"resaltea\">'+archivo+'</span><span class=\"resalter\">\"<?php echo $t_extra?>\"</span><span class=\"resaltea\">.bmd</span>',
				function(btn, text){
					switch(btn){
						case 'ok':
							var rulesUsed2    = store2.getRange();
							var cambiosrules2 = new Array();
							for(var i = 0; i < rulesUsed2.length; i++) {
								cambiosrules2.push(rulesUsed2[i].data);
							}
							var rulesUsed3    = store3.getRange();
							var cambiosrules3 = new Array();
							for(var i = 0; i < rulesUsed3.length; i++) {
								cambiosrules3.push(rulesUsed3[i].data);
							}
							var con2 = new Ext.data.Connection();
							con2.request({
								url: 'enco_mix.php',
								params: {'dato2': Ext.util.JSON.encode(cambiosrules2),
										 'dato3': Ext.util.JSON.encode(cambiosrules3),
											'id': Ext.getCmp("id").getValue(),
											'hc': Ext.getCmp("hc").getValue(),
										  'mdm1': Ext.getCmp("mdm1").getValue(),
										  'mdm2': Ext.getCmp("mdm2").getValue(),
										  'mdm3': Ext.getCmp("mdm3").getValue(),
										  'bmn1': Ext.getCmp("bmn1").getValue(),
										  'bmn2': Ext.getCmp("bmn2").getValue(),
										  'bmn3': Ext.getCmp("bmn3").getValue(),
										  'gmn1': Ext.getCmp("gmn1").getValue(),
										  'gmn2': Ext.getCmp("gmn2").getValue(),
										  'gmn3': Ext.getCmp("gmn3").getValue(),
											'he': Ext.getCmp("he").getValue(),
											'wi': Ext.getCmp("wi").getValue(),
											'ml': Ext.getCmp("ml").getValue(),
											'mr': Ext.getCmp("mr").getValue(),
											'rm': Ext.getCmp("rm").getValue(),
										   'msr': Ext.getCmp("msr").getValue(),
										   'ub1': Ext.getCmp("ub1").getValue(),
										   'atl': Ext.getCmp("atl").getValue(),
										   'ub2': Ext.getCmp("ub2").getValue(),
										   'ruu': Ext.getCmp("ruu").getValue(),
										   'miu': Ext.getCmp("miu").getValue(),
										   'archivo': '<?php echo $archivo?>', 
										   'file': file, 
										   'extra': text
										 },
								method: 'POST',
								callback: function(opts, success, response)  {
									if (!success || ("OK" != response.responseText)) {
										Ext.MessageBox.alert("Error", success ? response.responseText : "Error Translating - try again");
										return;
									}
									else{
										Ext.MessageBox.alert("Info",'Datos Guardados con Exitos');
										store2.commitChanges();
										store3.commitChanges();
										file = archivo + text + '.bmd';
										return;

									}
								}
							});
						break;
					}
				})
			}
		}],
        items: [{
            columnWidth: 0.20,
            layout: 'fit',
            items: {
                xtype: 'grid',
                store: store,
				id: 'tabla',
				frame: true,
				stripeRows: true,
				columns: [
					{id:'combinacion',header: 'Type List', width: 60, sortable: false, dataIndex: 'o0',menuDisabled: true},
					{header: '', width: 20, sortable: false, dataIndex: 'o1', hidden: true}
				],
				view: new Ext.grid.GroupingView({
					forceFit:true,
					groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Cominaciones" : "Combinacion"]})'
				}),
                sm: new Ext.grid.RowSelectionModel({
                    singleSelect: true,
                    listeners: {
                        rowselect: function(sm, row, rec) {
//							Ext.getCmp("tit").setRawValue(rec.data.t);
							var con = new Ext.data.Connection();
							con.request({
								url: 'deco_mix.php?dato=datos',
								params: {'id': rec.data.i,'file': file},
								method: 'POST',
								callback: function(opts, success, response)  {
									if (!success || ("error" == response.responseText)) {
										Ext.MessageBox.alert("Error", success ?
											response.responseText  :
											"Error saving data - try again");
											return;
									}
									else{
										var partes = response.responseText.split("|");
										Ext.getCmp("id").setRawValue(rec.data.i);
										Ext.getCmp("hc").setRawValue(partes[1]);
										Ext.getCmp("mdm1").setRawValue(partes[2]);
										Ext.getCmp("bmn1").setRawValue(partes[5]);
										Ext.getCmp("gmn1").setRawValue(partes[8]);
										Ext.getCmp("mdm2").setRawValue(partes[3]);
										Ext.getCmp("bmn2").setRawValue(partes[6]);
										Ext.getCmp("gmn2").setRawValue(partes[9]);
										Ext.getCmp("mdm3").setRawValue(partes[4]);
										Ext.getCmp("bmn3").setRawValue(partes[7]);
										Ext.getCmp("gmn3").setRawValue(partes[10]);
										Ext.getCmp("he").setRawValue(partes[11]);
										Ext.getCmp("wi").setRawValue(partes[12]);
										Ext.getCmp("ml").setRawValue(partes[13]);
										Ext.getCmp("mr").setRawValue(partes[14]);
										Ext.getCmp("rm").setRawValue(partes[15]);
										Ext.getCmp("msr").setRawValue(partes[16]);
										Ext.getCmp("ub1").setRawValue(partes[17]);
										Ext.getCmp("atl").setRawValue(partes[18]);
										Ext.getCmp("ub2").setRawValue(partes[19]);
										Ext.getCmp("ruu").setRawValue(partes[20]);
										Ext.getCmp("miu").setRawValue(partes[21]);
										store2.load({params:{'id': rec.data.i,'dato': 'lista2','file': file}});
										store3.load({params:{'id': rec.data.i,'dato': 'lista3','file': file}});
										return;
									}
								}
							});
                        }
                    }
                }),
                height: 520,
                title:'Tipos de Combinaciones',
                border: true,
                listeners: {
                    viewready: function(g) {
                        g.getSelectionModel().selectRow(0);
                    }
                }
            }
        },{
            columnWidth: 0.19,
            xtype: 'fieldset',
            labelWidth: 90,
			header: true,
            defaults: {width: 80, border:true},
			autoHeight: true,
            bodyStyle: Ext.isIE ? 'padding:0 0 5px 5px;' : 'padding:10px 5px;',
            style: {
                "margin-left": "5px",
                "margin-right": Ext.isIE6 ? (Ext.isStrict ? "-10px" : "-13px") : "5px"
            },
			border: false,
			frame:true,
            items: [{
				fieldLabel: 'ID',
				xtype: 'hidden',
				height: 20,
				id: 'id',
				name: 't'
			},{
				fieldLabel: 'HeadCode',
				xtype: 'textfield',
				height: 20,
				id: 'hc',
				name: 't'
			},{
				fieldLabel: 'MixDescrtMsg1',
				xtype: 'textfield',
				height: 20,
				id: 'mdm1',
				name: 't'
			},{
				fieldLabel: 'MixDescrtMsg2',
				xtype: 'textfield',
				height: 20,
				id: 'mdm2',
				name: 't'
			},{
				fieldLabel: 'MixDescrtMsg3',
				xtype: 'textfield',
				height: 20,
				id: 'mdm3',
				name: 't'
			},{
				fieldLabel: 'BadMixNotice1',
				xtype: 'textfield',
				height: 20,
				id: 'bmn1',
				name: 't'
			},{
				fieldLabel: 'BadMixNotice2',
				xtype: 'textfield',
				height: 20,
				id: 'bmn2',
				name: 't'
			},{
				fieldLabel: 'BadMixNotice3',
				xtype: 'textfield',
				height: 20,
				id: 'bmn3',
				name: 't'
			},{
                fieldLabel: 'GoodMixNot1',
				xtype: 'textfield',
				height: 20,
				id: 'gmn1',
                name: 'e'
            },{
                fieldLabel: 'GoodMixNot2',
				xtype: 'textfield',
				height: 20,
				id: 'gmn2',
                name: 'e'
            },{
                fieldLabel: 'GoodMixNot3',
				xtype: 'textfield',
				height: 20,
				id: 'gmn3',
                name: 'e'
            },{
                fieldLabel: 'Height',
				xtype: 'textfield',
				height: 20,
				id: 'he',
                name: 'p'
            },{
                fieldLabel: 'Width',
				xtype: 'textfield',
				height: 20,
				id: 'wi',
                name: 'p'
            },{
                fieldLabel: 'MinLvl',
				xtype: 'textfield',
				height: 20,
				id: 'ml',
                name: 'p'
            },{
                fieldLabel: 'MoneyRule',
				xtype: 'textfield',
				height: 20,
				id: 'mr',
                name: 'p'
            },{
                fieldLabel: 'ReqMoney',
				xtype: 'textfield',
				height: 20,
				id: 'rm',
                name: 'p'
            },{
                fieldLabel: 'MaxSuccRate',
				xtype: 'textfield',
				height: 20,
				id: 'msr',
                name: 'p'
            },{
                fieldLabel: 'UnknownBYTE',
				xtype: 'textfield',
				height: 20,
				id: 'ub1',
                name: 'p'
            },{
                fieldLabel: 'AcceptTalisman',
				xtype: 'textfield',
				height: 20,
				id: 'atl',
                name: 'p'
            },{
                fieldLabel: 'UnknownBYTE',
				xtype: 'textfield',
				height: 20,
				id: 'ub2',
                name: 'p'
            },{
                fieldLabel: 'RulesUsed',
				xtype: 'textfield',
				height: 20,
				id: 'ruu',
                name: 'p'
            },{
                fieldLabel: 'MixItemUsed',
				xtype: 'textfield',
				height: 20,
				id: 'miu',
                name: 'p'
            }]
        },{
            columnWidth: 0.11,
            layout: 'fit',
            items: {
                xtype: 'editorgrid',
                store: store2,
				id: 'tabla2',
				stripeRows: true,	
				columns: [
					{
						id:'id_rule',
						header: "Rule", 
						width: 33, 
						sortable: false, 
						dataIndex: 'o0',
						menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false,
							minValue: 0,
							maxValue: 65535
						})
					},
					{
						header: "Div", 
						width: 59, 
						sortable: false, 
						dataIndex: 'o1',
						menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: true
						})
					}
				],
                height: 520,
                title:'Reglas Usadas',
				border: true,
				frame:true,
            }
        },{
            columnWidth: 0.50,
            layout: 'fit',
            items: {
                xtype: 'editorgrid',
                store: store3,
				id: 'tabla3',
				stripeRows: true,
				columns: [
					{
						id:'id_rule',
						header: "StartId", 
						width: 40, 
						sortable: false, 
						dataIndex: 'o0',
						menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header:  "EndId", width: 40, sortable: false, dataIndex: 'o1',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "Minlvl", width: 40, sortable: false, dataIndex: 'o2',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "Maxlvl", width: 45, sortable: false, dataIndex: 'o3',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MinOpt", width: 42, sortable: false, dataIndex: 'o4',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MaxOpt", width: 45, sortable: false, dataIndex: 'o5',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MinDur", width: 45, sortable: false, dataIndex: 'o6',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MaxDur", width: 45, sortable: false, dataIndex: 'o7',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MinCnt", width: 45, sortable: false, dataIndex: 'o8',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header: "MaxCnt", width: 45, sortable: false, dataIndex: 'o9',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					},
					{header:   "Type", width: 35, sortable: false, dataIndex: 'o10',menuDisabled: true,
						align: 'right',
						editor: new Ext.form.NumberField({
							allowBlank: false,
							allowNegative: false,
							allowDecimals: false
						})
					}
				],
                height: 520,
				style: {
					"padding-left": "5px",
				},
                title:'Items Usados',
                border: true,
				frame:true,
            }
        }],
        renderTo: "editor-grid"
    });
});