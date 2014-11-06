<?php

//delete_transient('woocommerce_currency_converter_rates');
//add_action('init', 'js_inc_function');
//add_theme_support( 'post-formats', array( 'link', 'gallery', 'video' ) );


/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/


// Paths to admin functions
define('MY_TEXTDOMAIN', 'wp-emporium');
load_theme_textdomain( 'wp-emporium', get_template_directory() . '/languages' );
load_theme_textdomain( 'woocommerce', get_template_directory() . '/languages' );
define('ADMIN_PATH', get_stylesheet_directory() . '/admin/');
define('BOX_PATH', get_stylesheet_directory() . '/includes/boxes/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', ADMIN_PATH . '/layouts/');

// You can mess with these 2 if you wish.
$themedata = wp_get_theme(get_stylesheet_directory() . '/style.css');
define('THEMENAME', $themedata['Name']);
define('OPTIONS', 'of_options'); // Name of the database row where your options are stored

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	
	add_action('admin_head','of_option_setup');

}

// Build Options
require_once (ADMIN_PATH . 'theme-options.php'); 		// Options panel settings and custom settings
require_once (ADMIN_PATH . 'admin-interface.php');		// Admin Interfaces 
require_once (ADMIN_PATH . 'admin-functions.php'); 	// Theme actions based on options settings
require_once (ADMIN_PATH . 'medialibrary-uploader.php'); // Media Library Uploader


$includes =  get_template_directory() . '/includes/';
$widget_includes =  get_template_directory() . '/includes/widgets/';

require_once ($includes  . 'scripts.php'); // Load JS 

// Other theme options
require_once ($includes . 'menu.php'); 		   // Menus
require_once ($includes . 'sidebars.php');
require_once ($includes . 'shortcodes.php');
	
require_once ($widget_includes . 'pop_widget.php'); 
require_once ($widget_includes . 'racent_widget.php'); 
require_once ($widget_includes . 'contact_widget.php'); 


/*woocomerce widget*/
if (function_exists( 'is_woocommerce' ) ) : 

require_once ($widget_includes . 'widget-top_rated_products_pmc.php'); 
require_once ($widget_includes . 'widget-recent_products_pmc.php'); 
require_once ($widget_includes . 'widget-random_products_pmc.php'); 
require_once ($widget_includes . 'widget-featured_products_pmc.php'); 
require_once ($widget_includes . 'widget-best_sellers_pmc.php'); 
require_once ($widget_includes . 'widget-recently_viewed_pmc.php'); 
require_once ($widget_includes . 'widget-recent_reviews_pmc.php'); 
require_once ($widget_includes . 'widget-onsale_pmc.php'); 
require_once ($widget_includes . 'widget-price_filter_pmc.php'); 

endif;


// Load external file to add support for MultiPostThumbnails. Allows you to set more than one "feature image" per post.
require_once('includes/multi-post-thumbnails.php');

if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label' => '2nd Feature Image',
        'id' => 'feature-image-2',
        'post_type' => 'portfolioentry'
        )
    );    
 
}

if (function_exists('icl_object_id')) { 
    function languages_list_footer(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        echo '<div id="footer_language_list"><ul>';
        foreach($languages as $l){
            echo '<li>';
            if($l['country_flag_url']){
                if(!$l['active']) echo '<a href="'.$l['url'].'">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                if(!$l['active']) echo '</a>';
            }

            echo '</li>';
        }
        echo '</ul></div>';
    }
	}
	function current_language(){

		global $sitepress;

		$current_language = $sitepress->get_current_language();

		return $current_language;

	}
}    
        
	function showTopCart() {
		
		global $woocommerce, $data, $sitepress;
		?>
			<div class="top-nav">
				<div class="socialTop">
					<?php socialLinkTop() ?><a href="https://www.google.com/+Dynamicdiscdesigns?rel=author" target="_blank" class="googlelink top"></a>
					<?php if (function_exists('icl_object_id')) { echo languages_list_footer(); } ?>
				</div>
				<?php	if (function_exists( 'is_woocommerce' ) ) : ?>
				<div class="notification">
				<div class="cartWrapper">
					<div class="cart-bubble-load"></div><span class="cartHide"><a class="cart-bubble cart-contents">(<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>)</a></span>
					<?php 
					$check_out = '';
					if($woocommerce->cart->get_cart_url() != ''){ 
					if (function_exists('icl_object_id')) {
						$cart= get_permalink(icl_object_id(woocommerce_get_page_id( 'cart' ), 'page', false));
						$check_out = get_permalink(icl_object_id(woocommerce_get_page_id( 'checkout' ), 'page', false));
						}
					else {
						$cart=$woocommerce->cart->get_cart_url();
						$check_out = $woocommerce->cart->get_checkout_url(); 
					}
					}
					else {$cart = home_url().'/cart/';};
					?>
					<a href="<?php echo $cart; ?>" class="cart"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_cart']); } else {  _e('Cart','wp-emporium'); } ?></a>
				<div class="widget_shopping_cart_top">	
					<div class="cartTopDetails">
						<ul class="cart_list product_list_widget ">

							<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>

								<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :

									$_product = $cart_item['data'];

									// Only display if allowed
									if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
										continue;

									// Get price
									$product_price = get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price() ;
									
									$product_price = $product_price * $cart_item['quantity'];
									
									$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
									?>

									<li>
										<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">


											<?php echo $cart_item['quantity'] ?> x <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>

										</a>

										<?php //echo $woocommerce->cart->get_item_data( $cart_item ); ?>

										<span class="quantity"><?php printf( '%s',  $product_price ); ?></span>
									</li>

								<?php endforeach; ?>

							<?php else : ?>

								<li class="empty cart"><?php _e('No products in the cart.', 'woocommerce'); ?></li>

							<?php endif; ?>
						<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
								<p class="total top"><strong><?php _e('Subtotal', 'woocommerce'); ?>:</strong> <?php echo $woocommerce->cart->get_cart_subtotal(); ?></p>
							
							<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

							<p class="buttons">
								<a href="<?php echo $cart ; ?>" class="button"><?php _e('View Cart', 'woocommerce'); ?></a>
								<a href="<?php echo $check_out; ?>" class="button checkout"><?php _e('Checkout', 'woocommerce'); ?></a>
							</p>

					<?php endif; ?>
						</ul><!-- end product list -->
					</div>	
						
					</div>	
					</div>
				</div>	
				<?php endif; ?>	
				<?php if ( is_user_logged_in() ) {?> 				
				<ul>
				
				<?php 
				if ( has_nav_menu( 'top_menu' ) ) {
					wp_nav_menu( array('theme_location' => 'top_menu', 'container' => 'false', 'menu_class' => 'top-nav', 'echo' => true, 'items_wrap' => '%3$s' )); 
				}
				?>
				</ul>
				<?php } else {?>
				<ul>
					<li><a href="<?php echo home_url() ?>/my-account/"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_login_register']); } else {  _e('Login / Register','wp-emporium'); } ?></a></li>
				</ul>				
				<?php } ?>
			</div>
		<?php
	}


	if (function_exists( 'is_woocommerce' ) ) : 

	/*== WOO CUSTOMIZATION ==*/
	

	function unregister_problem_widgets() {
	unregister_widget('WooCommerce_Widget_Top_Rated_Products');
	unregister_widget('WooCommerce_widget_recent_products');	
	unregister_widget('WooCommerce_Widget_Random_Products');		
	unregister_widget('WooCommerce_widget_featured_products');	
	unregister_widget('WooCommerce_widget_best_sellers');		
	unregister_widget('WooCommerce_Widget_Recently_Viewed');		
	unregister_widget('WooCommerce_widget_recent_reviews');
	unregister_widget('WooCommerce_Widget_On_Sale');	
	unregister_widget('WooCommerce_widget_price_filter');	
	
	}
	add_action('widgets_init','unregister_problem_widgets');
	
	if(isset($data['product_cat_page']) && $data['product_cat_page'] != 'Select a number:'){

	add_filter('loop_shop_per_page', create_function('$cols', 'return '.$data['product_cat_page'].';'));
	
	}

	add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');

    function get_image_pmc( $width, $height ,$id) {
        global $woocommerce;
 
        $image = '';
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full', false);
			$image = $image[0];
			}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png' ; 
 	//	$image = '<img src="'. get_template_directory_uri() .'/js/timthumb.php?src='. $image .'&amp;h='.$height.'&amp;w='.$width.'" >';

		$image = '<img src="'. get_template_directory_uri() .'/createthumb.php?path='.$image.'&amp;height='.$height.'&amp;width='.$width.'" >';
//src="createthumb.php?width=80&height=80&path=images/imagefilename.jpg"  
        return $image ;
     }	
	 
	function custom_woocommerce_get_catalog_ordering_args( $args ) {
		if (isset($_SESSION['orderby'])) {
			switch ($_SESSION['orderby']) :
				case 'date_asc' :
					$args['orderby'] = 'date';
					$args['order'] = 'asc';
					$args['meta_key'] = '';
				break;
				case 'price_desc' :
					$args['orderby'] = 'meta_value_num';
					$args['order'] = 'desc';
					$args['meta_key'] = '_price';
				break;
				case 'title_desc' :
					$args['orderby'] = 'title';
					$args['order'] = 'desc';
					$args['meta_key'] = '';
				break;
				case 'date_desc' :
					$args['orderby'] = 'date';
					$args['order'] = 'desc';
					$args['meta_key'] = '';
				break;
				case 'price_asc' :
					$args['orderby'] = 'meta_value_num';
					$args['order'] = 'asc';
					$args['meta_key'] = '_price';
				break;
				case 'title_asc' :
					$args['orderby'] = 'title';
					$args['order'] = 'asc';
					$args['meta_key'] = '';
				break;				
			endswitch;
		}
		return $args;
	}

	add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

	function custom_woocommerce_catalog_orderby( $sortby ) {
		$sortby['title_asc'] = __('Alphabetically','woocommerce');	
		$sortby['title_desc'] = __('Reverse-Alphabetically','woocommerce');	
		$sortby['price_asc'] = __('Price (lowest to highest)','woocommerce');		
		$sortby['price_desc'] = __('Price (highest to lowest)','woocommerce');	
		$sortby['date_desc'] = __('Newest to oldest','woocommerce');		
		$sortby['date_asc'] = __('Oldest to newest','woocommerce');
		return $sortby;
	}	

	
	// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<a class="cart-bubble cart-contents">(<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>)</a>
		<?php

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
	
	
	
	define('WOOCOMMERCE_USE_CSS', false);
	
	add_action('woocommerce_before_main_content', create_function('', 'echo "";'), 10);
	add_action('woocommerce_after_main_content', create_function('', 'echo "";'), 10);
	
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
	
	// change add to cart location
	
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 10);
	
	// remove ordering
	
	remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
	
	// excerpt on top
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5);
	
	// remove categories
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	
	// remove title from single
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	
	// remove default related
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	
	//remove add to cart
	
	update_option( 'woocommerce_enable_ajax_add_to_cart' , 'no' );
	
endif;	



function fl_shortcode_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "fl_add_shortcode_tinymce_plugin");
		add_filter('mce_buttons', 'fl_register_shortcode_button');
	}
}

 
 if ( ! isset( $content_width ) ) $content_width = 960;
/**
 * Register the TinyMCE Shortcode Button
 */
function fl_register_shortcode_button($buttons) {
	array_push($buttons, "|", "flshortcodes");
	return $buttons;
}

/**
 * Load the TinyMCE plugin: shortcode_plugin.js
 */
function fl_add_shortcode_tinymce_plugin($plugin_array) {
   $plugin_array['flshortcodes'] = get_template_directory_uri() . '/js/shortcode_plugin.js';
   return $plugin_array;
}
 
 function pmc_formatter($content) {

    $new_content = wptexturize(wpautop($content));

 
    return $new_content;
}
 
add_filter('the_content', 'pmc_formatter', 99);

function shortcontent($start, $end, $new, $source, $lenght){
$text = strip_tags(preg_replace('/<h(.*)>(.*)<\/h(.*)>.*/iU', '', $source), '<b><strong>');
$text = preg_replace('#\[video\](.*)\[\/video\]#si', '', $text);
$text = preg_replace('#\[pmc_link\](.*)\[\/pmc_link\]#si', '', $text);
$text = preg_replace('/\[[^\]]*\]/', $new, $text); 
return substr(preg_replace('/\s[\s]+/','',$text),0,$lenght).'</strong>';

}

function fl_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

function the_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
		echo home_url();
		echo '">';
		bloginfo('name');
		echo "</a> » ";
		if (is_single()) {
			if (is_single()) {
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}
		elseif(get_query_var('portfoliocategory')){
			$cat = get_query_var('portfoliocategory');
			$cat = str_replace('-',' ',$cat);
			echo $cat;
		}	
		else if(get_query_var('tag')){
			$tag = get_query_var('tag');
			$tag = str_replace('-',' ',$tag);
			echo $tag;
		}
		else if(get_query_var('s')){
			$search = get_query_var('s');
			echo $search;				
		} else {
			$cat = get_query_var('cat');
			$cat = get_category($cat);
			echo $cat->name;
		}
	}
}

function social($url) {
	$social = '';
	global $data; 
	$social .= '<div id="social">';
	if($data['facebook_show'] == 1)
	$social .= '<div class="fb-like" data-href="'.$url.'" data-send="false" data-width="80" data-layout="button_count" data-show-faces="false"></div>';            
	if($data['twitter_show'] == 1)
	$social .= '<div id="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="'.$name.'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>';
	if($data['google_show'] == 1) 
	$social .= '<div class="g-plusone" data-size="medium"></div>';
	$social .=	'</div>';
	
	echo $social;
}




function footer(){
	function pmc_recent_footer_excerpt_length( $length ) {
		return 40;
	}
	
	function pmc_recent_footer_title($title) { return  substr($title, 0, 40). '';}
		
	add_filter( 'excerpt_length', 'pmc_recent_footer_excerpt_length', 999 );
	add_filter('the_title', 'pmc_recent_footer_title') ;
}

function shortTitle($lenght)
{
	$title = the_title('','',FALSE); 
	echo substr($title, 0, $lenght);
}
function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');



function socialLinkProduct() {
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<a class="addthis_button_facebook" title="'.translation('translation_facebook', 'Facebook').'"><img src="'. get_template_directory_uri() .'/images/icon-facebook-product-single.png" width="16" height="16" border="0" alt="'.translation('translation_facebook', 'Facebook').'" /></a>';            
	if($data['twitter_show'] == 1)
	$social .= '<a class="addthis_button_twitter" title="'.translation('translation_twitter', 'Twitter').'"><img src="'. get_template_directory_uri() .'/images/icon-twitter-product-single.png" width="16" height="16" border="0" alt="'.translation('translation_twitter', 'Twitter').'" /></a>';  
	$social .='<a class="addthis_button_more"><img src="'. get_template_directory_uri() .'/images/icon-more-product-single.png" width="16" height="16" border="0" alt="More..." /></a></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	if($data['email_show'] == 1) 
	$social .= '<a class="emaillink" href="mailto:'.$data['email'].'" title="'.translation('translation_email', 'Send us Email').'"></a></div>'; 
	echo $social;
}

function socialLinkTop() {
	$social = '';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<a target="_blank" class="facebooklink top" href="'.$data['facebook'].'" title="'.translation('translation_facebook', 'Facebook').'"></a>'; 
	if($data['youtube_show'] == 1)
	$social .= '<a target="_blank" class="dribble top" href="'.$data['youtube'].'" title="'.translation('translation_dribble', 'Dribble').'"></a>';  
	if($data['twitter_show'] == 1)
	$social .= '<a target="_blank" class="twitterlink top" href="'.$data['twitter'].'" title="'.translation('translation_twitter', 'Twitter').'"></a>'; 
	if($data['email_show'] == 1) 
	$social .= '<a target="_blank" class="emaillink top" href="mailto:'.$data['email'].'" title="'.translation('translation_email', 'Send us Email').'"></a>';  	
	if($data['digg_show'] == 1) 
	$social .= '<a target="_blank" class="vimeo top" href="'.$data['digg'].'" title="'.translation('translation_vimeo', 'Vimeo').'"></a>';
	

	echo $social;
}

function socialLinkTeam($facebook,$twitter,$vimeo,$dribble,$email) {
	$social = '';
	global $data; 
	if($facebook != '')
	$social .= '<a target="_blank" class="facebooklink" href="'.$facebook.'" title="'.translation('translation_facebook', 'Facebook').'"></a>';            
	if($twitter != '')
	$social .= '<a target="_blank" class="twitterlink" href="'.$twitter.'" title="'.translation('translation_twitter', 'Twitter').'"></a>';  
	if($vimeo != '') 
	$social .= '<a target="_blank" class="vimeo" href="'.$vimeo.'" title="'.translation('translation_vimeo', 'Vimeo').'"></a>';  
	if($dribble != '')
	$social .= '<a target="_blank" class="dribble" href="'.$dribble.'" title="'.translation('translation_dribble', 'Dribble').'"></a>';  
	if($email != '') 
	$social .= '<a target="_blank" class="emaillink" href="mailto:'.$email.'" title="'.translation('translation_email', 'Send us Email').'"></a>';  	
	echo $social;
}


function socialLinkCat($link,$title,$email) {
	global $data,$sitepress;; 
	$social = '';
	$social .='<a class="addthis_button" addthis:url="'.$link.'" addthis:title="'.$title.'" ><img src="'. get_template_directory_uri() .'/images/socialIconShareMore.png" width="64" height="64" border="0" alt="More..." />';
	$social .= translation('translation_share_category', 'Share'); 
	$social .='</a><script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-507800a118eab6fa"></script>';	

	echo $social;
}


function socialLinkSingle() {
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	global $data; 
	if($data['facebook_show'] == 1)
	$social .= '<a class="addthis_button_facebook" title="'.translation('translation_facebook', 'Facebook').'"><img src="'. get_template_directory_uri() .'/images/facebookPortfolioIcon.png" width="64" height="64" border="0" alt="'.translation('translation_facebook', 'Facebook').'" /></a>';            
	if($data['twitter_show'] == 1)
	$social .= '<a class="addthis_button_twitter" title="'.translation('translation_twitter', 'Twitter').'"><img src="'. get_template_directory_uri() .'/images/twitterPortfolioIcon.png" width="64" height="64" border="0" alt="'.translation('translation_twitter', 'Twitter').'" /></a>';  
	if($data['digg_show'] == 1) 
	$social .= '<a class="addthis_button_digg" title="'.translation('translation_vimeo', 'Vimeo').'"><img src="'. get_template_directory_uri() .'/images/diggPortfolioIcon.png" width="64" height="64" border="0" alt="'.translation('translation_vimeo', 'Vimeo').'" /></a>';  
	$social .='<a class="addthis_button_more"><img src="'. get_template_directory_uri() .'/images/addPortfolioIcon.png" width="64" height="64" border="0" alt="More..." /></a></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	if($data['email_show'] == 1) 
	$social .= '<a class="emaillink" href="mailto:'.$data['email'].'" title="'.translation('translation_email', 'Send us Email').'"><img src="'. get_template_directory_uri() .'/images/emailPortfolioIcon.png" width="24" height="24" border="0" alt="More..." /></a></div>'; 
	echo $social;
}

function translation($theme_name, $translation_name){
	global $data, $sitepress;
	if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { 
		if(isset($data[$theme_name]))
			$string = stripText($data[$theme_name]); 
		else
			$string = '';
		} 
	else {  
		$string = __($translation_name,'wp-emporium'); 				
	} 
	return $string;

}

function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}
/**
 * Init process for button control
 */
add_filter( 'tiny_mce_version', 'fl_refresh_mce');
add_action( 'init', 'fl_shortcode_button' );


add_filter('the_content', 'addlightboxrel_replace');

function addlightboxrel_replace ($content)
{	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox[%LIGHTID%]"$6>';
    $content = preg_replace($pattern, $replacement, $content);
	if(isset($post->ID))
		$content = str_replace("%LIGHTID%", $post->ID, $content);
    return $content;
}


function filter_content_video( $content ){
	$content = explode('[video]', $content );
	$content = explode('[/video]',$content[1] );					
	$content = $content[0];
	return $content;
}

function filter_content( $content ){
	$content = explode('[video]', $content );
	$contentpost = $content[0] . '';
	$content = explode('[/video]',$content[1] );	
	$contentpost .= $content[1]; 
	return $contentpost;
}

function filter_link( $content ){
	$content = explode('[pmc_link]', $content );
	$content = explode('[/pmc_link]',$content[1] );	
	$content = $content[0];
	return $content;
}

function filter_content_link( $content ){
	$content = explode('[pmc_link]', $content );
	$contentcat = $content[0];
	$content = explode('[/pmc_link]',$content[1] );	
	$contentcat .= $content[1];	
	return $contentcat;
}

function filter_content_gallery( $content ){
	$content = explode('[gallery]', $content );	
	$contentgal = $content[0];	
	return $contentgal;
}


// Adds <span></span> around the first word of Widget titles
function arixWP_widget_title($title) {
$title = preg_replace('/(^[A-z0-9_]+)\s/i', '<span>$1</span> ', $title);
return $title;
}
add_filter('widget_title', 'arixWP_widget_title');

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}
add_filter('dynamic_sidebar_params','widget_first_last_classes');

function stripText($string) 
{ 
    return str_replace("\\",'',$string);
} 



/*portfolio loop*/

function portfolio($height, $width, $item, $post = 'port' ,$number = 0,$cat = ''){
	global $data; 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$categport = '';


	if($post == 'post'){
		$postT = 'post';
		$showposts = $data['sortingpost_number'];
		$postC = 'category';	
		$categport="";		
		}
	else{
		$postT = 'portfolioentry';
		$postC = 'portfoliocategory';
		$showposts = $data['port_number'];
		if($cat != '')
			$categport='&portfoliocategory='.$cat;
		}
		
	if($number != 0)
		$showposts = $number;
		
	$postPage = '&posts_per_page='.$showposts;		
		
	if($item == 3){
		$titleChar = 999;
	}
	else if($item == 2){
		$titleChar = 25;
	}	
	else {
		$titleChar = 25;
	}


	if($categport != "")
		$pmc = new WP_Query(array('orderby=date', 'post_type' =>  $postT, 'paged' => $paged, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $showposts ,'portfoliocategory' => $cat )); 
	else
		$pmc = new WP_Query(array('orderby=date', 'post_type' =>  $postT, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $showposts , 'paged' => $paged,'suppress_filters' => false)); 
		

	$limit_text = 100;
	$currentindex = '';
	$counter = 0;
	$portfolio = '';
	$count = 0;
	while ( $pmc->have_posts() ) : $pmc->the_post();
		$do_not_duplicate = $post['ID']; 
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', false);
		$entrycategory = get_the_term_list( $post['ID'], $postC, '', '_', '' );
		$catstring = $entrycategory;
		$catstring = strip_tags($catstring);
		$catstring = str_replace('_', ', ', $catstring);
		$categoryname = $catstring;							
		$entrycategory = strip_tags($entrycategory);
		$entrycategory = str_replace(' ', '-', $entrycategory);
		$entrycategory = str_replace('_', ' ', $entrycategory);
		$title = the_title('','',FALSE);
		$catidlist = explode(" ", $entrycategory);
		for($i = 0; $i < sizeof($catidlist); ++$i){
			$catidlist[$i].=$currentindex;
		}
		$catlist = implode(" ", $catidlist);

		$counter++;
		$category = get_the_term_list( $post['ID'], $postC, '', ', ', '' );	
		if ( has_post_format( 'link' , $post['ID'])) 
			$linkPost = filter_link(get_the_content());
		else
			if (function_exists('icl_object_id')) 
				$linkPost = get_permalink(icl_object_id($post->ID, 'portfolioentry', true, true));
			else 
				$linkPost = get_permalink();
				
		
		if($item != 2){

		$portfolio .= '<div class="item'.$item.' '.$catlist .'" data-category="'. $catlist.'">';
			if($item != 3) {
				$portfolio .= '
				<a href="'. $linkPost .'">	
				<div class="overdefult">
					<div class = "overLowerDefaultBorder"></div><div class="overLowerDefault"></div>
					<div class="overLowerDefault"></div>
				</div>
			</a>
			<div class="image">
				<div class="loading"></div>
				<img src="'. get_template_directory_uri() .'/createthumb.php?path='. $full_image[0] .'&amp;height='.$height.'&amp;width='.$width.'" alt="'. the_title('','',FALSE) .'">
			</div>';}
			if($item == 3) {
			
			$portfolio .= '
				<div class="recentimage">
					<a class="overdefultlink" href="'. $linkPost .'">
					<div class="overdefult">
					</div>
					</a>
					<div class="image">
						<div class="loading"></div>
						<img src="'. get_template_directory_uri() .'/createthumb.php?path='. $full_image[0] .'&amp;height='.$height.'&amp;width='.$width.'" alt="'. the_title('','',FALSE) .'">
					</div>
				</div>';
			}
			
		
			if($item != 3) 
				$portfolio .= '<h4><a href="'. $linkPost .'">'. substr(the_title('','',FALSE),0,$titleChar)  .'</a></h4>';
			if($item == 3) {
				$portfolio .= '<div class="recentdescription">
					<h3><a class="overdefultlink" href="'. $linkPost .'">'.  substr($title, 0, 99)  .'</a></h3>
					
					<div class="descriptionHomePort">
						<div class="borderLine"><div class="borderLineLeft"></div><div class="borderLineRight"></div></div>
						<div>'. shortcontent("[", "]", "", get_the_content() ,140) .'</strong></div>
					</div>
				</div>';
			}
			

		$portfolio .= '</div>';
		
		} else {
		$category = get_the_term_list( $post['ID'], $postC, '', '', '' );	
		if($count != 2){
			$portfolio .= '<div class="one_half item2 '.$catlist .'" data-category="'. $catlist.'" >';
		}
		else{
			$portfolio .= '<div class="one_half last item2 '.$catlist .'" data-category="'. $catlist.'" >';
			$count = 0;
		}

			$portfolio .= '	<div class="recentimage">
					<a href="'. $linkPost .'">
					<div class="overdefult">
						<div class = "overLowerDefaultBorder"></div><div class="overLowerDefault"></div>
					</div>
					</a>
				
					<div class="image">
						<div class="loading"></div>
						<img src="'. get_template_directory_uri() .'/createthumb.php?path='. $full_image[0] .'&amp;height=150&amp;width=230" alt="'. the_title('','',FALSE) .'">
					</div>
				</div>
				<div class="recentdescription">
					<h3><a class="overdefultlink" href="'.$linkPost.'">'. substr(the_title('','',FALSE),0,99999) .'</a></h3>
					<h3 class="category">'. $category .'</h3>	
					<div class="description">'. shortcontent("[", "]", "", get_the_content() ,140) .'...</strong></div>
				</div>
			</div>';

		$count++;
		
		}

		

	endwhile; 	

	echo $portfolio;
}

add_action('init', 'create_portfolio');

function create_portfolio() {
	$portfolio_args = array(
		'label' => 'Portfolio',
		'singular_label' => 'Portfolio',
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt')
	);
	register_post_type('portfolioentry',$portfolio_args);
}
add_action("admin_init", "add_portfolio");
add_action('save_post', 'update_portfolio_data');

function add_portfolio(){
	add_meta_box("portfolio_details", "Portfolio Entry Options", "portfolio_options", "portfolioentry", "normal", "high");
}

function update_portfolio_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["author"]) ) {
			update_post_meta($post->ID, "author", $_POST["author"]);
		}
		if( isset($_POST["date"]) ) {
			update_post_meta($post->ID, "date", $_POST["date"]);
		}
		if( isset($_POST["detail_active"]) ) {
			update_post_meta($post->ID, "detail_active", $_POST["detail_active"]);
		}else{
			update_post_meta($post->ID, "detail_active", 0);
		}
		if( isset($_POST["website_url"]) ) {
			update_post_meta($post->ID, "website_url", $_POST["website_url"]);
		}
		if( isset($_POST["status"]) ) {
			update_post_meta($post->ID, "status", $_POST["status"]);
		}		
		if( isset($_POST["customer"]) ) {
			update_post_meta($post->ID, "customer", $_POST["customer"]);
		}			

	}
}

function portfolio_options(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["author"][0])){
		$author = $data["author"][0];
	}else{
		$author = "";
	}
	if (isset($data["date"][0])){
		$date = $data["date"][0];
	}else{
		$date = "";
	}
	if (isset($data["status"][0])){
		$status = $data["status"][0];
	}else{
		$status = "";
	}	
	if (isset($data["detail_active"][0])){
		$detail_active = $data["detail_active"][0];
	}else{
		$detail_active = 0;
		$data["detail_active"][0] = 0;
	}
	if (isset($data["website_url"][0])){
		$website_url = $data["website_url"][0];
	}else{
		$website_url = "";
	}
	
	if (isset($data["customer"][0])){
		$customer = $data["customer"][0];
	}else{
		$customer = "";
	}	 ?>
    <div id="portfolio-options">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Overview Options:</strong></td>
            </tr>
            <tr>
                <td><label>Link to Detail Page: <i style="color: #999999;">(Do you want a project detail page?)</i></label></td><td><input type="checkbox" name="detail_active" value="1" <?php if( isset($detail_active)){ checked( '1', $data["detail_active"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Project Link: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="website_url" style="width:500px" value="<?php echo $website_url; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project Author: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="author" style="width:500px" value="<?php echo $author; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project date: <i style="color: #999999;">(Date of project)</i></label></td><td><input name="date" style="width:500px" value="<?php echo $date; ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Customer: <i style="color: #999999;">(Customer of project)</i></label></td><td><input name="customer" style="width:500px" value="<?php echo $customer; ?>" /></td>
            </tr>				
            <tr>
            	<td><label>Project status: <i style="color: #999999;">(Status of project)</i></label></td><td><input name="status" style="width:500px" value="<?php echo $status; ?>" /></td>
            </tr>				
        </table>
    </div>
      
<?php
}	
	
function add_portfolio_category(){
	add_meta_box("portfolio_categories", "Portfolio categories(only for portfolio templates)", "portfolio_category_options", "page", "normal", "high");
}	

add_action('save_post', 'update_portfolio_category_data');
add_action("admin_init", "add_portfolio_category");

function portfolio_category_options(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["port_category"][0])){
		$port_category = $data["port_category"][0];
	}else{
		$port_category = "";
	}

?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio category(only for portfolio templates):</strong></td>
            </tr>
            <tr>
            	<td><label>Category: <i style="color: #999999;">(select category)</i></label></td><td>
				<?php wp_dropdown_categories('show_option_all=Show all&hierarchical=2&name=port_category&taxonomy=portfoliocategory&selected='.$port_category.''); ?>
				</td>
            </tr>
			
        </table>
    </div>
      
<?php
}
function update_portfolio_category_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["port_category"]) ) {
			update_post_meta($post->ID, "port_category", $_POST["port_category"]);
		}			

	}
}


register_taxonomy("portfoliocategory", array("portfolioentry"), array("hierarchical" => true, "label" => "Portfolio Categories", "singular_label" => "Portfolio Category", "rewrite" => true));

function getcatslug($catID){
		$cat_obj = get_term($catID, 'portfoliocategory');
		$cat_slug = '';
		$cat_slug = $cat_obj->slug;
		return $cat_slug;
	}

function add_slider_category(){
	add_meta_box("slider_categories", "Post type", "slider_category_options_post", "post", "normal", "high");
	
}	


add_action('save_post', 'update_slider_category_data');
add_action("admin_init", "add_slider_category");

function slider_category_options(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["slider_category"][0])){
		$slider_category = $data["slider_category"][0];
	}else{
		$slider_category = "";
	}

?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">		
		
        	<tr>
                <td colspan="2"><strong>Select slider:</strong></td>
            </tr>
			
            <tr>
            	<td><label>Slider: <i style="color: #999999;">(select slider for this page/post)</i></label></td><td>
				<?php wp_dropdown_categories('show_option_all=None&hierarchical=2&name=slider_category&taxonomy=sliderocategory&selected='.$slider_category.''); ?>
				</td>
            </tr>
        </table>
    </div>
      
<?php
}

function slider_category_options_post(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["slider_category"][0])){
		$slider_category = $data["slider_category"][0];
	}else{
		$slider_category = "";
	}
	if (isset($data["video_post_url"][0])){
		$video_post_url = $data["video_post_url"][0];
	}else{
		$video_post_url = "";
	}	
	if (isset($data["video_active_post"][0])){
		$video_active_post = $data["video_active_post"][0];
	}else{
		$video_active_post = 0;
		$data["video_active_post"][0] = 0;
	}	
	
	if (isset($data["link_post_url"][0])){
		$link_post_url = $data["link_post_url"][0];
	}else{
		$link_post_url = "";
	}	
	if (isset($data["selectv"][0])){
		$selectv = $data["selectv"][0];
	}else{
		$selectv = "";
	}	
	
	

?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
	
            <tr class="videoonly">
            	<td><label>Video URL(*required): <i style="color: #999999;">
				<br>Link should look for Youtube: http://www.youtube.com/watch?v=WhBoR_tgXCI - So ID is WhBoR_tgXCI
				<br>Link should look for Vimeo: http://vimeo.com/29017795 so ID is 29017795 <br></i></label><br><input name="video_post_url" style="width:500px" value="<?php echo $video_post_url; ?>" /></td>
            </tr>	
            <tr class="select_video">
            	<td><label>Select video: <i style="color: #999999;">
				<select name="selectv">
				<?php if ($selectv == 'vimeo') {?>
				  <option value="vimeo" selected>Vimeo</option>
				 <?php } else {?>
				  <option value="vimeo">Vimeo</option>						
				 <?php }?>	
				<?php if ($selectv == 'youtube') {?>				 
				  <option value="youtube" selected>YouTube</option>
				 <?php } else {?>
				  <option value="youtube">YouTube</option>						
				 <?php }?>					  
				</select>
				
            </tr>			
            <tr class="linkonly">
            	<td><label>Link URL: <i style="color: #999999;"></i></label><br></td><td><input name="link_post_url" style="width:500px" value="<?php echo $link_post_url; ?>" /></td>
            </tr>				

			
        </table>
		<script>
		jQuery(document).ready(function(){	
				if (jQuery("input[name=post_format]:checked").val() == 'video'){
					jQuery('.videoonly , .select_video').show();
					jQuery('.linkonly').hide();}
				else if (jQuery("input[name=post_format]:checked").val() == 'link'){
					jQuery('.linkonly').show();
					jQuery('.videoonly, .select_video').hide();	}				
				else{
					jQuery('.videoonly').hide();
					jQuery('.linkonly, .select_video').hide();}
			jQuery("input[name=post_format]").change(function(){
				if (jQuery("input[name=post_format]:checked").val() == 'video'){
					jQuery('.videoonly, .select_video').show();
					jQuery('.linkonly').hide();}
				else if (jQuery("input[name=post_format]:checked").val() == 'link'){
					jQuery('.linkonly').show();
					jQuery('.videoonly, .select_video').hide();	}				
				else{
					jQuery('.videoonly, .select_video').hide();
					jQuery('.linkonly').hide();}
			});
		});
		</script>
    </div>
	
      
<?php


	
}


function update_slider_category_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["slider_category"]) ) {
			update_post_meta($post->ID, "slider_category", $_POST["slider_category"]);
		}	
		if( isset($_POST["video_post_url"]) ) {
			update_post_meta($post->ID, "video_post_url", $_POST["video_post_url"]);
		}	
		if( isset($_POST["video_active_post"]) ) {
			update_post_meta($post->ID, "video_active_post", $_POST["video_active_post"]);
		}else{
			update_post_meta($post->ID, "video_active_post", 0);
		}		
		if( isset($_POST["link_post_url"]) ) {
			update_post_meta($post->ID, "link_post_url", $_POST["link_post_url"]);
		}	
		if( isset($_POST["selectv"]) ) {
			update_post_meta($post->ID, "selectv", $_POST["selectv"]);
		}			
	}
	
	
	
}

if (function_exists( 'is_woocommerce' ) ) {

function add_product_video(){
	add_meta_box("product_video", "Video product", "video_product_options_post", "product", "normal", "high");
}	

add_action("admin_init", "add_product_video");
add_action('save_post', 'update_product_video_data');

function update_product_video_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["video_post_url"]) ) {
			update_post_meta($post->ID, "video_post_url", $_POST["video_post_url"]);
		}	
		if( isset($_POST["video_active_post"]) ) {
			update_post_meta($post->ID, "video_active_post", $_POST["video_active_post"]);
		}else{
			update_post_meta($post->ID, "video_active_post", 0);
		}		
		if( isset($_POST["selectv"]) ) {
			update_post_meta($post->ID, "selectv", $_POST["selectv"]);
		}	
		if( isset($_POST["video_active"]) ) {
			update_post_meta($post->ID, "video_active", $_POST["video_active"]);
		}else{
			update_post_meta($post->ID, "video_active", 0);
		}			
	}
	
	
	
}

function video_product_options_post(){
	global $post;
	$data = get_post_custom($post->ID);
	if (isset($data["video_post_url"][0])){
		$video_post_url = $data["video_post_url"][0];
	}else{
		$video_post_url = "";
	}	
	if (isset($data["video_active_post"][0])){
		$video_active_post = $data["video_active_post"][0];
	}else{
		$video_active_post = 0;
		$data["video_active_post"][0] = 0;
	}	
	
	
	if (isset($data["selectv"][0])){
		$selectv = $data["selectv"][0];
	}else{
		$selectv = "";
	}	
	if (isset($data["video_active"][0])){
		$video_active = $data["video_active"][0];
	}else{
		$video_active = 0;
		$data["video_active"][0] = 0;
	}
	

?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
            <tr>
                <td><label>Use video insted of image(you also need to add feautured image): </label></td><td><input type="checkbox" id="checkedbox" name="video_active" value="1" <?php if( isset($video_active)){ checked( '1', $data["video_active"][0] ); } ?> /></td>	
            </tr>	
            <tr class="videoonly">
            	<td><label>Video URL(*required): <i style="color: #999999;">
				<br>Link should look for Youtube: http://www.youtube.com/watch?v=WhBoR_tgXCI - So ID is WhBoR_tgXCI
				<br>Link should look for Vimeo: http://vimeo.com/29017795 so ID is 29017795 <br></i></label><br><input name="video_post_url" style="width:500px" value="<?php echo $video_post_url; ?>" /></td>
            </tr>	
            <tr class="select_video">
            	<td><label>Select video: <i style="color: #999999;">
				<select name="selectv">
				<?php if ($selectv == 'vimeo') {?>
				  <option value="vimeo" selected>Vimeo</option>
				 <?php } else {?>
				  <option value="vimeo">Vimeo</option>						
				 <?php }?>	
				<?php if ($selectv == 'youtube') {?>				 
				  <option value="youtube" selected>YouTube</option>
				 <?php } else {?>
				  <option value="youtube">YouTube</option>						
				 <?php }?>					  
				</select>
				
            </tr>			
			

			
        </table>
		<script>
		jQuery(document).ready(function(){	
				if (jQuery('input[name=video_active]').is(':checked')){
					jQuery('.videoonly , .select_video').show();}		
				else{
					jQuery('.videoonly, .select_video').hide();}
				jQuery("input[name=video_active]").change(function(){
				if (jQuery('input[name=video_active]').is(':checked')){
					jQuery('.videoonly , .select_video').show();}		
				else{
					jQuery('.videoonly, .select_video').hide();}
				});
		});
		
		</script>
    </div>
	
      
<?php
	
}
}



if( !function_exists( 'emporium_fallback_menu' ) )
{
	/**
	 * Create a navigation out of pages if the user didnt create a menu in the backend
	 *
	 */
	function emporium_fallback_menu()
	{
		$current = "";
		if (is_front_page()){$current = "class='current-menu-item'";} 
		
		
		echo "<div class='fallback_menu'>";
		echo "<ul class='emporium_fallback menu'>";
		echo "<li $current><a href='".get_bloginfo('url')."'>Home</a></li>";
		wp_list_pages('title_li=&sort_column=menu_order');
		echo "</ul></div>";
	}
}

function getVimeoThumb($id) {
    $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
    $data = json_decode($data);
    return $data[0]->thumbnail_small;
}
function wp_nav_menu_top( $args = array(),$catname) {
        static $menu_id_slugs = array();

        $defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
        'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth' => 0, 'walker' => '', 'theme_location' => '' );

        $args = wp_parse_args( $args, $defaults );
        $args = apply_filters( 'wp_nav_menu_args', $args );
        $args = (object) $args;

        // Get the nav menu based on the requested menu
        $menu = wp_get_nav_menu_object( $args->menu );

        // Get the nav menu based on the theme_location
        if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
        $menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

        // get the first menu that has items if we still can't find a menu
        if ( ! $menu && !$args->theme_location ) {
        $menus = wp_get_nav_menus();
        foreach ( $menus as $menu_maybe ) {
        if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
        $menu = $menu_maybe;
        break;
        }
        }
        }

        // If the menu exists, get its items.
        if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
        $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

        
        if ( ( !$menu || is_wp_error($menu) || ( isset($menu_items) && empty($menu_items) && !$args->theme_location ) )
        && $args->fallback_cb && is_callable( $args->fallback_cb ) )
        return call_user_func( $args->fallback_cb, (array) $args );

        if ( !$menu || is_wp_error( $menu ) || empty( $menu_items ) )
        return false;

        $nav_menu = $items = '';

        $show_container = false;
        if ( $args->container ) {
        $allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
        if ( in_array( $args->container, $allowed_tags ) ) {
        $show_container = true;
        $class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
        $id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
        $nav_menu .= '<'. $args->container . $id . $class . '>';
        }
        }

        // Set up the $menu_item variables
        _wp_menu_item_classes_by_context( $menu_items );
        $menu_array = array();
        $menu_sub_array = array();
        $i=0;
        $ii=0;
        foreach($menu_items as $row_menu)
        {
       if($row_menu->menu_item_parent==0)
        {
        $menu_array[$i]['title'] =$row_menu->title;
        $menu_array[$i]['id'] =$row_menu->ID;
        $menu_array[$i]['db_id'] =$row_menu->db_id;
        $menu_array[$i]['menu_item_parent'] =$row_menu->menu_item_parent;
        $menu_array[$i]['url'] =$row_menu->url;
        $i++;
        }
        else
        {
        $menu_sub_array[$ii]['title'] =$row_menu->title;
        $menu_sub_array[$ii]['id'] =$row_menu->ID;
        $menu_sub_array[$ii]['db_id'] =$row_menu->db_id;
        $menu_sub_array[$ii]['menu_item_parent'] =$row_menu->menu_item_parent;
        $menu_sub_array[$ii]['url'] =$row_menu->url;
        $ii++;
        }
        }
    
        foreach($menu_array as $l_menu)
        {
            
        $videodata = $l_menu['id'];
        $s_menu_arr1='';
        $s_menu_arr2='';
        $s_menu_arr3='';
        $k = 1;
        $menu_sub_ext = 0;
        if(    $catname==$l_menu['title']){
        $s_menu_arr1 .="<div class='sub-nav'>";    
            $s_menu_arr1 .="<div class='heading'>".$catname."</div>";
        foreach($menu_sub_array as $s_menu)
        {
            
        if($s_menu['menu_item_parent'] == $l_menu['db_id'])
        {
					$menu_sub_ext = 1;
					//print $s_menu['title'].$s_menu['id']."<br>";
									
					$s_menu_arr1 .='<div><a href="'.$s_menu['url'].'">'.$s_menu['title'].'</a></div>';
					foreach($menu_sub_array as $ss_menu)
					{
					if($ss_menu['menu_item_parent'] == $s_menu['db_id'])
					{
					//print $ss_menu['title'].$ss_menu['id']."<br>";
					$s_menu_arr1 .='<div><a href="'.$ss_menu['url'].'">'.$ss_menu['title'].'</a></div>';
					}
        }
        
    }
}

        $s_menu_arr1 .="<div style='clear: both;'></div></div>";
        
        } 

        echo $s_menu_arr1;


        }	
}

//added by CLW April 25, 2013
//adds Responsive NAV  files
function responsive_files_add() {  
	//wp_register_script( 'responsive-nav', get_template_directory_uri() . '/js/responsive-nav/responsive-nav.js' );  
	//wp_enqueue_script( 'responsive-nav' );
	//wp_register_style( 'responsive-nav-style', get_template_directory_uri() . '/js/responsive-nav/responsive-nav.css', array(), '20120208', 'all' );
  //wp_enqueue_style( 'responsive-nav-style' );
}  
add_action( 'wp_enqueue_scripts', 'responsive_files_add' ); 

//added by CLW May 9, 2013
//allows custom thumbnail sizes
add_image_size( 'footer_thumb', 100, 75, TRUE );
add_image_size('feature_product', 300, 225, TRUE);
add_image_size('carousel_thumb', 82, 82, TRUE);
add_image_size('product_full', 404, 345, TRUE);
add_image_size('blog', 580, 280, TRUE);
add_image_size('blog_thumb', 146, 83, TRUE);

//allows medium images to be cropped instead of resized
if(false === get_option("footer_thumb_crop")) {
    add_option("footer_thumb_crop", "1");
} else {
    update_option("footer_thumb_crop", "1");
}
if(false === get_option("feature_product_crop")) {
    add_option("feature_product_crop", "1");
} else {
    update_option("feature_product_crop", "1");
}
if(false === get_option("carousel_thumb_crop")) {
    add_option("carousel_thumb_crop", "1");
} else {
    update_option("carousel_thumb_crop", "1");
}
if(false === get_option("product_full_crop")) {
    add_option("product_full_crop", "1");
} else {
    update_option("product_full_crop", "1");
}
if(false === get_option("blog_crop")) {
    add_option("blog_crop", "1");
} else {
    update_option("blog_crop", "1");
}
if(false === get_option("blog_thumb_crop")) {
    add_option("blog_thumb_crop", "1");
} else {
    update_option("blog_thumb_crop", "1");
}


//-------------------
function of_option_setup()	{


		
	if (!get_option('of_options')){
	
		$data = 'YToxNDg6e3M6MTM6InNob3dhZHZlcnRpc2UiO3M6MToiMSI7czoxNToiaW5mb3RleHRfc3RhdHVzIjtzOjE6IjEiO3M6MTA6ImJveF9zdGF0dXMiO3M6MToiMSI7czoxODoiaG9tZV9yZWNlbnRfbnVtYmVyIjtzOjI6IjEyIjtzOjI2OiJob21lX3JlY2VudF9udW1iZXJfZGlzcGxheSI7czoxOiIzIjtzOjMxOiJob21lX3JlY2VudF9udW1iZXJfZGlzcGxheV9wb3N0IjtzOjE6IjMiO3M6MjM6ImhvbWVfcmVjZW50X251bWJlcl9wb3N0IjtzOjI6IjIwIjtzOjE2OiJob2VtcmVjZW50ZGVzaWduIjtzOjE6IjEiO3M6MTA6ImNhdHdvb3R5cGUiO3M6MToiMSI7czoxMToiYWRkX3RvX2NhcnQiO3M6MToiMSI7czoyMToicmFjZW50X3N0YXR1c19wcm9kdWN0IjtzOjE6IjEiO3M6Mjc6ImhvbWVfcmVjZW50X3Byb2R1Y3RzX251bWJlciI7czoyOiIxMiI7czozNDoiaG9tZV9yZWNlbnRfbnVtYmVyX2Rpc3BsYXlfcHJvZHVjdCI7czoxOiI2IjtzOjIyOiJyYWNlbnRfc3RhdHVzX3Byb2R1Y3RGIjtzOjE6IjEiO3M6Mjg6ImhvbWVfcmVjZW50X3Byb2R1Y3RzRl9udW1iZXIiO3M6MjoiMTIiO3M6MzU6ImhvbWVfcmVjZW50X251bWJlcl9kaXNwbGF5X2Zwcm9kdWN0IjtzOjE6IjMiO3M6MTY6InByb2R1Y3RfY2F0X3BhZ2UiO3M6MjoiMTIiO3M6MTY6InRyYW5zbGF0aW9uX2NhcnQiO3M6NDoiQ2FydCI7czoyNToidHJhbnNsYXRpb25fc2hhcmVfcHJvZHVjdCI7czoxODoiU2hhcmUgdGhpcyBwcm9kdWN0IjtzOjIxOiJ0cmFuc2xhdGlvbl9hbHNvX2xpa2UiO3M6MTk6IllvdSBtaWdodCBhbHNvIGxpa2UiO3M6MjY6InRyYW5zbGF0aW9uX2xvZ2luX3JlZ2lzdGVyIjtzOjE2OiJMb2dpbiAvIFJlZ2lzdGVyIjtzOjIwOiJ0cmFuc2xhdGlvbl9mZWF0dXJlZCI7czoyOToiRmVhdHVyZWQgUHJvZHVjdHMgaW4gRW1wb3JpdW0iO3M6MzI6InRyYW5zbGF0aW9uX3JlY2VudF9wcnVkdWN0X3RpdGxlIjtzOjI3OiJSZWNlbnQgQXJyaXZhbHMgaW4gRW1wb3JpdW0iO3M6ODoiaW5mb3RleHQiO3M6NTc6IldlbGNvbWUgdG8gPHNwYW4+RW1wb3JpdW08L3NwYW4+IC0gV2UgYXJlIGdsYWQgdG8gc2VlIHlvdSI7czoxOToicXVvdGVfYm90dG9tX2JvcmRlciI7czoxOiIxIjtzOjEwOiJib3gxX3RpdGxlIjtzOjI2OiJGYXN0IGFuZCBlZmZpY2llbnQgU3VwcG9ydCI7czoxMDoiYm94MV9pbWFnZSI7czo4MToiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzExL2ZlYXR1cmVkLWltYWdlLTUuanBnIjtzOjk6ImJveDFfbGluayI7czoyNDoiaHR0cDovL3ByZW1pdW1jb2RpbmcuY29tIjtzOjE2OiJib3gxX2Rlc2NyaXB0aW9uIjtzOjI3NjoiPHN0cm9uZz5Eb25lYyBwZWRlPC9zdHJvbmc+IGp1c3RvLCBmcmluZ2lsbGEgdmVsLCBhbHUsIA0KdnVscHV0IGVnZXQsIGFyY3UuIEluIGVuaW0ganVzdG8sIA0KdXQsIGltcGVyZGlldCBhLCB2ZW5lbmF0aXMgdml0YWUsIHRvLg0KcGVkZSA8c3Ryb25nPmp1c3RvPC9zdHJvbmc+LCBmcmluZ2lsbGEgdmVsLCBhbGlldC4gTG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsICA8c3Ryb25nPmNvbnNlY3RldHVlciBhZGlwaXNjaW5nIDwvc3Ryb25nPiBlbGl0LCBzZWQgZGlhbSBub251bW0uIjtzOjEwOiJib3gyX3RpdGxlIjtzOjI1OiJPbmxpbmUgc3RvcmUgLSBzaW1wbGlmaWVkIjtzOjEwOiJib3gyX2ltYWdlIjtzOjExNDoiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzExL3Bob3RvZHVuZS0xMzAyMzkyLXdvbWFuLW9wZW5pbmctYS1yZXRhaWwtc3RvcmUteHMuanBnIjtzOjk6ImJveDJfbGluayI7czoyNDoiaHR0cDovL3ByZW1pdW1jb2RpbmcuY29tIjtzOjE2OiJib3gyX2Rlc2NyaXB0aW9uIjtzOjI3NjoiPHN0cm9uZz5Eb25lYyBwZWRlPC9zdHJvbmc+IGp1c3RvLCBmcmluZ2lsbGEgdmVsLCBhbHUsIA0KdnVscHV0IGVnZXQsIGFyY3UuIEluIGVuaW0ganVzdG8sIA0KdXQsIGltcGVyZGlldCBhLCB2ZW5lbmF0aXMgdml0YWUsIHRvLg0KcGVkZSA8c3Ryb25nPmp1c3RvPC9zdHJvbmc+LCBmcmluZ2lsbGEgdmVsLCBhbGlldC4gTG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsICA8c3Ryb25nPmNvbnNlY3RldHVlciBhZGlwaXNjaW5nIDwvc3Ryb25nPiBlbGl0LCBzZWQgZGlhbSBub251bW0uIjtzOjEwOiJib3gzX3RpdGxlIjtzOjI4OiJDYXJuaXZhbCBNYXNrcyBEaXNjb3VudCBTYWxlIjtzOjEwOiJib3gzX2ltYWdlIjtzOjkwOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMTEvcGhvdG9kdW5lLTI0NjE2ODUtbWFzay14cy5qcGciO3M6OToiYm94M19saW5rIjtzOjI0OiJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20iO3M6MTY6ImJveDNfZGVzY3JpcHRpb24iO3M6Mjc2OiI8c3Ryb25nPkRvbmVjIHBlZGU8L3N0cm9uZz4ganVzdG8sIGZyaW5naWxsYSB2ZWwsIGFsdSwgDQp2dWxwdXQgZWdldCwgYXJjdS4gSW4gZW5pbSBqdXN0bywgDQp1dCwgaW1wZXJkaWV0IGEsIHZlbmVuYXRpcyB2aXRhZSwgdG8uDQpwZWRlIDxzdHJvbmc+anVzdG88L3N0cm9uZz4sIGZyaW5naWxsYSB2ZWwsIGFsaWV0LiBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgIDxzdHJvbmc+Y29uc2VjdGV0dWVyIGFkaXBpc2NpbmcgPC9zdHJvbmc+IGVsaXQsIHNlZCBkaWFtIG5vbnVtbS4iO3M6MTQ6ImFkdmVydGlzZWltYWdlIjthOjk6e2k6MTthOjQ6e3M6NToib3JkZXIiO3M6MToiMSI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDEiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjEucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6MjthOjQ6e3M6NToib3JkZXIiO3M6MToiMiI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDIiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjIucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6MzthOjQ6e3M6NToib3JkZXIiO3M6MToiMyI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDMiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjMucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6NDthOjQ6e3M6NToib3JkZXIiO3M6MToiNCI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDQiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjQucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6NTthOjQ6e3M6NToib3JkZXIiO3M6MToiNSI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDUiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjYucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6NjthOjQ6e3M6NToib3JkZXIiO3M6MToiNiI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDYiO3M6MzoidXJsIjtzOjczOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvcjkucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6NzthOjQ6e3M6NToib3JkZXIiO3M6MToiNyI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDciO3M6MzoidXJsIjtzOjc1OiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvci0xMC5wbmciO3M6NDoibGluayI7czoyNDoiaHR0cDovL3ByZW1pdW1jb2RpbmcuY29tIjt9aTo4O2E6NDp7czo1OiJvcmRlciI7czoxOiI4IjtzOjU6InRpdGxlIjtzOjk6IlNwb25zb3IgOCI7czozOiJ1cmwiO3M6NzQ6Imh0dHA6Ly9lbXBvcml1bS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8wOS9zcG9uc29yNTEucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6OTthOjQ6e3M6NToib3JkZXIiO3M6MToiOSI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDkiO3M6MzoidXJsIjtzOjc3OiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3BvbnNvckxvZ283LnBuZyI7czo0OiJsaW5rIjtzOjI0OiJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20iO319czo0OiJsb2dvIjtzOjc1OiJodHRwOi8vZGFlZHJhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzEwL2xvZ28tZGFlZHJhNC5wbmciO3M6NzoiZmF2aWNvbiI7czo3NzoiaHR0cDovL21lcmNvci5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8wOS9mYXZpY29uLW1lcmNvci5wbmciO3M6MTY6Imdvb2dsZV9hbmFseXRpY3MiO3M6MDoiIjtzOjk6Im1haW5Db2xvciI7czo3OiIjRUVDNDNEIjtzOjg6ImJveENvbG9yIjtzOjc6IiMzNDM0MzQiO3M6MTU6IlNoYWRvd0NvbG9yRm9udCI7czo3OiIjZmZmZmZmIjtzOjIzOiJTaGFkb3dPcGFjaXR0eUNvbG9yRm9udCI7czozOiIwLjIiO3M6MjE6ImJvZHlfYmFja2dyb3VuZF9jb2xvciI7czo3OiIjZmFmYWZhIjtzOjE2OiJiYWNrZ3JvdW5kX2ltYWdlIjtzOjE6IjEiO3M6NzoiYm9keV9iZyI7czo3OToiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdGhlbWVzL2VtcG9yaXVtL2ltYWdlcy9iZy9iZzE2LnBuZyI7czoxODoiYm9keV9iZ19wcm9wZXJ0aWVzIjtzOjEwOiJyZXBlYXQgMCAwIjtzOjIzOiJiYWNrZ3JvdW5kX2ltYWdlX2hlYWRlciI7czoxOiIxIjtzOjIzOiJoZWFkZXJfYmFja2dyb3VuZF9jb2xvciI7czo3OiIjMWUxZTIwIjtzOjk6ImhlYWRlcl9iZyI7czo4NjoiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdGhlbWVzL2VtcG9yaXVtL2ltYWdlcy9iZy1oZWFkZXIvYmcxMi5wbmciO3M6MjA6ImhlYWRlcl9iZ19wcm9wZXJ0aWVzIjtzOjEwOiJyZXBlYXQgMCAwIjtzOjEyOiJjdXN0b21fc3R5bGUiO3M6MDoiIjtzOjExOiJkZW1vX3NsaWRlciI7YTo0OntpOjE7YTo4OntzOjU6Im9yZGVyIjtzOjE6IjEiO3M6NToidGl0bGUiO3M6NToiTWFza3MiO3M6MzoidXJsIjtzOjc2OiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMTEvZW1wdHlIb2xkZXIucG5nIjtzOjU6InZpZGVvIjtzOjA6IiI7czozOiJ0b3AiO3M6MjoiMjUiO3M6NDoibGVmdCI7czoyOiI1NyI7czo0OiJsaW5rIjtzOjA6IiI7czoxMToiZGVzY3JpcHRpb24iO3M6MTc4NjoiPGRpdiBjbGFzcz1cImNhcHRpb25Cb3hcIiBzdHlsZT1cImhlaWdodDogMjM1cHg7IG1hcmdpbi1sZWZ0OjQwcHg7IHotaW5kZXg6MTI7XCI+DQo8aDEgY2xhc3M9XCJ1bmRlcmxpbmVcIiBzdHlsZT1cInBhZGRpbmc6IDE1cHggMjVweCAxNXB4IDBweDsgZm9udC1zaXplOiAyNnB4ICFpbXBvcnRhbnQ7XCI+Q0FSTklWQUwgTUFTS1M8L2gxPg0KPHVsIGNsYXNzPVwicXVvdGVcIiBzdHlsZT1cInBhZGRpbmctcmlnaHQ6IDIwcHg7XCI+DQoJPGxpIGNsYXNzPVwibGVmdFwiPllvdSBjYW4gYWRkIDxzdHJvbmc+dW5pcXVlIDwvc3Ryb25nPiBpbWFnZXM8L2xpPg0KCTxsaSBjbGFzcz1cInJpZ2h0XCI+dG8gZWFjaCBzbGlkZSBhbmQgbWFrZSB0aGVtIDxzcGFuIHN0eWxlPVwiZm9udC13ZWlnaHQ6IGJvbGQ7XCI+ZGlzdGluY3QuPC9zcGFuPjwvbGk+DQoJPGxpIGNsYXNzPVwibGVmdFwiPkdldCB0aGUgY29tcGxldGUgPHNwYW4gc3R5bGU9XCJmb250LXdlaWdodDogYm9sZDtcIj5mcmVlZG9tPC9zcGFuPiBvZiB5b3VyIGRlc2lnbi48L2xpPg0KCTxsaSBjbGFzcz1cInJpZ2h0XCI+QSBjcmVhdGl2ZSBhcHByb2FjaCB0byA8c3Ryb25nPndlYiBkZXNpZ24uPC9zdHJvbmc+PC9saT4NCjwvdWw+DQo8dWw+DQoJPGxpIGNsYXNzPVwiYnV0dG9uXCI+PGEgaHJlZj1cImh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbVwiPlJFQUQgTU9SRTwvYT48L2xpPg0KPC91bD4NCjwvZGl2Pg0KDQo8dWw+DQoNCg0KPGxpIGNsYXNzPVwidG9wMVwiPg0KPGEgaHJlZiA9XCJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vc2hvcC0yL2Etc2lsdmVyLWFuZC1ibGFjay1jYXJuaXZhbC1tYXNrL1wiPg0KPGltZyBzdHlsZSA9IFwibWFyZ2luOi0xMjBweCAwcHggMCAtNjAwcHg7XCIgc3JjPVwiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzExL2Nhcm5pdmFsLW1hc2stMTUucG5nDQpcIi8+PC9hPjwvbGk+DQoNCjxsaSBjbGFzcz1cInRvcDJcIj4NCjxhIGhyZWYgPVwiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3Nob3AtMi9hLXNpbHZlci1hbmQtYmxhY2stY2Fybml2YWwtbWFzay9cIj4NCjxpbWcgc3R5bGUgPSBcIm1hcmdpbjotMTI1cHggMHB4IDAgLTI4NXB4O1wiIHNyYz1cImh0dHA6Ly9lbXBvcml1bS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8xMS9jYXJuaXZhbC1tYXNrLTIzLnBuZw0KXCIvPjwvYT48L2xpPg0KDQo8bGkgY2xhc3M9XCJ0b3AzXCI+DQo8YSBocmVmID1cImh0dHA6Ly9lbXBvcml1bS5wcmVtaXVtY29kaW5nLmNvbS9zaG9wLTIvYS1zaWx2ZXItYW5kLWJsYWNrLWNhcm5pdmFsLW1hc2svXCI+DQo8aW1nIHN0eWxlID0gXCJtYXJnaW46MTIwcHggMHB4IDAgLTYwMHB4O1wiIHNyYz1cImh0dHA6Ly9lbXBvcml1bS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8xMS9jYXJuaXZhbC1tYXNrLTUucG5nDQpcIi8+PC9hPjwvbGk+DQoNCjxsaSBjbGFzcz1cInRvcDRcIj4NCjxhIGhyZWYgPVwiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3Nob3AtMi9hLXNpbHZlci1hbmQtYmxhY2stY2Fybml2YWwtbWFzay9cIj4NCjxpbWcgc3R5bGUgPSBcIm1hcmdpbjoxMTVweCAwcHggMCAtMjg1cHg7XCIgc3JjPVwiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzExL2Nhcm5pdmFsLW1hc2stNC5wbmcNClwiLz48L2E+PC9saT4NCg0KPC91bD4NCg0KICI7fWk6MjthOjg6e3M6NToib3JkZXIiO3M6MToiMiI7czo1OiJ0aXRsZSI7czo1OiJWaWRlbyI7czozOiJ1cmwiO3M6MDoiIjtzOjU6InZpZGVvIjtzOjM4OiJodHRwOi8vcGxheWVyLnZpbWVvLmNvbS92aWRlby8zNTg5OTE0OSI7czozOiJ0b3AiO3M6MToiNiI7czo0OiJsZWZ0IjtzOjQ6Ijc5LjEiO3M6NDoibGluayI7czowOiIiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjY3NzoiPGRpdiBjbGFzcz1cImNhcHRpb25Cb3hcIiBzdHlsZT1cImhlaWdodDogNDQwcHg7IHdpZHRoOjIwMHB4O1wiPg0KPGgxIGNsYXNzPVwidW5kZXJsaW5lXCIgc3R5bGU9XCJwYWRkaW5nOiAxNXB4IDI1cHggMTVweCAwcHg7IGZvbnQtc2l6ZTogMjZweCAhaW1wb3J0YW50O1wiPlZJREVPUzwvaDE+DQo8dWwgY2xhc3M9XCJxdW90ZVwiIHN0eWxlPVwicGFkZGluZy1yaWdodDogMjBweDtcIj4NCgk8bGkgY2xhc3M9XCJsZWZ0XCI+WW91IGNhbiBhZGQgdmlkZW9zDQoJYW5kIGFkZCBkZXNjcmlwdGlvbg0KCVRlbGwgeW91ciB2aXNpdG9ycy4NCgl3aGF0IGl0XCdzIGFib3V0Lg0KICAgICAgICBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgY29uc2VjdGV0dWVyIGFkaXBpc2NpbmcgZWxpdCwgc2VkIGRpYW0gbm9udW1teSBuaWJoIGV1aXNtb2QgdGluY2lkdW50IHV0IGxhb3JlZXQgZG9sb3JlIG1hZ25hIGFsaXF1YW0gZXJhdCB2b2x1dHBhdC4gIExvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZWN0ZXR1ZXIgYWRpcGlzY2luZyBlbGl0LiBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldDwvc3Ryb25nPjwvbGk+DQo8L3VsPg0KDQoJPGxpIGNsYXNzPVwiYnV0dG9uXCI+PGEgaHJlZj1cImh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbVwiPlJFQUQgTU9SRTwvYT48L2xpPg0KDQo8L2Rpdj4iO31pOjM7YTo4OntzOjU6Im9yZGVyIjtzOjE6IjMiO3M6NToidGl0bGUiO3M6NToiSXBhZHMiO3M6MzoidXJsIjtzOjc2OiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMTEvZW1wdHlIb2xkZXIucG5nIjtzOjU6InZpZGVvIjtzOjA6IiI7czozOiJ0b3AiO3M6MjoiMjQiO3M6NDoibGVmdCI7czoyOiI2MCI7czo0OiJsaW5rIjtzOjA6IiI7czoxMToiZGVzY3JpcHRpb24iO3M6MTQwMjoiPHVsPg0KPGxpIGNsYXNzPVwidG9wMlwiIHN0eWxlPVwiei1pbmRleDo5O1wiPg0KPGEgaHJlZiA9XCJodHRwOi8vZGFlZHJhLnByZW1pdW1jb2RpbmcuY29tXCI+DQo8aW1nIHN0eWxlID0gXCJtYXJnaW46MjBweCAwcHggMCAtNjg1cHg7XCIgc3JjPVwiaHR0cDovL2RhZWRyYS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8xMC9pcGhvbmUucG5nDQpcIi8+PC9hPjwvbGk+DQoNCg0KPGxpIGNsYXNzPVwidG9wMVwiIHN0eWxlPVwiei1pbmRleDo4O1wiPg0KPGEgaHJlZiA9XCJodHRwOi8vZGFlZHJhLnByZW1pdW1jb2RpbmcuY29tXCI+DQo8aW1nIHN0eWxlID0gXCJtYXJnaW46LTYzcHggMHB4IDAgLTYyMHB4O1wiIHNyYz1cImh0dHA6Ly9kYWVkcmEucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMTAvbGNkbW9uaXRvci5wbmcNClwiLz48L2E+PC9saT4NCg0KPGxpIGNsYXNzPVwidG9wM1wiIHN0eWxlPVwiei1pbmRleDoxMDtcIj4NCjxhIGhyZWYgPVwiaHR0cDovL2RhZWRyYS5wcmVtaXVtY29kaW5nLmNvbVwiPg0KPGltZyBzdHlsZSA9IFwibWFyZ2luOjEwNnB4IDBweCAwIC0zMzBweDtcIiBzcmM9XCJodHRwOi8vZGFlZHJhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzEwL2lwYWQucG5nDQpcIi8+PC9hPjwvbGk+DQoNCjwvdWw+DQoNCg0KDQoNCg0KPGRpdiBjbGFzcz1cImNhcHRpb25Cb3hcIiBzdHlsZT1cImhlaWdodDogMjM1cHg7XCI+DQo8aDEgY2xhc3M9XCJ1bmRlcmxpbmVcIiBzdHlsZT1cInBhZGRpbmc6IDE1cHggMjVweCAxNXB4IDBweDsgZm9udC1zaXplOiAyNnB4ICFpbXBvcnRhbnQ7XCI+VU5MSU1JVEVEIElNQUdFUzwvaDE+DQo8dWwgY2xhc3M9XCJxdW90ZVwiIHN0eWxlPVwicGFkZGluZy1yaWdodDogMjBweDtcIj4NCgk8bGkgY2xhc3M9XCJsZWZ0XCI+WW91IGNhbiBhZGQgPHN0cm9uZz51bmlxdWUgPC9zdHJvbmc+IHdpZGUgaW1hZ2VzPC9saT4NCgk8bGkgY2xhc3M9XCJyaWdodFwiPnZpZGVvcyBhbmQgZXh0cmEgaW1hZ2VzIDxzcGFuIHN0eWxlPVwiZm9udC13ZWlnaHQ6IGJvbGQ7XCI+dG8gc2xpZGVyLjwvc3Bhbj48L2xpPg0KCTxsaSBjbGFzcz1cImxlZnRcIj5HZXQgdGhlIGNvbXBsZXRlIDxzcGFuIHN0eWxlPVwiZm9udC13ZWlnaHQ6IGJvbGQ7XCI+ZnJlZWRvbTwvc3Bhbj4gb2YgeW91ciBkZXNpZ24uPC9saT4NCgk8bGkgY2xhc3M9XCJyaWdodFwiPkEgY3JlYXRpdmUgYXBwcm9hY2ggdG8gPHN0cm9uZz53ZWIgZGVzaWduLjwvc3Ryb25nPjwvbGk+DQo8L3VsPg0KPHVsPg0KCTxsaSBjbGFzcz1cImJ1dHRvblwiPjxhIGhyZWY9XCJodHRwOi8vcHJlbWl1bWNvZGluZy5jb21cIj5SRUFEIE1PUkU8L2E+PC9saT4NCjwvdWw+DQo8L2Rpdj4NCiI7fWk6NDthOjg6e3M6NToib3JkZXIiO3M6MToiNCI7czo1OiJ0aXRsZSI7czo1OiJJbWFnZSI7czozOiJ1cmwiO3M6NzI6Imh0dHA6Ly9lbXBvcml1bS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMi8xMS9yYWlsd2F5LmpwZyI7czo1OiJ2aWRlbyI7czowOiIiO3M6MzoidG9wIjtzOjI6IjI1IjtzOjQ6ImxlZnQiO3M6MjoiMjUiO3M6NDoibGluayI7czowOiIiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjY5MjoiPGRpdiBjbGFzcz1cImNhcHRpb25Cb3hcIiBzdHlsZT1cImhlaWdodDogMjM1cHg7XCI+DQo8aDEgY2xhc3M9XCJ1bmRlcmxpbmVcIiBzdHlsZT1cInBhZGRpbmc6IDE1cHggMjVweCAxNXB4IDBweDsgZm9udC1zaXplOiAyNnB4ICFpbXBvcnRhbnQ7XCI+VU5MSU1JVEVEIElNQUdFUzwvaDE+DQo8dWwgY2xhc3M9XCJxdW90ZVwiIHN0eWxlPVwicGFkZGluZy1yaWdodDogMjBweDtcIj4NCgk8bGkgY2xhc3M9XCJsZWZ0XCI+WW91IGNhbiBhZGQgPHN0cm9uZz51bmlxdWUgPC9zdHJvbmc+IHdpZGUgaW1hZ2VzPC9saT4NCgk8bGkgY2xhc3M9XCJyaWdodFwiPnZpZGVvcyBhbmQgZXh0cmEgaW1hZ2VzIDxzcGFuIHN0eWxlPVwiZm9udC13ZWlnaHQ6IGJvbGQ7XCI+dG8gc2xpZGVyLjwvc3Bhbj48L2xpPg0KCTxsaSBjbGFzcz1cImxlZnRcIj5HZXQgdGhlIGNvbXBsZXRlIDxzcGFuIHN0eWxlPVwiZm9udC13ZWlnaHQ6IGJvbGQ7XCI+ZnJlZWRvbTwvc3Bhbj4gb2YgeW91ciBkZXNpZ24uPC9saT4NCgk8bGkgY2xhc3M9XCJyaWdodFwiPkEgY3JlYXRpdmUgYXBwcm9hY2ggdG8gPHN0cm9uZz53ZWIgZGVzaWduLjwvc3Ryb25nPjwvbGk+DQo8L3VsPg0KPHVsPg0KCTxsaSBjbGFzcz1cImJ1dHRvblwiPjxhIGhyZWY9XCJodHRwOi8vcHJlbWl1bWNvZGluZy5jb21cIj5SRUFEIE1PUkU8L2E+PC9saT4NCjwvdWw+DQo8L2Rpdj4iO319czoxMToibml2b19zbGlkZXIiO2E6Mjp7aToxO2E6NTp7czo1OiJvcmRlciI7czoxOiIxIjtzOjU6InRpdGxlIjtzOjc6IkltYWdlIDEiO3M6MzoidXJsIjtzOjEwMjoiaHR0cDovL2VtcG9yaXVtLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzExL3Bob3RvZHVuZS0yMDM0MjU0LWRhcmstZmFzaGlvbi1tLW5pdm8uanBnIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7czoxMToiZGVzY3JpcHRpb24iO3M6NjE6IlRoaXMgaXMgYSBOaXZvIFNsaWRlciBDYXB0aW9uIFRleHQuIFNheSBzb21ldGhpbmcgbWVhbmluZ2Z1bC4iO31pOjI7YTo1OntzOjU6Im9yZGVyIjtzOjE6IjIiO3M6NToidGl0bGUiO3M6NzoiSW1hZ2UgMiI7czozOiJ1cmwiO3M6MTQyOiJodHRwOi8vZW1wb3JpdW0ucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMTEvcGhvdG9kdW5lLTMwMjYyMTgtY2xhc3NpY2FsLXJldHJvLXN0eWxlLXBvcnRyYWl0LXJvbWFudGljLWJlYXV0eS12aW50YWdlLW5pdm8uanBnIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7czoxMToiZGVzY3JpcHRpb24iO3M6Mjc6IkNoZWNrIG91ciBsYXRlc3QgQ29sbGVjdGlvbiI7fX1zOjE0OiJzbGlkZXJfb3BhY2l0eSI7czozOiIwLjkiO3M6ODoiYW5pc3BlZWQiO3M6MzoiODAwIjtzOjk6InBhdXNldGltZSI7czo1OiIyMDAwMCI7czoyNToic2xpZGVyX2ZvbnRTaXplX2NvbG9yTml2byI7YToyOntzOjQ6InNpemUiO3M6NDoiMjRweCI7czo1OiJjb2xvciI7czo3OiIjMmEyYjJjIjt9czoyMDoic2xpZGVyX2JhY2tDb2xvck5pdm8iO3M6NzoiI0VFQzQzRCI7czoyMjoic2xpZGVyX2JvcmRlckNvbG9yTml2byI7czo3OiIjRUVDNDNEIjtzOjY6ImVmZmVjdCI7czo2OiJyYW5kb20iO3M6Njoic2xpY2VzIjtzOjI6IjE1IjtzOjc6ImJveGNvbHMiO3M6MToiOCI7czo3OiJib3hyb3dzIjtzOjE6IjQiO3M6OToiYm9keV9mb250IjthOjM6e3M6NDoic2l6ZSI7czo0OiIxM3B4IjtzOjU6ImNvbG9yIjtzOjc6IiMyYTJiMmMiO3M6NDoiZmFjZSI7czo1OiJhcmlhbCI7fXM6MTI6ImhlYWRpbmdfZm9udCI7YToyOntzOjQ6ImZhY2UiO3M6MjM6Illhbm9uZSUyMEthZmZlZXNhdHo6MjAwIjtzOjU6InN0eWxlIjtzOjY6Im5vcm1hbCI7fXM6OToibWVudV9mb250IjtzOjE0OiJIZWx2ZXRpY2EgTmV1ZSI7czoxNDoiYm9keV9ib3hfY29sZXIiO3M6NzoiIzJhMmIyYyI7czoxNToiYm9keV9saW5rX2NvbGVyIjtzOjc6IiMyYTJiMmMiO3M6MTU6ImhlYWRpbmdfZm9udF9oMSI7YToyOntzOjQ6InNpemUiO3M6NDoiMzRweCI7czo1OiJjb2xvciI7czo3OiIjMmEyYjJjIjt9czoxNToiaGVhZGluZ19mb250X2gyIjthOjI6e3M6NDoic2l6ZSI7czo0OiIzMHB4IjtzOjU6ImNvbG9yIjtzOjc6IiMyYTJiMmMiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDMiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjIycHgiO3M6NToiY29sb3IiO3M6NzoiIzJhMmIyYyI7fXM6MTU6ImhlYWRpbmdfZm9udF9oNCI7YToyOntzOjQ6InNpemUiO3M6NDoiMThweCI7czo1OiJjb2xvciI7czo3OiIjMmEyYjJjIjt9czoxNToiaGVhZGluZ19mb250X2g1IjthOjI6e3M6NDoic2l6ZSI7czo0OiIxN3B4IjtzOjU6ImNvbG9yIjtzOjc6IiMyYTJiMmMiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDYiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjE2cHgiO3M6NToiY29sb3IiO3M6NzoiIzJhMmIyYyI7fXM6NDoidGVhbSI7YTo2OntpOjE7YToxMTp7czo1OiJvcmRlciI7czoxOiIxIjtzOjU6InRpdGxlIjtzOjg6IkphbmUgRG9lIjtzOjQ6InJvbGUiO3M6MTk6IlByZXNpZGVudCAmIEZvdW5kZXIiO3M6MzoidXJsIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3RlYW1NZW1iZXIxLmpwZyI7czo0OiJpY29uIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L2ZvdW5kZXJUZWFtLnBuZyI7czo3OiJ0d2l0dGVyIjtzOjMyOiJodHRwOi8vdHdpdHRlci5jb20vcHJlbWl1bWNvZGluZyI7czo4OiJmYWNlYm9vayI7czozNjoiaHR0cDovL3d3dy5mYWNlYm9vay5jb20vR0ZsYXNoRGVzaWduIjtzOjU6InZpbWVvIjtzOjE2OiJodHRwOi8vdmltZW8uY29tIjtzOjc6ImRyaWJibGUiO3M6Mjc6Imh0dHA6Ly9kcmliYmJsZS5jb20vZ2xqaXZlYyI7czo0OiJtYWlsIjtzOjIyOiJpbmZvQHByZW1pdW1jb2RpbmcuY29tIjtzOjExOiJkZXNjcmlwdGlvbiI7czoyNzE6IjxiPkxvcmVtIGlwc3VtPC9iPiBkb2xvciBzaXQgYW1ldCBkYXMgY29uc2UgDQpuaWJoIGV1aXNtb2RvcyB0aW5jaWR1bnQgdXQgbGFvcmVlIGNvbnNlDQplc3QgYXQuIE51bGxhIHZpdGFlIDxiPmVsaXQgbGliZXJvPC9iPiwgYSBwaGEgc2l0IGFtDQp0ZXR1ZXIgYWRpcGlzY2luZyBlbGl0LiBOdWxsYSB2aXRhZSBlbGl0IGxlcm8sIA0KYSBwaGFyZXRyYS4gPGI+TG9yZW0gaXBzdW08L2I+IGN0ZXR1ZXIgYWRpcGlzY2luZy4gDQpMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldC4iO31pOjI7YToxMTp7czo1OiJvcmRlciI7czoxOiIyIjtzOjU6InRpdGxlIjtzOjg6IkpvaG4gRG9lIjtzOjQ6InJvbGUiO3M6MTM6IldlYiBEZXZlbG9wZXIiO3M6MzoidXJsIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3RlYW1NZW1iZXIyLnBuZyI7czo0OiJpY29uIjtzOjc5OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3dlYkRldmVsb3Blckljb24ucG5nIjtzOjc6InR3aXR0ZXIiO3M6MzI6Imh0dHA6Ly90d2l0dGVyLmNvbS9wcmVtaXVtY29kaW5nIjtzOjg6ImZhY2Vib29rIjtzOjM2OiJodHRwOi8vd3d3LmZhY2Vib29rLmNvbS9HRmxhc2hEZXNpZ24iO3M6NToidmltZW8iO3M6MDoiIjtzOjc6ImRyaWJibGUiO3M6Mjc6Imh0dHA6Ly9kcmliYmJsZS5jb20vZ2xqaXZlYyI7czo0OiJtYWlsIjtzOjIyOiJpbmZvQHByZW1pdW1jb2RpbmcuY29tIjtzOjExOiJkZXNjcmlwdGlvbiI7czoyNzE6IjxiPkxvcmVtIGlwc3VtPC9iPiBkb2xvciBzaXQgYW1ldCBkYXMgY29uc2UgDQpuaWJoIGV1aXNtb2RvcyB0aW5jaWR1bnQgdXQgbGFvcmVlIGNvbnNlDQplc3QgYXQuIE51bGxhIHZpdGFlIDxiPmVsaXQgbGliZXJvPC9iPiwgYSBwaGEgc2l0IGFtDQp0ZXR1ZXIgYWRpcGlzY2luZyBlbGl0LiBOdWxsYSB2aXRhZSBlbGl0IGxlcm8sIA0KYSBwaGFyZXRyYS4gPGI+TG9yZW0gaXBzdW08L2I+IGN0ZXR1ZXIgYWRpcGlzY2luZy4gDQpMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldC4iO31pOjM7YToxMTp7czo1OiJvcmRlciI7czoxOiIzIjtzOjU6InRpdGxlIjtzOjEzOiJKb3NlcGhpbmUgRG9lIjtzOjQ6InJvbGUiO3M6MTY6IkN1c3RvbWVyIFNlcnZpY2UiO3M6MzoidXJsIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3RlYW1NZW1iZXIzLnBuZyI7czo0OiJpY29uIjtzOjc4OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3N1cHBvcnRUZWFtSWNvbi5wbmciO3M6NzoidHdpdHRlciI7czozMjoiaHR0cDovL3R3aXR0ZXIuY29tL3ByZW1pdW1jb2RpbmciO3M6ODoiZmFjZWJvb2siO3M6MzY6Imh0dHA6Ly93d3cuZmFjZWJvb2suY29tL0dGbGFzaERlc2lnbiI7czo1OiJ2aW1lbyI7czowOiIiO3M6NzoiZHJpYmJsZSI7czowOiIiO3M6NDoibWFpbCI7czoyMjoiaW5mb0BwcmVtaXVtY29kaW5nLmNvbSI7czoxMToiZGVzY3JpcHRpb24iO3M6MjcxOiI8Yj5Mb3JlbSBpcHN1bTwvYj4gZG9sb3Igc2l0IGFtZXQgZGFzIGNvbnNlIA0KbmliaCBldWlzbW9kb3MgdGluY2lkdW50IHV0IGxhb3JlZSBjb25zZQ0KZXN0IGF0LiBOdWxsYSB2aXRhZSA8Yj5lbGl0IGxpYmVybzwvYj4sIGEgcGhhIHNpdCBhbQ0KdGV0dWVyIGFkaXBpc2NpbmcgZWxpdC4gTnVsbGEgdml0YWUgZWxpdCBsZXJvLCANCmEgcGhhcmV0cmEuIDxiPkxvcmVtIGlwc3VtPC9iPiBjdGV0dWVyIGFkaXBpc2NpbmcuIA0KTG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIjt9aTo0O2E6MTE6e3M6NToib3JkZXIiO3M6MToiNCI7czo1OiJ0aXRsZSI7czo2OiJEYW1pZW4iO3M6NDoicm9sZSI7czo5OiJQSFAgQ29kZXIiO3M6MzoidXJsIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3RlYW1NZW1iZXI0LnBuZyI7czo0OiJpY29uIjtzOjc0OiJodHRwOi8vbWVyY29yLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA5L3BocFRlYW1JY29uLnBuZyI7czo3OiJ0d2l0dGVyIjtzOjMyOiJodHRwOi8vdHdpdHRlci5jb20vcHJlbWl1bWNvZGluZyI7czo4OiJmYWNlYm9vayI7czozNjoiaHR0cDovL3d3dy5mYWNlYm9vay5jb20vR0ZsYXNoRGVzaWduIjtzOjU6InZpbWVvIjtzOjA6IiI7czo3OiJkcmliYmxlIjtzOjI3OiJodHRwOi8vZHJpYmJibGUuY29tL2dsaml2ZWMiO3M6NDoibWFpbCI7czoyMjoiaW5mb0BwcmVtaXVtY29kaW5nLmNvbSI7czoxMToiZGVzY3JpcHRpb24iO3M6MjcxOiI8Yj5Mb3JlbSBpcHN1bTwvYj4gZG9sb3Igc2l0IGFtZXQgZGFzIGNvbnNlIA0KbmliaCBldWlzbW9kb3MgdGluY2lkdW50IHV0IGxhb3JlZSBjb25zZQ0KZXN0IGF0LiBOdWxsYSB2aXRhZSA8Yj5lbGl0IGxpYmVybzwvYj4sIGEgcGhhIHNpdCBhbQ0KdGV0dWVyIGFkaXBpc2NpbmcgZWxpdC4gTnVsbGEgdml0YWUgZWxpdCBsZXJvLCANCmEgcGhhcmV0cmEuIDxiPkxvcmVtIGlwc3VtPC9iPiBjdGV0dWVyIGFkaXBpc2NpbmcuIA0KTG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIjt9aTo1O2E6MTE6e3M6NToib3JkZXIiO3M6MToiNSI7czo1OiJ0aXRsZSI7czoxMzoiQ2hyaXN0aW5hIERvZSI7czo0OiJyb2xlIjtzOjk6Ik1hcmtldGVlciI7czozOiJ1cmwiO3M6NzQ6Imh0dHA6Ly9tZXJjb3IucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvdGVhbU1lbWJlcjUucG5nIjtzOjQ6Imljb24iO3M6ODA6Imh0dHA6Ly9tZXJjb3IucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvbWFya2V0aW5nVGVhbUljb24ucG5nIjtzOjc6InR3aXR0ZXIiO3M6MzI6Imh0dHA6Ly90d2l0dGVyLmNvbS9wcmVtaXVtY29kaW5nIjtzOjg6ImZhY2Vib29rIjtzOjM2OiJodHRwOi8vd3d3LmZhY2Vib29rLmNvbS9HRmxhc2hEZXNpZ24iO3M6NToidmltZW8iO3M6MDoiIjtzOjc6ImRyaWJibGUiO3M6MDoiIjtzOjQ6Im1haWwiO3M6MjI6ImluZm9AcHJlbWl1bWNvZGluZy5jb20iO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjI3MToiPGI+TG9yZW0gaXBzdW08L2I+IGRvbG9yIHNpdCBhbWV0IGRhcyBjb25zZSANCm5pYmggZXVpc21vZG9zIHRpbmNpZHVudCB1dCBsYW9yZWUgY29uc2UNCmVzdCBhdC4gTnVsbGEgdml0YWUgPGI+ZWxpdCBsaWJlcm88L2I+LCBhIHBoYSBzaXQgYW0NCnRldHVlciBhZGlwaXNjaW5nIGVsaXQuIE51bGxhIHZpdGFlIGVsaXQgbGVybywgDQphIHBoYXJldHJhLiA8Yj5Mb3JlbSBpcHN1bTwvYj4gY3RldHVlciBhZGlwaXNjaW5nLiANCkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LiI7fWk6NjthOjExOntzOjU6Im9yZGVyIjtzOjE6IjYiO3M6NToidGl0bGUiO3M6ODoiQW5ueSBEb2UiO3M6NDoicm9sZSI7czoxNjoiQ3VzdG9tZXIgU2VydmljZSI7czozOiJ1cmwiO3M6NzQ6Imh0dHA6Ly9tZXJjb3IucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvdGVhbU1lbWJlcjYucG5nIjtzOjQ6Imljb24iO3M6ODA6Imh0dHA6Ly9tZXJjb3IucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDkvc3VwcG9ydFRlYW1JY29uLTEucG5nIjtzOjc6InR3aXR0ZXIiO3M6MzI6Imh0dHA6Ly90d2l0dGVyLmNvbS9wcmVtaXVtY29kaW5nIjtzOjg6ImZhY2Vib29rIjtzOjM2OiJodHRwOi8vd3d3LmZhY2Vib29rLmNvbS9HRmxhc2hEZXNpZ24iO3M6NToidmltZW8iO3M6MTY6Imh0dHA6Ly92aW1lby5jb20iO3M6NzoiZHJpYmJsZSI7czoyNzoiaHR0cDovL2RyaWJiYmxlLmNvbS9nbGppdmVjIjtzOjQ6Im1haWwiO3M6MjI6ImluZm9AcHJlbWl1bWNvZGluZy5jb20iO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjI3MToiPGI+TG9yZW0gaXBzdW08L2I+IGRvbG9yIHNpdCBhbWV0IGRhcyBjb25zZSANCm5pYmggZXVpc21vZG9zIHRpbmNpZHVudCB1dCBsYW9yZWUgY29uc2UNCmVzdCBhdC4gTnVsbGEgdml0YWUgPGI+ZWxpdCBsaWJlcm88L2I+LCBhIHBoYSBzaXQgYW0NCnRldHVlciBhZGlwaXNjaW5nIGVsaXQuIE51bGxhIHZpdGFlIGVsaXQgbGVybywgDQphIHBoYXJldHJhLiA8Yj5Mb3JlbSBpcHN1bTwvYj4gY3RldHVlciBhZGlwaXNjaW5nLiANCkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LiI7fX1zOjExOiJwb3J0X251bWJlciI7czoyOiIxMiI7czoxODoic29ydGluZ3Bvc3RfbnVtYmVyIjtzOjI6IjEyIjtzOjEzOiJmYWNlYm9va19zaG93IjtzOjE6IjEiO3M6ODoiZmFjZWJvb2siO3M6MzY6Imh0dHA6Ly93d3cuZmFjZWJvb2suY29tL0dGbGFzaERlc2lnbiI7czoxMjoidHdpdHRlcl9zaG93IjtzOjE6IjEiO3M6NzoidHdpdHRlciI7czozMzoiaHR0cHM6Ly90d2l0dGVyLmNvbS9wcmVtaXVtY29kaW5nIjtzOjEwOiJ2aW1lb19zaG93IjtzOjE6IjEiO3M6NToidmltZW8iO3M6MTY6Imh0dHA6Ly92aW1lby5jb20iO3M6MTI6InlvdXR1YmVfc2hvdyI7czoxOiIxIjtzOjc6InlvdXR1YmUiO3M6Mjc6Imh0dHA6Ly9kcmliYmJsZS5jb20vZ2xqaXZlYyI7czoxMjoic3R1bWJsZV9zaG93IjtzOjE6IjEiO3M6Nzoic3R1bWJsZSI7czoyNzoiaHR0cDovL3d3dy5zdHVtYmxldXBvbi5jb20vIjtzOjk6ImRpZ2dfc2hvdyI7czoxOiIxIjtzOjQ6ImRpZ2ciO3M6MTk6Imh0dHA6Ly93d3cuZGlnZy5jb20iO3M6MTA6ImVtYWlsX3Nob3ciO3M6MToiMSI7czo1OiJlbWFpbCI7czoyMjoiaW5mb0BwcmVtaXVtY29kaW5nLmNvbSI7czoxMjoiY29udGFjdGVtYWlsIjtzOjE3OiJpbmZvQHlvdXJtYWlsLmNvbSI7czoxMjoiY29udGFjdGVycm9yIjtzOjI1OiJFcnJvciB3aGlsZSBzZW5kaW5nIG1haWwuIjtzOjE0OiJjb250YWN0c3VjY2VzcyI7czo3OiJTdWNjZXNzIjtzOjE0OiJlcnJvcnBhZ2V0aXRsZSI7czoxMDoiT09PUFMhIDQwNCI7czoxNzoiZXJyb3JwYWdlc3VidGl0bGUiO3M6NjM6IlNlZW1zIGxpa2UgeW91IHN0dW1ibGVkIGF0IHNvbWV0aGluZyB0aGF0IGRvZXNuXCd0IHJlYWxseSBleGlzdCI7czo5OiJlcnJvcnBhZ2UiO3M6MTcxOiJTb3JyeSwgYnV0IHRoZSBwYWdlIHlvdSBhcmUgbG9va2luZyBmb3IgaGFzIG5vdCBiZWVuIGZvdW5kLjxici8+VHJ5IGNoZWNraW5nIHRoZSBVUkwgZm9yIGVycm9ycywgdGhlbiBoaXQgcmVmcmVzaC48L2JyPk9yIHlvdSBjYW4gc2ltcGx5IGNsaWNrIHRoZSBpY29uIGJlbG93IGFuZCBnbyBob21lOikiO3M6MTY6InNob3dzb2NpYWxmb290ZXIiO3M6MToiMSI7czo5OiJjb3B5cmlnaHQiO3M6Mjk6IsKpIDIwMTEgQWxsIHJpZ2h0cyByZXNlcnZlZC4gIjtzOjIzOiJ0cmFuc2xhdGlvbl9zb2NpYWx0aXRsZSI7czoxNzoiU29jaWFsaXplIHdpdGggdXMiO3M6MjA6InRyYW5zbGF0aW9uX2ZhY2Vib29rIjtzOjg6IkZhY2Vib29rIjtzOjE5OiJ0cmFuc2xhdGlvbl90d2l0dGVyIjtzOjc6IlR3aXR0ZXIiO3M6MTc6InRyYW5zbGF0aW9uX3ZpbWVvIjtzOjU6IlZpbWVvIjtzOjE5OiJ0cmFuc2xhdGlvbl9kcmliYmxlIjtzOjc6IkRyaWJibGUiO3M6MTc6InRyYW5zbGF0aW9uX2VtYWlsIjtzOjEzOiJTZW5kIHVzIEVtYWlsIjtzOjE2OiJ0cmFuc2xhdGlvbl9wb3N0IjtzOjE2OiJPdXIgbGF0ZXN0IHBvc3RzIjtzOjI0OiJ0cmFuc2xhdGlvbl9lbnRlcl9zZWFyY2giO3M6MTU6IkVudGVyIHNlYXJjaC4uLiI7czoxNjoidHJhbnNsYXRpb25fcG9ydCI7czoxNjoiUmVjZW50IHBvcnRmb2xpbyI7czoyMzoidHJhbnNsYXRpb25fcmVsYXRlZHBvc3QiO3M6NzoiUmVsYXRlZCI7czoyNzoidHJhbnNsYXRpb25fYWR2ZXJ0aXNlX3RpdGxlIjtzOjE2OiJPdXIgTWFqb3IgQnJhbmRzIjtzOjIwOiJ0cmFuc2xhdGlvbl9tb3JlbGluayI7czo5OiJSZWFkIG1vcmUiO3M6MjQ6InBvcnRfcHJvamVjdF9kZXNjcmlwdGlvbiI7czoyMDoiUHJvamVjdCBEZXNjcmlwdGlvbjoiO3M6MjA6InBvcnRfcHJvamVjdF9kZXRhaWxzIjtzOjE2OiJQcm9qZWN0IGRldGFpbHM6IjtzOjE2OiJwb3J0X3Byb2plY3RfdXJsIjtzOjEyOiJQcm9qZWN0IFVSTDoiO3M6MjE6InBvcnRfcHJvamVjdF9kZXNpZ25lciI7czoxNzoiUHJvamVjdCBkZXNpZ25lcjoiO3M6MTc6InBvcnRfcHJvamVjdF9kYXRlIjtzOjI3OiJQcm9qZWN0IERhdGUgb2YgY29tcGxldGlvbjoiO3M6MTk6InBvcnRfcHJvamVjdF9jbGllbnQiO3M6MTU6IlByb2plY3QgQ2xpZW50OiI7czoxODoicG9ydF9wcm9qZWN0X3NoYXJlIjtzOjE3OiJTaGFyZSB0aGUgcHJvamVjdCI7czoyMDoicG9ydF9wcm9qZWN0X3JlbGF0ZWQiO3M6MTU6IlJlbGF0ZWQgcHJvamVjdCI7czoxNToidHJhbnNsYXRpb25fYWxsIjtzOjg6IlNob3cgYWxsIjtzOjI0OiJ0cmFuc2xhdGlvbl9uZXh0X3Byb2plY3QiO3M6MTY6Ik5leHQgcHJvamVjdCDihpIiO3M6Mjc6InRyYW5zbGF0aW9uX3ByZXZpdXNfcHJvamVjdCI7czoxNzoi4oaQIFByZXYgcHJvamVjdCAiO3M6MTQ6InRyYW5zbGF0aW9uX2J5IjtzOjM6IkJ5OiI7czoyMjoidHJhbnNsYXRpb25fY2F0ZWdvcmllcyI7czoxMToiQ2F0ZWdvcmllczoiO3M6MTY6InRyYW5zbGF0aW9uX3RhZ3MiO3M6NjoiVGFnczogIjtzOjI2OiJ0cmFuc2xhdGlvbl9zaGFyZV9jYXRlZ29yeSI7czo1OiJTaGFyZSI7czoyMToidHJhbnNsYXRpb25fYmxvZ19wYWdlIjtzOjU5OiJXZWxjb21lIHRvIDxzcGFuPm91ciBibG9nPC9zcGFuPiwgd2Ugd2lsbCBrZWVwIHlvdSBpbmZvcm1lZCI7czozMjoidHJhbnNsYXRpb25fY29tbWVudF9sZWF2ZV9yZXBsYXkiO3M6NToiUmVwbHkiO3M6MzU6InRyYW5zbGF0aW9uX2NvbW1lbnRfbGVhdmVfcmVwbGF5X3RvIjtzOjE2OiJMZWF2ZSBhIFJlcGx5IHRvIjtzOjM5OiJ0cmFuc2xhdGlvbl9jb21tZW50X2xlYXZlX3JlcGxheV9jYW5jbGUiO3M6MTM6IkNhbmNsZSBSZXBsYXkiO3M6MjQ6InRyYW5zbGF0aW9uX2NvbW1lbnRfbmFtZSI7czo0OiJOYW1lIjtzOjI0OiJ0cmFuc2xhdGlvbl9jb21tZW50X21haWwiO3M6NDoiTWFpbCI7czoyNzoidHJhbnNsYXRpb25fY29tbWVudF93ZWJzaXRlIjtzOjc6IldlYnNpdGUiO3M6Mjg6InRyYW5zbGF0aW9uX2NvbW1lbnRfcmVxdWlyZWQiO3M6ODoicmVxdWlyZWQiO3M6MjY6InRyYW5zbGF0aW9uX2NvbW1lbnRfY2xvc2VkIjtzOjIwOiJDb21tZW50cyBhcmUgY2xvc2VkLiI7czozMToidHJhbnNsYXRpb25fY29tbWVudF9ub19yZXNwb25jZSI7czoxMDoiTm8gUmVwbGllcyI7czozMToidHJhbnNsYXRpb25fY29tbWVudF9vbmVfY29tbWVudCI7czo5OiJPbmUgUmVwbHkiO3M6MzE6InRyYW5zbGF0aW9uX2NvbW1lbnRfbWF4X2NvbW1lbnQiO3M6NzoiUmVwbGllcyI7czoyNDoidHJhbnNsYXRpb25fY29udGFjdF9uYW1lIjtzOjQ6Ik5hbWUiO3M6MjU6InRyYW5zbGF0aW9uX2NvbnRhY3RfZW1haWwiO3M6NToiRW1haWwiO3M6Mjc6InRyYW5zbGF0aW9uX2NvbnRhY3RfbWVzc2FnZSI7czo3OiJNZXNzYWdlIjtzOjI0OiJ0cmFuc2xhdGlvbl9jb250YWN0X3NlbmQiO3M6MTI6IlNlbmQgTWVzc2FnZSI7czoyNToidHJhbnNsYXRpb25fY29udGFjdF9jbGVhciI7czo1OiJDbGVhciI7czoxODoicmFjZW50X3N0YXR1c19wb3J0IjtzOjA6IiI7czoxMzoicmFjZW50X3N0YXR1cyI7czowOiIiO30=';
		$data = unserialize(base64_decode($data)); //100% safe - ignore theme check nag
		update_option('of_options', $data);
		
	}
	//delete_option(OPTIONS);
	
}

function mv_my_theme_scripts()
{
	wp_enqueue_script('add-to-cart-variation', get_template_directory_uri() . '/js/add-to-cart-variation.js',array('jquery'),'1.0',true);
	wp_enqueue_script('paralax', get_template_directory_uri().'/js/jquery.parallax-1.1.3.js', array('jquery'));
}
add_action('wp_enqueue_scripts','mv_my_theme_scripts');

function getTextBetweenTags($tag, $html, $strict=0)
{
    /*** a new dom object ***/
    $dom = new domDocument;

    /*** load the html into the object ***/
    if($strict==1)
    {
        $dom->loadXML($html);
    }
    else
    {
        $dom->loadHTML($html);
    }

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the tag by its tag name ***/
    $content = $dom->getElementsByTagname($tag);

    /*** the array to return ***/
    $out = array();
    foreach ($content as $item)
    {
        /*** add node value to the out array ***/
        $out[] = $item->nodeValue;
    }
    /*** return the results ***/
    return $out;
}




?>
