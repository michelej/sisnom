$(document).ready(
function(){  
    // fadeout flash messages on click  
    $('.cancel').click(function(){  
        $(this).parent().fadeOut();  
    return false;  
    });  
  
    // fade out good flash messages after 2 seconds  
    $('.flash_success').animate({opacity: 1.0}, 2000).fadeOut();
    $('.flash_error').animate({opacity: 1.0}, 10000).fadeOut();  
}
);