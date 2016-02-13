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
    
    
    
	
                      
	 
	$('#btAgregar').click(function() {
		        
                      	                 
			iCnt = iCnt + 1;
	                 
			// Añadir elementos Dinamicos en el DOM
			
			$(container).append('<fieldset id=panel'+iCnt+' class="ui-widget ui-widget-content">'+
					'<legend class="ui-state-default ui-corner-all"> CAMPO'+iCnt+'</legend>'+
					'<div id=lab1'+iCnt+' class="col-md-2">'+
						'<label> Nombre del Campo:  </label> ' + 
					'</div>'+
                                        '<input type=text class="input" id=tb1' + iCnt + ' size="80"  maxlength="30" value="""/>'+
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
                                        '<option value="Fecha">Audi</option>'+
                                        '<option value="Tabla">Audi</option>'+
                                        '</select>'+
                                        '</div>'+
                                        '<br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Requerido: </label> ' + 
						'</div>'+
					'<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                                        '</div>'+
                                        '<br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Fórmula: </label> ' + 
						'</div>'+
					'<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                                        '</div>'+ 
					'</fieldset>');
			$('#camposDinamicos').after(container);
			$('#tipoDato'+iCnt).width(250);
                        $('#tipoDato'+iCnt).select2();
                 
	});
	
         
        
        
        
        
});
</script>