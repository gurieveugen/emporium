jQuery(document).ready(function(){
    jQuery(window).bind('scroll', update).resize(update);
    update();
});

function update()
{
    var pos = jQuery(window).scrollTop(); 
    jQuery('#header-container').css('top', Math.round(pos*0.7) + 'px');
}   