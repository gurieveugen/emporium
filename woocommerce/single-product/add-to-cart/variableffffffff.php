<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.5
 */

global $woocommerce, $product, $post;
?>
<script type="text/javascript">
    var product_variations_<?php echo $post->ID; ?> = <?php echo json_encode( $available_variations ) ?>;
</script>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

<div class="cartPS">
<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="variations_form" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" >
	<div class="variations">
			<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
				<div class="rowSP">
					<div class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo $woocommerce->attribute_label($name); ?></label></div>
					<div class="value"><select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
						<option value=""><?php echo __('Choose an option', 'woocommerce') ?>&hellip;</option>
						<?php
							if ( is_array( $options ) ) {

								if ( empty( $_POST ) )
									$selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
								else
									$selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';

								// Get terms if this is a taxonomy - ordered
								if ( taxonomy_exists( sanitize_title( $name ) ) ) {

									$terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );

									foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) continue;
										echo '<option value="' . $term->slug . '" ' . selected( $selected_value, $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
									}
								} else {
									foreach ( $options as $option )
										echo '<option value="' . $option . '" ' . selected( $selected_value, $option, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $option ) . '</option>';
								}
							}
						?>
					</select> </div>
				</div>
	        <?php endforeach;?>
		
	</div>
	<?php $available_variations = $product->get_available_variations(); ?>
		<select>
		<?php foreach ($available_variations as $available_variation) { ?>
			<?php $name = $available_variation['attributes']['attribute_options']; ?>
			<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
		<?php } ?>
		</select>
<?php /* $available_variation['attributes']['attribute_options']
[variation_id]
[price_html] */ ?>
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<div class="single_variation_wrap" style="">
		<div class="single_variation"></div>
		<div class="variations_button">
			<input type="hidden" name="variation_id" value="" />
			<button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __('Add to cart', 'woocommerce'), $product->product_type); ?></button>
			
			<?php woocommerce_quantity_input(); ?>
		</div>

	</div>
	<div><input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" /></div>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

</form>
		<div class="messageSP">
			<?php do_action( 'woocommerce_before_single_product' ); ?>
		</div>
</div>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
