<?php

	if(isset($data['home_recent_products_number']))
		$showpost = $data['home_recent_products_number'];
	else
		$showpost = 9;
		
	if(isset($data['home_recent_number_display_product']))
		$rows = $data['home_recent_number_display_product'];
	else
		$rows = 3;

	$args = array( 'post_type' => 'product', 'posts_per_page' => $showpost );
	$pc = new WP_Query( $args );
	
?>

	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#productR').bxSlider({
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




		

<div class="homeRacent">
	<div class="titleborder shop"></div>
	<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_recent_pruduct_title']); } else {  _e('Recent Products','wp-emporium'); } ?></h2>
	<div id="homeRecent" class="productRH">
	
	<ul id="productR" class="productR">
		<?php
		
		$currentindex = '';
		if ($pc->have_posts()) :
		$count = 1;
		$countitem = 1;

		?>
		<?php  while ($pc->have_posts()) : $pc->the_post();
		$postmeta = get_post_custom($post->ID);
		global $product;
		if($countitem == 1){
			echo '<li>';}				
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
			$image = $image[0];}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
			if( has_post_format( 'link' , $post->ID))
			add_filter( 'the_excerpt', 'filter_content_link' );		
		if($count != 3){
			echo '<div class="one_third" >';
		}
		else{
			echo '<div class="one_third last" >';
			$count = 0;
		}?>
				<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php the_title() ?>">
				<?php if(isset($postmeta["video_active"][0]) && $postmeta["video_active"][0] == 1) { ?>
					<div class="recentimage">
						<div class="image">
							<div class="loading"></div>
							<?php
							
								if ($postmeta["selectv"][0] == 'vimeo')  
								{  
									echo '<iframe class = "productIframe full" src="http://player.vimeo.com/video/'.$postmeta["video_post_url"][0].'" width="300" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';  
								}  
								else if ($postmeta["selectv"][0] == 'youtube')  
								{  
									echo '<iframe class = "productIframe full youtube"  width="300" height="225" src="http://www.youtube.com/embed/'.$postmeta["video_post_url"][0].'" frameborder="0" allowfullscreen></iframe>';  
								}  
								else  
								{  
									//echo 'Please select a Video Site via the WordPress Admin';  
								} 

							?>
						</div>
					</div>								
					
					<?php } else { ?>
					<div class="recentimage">
						<div class="overdefult"></div>
						<div class="image">
							<div class="loading"></div>
							<?php if (has_post_thumbnail( $post->ID )) {
								$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'feature_product');
							?>
              	<img src="<?php echo $thumbnail[0]; ?>" />
              <?php
								//echo get_image_pmc(300,225,$post->ID); 
								} else {
									echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />'; 
								}
							?>
						</div>
					</div>						
					<?php  }  ?>
				</a>
				<div class="recentdescription">
					<?php woocommerce_show_product_sale_flash( $post, $product ); ?>
					<h3><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
					<div class="borderLine"><div class="borderLineLeft"></div><div class="borderLineRight"></div></div>
					<div class="shortDescription"><?php echo shortcontent('[', ']', '', $post->post_content ,100);?> ...</strong></div>					
					<h3 class="category"><span class="price"><?php echo $product->get_price_html(); ?></span></h3>	
				</div>
				<div class="recentCart"><?php woocommerce_template_loop_add_to_cart( $post, $product ); ?></div>
			</div>
		<?php 
		$count++;
		
		 if($countitem == $rows){ 
			$countitem = 0; ?>
			</li>
		<?php } 
		$countitem++;
		endwhile; endif;
		wp_reset_query(); ?>
		</ul>
	</div>
</div>

<div class="clear"></div>

