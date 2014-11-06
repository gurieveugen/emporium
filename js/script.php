<?php
	ob_start();
	define('AWP_AJAXED', true);
	define('AWP_ID', $id);

    	//path for xml file
	$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
      if (file_exists($root.'/wp-load.php')) {
          // WP 2.6
          require_once($root.'/wp-load.php');

      } else {
          // Before 2.6
          require_once($root.'/wp-config.php');
				

      }


	ob_end_clean();
	global $data, $sitepress;
	
		if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { 
			$search = stripText($data['translation_enter_search']); 
			
			} 
		else {  
			$search = __('Enter search...','wp-emporium'); 
				
		} 


echo "
	jQuery(document).ready(function(){	
		jQuery('#sidebarsearch input').val('". $search."');
		
		jQuery('#sidebarsearch input').focus(function() {
			jQuery('#sidebarsearch input').val('');
		});
		
		jQuery('#sidebarsearch input').focusout(function() {
			jQuery('#sidebarsearch input').val('". $search ."');
		});	
		
	});
";

if($data['add_to_cart'] == 1){
	echo "
	jQuery(document).ready(function(){	
		jQuery('.add_to_cart_button').live('click', function() {
			jQuery('html, body').animate({scrollTop:0}, 'medium',function(){ 

			
				jQuery('.cartHide').animate({opacity : 0},300);
				setTimeout(function() {
				  jQuery('.cart-bubble-load').addClass('loading'); 
				}, 300); 	
				setTimeout(function() {
				  	jQuery('.cart-bubble-load').removeClass('loading');  
				}, 2300);	
				setTimeout(function() {
				  	jQuery('.cartHide').animate({opacity : 1},300);
					jQuery('.widget_shopping_cart_top').css('position','static');
				}, 2300);				
			
			});
		});
	});";
	} 
	
	

?>