<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product, $data;


?>

	<div class="titleSP">
		<h2><?php the_title(); ?></h2>
	</div>
	<div class="priceSP">

	<?php echo $product->get_price_html(); ?>

	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

	</div>
	<?php if($post->post_excerpt) { ?>
	<div class="descriptionSP short">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
	</div>
	<?php } ?>
