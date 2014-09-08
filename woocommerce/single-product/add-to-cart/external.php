<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>
<?php do_action('woocommerce_before_add_to_cart_button'); ?>
<div class="cartPS">
<a href="<?php echo $product_url; ?>" rel="nofollow" class="single_add_to_cart_button button alt external"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a>
</div>
<?php do_action('woocommerce_after_add_to_cart_button'); ?>