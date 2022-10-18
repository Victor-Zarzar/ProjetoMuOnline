/*!
 * Ext JS Library 3.1.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){
    var xd = Ext.data;

    var store = new Ext.data.JsonStore({
        url: 'get-map-images.php',
        root: 'images',
		id:'id',
        fields: ['id', 'name']
    });
    store.load();

    var tpl = new Ext.XTemplate(
		'<tpl for=".">',
            '<div class="thumb-wrap" id="{id}">',
		    '<div class="thumb"><img src="get-map-images.php?file={name}" title="{name}"></div>',
		    '<span class=""><b>{name}</b></span></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
	);

	var dataview = new Ext.DataView({
			id: 'lista_att',
            store: store,
            tpl: tpl,
            autoHeight:true,
            multiSelect: false,
            overClass:'x-view-over',
            itemSelector:'div.thumb-wrap',
            emptyText: 'No Maps to display',
           
            listeners: {
            	dblclick: {
            		fn: function(dv,nodes){
						var con = new Ext.data.Connection();
						con.request({
							url: 'get-map-images.php',
							params: {'deco': 'ok', 'file': dataview.store.getById(nodes).data.name},
							method: 'POST',
							callback: function(opts, success, response)  {
								if (!success || ("OK" != response.responseText)) {
									Ext.MessageBox.alert("Error", success ?
										response.responseText  :
										"Error Decoding File Try Again");
										return;
								}
								else{
									Ext.MessageBox.alert(dataview.store.getById(nodes).data.name, 'Was Decode Succefully');
									return;
								}
							}
						});
            		}
            	}
            }
        })

    var panel = new Ext.Panel({
        id:'images-view',
        frame:true,
        width:1000,
		Height: 450,
        collapsible:true,
        layout:'fit',
        title:'Map To 3 Layer',
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