// jQuery(document).ready(function(){
//     var logoHeight = jQuery("#logo").height();
//     var headerwrapHeight = jQuery("#headerwrap").height();
//     var pastWaypoint = false;
        
//     jQuery(window).scroll(function(){
//         if (jQuery(window).width() > 755) {
//             if (jQuery(window).scrollTop() < 200 && !pastWaypoint) {
//                 jQuery('#headerwrap').css('min-height',headerwrapHeight + 'px');
//                 jQuery('#logo').show();
//                 pastWaypoint = true;
//             }
//             else if (jQuery(window).scrollTop() >= 200 && pastWaypoint)
//             {
//                 jQuery('#logo').hide();
//                 jQuery('#headerwrap').css('min-height',headerwrapHeight - logoHeight + 'px');            
//                 pastWaypoint = false;
//             }
//         }
//     }); 

//     jQuery(window).bind('scroll', update).resize(update);
//     update();
// });

// function update()
// {
//     var pos = jQuery(window).scrollTop(); 
//     jQuery('#logo a').css('top', Math.round(pos*0.7) + 'px');
// }   