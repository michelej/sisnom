// JavaScript Document
$(document).ready(function(){
	$('#filtro').hide();
	$('#sfiltro').hide();
	$('#ContratoFiltrarop').change(function(){ 
	   if($('#ContratoFiltrarop').val()==1){
		 $('#filtro_1').show();
		
	   
	   }
	   if($('#ContratoFiltrarop').val()==2){alert('hola2');}
	   
	});
});