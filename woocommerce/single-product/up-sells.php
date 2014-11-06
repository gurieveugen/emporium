<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop ,$data ,$sitepress;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$args = array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> 99,
	'no_found_rows' 		=> 1,
	'orderby' 				=> 'rand',
	'post__in' 				=> $upsells
);

$pc = new WP_Query( $args ); ?>


	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#relatedSP').bxSlider({
			controls: true,
			displaySlideQty: 1,
			default: 1000,
			easing : 'easeInOutQuint',
			prevText : '',
			nextText : ''
			
		});

		// Resize
		jQuery(window).resize(function(){

		$slider.reloadShow();

		});	  

		 });
	</script>



		

<div class="homeRacent SP">
		<?php
		$currentindex = '';
		if ($pc->have_posts()) :
		$count = 1;
		$countitem = 1;
		?>
	<div class="titleborder"></div>
	<h3 class="titleborderh">
		<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_also_like']); } else {  _e('<span>Also</span> like','wp-emporium'); } ?>
	</h3>
	<div id="homeRecent">
	<ul  id="relatedSP" class="productR">
		<?php  while ($pc->have_posts()) : $pc->the_post(); global $product;
		if($countitem == 1){
			echo '<li>';}				
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
			$image = $image[0];}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
			if( has_post_format( 'link' , get_the_ID()))
			add_filter( 'the_excerpt', 'filter_content_link' );		
		if($count != 3){
			echo '<div class="one_third" >';
		}
		else{
			echo '<div class="one_third last" >';
			$count = 0;
		}?>
				<a href="<?php echo get_permalink( get_the_ID() ) ?>" title="<?php the_title() ?>">
					<div class="recentimage">
					<div class="overdefult"></div>
						<div class="image">
							<div class="loading"></div>
							<?php if (has_post_thumbnail( get_the_ID() )) {
								$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'feature_product');
								echo '<img src="'.$thumbnail[0].'" />';
								//echo get_image_pmc(300,225,get_the_ID() ); 
							} else {
								echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />'; 
							} ?>
						</div>
					</div>
				</a>
				<div class="recentdescription">
					<?php woocommerce_show_product_sale_flash( get_the_ID(), $product ); ?>
					<h3><a href="<?php echo get_permalink( get_the_ID() ) ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
					<h3 class="category"><span class="price"><?php echo $product->get_price_html(); ?></span></h3>	
				</div>
				<div class="recentCart"><?php woocommerce_template_loop_add_to_cart(get_the_ID(), $product ); ?></div>
			
			</div>
		<?php 
		$count++;
		
		 if($countitem == 3){ 
			$countitem = 0; ?>
			</li>
		<?php } 
		$countitem++;
		endwhile; endif;
		wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php
wp_reset_postdata(); ?>