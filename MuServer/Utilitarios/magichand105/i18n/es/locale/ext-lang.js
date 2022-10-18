Ext.UpdateManager.defaults.indicatorText = '<div class="loading-indicator">Cargando...</div>';

if(Ext.DataView){
  Ext.DataView.prototype.emptyText = "";
}

if(Ext.grid.GridPanel){
  Ext.grid.GridPanel.prototype.ddText = "{0} fila(s) seleccionada(s)";
}

if(Ext.LoadMask){
  Ext.LoadMask.prototype.msg = "Cargando...";
}

Date.parseCodes.S.s = "(?:st|nd|rd|th)";

if(Ext.MessageBox){
  Ext.MessageBox.buttonText = {
    ok     : "Aceptar",
    cancel : "Cancelar",
    yes    : "S&#237;",
    no     : "No"
  };
}

if(Ext.PagingToolbar){
  Ext.apply(Ext.PagingToolbar.prototype, {
    beforePageText : "P&#225;gina",
    afterPageText  : "de {0}",
    firstText      : "Primera p&#225;gina",
    prevText       : "P&#225;gina anterior",
    nextText       : "P&#225;gina siguiente",
    lastText       : "Última p&#225;gina",
    refreshText    : "Actualizar",
    displayMsg     : "Mostrando {0} - {1} de {2}",
    emptyMsg       : 'Sin datos para mostrar'
  });
}

if(Ext.form.Field){
  Ext.form.Field.prototype.invalidText = "El valor en este campo es inv&#225;lido";
}

if(Ext.form.TextField){
  Ext.apply(Ext.form.TextField.prototype, {
    minLengthText : "El tama&#241;o m&#237;nimo para este campo es de {0}",
    maxLengthText : "El tama&#241;o m&#225;ximo para este campo es de {0}",
    blankText     : "Este campo es obligatorio",
    regexText     : "",
    emptyText     : null
  });
}

if(Ext.form.NumberField){
  Ext.apply(Ext.form.NumberField.prototype, {
    decimalSeparator : ".",
    decimalPrecision : 2,
    minText : "El valor m&#237;nimo para este campo es de {0}",
    maxText : "El valor m&#225;ximo para este campo es de {0}",
    nanText : "{0} no es un n&#250;mero v&#225;lido"
  });
}

if(Ext.form.ComboBox){
  Ext.apply(Ext.form.ComboBox.prototype, {
    loadingText       : "Cargando...",
    valueNotFoundText : undefined
  });
}

if(Ext.form.VTypes){
  Ext.apply(Ext.form.VTypes, {
    emailText    : 'Este campo debe ser una direcci&#243;n de correo electr&#243;nico con el formato "usuario@dominio.com"',
    urlText      : 'Este campo debe ser una URL con el formato "http:/'+'/www.dominio.com"',
    alphaText    : 'Este campo s&#243;lo debe contener letras y _',
    alphanumText : 'Este campo s&#243;lo debe contener letras, n&#250;meros y _'
  });
}

if(Ext.grid.GridView){
  Ext.apply(Ext.grid.GridView.prototype, {
    sortAscText  : "Ordenar en forma ascendente",
    sortDescText : "Ordenar en forma descendente",
    columnsText  : "Columnas"
  });
}

if(Ext.grid.GroupingView){
  Ext.apply(Ext.grid.GroupingView.prototype, {
    emptyGroupText : '(Ninguno)',
    groupByText    : 'Agrupar por este campo',
    showGroupsText : 'Mostrar en grupos'
  });
}

if(Ext.grid.PropertyColumnModel){
  Ext.apply(Ext.grid.PropertyColumnModel.prototype, {
    nameText   : "Nombre",
    valueText  : "Valor",
    dateFormat : "j/m/Y"
  });
}

if(Ext.layout.BorderLayout && Ext.layout.BorderLayout.SplitRegion){
  Ext.apply(Ext.layout.BorderLayout.SplitRegion.prototype, {
    splitTip            : "Arrastre para redimensionar.",
    collapsibleSplitTip : "Arrastre para redimensionar. Doble clic para ocultar."
  });
}

if(Ext.form.CheckboxGroup){
  Ext.apply(Ext.form.CheckboxGroup.prototype, {
    blankText : "Debe seleccionar al menos un &#233;tem de este grupo"
  });
}

if(Ext.form.RadioGroup){
  Ext.apply(Ext.form.RadioGroup.prototype, {
    blankText : "Debe seleccionar un &#233;tem de este grupo"
  });
}
