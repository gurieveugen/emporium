jQuery(document).ready(function(){
    // var logoHeight = jQuery("#logo").height();
    // var headerwrapHeight = jQuery("#headerwrap").height();
    // var pastWaypoint = false;
    
    // jQuery(window).scroll(function(){
    //     if (jQuery(window).width() > 755) {
    //         if (jQuery(window).scrollTop() < 200 && !pastWaypoint) {
    //             jQuery('#headerwrap').css('min-height',headerwrapHeight + 'px');
    //             jQuery('#logo').show();
    //             pastWaypoint = true;
    //         }
    //         else if (jQuery(window).scrollTop() >= 200 && pastWaypoint)
    //         {
    //             jQuery('#logo').hide();
    //             jQuery('#headerwrap').css('min-height',headerwrapHeight - logoHeight + 'px');            
    //             pastWaypoint = false;
    //         }
    //     }
    // }); 
    jQuery('#header').css('position', 'relative');
    console.log(jQuery('#header').position().top);
    jQuery(window).bind('scroll', update);
    // $window.bind('scroll', update).resize(update);
    // update();
});

function update()
{
    var pos = jQuery(window).scrollTop(); 
    jQuery('#header-container').css('top', Math.round(pos*0.7) + 'px');
    console.log(pos);
}

// function update()
// {
//     var pos = $window.scrollTop();              

//     $this.each(function(){
//         var $element = $(this);
//         var top = $element.position().top;
//         var height = getHeight($element);

//         // Check if totally above or totally below viewport
//         if (top + height < pos || top > pos + windowHeight) {
//             return;
//         }
//         $this.css('position', 'relative');
//         $this.css('top', Math.round((firstTop - pos) * speedFactor) + "px");
//     });
// }      