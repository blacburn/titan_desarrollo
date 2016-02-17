<?php
// URL base

?>

<script>
var iCnt = 0;   
var container = $(document.createElement('div')).css({
	padding: '5px'
});
$(container).attr('class', 'col-md-12')
$(container).attr('id', 'pushDina')
$(document).ready(function() {
    var t = $('#tablaCampos').DataTable();
                    $('#btAgregar').click(function() {
		        
                      	var validacion=0;          
			iCnt = iCnt + 1;
	                 if(iCnt>1){
                             var n=iCnt-1;
                            if($('#tb1'+n).val()=='' || $('#tb2'+n).val()==''){
                                if($('#tb1'+n).val()==''){
                                    alert('ingese nombre de campo');
                                }
                                if($('#tb2'+n).val()==''){
                                    alert('ingese label del campo');
                                }    
                                
                                validacion=1;
                            }
                        }
			// Añadir elementos Dinamicos en el DOM
			if(validacion==0){
                            $(container).append('<fieldset id=panel'+iCnt+' class="ui-widget ui-widget-content">'+
					'<legend class="ui-state-default ui-corner-all"> CAMPO'+iCnt+'</legend>'+
					'<div id=lab1'+iCnt+' class="col-md-2">'+
						'<label> Nombre del Campo:  </label> ' + 
					'</div>'+
                                        '<input type=text class="input" id=tb1' + iCnt + ' size="80"  maxlength="30" value="" required/>'+
                                        '<br/><br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Label del Campo: </label> ' + 
						'</div>'+
					'<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                                        '</div>'+
                                        '<br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Tipo de dato: </label> ' + 
						'</div>'+
					'<select id=tipoDato'+iCnt+'><option value="Alfanumerico">Alfanumérico</option>'+
                                        '<option value="Valor">Valor</option>'+
                                        '<option value="Lista">Lista</option>'+
                                        '<option value="Fecha">Fecha</option>'+
                                        '<option value="Tabla">Tabla</option>'+
                                        '</select>'+
                                        '</div>'+
                                        '<br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Requerido: </label> ' + 
						'</div>'+
					'<select id=requerido'+iCnt+'><option value="No">No</option>'+
                                        '<option value="Si">Si</option>'+
                                        '</select>'+
                                        '</div>'+
                                        '<br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Fórmula: </label> ' + 
						'</div>'+
					'<select id=formulacionCampo'+iCnt+'><option value="No">No</option>'+
                                        '<option value="Si">Si</option>'+
                                        '</select>'+
                                        '</div>'+ 
					'</fieldset>');
			$('#camposDinamicos').after(container);
			$('#tipoDato'+iCnt).width(250);
                        $('#tipoDato'+iCnt).select2();
                        $('#requerido'+iCnt).width(250);
                        $('#requerido'+iCnt).select2();
                        $('#formulacionCampo'+iCnt).width(250);
                        $('#formulacionCampo'+iCnt).select2(); 
                        
                        if(iCnt>1){
                            var num=iCnt-1;
                           
                           
                                 t.row.add( [ ($('#tb1'+num).val()),
                                      ($('#tb2'+num).val()),
                                      ($('#tipoDato'+num).val()),
                                      ($('#requerido'+num).val()),
                                      ($('#formulacionCampo'+num).val())] ).draw( false );
                            $('#panel'+num).remove();     
                        }
                        }
                        else{
                        iCnt = iCnt - 1;
                        }
	});
        
        
 
          $('#tablaCampos tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            t.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
        $('#btRemove').click(function() { // Elimina un panel de condiciones del DOM
		
 
   
        t.row('.selected').remove().draw( false );
    
	});
});





</script>