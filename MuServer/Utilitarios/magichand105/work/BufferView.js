Ext.ux.BufferView = Ext.extend(Ext.grid.GridView, {
	rowHeight: 19,
	borderHeight: 2,
	scrollDelay: 100,
	cacheSize: 20,
	cleanDelay: 500,
	
	initTemplates : function(){
		Ext.ux.BufferView.superclass.initTemplates.call(this);
		var ts = this.templates;
	        ts.rowHolder = new Ext.Template(
		        '<div class="x-grid3-row {alt}" style="{tstyle}"></div>'
		);
		ts.rowHolder.disableFormats = true;
		ts.rowHolder.compile();
		
		ts.rowBody = new Ext.Template(
		        '<table class="x-grid3-row-table" border="0" cellspacing="0" cellpadding="0" style="{tstyle}">',
			'<tbody><tr>{cells}</tr>',
			(this.enableRowBody ? '<tr class="x-grid3-row-body-tr" style="{bodyStyle}"><td colspan="{cols}" class="x-grid3-body-cell" tabIndex="0" hidefocus="on"><div class="x-grid3-row-body">{body}</div></td></tr>' : ''),
			'</tbody></table>'
		);
		ts.rowBody.disableFormats = true;
		ts.rowBody.compile();
	},

	getStyleRowHeight : function(){
		return Ext.isBorderBox ? (this.rowHeight + this.borderHeight) : this.rowHeight;
	},

	getCalculatedRowHeight : function(){
		return this.rowHeight + this.borderHeight;
	},

	getVisibleRowCount : function(){
		var rh = this.getCalculatedRowHeight();
		var visibleHeight = this.scroller.dom.clientHeight;
		return (visibleHeight < 1) ? 0 : Math.ceil(visibleHeight / rh);
	},
	getVisibleRows: function(){
		var count = this.getVisibleRowCount();
		var sc = this.scroller.dom.scrollTop;
		var start = (sc == 0 ? 0 : Math.floor(sc/this.getCalculatedRowHeight())-1);
		return {
			first: Math.max(start, 0),
			last: Math.min(start + count + 2, this.ds.getCount()-1)
		};
	},
	doRender : function(cs, rs, ds, startRow, colCount, stripe, onlyBody){
		var ts = this.templates, ct = ts.cell, rt = ts.row, rb = ts.rowBody, last = colCount-1;
		var rh = this.getStyleRowHeight();
		var vr = this.getVisibleRows(); 
		var tstyle = 'width:'+this.getTotalWidth()+';height:'+rh+'px;';
		var buf = [], cb, c, p = {}, rp = {tstyle: tstyle}, r;
		for (var j = 0, len = rs.length; j < len; j++) {
			r = rs[j]; cb = [];
			var rowIndex = (j+startRow);
			var visible = rowIndex >= vr.first && rowIndex <= vr.last;
			if (visible) {
				for (var i = 0; i < colCount; i++) {
					c = cs[i];
					p.id = c.id;
					p.css = i == 0 ? 'x-grid3-cell-first ' : (i == last ? 'x-grid3-cell-last ' : '');
					p.attr = p.cellAttr = "";
					p.value = c.renderer(r.data[c.name], p, r, rowIndex, i, ds);
					p.style = c.style;
					if (p.value == undefined || p.value === "") {
						p.value = "&#160;";
					}
					if (r.dirty && typeof r.modified[c.name] !== 'undefined') {
						p.css += ' x-grid3-dirty-cell';
					}
					cb[cb.length] = ct.apply(p);
				}
			}
			var alt = [];
			if(stripe && ((rowIndex+1) % 2 == 0)){
			    alt[0] = "x-grid3-row-alt";
			}
			if(r.dirty){
			    alt[1] = " x-grid3-dirty-row";
			}
			rp.cols = colCount;
			if(this.getRowClass){
			    alt[2] = this.getRowClass(r, rowIndex, rp, ds);
			}
			rp.alt = alt.join(" ");
			rp.cells = cb.join("");
			buf[buf.length] =  !visible ? ts.rowHolder.apply(rp) : (onlyBody ? rb.apply(rp) : rt.apply(rp));
		}
		return buf.join("");
	},
	isRowRendered: function(index){
		var row = this.getRow(index);
		return row && row.childNodes.length > 0;
	},
	syncScroll: function(){
		Ext.ux.BufferView.superclass.syncScroll.apply(this, arguments);
		this.update();
	},
	update: function(){
		if (this.scrollDelay) {
			if (!this.renderTask) {
				this.renderTask = new Ext.util.DelayedTask(this.doUpdate, this);
			}
			this.renderTask.delay(this.scrollDelay);
		}else{
			this.doUpdate();
		}
	},
	doUpdate: function(){
		if (this.getVisibleRowCount() > 0) {
			var g = this.grid, cm = g.colModel, ds = g.store;
		        var cs = this.getColumnData();

		        var vr = this.getVisibleRows();
			for (var i = vr.first; i <= vr.last; i++) {
				if(!this.isRowRendered(i)){
					var html = this.doRender(cs, [ds.getAt(i)], ds, i, cm.getColumnCount(), g.stripeRows, true);
					this.getRow(i).innerHTML = html;
				}	
			}
			this.clean();
		}
	},
	clean : function(){
		if(!this.cleanTask){
			this.cleanTask = new Ext.util.DelayedTask(this.doClean, this);
		}
		this.cleanTask.delay(this.cleanDelay);
	},
	doClean: function(){
		if (this.getVisibleRowCount() > 0) {
			var vr = this.getVisibleRows();
			vr.first -= this.cacheSize;
			vr.last += this.cacheSize;

			var i = 0, rows = this.getRows();
			if(vr.first <= 0){
				i = vr.last + 1;
			}			
			for(var len = this.ds.getCount(); i < len; i++){
				if ((i < vr.first || i > vr.last) && rows[i].innerHTML) {
					rows[i].innerHTML = '';
				}
			}
		}
	},
	layout: function(){
		Ext.ux.BufferView.superclass.layout.call(this);
		this.update();
	}
});
