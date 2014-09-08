<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

// Get tabs
ob_start();

do_action('woocommerce_product_tabs');

$tabs = trim( ob_get_clean() );

if ( ! empty( $tabs ) ) : ?>
	<div class="woocommerce_tabs" style="margin-top: -15%;margin-left: 52.5%;bottom: 80%;width: 66%;">
		<ul class="tabs woo">
			<?php echo $tabs; ?>
		</ul>
		<?php do_action('woocommerce_product_tab_panels'); ?>
	</div>
<?php endif; ?>
