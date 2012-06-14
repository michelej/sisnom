var $jq = jQuery.noConflict();

$jq(document).ready(function(){

    $jq('.cancel').click(function(){  
        $jq(this).parent().fadeOut();  
        return false;  
    });  
  
    // fade out good flash messages after 2 seconds  
    $jq('.flash_success').animate({
        opacity: 1.0
    }, 2000).fadeOut();
    $jq('.flash_error').animate({
        opacity: 1.0
    }, 10000).fadeOut();
        
    
    $jq('img').pngFix();
    // MENU
    $jq(".menu ul").supersubs({
        minWidth: 12,
        maxWidth: 30
    })
    .superfish({
        autoArrows: false,
        dropShadows: false
    });
    // SOME STYLE USER BOX
    $jq("ul.user li:first-child").css("padding", "0 0 12px").css("margin", "-3px 0 0");
    $jq("ul.user li:last-child").css("padding", "12px 0 0").css("background-image", "none");
    $jq("ul.user li:last-child").css("margin", "0 0 -5px")
    // SOME STYLE PAGE TABLE
    $jq(".pages table td:first-child").css("padding", "0 8px 0 6px").css("width", "13px");
    $jq(".pages table td:last-child").css("border-right", "none").css("text-align", "center").css("padding", "4px 20px 0");
    $jq(".pages table tr:odd").css("background-color", "#f8f8f8");
    // CHECK ALL PAGES
    $jq('.pages .checkall').click(function () {
        $jq(this).parents('.pages table').find(':checkbox').attr('checked', this.checked);
    });
    // HIDE BOXES
    $jq('.toggle').click( function() {
        $jq(this).parent().next('.content').fadeToggle(400);
    });
    // SYSTEM MESSAGES
    $jq("div.message img").click(function () {
        $jq(this).parent().closest('div.message').fadeOut();
    });
    // TABS
    $jq('.tabs').tabs({
        fx: {
            opacity: 'toggle'
        }
    });
$jq(".tabs table tr td:first-child").css('border-left','none').css('padding-left','0');
    // THUMB HOVER
    $jq(function() {
        $jq("div.thumb").hover(
            function() {
                $jq(this).children("img").fadeTo(200, 0.85).end().children("div").show();
            },
            function() {
                $jq(this).children("img").fadeTo(200, 1).end().children("div").hide();
            });
    });
    
    // STYLE FILE BUTTON
    $jq("input[type=file]").filestyle({
        imageheight : 24,
        imagewidth : 89,
        width : 250
    });
    // STYLE SELECT BOXES

    //$('.row select, .actionbox select').sbCustomSelect(); 
    Date.format = 'dd-mm-yyyy';
    $jq('input.datepicker').datePicker({
        clickInput:true
    });

});