<?php
$archivo  = $_REQUEST['archivo'];
$file     = $_REQUEST['file'];
$busqueda = $_REQUEST['busqueda'];
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");

$f_original= ereg_replace("[^A-Za-z]", "", $archivo);
$variables = "var archivo = \"$f_original\";\n
			  var file    = \"$file\";\n";

include("funciones.php");
$archivo  = version_file($archivo, $file);
include("../config.php");

$field = "			{name: 'i'},\n			{name: 'e'},\n";
$campos_trad  = "";
$campos_trad2 = "";
$num 		  =  0;
for($i = 0;$i < count($col); $i++){
	($col[$i][7]==1) ? ($verdad="true") : ($verdad="false");
	if($col[$i][1]==0){
		$num++;
		$campos_trad  .= "'text_tran".$num."': l_trans[i].get(\"o".$i."\"),";
		$campos_trad2 .= "erecord.set(\"o".$i."\", partes_tans[".$num."]);\n";
		$editor = ",
			editor: new fm.TextField({
				allowBlank: ".$verdad.",
				minLength: 0,
				maxLength: ".$col[$i][8]."
			})";
		$h_trad = true;
	}
	if($col[$i][1]==1){
		list( $minval, $maxval) = split( '[.]', $col[$i][8]);
		if($maxval!=0){
			$editor = ",
				editor: new fm.NumberField({
					allowBlank: false,
					allowNegative: ".$verdad.",
					allowDecimals: false,
					minValue: ".$minval.",
					maxValue: ".$maxval."
				})";
		}
	}
	
	($conf[0]==$i) ? ($ae ="id:'o".$i."',\n\t\t\t") : ($ae="");
	($col[$i][6]==0) ? ($a="left") : ($a="right");
	$lcol .= "
		{
			".$ae."header: \"".$col[$i][0]."\",
			dataIndex: 'o".$i."',
			width: ".$col[$i][4].",
			hideable: false,
			menuDisabled: true,
			resizable: true,
			tooltip: '".$col[$i][9]."',
			align: '".$a."'".$editor."
		},";
	$field .= "			{name: 'o".$i."'},\n";
}
if($h_trad) $cm = "		sm2,";
$cm .= "
		{
			header: '',
			width: 28,
			sortable: false,
			fixed:false,
			hideable: false,
			id: 'numberer',";

if($paginas[0][5]!=1){
	$cm .= "
			dataIndex: 'a',
			renderer : function(value, meta, record, rowIndex, colIndex, store){
				var num = -1;
				store.each(function(r){
				if(r._groupId == record._groupId){
					num++;
				}
				return record != r;
				});
				return num;
			}
		},\n";
}
else{
	$cm .= "
			dataIndex: 'i'\n
		},\n";
}

$cm .= substr_replace($lcol, '', -1);
$field = substr_replace($field, '', -2);

if($paginar==1){
	$store = "store.load({params:{start: 0, limit: ".$paginas[0][4]."}});";
	$cbotones = "vertipo.setText('<span class=\"tipos\">".$viendo.": ".$paginas[0][2]."</span>');";
	for($i = 0;$i < count($paginas); $i++){
		$cbotones .= "	var ".$paginas[$i][0]." = new Ext.Action({
			text: '<span class=\"tipos\">".$paginas[$i][1]."</span>',
			tooltip: '".$paginas[$i][2]."',
			handler: function(){
				grid.store.commitChanges();
				store.load({params:{start: ".$paginas[$i][3].", limit: ".$paginas[$i][4]."}});
				vertipo.setText('<span class=\"tipos\">".$viendo.": ".$paginas[$i][2]."</span>');
			}
		});\n";
		$botones .=	"			".$paginas[$i][0].",\n";
	}
	$bbar = "		bbar: [\n".substr_replace ($botones, '', -2)."\n		],\n";
}
else
	$store = "store.load();";


?>
Ext.onReady(function(){
	Ext.QuickTips.init();

	var fm = Ext.form;
	var xg = Ext.grid;
	
    var sm2 = new xg.CheckboxSelectionModel({
        listeners: {
            selectionchange: function(sm) {
                if (sm.getCount()) {
                    translate.enable();
                } else {
                    translate.disable();
                }
            }
        }
    });
	
	
	var cm = new Ext.grid.ColumnModel([<?php echo $cm."\n"?>
    ]);


	//top toolbar
    var vertipo = new Ext.Action({
        text: ''
	});
	<?php echo $variables?>
	
	if(archivo=="message"){
		var extension = '.wtf';
		var campo     = 'o2';
	}
	else{
		var extension = '.bmd';
		var campo     = 'o1';
	}

    var salvar = new Ext.Action({
        text: '<span class="tipos"><?php echo $save?> <?php echo $conf[5]?></span>',
        handler: function(){
            Ext.Msg.prompt(
			'<?php echo $save?>',
			'<b><?php echo $name?></b>: <span class=\"resaltea\">'+archivo+'</span><span class=\"resalter\">\"<?php echo $t_extra?>\"</span><span class=\"resaltea\">'+extension+'</span>',
			function(btn, text){
				switch(btn){
					case 'ok':
						var modifiedRecords = grid.store.getModifiedRecords();
						if (modifiedRecords.length > 0) {
							var cambios = new Array();
							for(var i = 0; i < modifiedRecords.length; i++) {
								cambios.push(modifiedRecords[i].data);
							}
							var con = new Ext.data.Connection();
							con.request({
								url: 'enco.php',
								params: {'datos': Ext.util.JSON.encode(cambios), 'archivo': '<?php echo $archivo?>', 'file': file, 'extra': text},
								method: 'POST',
								callback: function(opts, success, response)  {
									if (!success || ("OK" != response.responseText)) {
										Ext.MessageBox.alert("Error", success ?
											response.responseText  :
											"Error saving data - try again");
											return;
									}
									else{
										Ext.MessageBox.alert("<?php echo $saved?>", '<?php echo $t_saved?>');
										grid.store.commitChanges();
										if(archivo=="message")
											file = archivo + text + '.wtf';
										else
											file = archivo + text + '.bmd';
										return;
									}
								}
							});
						}
					break;
				}
			}
        )}
    });

    var buscar = new Ext.Action({
        text: '<span class="tipos">Buscar</span>',
        handler: function(){
			store.load({params:{busqueda: 'error'}});
		}
    });

	var f_lang = new Ext.data.JsonStore({
		url: '../i18n/from_langs.php',
		root: 'languages',
		fields: ['id', 'encode']
	});

	var from_encode = new Ext.form.ComboBox({
		store: f_lang,
		displayField:'encode',
		typeAhead: true,
		triggerAction: 'all',
		width:95,
		forceSelection:true
	});

	from_encode.on('select', function(newValue) {
		var con = new Ext.data.Connection();
		con.request({
			url: 'change_lang.php',
			params: {'lang_load': newValue.value},
			method: 'POST'
		});
		setTimeout(location.reload(), 500);
	});

	var to_encode = new Ext.form.ComboBox({
		store: f_lang,
		displayField:'encode',
		typeAhead: true,
		triggerAction: 'all',
		width:95,
		forceSelection:true
	});

	to_encode.on('select', function(newValue) {
		var con = new Ext.data.Connection();
		con.request({
			url: 'change_lang.php',
			params: {'lang_save': newValue.value},
			method: 'POST'
		});
		setTimeout(location.reload(), 500);
	});

    var translate = new Ext.Action({
        text: '<span class="tipos"><?php echo $t_translate?></span>',
        handler: function(){
			if(btn.text=="xx" || btn2.text=="xx"){
				alert("<?php echo $from_to;?>");
			}
			else{
				var l_trans = sm2.getSelections();
				var l_count = sm2.getCount();
				if(l_count > 50){
					l_count = 50;
				}
				for(var i = 0; i < l_count; i++) {
					var con = new Ext.data.Connection();
					con.request({
						url: 'googletranslate.php',
						params: {<?php echo $campos_trad;?>'text_id': l_trans[i].get("i"),'cantidad':'<?php echo $num?>','from':btn.text,'to':btn2.text},
						method: 'POST',
						callback: function(opts, success, response)  {
							if (!success || ("Error" == response.responseText)) {
								Ext.MessageBox.alert("Error", success ? response.responseText : "Error Translating - try again");
								return;
							}
							else{
								var partes_tans=response.responseText.split("|");
								erecord = grid.getStore().getAt(partes_tans[0]);
								<?php echo $campos_trad2;?>
							}
						}
					});
				}
			}
		},
		disabled: true
    });

<?php echo "$cbotones";?>

	cm.defaultSortable = false;

	var store = new Ext.data.JsonStore({
		url: 'deco.php?archivo=<?php  echo $archivo?>&file=<?php echo $file?>&busqueda=<?php  echo $busqueda?>',
		root: 'datos',
		fields: [
<?php echo "$field"?>

			]
	});

	var l_flags = [{
		text:'xx',
		iconCls:'flag-xx',
		checked:true
	},{
		text:'es',
		iconCls:'flag-es',
	},{
		text:'en',
		iconCls:'flag-us'
	},{
		text:'ru',
		iconCls:'flag-ru'
	},{
		text:'ko',
		iconCls:'flag-kr'
	},{
		text:'br',
		iconCls:'flag-br'
	},{
		text:'ja',
		iconCls:'flag-jp'
	}];
		
    var btn = new Ext.CycleButton({
        showText: true,
        items: l_flags
    });

    var btn2 = new Ext.CycleButton({
        showText: true,
        items: l_flags
    });

    var from = new Ext.CycleButton({
        showText: true,
        items: [{
				text:'Cod. Origen',
				iconCls:'flag-xx',
			},{
				text:'ISO-8859-1',
				iconCls:'flag-es',
<?php if($load_txt_lang=="ISO-8859-1") echo "				checked:true"; ?>
			},{
				text:'UTF-8',
				iconCls:'flag-us',
<?php if($load_txt_lang=="UTF-8") echo "				checked:true"; ?>
			},{
				text:'windows-1251',
				iconCls:'flag-ru',
<?php if($load_txt_lang=="windows-1251") echo "				checked:true"; ?>
			},{
				text:'EUC-KR',
				iconCls:'flag-kr',
<?php if($load_txt_lang=="EUC-KR") echo "				checked:true"; ?>
			},{
				text:'ISO-8859-1',
				iconCls:'flag-br',
			},{
				text:'EUC-JA',
				iconCls:'flag-jp',
<?php if($load_txt_lang=="EUC-JA") echo "				checked:true"; ?>
			}
		],
		changeHandler:function(){
			if(from.text!='Cod. Origen'){
				var con = new Ext.data.Connection();
				con.request({
					url: 'change_lang.php',
					params: {'lang_load': from.text},
					method: 'POST',
					success: function(responseObject) {
						setTimeout(location.reload(), 500);
					}
				});
			}
		}
    });

	var to = new Ext.CycleButton({
        showText: true,
        items: [{
				text:'Cod. Destino',
				iconCls:'flag-xx',
			},{
				text:'ISO-8859-1',
				iconCls:'flag-es',
<?php if($save_txt_lang=="ISO-8859-1") echo "				checked:true"; ?>
			},{
				text:'UTF-8',
				iconCls:'flag-us',
<?php if($save_txt_lang=="UTF-8") echo "				checked:true"; ?>
			},{
				text:'windows-1251',
				iconCls:'flag-ru',
<?php if($save_txt_lang=="windows-1251") echo "				checked:true"; ?>
			},{
				text:'EUC-KR',
				iconCls:'flag-kr',
<?php if($save_txt_lang=="EUC-KR") echo "				checked:true"; ?>
			},{
				text:'ISO-8859-1',
				iconCls:'flag-br',
			},{
				text:'EUC-JA',
				iconCls:'flag-jp',
<?php if($save_txt_lang=="EUC-JA") echo "				checked:true"; ?>
			}
		],
		changeHandler:function(){
			if(to.text!='Cod. Destino'){
				var con = new Ext.data.Connection();
				con.request({
					url: 'change_lang.php',
					params: {'lang_save': to.text},
					method: 'POST'
				});
			}
		}
    });

	var pepe =	new Ext.Toolbar.SplitButton({
		text: '<span class="tipos">Archivo</span>',
		tooltip: {text:'Abrir, Guardar, Etc', title:'Contenido de Archivo'},
		iconCls: 'blist',
		menu : {
			items: [{
				text: '<b>Abrir</b>',
				menu: {
					items: [
						{
							text: 'Desde archvo <b>.bmd</b>'
						},
						{
							text: 'Desde archvo <b>.txt</b>',
							iconCls: 'ico_txt'
						},
						{
							text: 'Desde archvo <b>.xls</b>',
							iconCls: 'ico_xls'
						}
					]
				}
			},{
				text: '<b>Guardar</b>',
				menu: {
					items: [
						{
							text: '<span class="tipos">En formato <b>.bmd</b></span>',
							iconCls: 'ico_txt',
							formato: 'bmd'
						},
						{
							text: '<span class="tipos">En formato <b>.txt</b></span>',
							iconCls: 'ico_txt',
							formato: 'txt'
						},
						{
							text: '<span class="tipos">En formato <b>.xls</b></span>',
							iconCls: 'ico_xls',
							formato: 'xls'
						}
					]
				}
			},{
				text: '<b>Combinar</b>',
				menu: {
					items: [
						{
							text: '<span class="tipos">Desde archivo <b>.bmd</b></span>',
							iconCls: 'ico_txt',
							formato: 'bmd'
						},
						{
							text: '<span class="tipos">Desde archivo <b>.txt</b></span>',
							iconCls: 'ico_txt',
							formato: 'bmd'
						},
						{
							text: '<span class="tipos">Desde archivo <b>.xls</b></span>',
							iconCls: 'ico_xls',
							formato: 'bmd'
						}
					]
				}
			}
			]
		}
	});

	var myMask = new Ext.LoadMask(Ext.getBody(), {msg:"<?php echo $loading;?>"});
	myMask.show();

	var grid = new Ext.grid.EditorGridPanel({
		store: store,
		waitMsg:'Loading',
		cm: cm,
		loadMask: myMask,
<?php
if($h_trad)
echo "		sm: sm2,\n";
?>
		renderTo: 'editor-grid',
		width: 800,
		height: 500,
<?php if($conf[0]!=-1) echo "		autoExpandColumn:'o".$conf[0]."',"; ?>
		title:'<span class="cleft"><?php  echo $conf[5]?></span><span class="cright">Magichand Mu Editor</span>',
		frame:true,
		tbar: [salvar,'-',  
			<?php if($buscar==1) echo "'  ', new Ext.app.SearchField({ store: store, width:240 }),  ";?> <?php if($h_trad) echo " btn, translate, btn2,'-', from, to, \n";?> 
			'->', vertipo
		],
		<?php  echo $bbar?>
		stripeRows: true,	
		view: new Ext.ux.BufferView({
			rowHeight: 19,
			scrollDelay: false
		}),

		columnLines : true,
		clicksToEdit:2
	});
<?php  echo $store?>

   function TamVentana() {
      var Tamanyo = [0, 0];
      if (typeof window.innerWidth != 'undefined')
      {
        Tamanyo = [
            window.innerWidth,
            window.innerHeight
        ];
      }
      else if (typeof document.documentElement != 'undefined'
          && typeof document.documentElement.clientWidth !=
          'undefined' && document.documentElement.clientWidth != 0)
      {
     Tamanyo = [
            document.documentElement.clientWidth,
            document.documentElement.clientHeight
        ];
      }
      else   {
        Tamanyo = [
            document.getElementsByTagName('body')[0].clientWidth,
            document.getElementsByTagName('body')[0].clientHeight
        ];
      }
      return Tamanyo;
    }
    var Tam = TamVentana();
    grid.setSize(Tam[0],Tam[1]);

    window.onresize = function() {
        var Tam = TamVentana();
		grid.setSize(Tam[0],Tam[1]);
    };
});

