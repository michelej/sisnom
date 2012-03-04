$(document).ready(function(){
// PNG FIX
/*
 $('#select_municipios').bind('click', function()
    {
		$.ajax({
               type: "GET",
               url: "http://sistemas.corpointa.com/SISNOM/empleados/obtener_municipios/"+$(this).val(),
               beforeSend: function() {
				   
                     $('#div_subcategorias_wrapper').html('<div class="rating-flash" id="cargando_div">Cargando  <img src="../img/ajax-loader_mini.gif"></div>');
                     },
               success: function(msg){
                   $('#div_subcategorias_wrapper').html(msg);
               }
             });
    });
*/
//-----------------------------------------FUNCIONES MODULO CALCULAR NOMINA-------------------------------------
$('#NominaNOMMES').bind('click', function(){
	var param=$('#NominaCalcularNominaForm').serialize();
	param=decodeURIComponent(param);
	$.ajax({
               type: "POST",
               url: "http://sistemas.corpointa.com/SISNOM/nominas/actualizar_fecha",
			   data:param,
               beforeSend: function() {
				   
                     $('#div_subcategorias_wrapper').html('<div class="rating-flash" id="cargando_div">Cargando  <img src="../img/ajax-loader_mini.gif"></div>');
                     },
               success: function(msg){
                   $('#div_subcategorias_wrapper').html(msg);
               }
             });
});

$('#EmpleadoFopcion').bind('click', function(){
	var opcion=$('#EmpleadoFopcion option:selected').val();
	if(opcion==4){
		$('#EmpleadoValor').replaceWith("<select id='EmpleadoValor' name='data[Empleado][valor]'><option value='5' selected='selected'>FIJO ADMINISTRATIVO</option><option value='6'>FIJO OBRERO</option><option value='7'>CONTRATADO ADMINISTRATIVO</option><option value='8'>CONTRATADO OBRERO</option></select>");
		
	}
	if(opcion!=4  || opcion!=0){
		$('#EmpleadoValor').replaceWith("<input type='text' id='EmpleadoValor' class='small' name='data[Empleado][valor]' >");	
	}
	if(opcion==0){
		$('#EmpleadoValor').replaceWith("<select id='EmpleadoValor' name='data[Empleado][valor]'><option value='9' >INACTIVO</option><option value='10' selected='selected'>ACTIVO</option><option value='11' >VACACIONES</option><option value='12' >SUSPENDIDO</option><option value='13' >LIQUIDADO</option><option value='14' >FALLECIDO</option></select>");
		
	}
	
});

//--------------------------------------------------------------------------------------------------------------

$('#ContratoCONTMONTO').priceFormat({
    prefix: '',
    thousandsSeparator: ''
}); 
$('img').pngFix();
// MENU
$(".menu ul").supersubs({
minWidth: 12,
maxWidth: 30
})
.superfish({
autoArrows: false,
dropShadows: false
});
// SOME STYLE USER BOX
$("ul.user li:first-child").css("padding", "0 0 12px").css("margin", "-3px 0 0");
$("ul.user li:last-child").css("padding", "12px 0 0").css("background-image", "none");
$("ul.user li:last-child").css("margin", "0 0 -5px")
// SOME STYLE PAGE TABLE
$(".pages table td:first-child").css("padding", "0 8px 0 6px").css("width", "13px");
$(".pages table td:last-child").css("border-right", "none").css("text-align", "center").css("padding", "4px 20px 0");
$(".pages table tr:odd").css("background-color", "#f8f8f8");
// CHECK ALL PAGES
$('.pages .checkall').click(function () {
$(this).parents('.pages table').find(':checkbox').attr('checked', this.checked);
});
// HIDE BOXES
$('.toggle').click( function() {
$(this).parent().next('.content').fadeToggle(400);
});
// SYSTEM MESSAGES
$("div.message img").click(function () {
$(this).parent().closest('div.message').fadeOut();
});
// TABS
$('.tabs').tabs({ fx: { opacity: 'toggle' } });
$(".tabs table tr td:first-child").css('border-left','none').css('padding-left','0');
// THUMB HOVER
$(function() {
$("div.thumb").hover(
function() {
$(this).children("img").fadeTo(200, 0.85).end().children("div").show();
},
function() {
$(this).children("img").fadeTo(200, 1).end().children("div").hide();
});
});
/*// WYSISWYG
$(function () {
$('#wysiwyg').wysiwyg({
css : "css/wysiwyg-editor.css",
plugins: {
rmFormat: { rmMsWordMarkup: true }
}
});
$('#wysiwyg').wysiwyg('clear');
});*/
// STYLE FILE BUTTON
$("input[type=file]").filestyle({
imageheight : 24,
imagewidth : 89,
width : 250
});
// STYLE SELECT BOXES

//$('.row select, .actionbox select').sbCustomSelect(); 
Date.format = 'dd-mm-yyyy';
$('input.datepicker').datePicker({clickInput:true});
// TABEL STATICS
/*$('table.statics').graphTable({series: 'columns', position : 'replace', height : '180px', colors: colors});
$('.flot-graph').before('<div class="space"></div>');
function showTooltip(x, y, contents) {
$('<div id="tooltip">' + contents + '</div>').css( {
position: 'absolute',
display: 'none',
top: y+5,
left: x+5
}).appendTo("body").fadeIn(200);
}
var previousPoint = null;
$(".flot-graph").bind("plothover", function (event, pos, item) {
$("#x").text(pos.x);
$("#y").text(pos.y);
if (item) {
if (previousPoint != item.dataIndex) {
previousPoint = item.dataIndex;
$("#tooltip").remove();
var x = item.datapoint[0],
y = item.datapoint[1];
showTooltip(item.pageX, item.pageY,
"<b>" + item.series.label + "</b>: " + y);
}
}
else {
$("#tooltip").remove();
previousPoint = null;
}
});
*/


});