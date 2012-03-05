// JavaScript Document
$(document).ready(function(){
// PNG FIX
$('img').pngFix();
// SYSTEM MESSAGES
$("div.message img").click(function () {
$(this).parent().closest('div.message').fadeOut();
});
        $(window).load(function () {
            var msg = $(".message").text();
            if ($.trim(msg) != '')
              $("div.message img").show();
			else
			  $("div.message img").hide();
            });
			
     
//$('.row select').sbCustomSelect();
});