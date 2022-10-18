<?php
include("../lang.php");
include("../i18n/".$lang."/locale/text.php");
($_REQUEST['archivo']) ? ($decenc_succ=$dec_succ) : ($decenc_succ=$enc_succ);
?>
Ext.onReady(function(){
    var xd = Ext.data;
	var listado = new Array();
	
    var convertir = new Ext.Action({
		text: '<span class="tipos"><?php echo $con_select;?></span>',
		handler: function(){
			var con = new Ext.data.Connection();
			var largo = listado.length;
			for(var i=0;i<largo;i++){
				con.request({
					url: 'get-gra-images.php',
					params: {'archivo': '<?php echo $_REQUEST['archivo'];?>','deco': 'ok', 'file': listado[i]},
					method: 'POST',
					callback: function(opts, success, response)  {
						if (!success || ("OK" != response.responseText)) {
							Ext.MessageBox.alert("Error", success ?
								response.responseText  :
								"Error Decoding File Try Again");
						}
					}
				});
			}
			var s = largo != 1 ? 's' : '';
			Ext.MessageBox.alert(largo+' Grafico'+s, ' <?php echo $decenc_succ;?>');
		}
	});

    var store = new Ext.data.JsonStore({
        url: 'get-gra-images.php?archivo=<?php echo $_REQUEST['archivo'];?>',
        root: 'images',
		id:'name',
        fields: ['id', 'name']
    });
    store.load();

    var tpl = new Ext.XTemplate(
		'<tpl for=".">',
            '<div class="thumb-wrap" id="{id}">',
		    '<div class="thumb"><img src="get-gra-images.php?archivo=<?php echo $_REQUEST['archivo'];?>&file={name}" title="{name}"></div>',
		    '<span class=""><b>{name}</b></span></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
	);

	var dataview = new Ext.DataView({
			id: 'lista_gra',
            store: store,
            tpl: tpl,
            autoHeight:false,
			autoScroll: true,
            multiSelect: true,
            overClass:'x-view-over',
            itemSelector:'div.thumb-wrap',
            emptyText: 'No Image to display',
           
            listeners: {
            	dblclick: {
            		fn: function(dv,nodes){
						var con = new Ext.data.Connection();
						con.request({
							url: 'get-gra-images.php',
							params: {'archivo': '<?php echo $_REQUEST['archivo'];?>','deco': 'ok', 'file': dataview.store.getById(nodes).data.name},
							method: 'POST',
							callback: function(opts, success, response)  {
								if (!success || ("OK" != response.responseText)) {
									Ext.MessageBox.alert("Error", success ?
										response.responseText  :
										"Error Decoding File Try Again");
										return;
								}
								else{
									Ext.MessageBox.alert(dataview.store.getById(nodes).data.name, '<?php echo $decenc_succ;?>');
									return;
								}
							}
						});
            		}
            	},
            	selectionchange: {
            		fn: function(dv,nodes){
            			var l = nodes.length;
						listado.length = l;
            			for(var i=0;i<l;i++){
							listado[i] = nodes[i].id;
						}
            		}
            	}				
            }
        })

    var panel = new Ext.Panel({
        id:'images-view',
        frame:true,
        width:1000,
		Height: 450,
		autoScroll: true,
        autoHeight:false,
        collapsible:true,
        layout:'fit',
		tbar: [convertir],
        title:'Image Decoder',
        items: dataview
    });

    panel.render(document.body);

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
    panel.setSize(Tam[0],Tam[1]);

    window.onresize = function() {
        var Tam = TamVentana();
		panel.setSize(Tam[0],Tam[1]);
    };
});