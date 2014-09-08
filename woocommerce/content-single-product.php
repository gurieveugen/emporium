<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	global $post,$product;
	 
?>
<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?> style="float: left;">
<?php 
$idcheck= get_the_ID();
$term_list = wp_get_post_terms($idcheck,'product_cat');
$cat= $term_list[0]->name;
//print_r($term_list);
$taxonomy = 'product_cat';
$terms = get_the_terms( $post->ID, $taxonomy ); 
//print_r($terms);

$cat_id = (int)$term_list[0];
$slug= $terms[$cat_id]->slug;

//echo get_term_link ($cat_id, 'product_cat');
?>
  <?php
  $product;
$categ = $product->get_categories(); /*	
	$terms = get_the_terms( $post->ID, $taxonomy ); echo "id".$post->ID;  foreach ($items as $items){echo $items['name'];} print_r($terms);
	* 
	*/ 
	?>		
		<?php
			//changed to show all three categories #CLW
            //echo "<!--<pre>";
            
            $menu = wp_nav_menu( array(
                'container' =>false,
                'container_class' => 'menu-header',
                'theme_location' => 'products-menu',
                'echo' => false,
                //'fallback_cb' => 'emporium_fallback_menu',
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'depth' => 1
            ));
            $content = getTextBetweenTags('a', $menu);            
            $prod_cat = strip_tags($categ);
            echo "<!--<pre>";
            var_dump($prod_cat);
            var_dump($content);
            echo "</pre>-->";
            $car_array = array();
            if ($prod_cat) $car_array[] = $prod_cat;  
            foreach( $content as $c ) {
                if ($prod_cat == $c) continue;
                $car_array[] = $c;
            }
            foreach( $car_array as $item )
            {
                wp_nav_menu_top(array(
                    'container' =>false,
                    'container_class' => 'menu-header',
                    'theme_location' => 'products-menu',
                    'echo' => true,
                    'fallback_cb' => 'emporium_fallback_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' =>''
                ), $item );             
            }            
            /*
			$menus = wp_nav_menu_top(array('container' =>false, 'container_class' => 'menu-header',        'theme_location' => 'main-menu','echo' => true, 'fallback_cb' => 'emporium_fallback_menu', 'before' => '', 'after' => '', 'link_before' => '','link_after' =>''),'Lumbar Models'); 
			$menus = wp_nav_menu_top(array('container' =>false, 'container_class' => 'menu-header',        'theme_location' => 'main-menu','echo' => true, 'fallback_cb' => 'emporium_fallback_menu', 'before' => '', 'after' => '', 'link_before' => '','link_after' =>''),'Cervical Models'); 
			$menus = wp_nav_menu_top(array('container' =>false, 'container_class' => 'menu-header',        'theme_location' => 'main-menu','echo' => true, 'fallback_cb' => 'emporium_fallback_menu', 'before' => '', 'after' => '', 'link_before' => '','link_after' =>''),'Packages');
            */             
	 	?>
		</div>
		<div class="product-info-container">
      <div  class="leftContentSP">
      
      <?php
        /**
         * woocommerce_show_product_images hook
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
      ?>
      </div>
    
        
        
      <div class="rightContentSP">
        <?php
        /**
         * woocommerce_after_single_product_summary hook
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
				?>
       	<div class="product-price-info">
        <?php
         /**
           * woocommerce_single_product_summary hook
           *
           * @hooked woocommerce_template_single_title - 5
           * @hooked woocommerce_template_single_price - 10
           * @hooked woocommerce_template_single_excerpt - 20
           * @hooked woocommerce_template_single_add_to_cart - 30
           * @hooked woocommerce_template_single_meta - 40
           * @hooked woocommerce_template_single_sharing - 50
           */
          do_action('woocommerce_single_product_summary');
              
        ?>
        <?php if ( is_active_sidebar( 'single-product-sidebar' ) ) : ?>
            <div class="converter">
                <?php dynamic_sidebar( 'single-product-sidebar' ); ?>        
            </div>
        <?php endif; ?>
        </div>        
      </div>
  
      <div style="clear: both;"></div>
      <?php
if ( is_singular('product') ):
	global $post;
	 
	// get categories
	$terms = wp_get_post_terms( $post->ID, 'product_cat' );
		$cats_array[] = $terms[0]->term_id;
	 
		$query_args = array( 
			'post__not_in' => array( $post->ID ), 
			'posts_per_page' => 100, 
			'no_found_rows' => 1, 
			'post_status' => 'publish', 
			'post_type' => 'product', 
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $cats_array
				)
			),
			'orderby' => 'ID'
		);
		 
		$r = new WP_Query($query_args);
		if ($r->have_posts()):
	?>
		<ul class="category-products">
			<h3>Related Products</h3>
			<?php $num = 1; ?>
			<?php 
				while ($r->have_posts()) : 
						$r->the_post(); 
						global $product; 
			?>
						<li<?php if (($num-1) % 2 == 0) { print " class='clearblock'"; } ?>>
							<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
							<?php 
								$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
								echo wp_get_attachment_image( $post_thumbnail_id, 'carousel_thumb' );
								if ( get_the_title() ) {
									the_title(); 
								} else {
									the_ID(); 
								}
							?>
							</a>
							<br/>
							<?php echo $product->get_price_html(); ?>
							<div  style="clear: both;"></div>
						</li>
			<?php 
						$num++; 
				endwhile; 
			?>
		</ul>
	<?php
		endif;
endif;
?>
    </div>
</div><!-- #product-<?php the_ID(); ?> -->
<?php /*
if ( is_singular('product') ):
	global $post;
	 
	// get categories
	$terms = wp_get_post_terms( $post->ID, 'product_cat' );
		$cats_array[] = $terms[0]->term_id;
	 
		$query_args = array( 
			'post__not_in' => array( $post->ID ), 
			'posts_per_page' => 100, 
			'no_found_rows' => 1, 
			'post_status' => 'publish', 
			'post_type' => 'product', 
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $cats_array
				)
			),
			'orderby' => 'ID'
		);
		 
		$r = new WP_Query($query_args);
		if ($r->have_posts()):
	?>
		<ul class="category-products">
			<h3>Related Products</h3>
			<?php $num = 1; ?>
			<?php 
				while ($r->have_posts()) : 
						$r->the_post(); 
						global $product; 
			?>
						<li<?php if (($num-1) % 2 == 0) { print " class='clearblock'"; } ?>>
							<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
							<?php 
								$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
								echo wp_get_attachment_image( $post_thumbnail_id, 'carousel_thumb' );
								if ( get_the_title() ) {
									the_title(); 
								} else {
									the_ID(); 
								}
							?>
							</a>
							<br/>
							<?php echo $product->get_price_html(); ?>
							<div  style="clear: both;"></div>
						</li>
			<?php 
						$num++; 
				endwhile; 
			?>
		</ul>
	<?php
		endif;
endif;
*/ ?>
<?php do_action( 'woocommerce_after_single_product' ); ?>
