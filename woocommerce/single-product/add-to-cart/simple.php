<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php if ( $product->is_in_stock() ) : ?>
<div class="cartPS">
	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>"  method="post" enctype='multipart/form-data'>

	 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>


	<div class="single_variation_wrap">
		<div class="single_variation">
			<span class="price"><span class="amount"><?php echo $product->get_price_html(); ?></span></span>
			<?php
				// Availability
				$availability = $product->get_availability();

				if ($availability['availability']) :
					echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] );
				endif;
			?>			
		</div>
		<div class="variations_button">
			<button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __('Add to cart', 'woocommerce'), $product->product_type); ?></button>
			<?php if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) ); ?>				
		</div>
	</div>
	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>
	<div class="messageSP">
		<?php do_action( 'woocommerce_before_single_product' ); ?>
	</div>
	<?php do_action('woocommerce_after_add_to_cart_form'); ?>
</div>
<?php endif; ?>