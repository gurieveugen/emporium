<?php
/**
 * Reviews tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
global $data,$sitepress;
 
if ( comments_open() ) : ?>
	<li class="reviews_tab"><a href="#tab-reviews"><?php _e('Reviews', 'woocommerce'); ?><?php echo comments_number(' (0)', ' (1)', ' (%)'); ?></a>	
	
	</li>
	
	<div class="social_tab" >
			<div class="titleShareSP">
				<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_share_product']); } else {  _e('<span>Share</span> this product','wp-emporium'); } ?>
			</div>
			<div class="socialSP"><?php socialLinkProduct() ?></div>
	</div>
<?php endif; ?>