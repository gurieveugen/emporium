<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); 
global $data, $woocommerce;

?>

					
	<div id="mainwrap" class="homewrap archive-product_template_1">

		<div id="main" class="clearfix">
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorderSingle"></div>
						<h1>
						<?php if ( is_search() ) : ?>
							<?php
								printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
								if ( get_query_var( 'paged' ) )
									printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
							?>
						<?php elseif ( is_tax() ) : ?>
							<?php echo single_term_title( "", false ); ?>
						<?php else : ?>
							<?php
								$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );

								echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
							?>
						<?php endif; ?>
						
					</h1>
					<div class="title-right">
          	<?php dynamic_sidebar( 'title_right' ); ?>
						<!--<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>-->
          </div>
				<div class="infotextBorderSingle"></div>
			</div>
		</div>	
		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( is_tax() ) : ?>
			<?php do_action( 'woocommerce_taxonomy_archive_description' ); ?>
		<?php elseif ( ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
			<?php do_action( 'woocommerce_product_archive_description', $shop_page ); ?>
		<?php endif; ?>
		
		<?php 


			


		?>

		<?php if ( have_posts() ) : ?>

			<?php
			/**
			* Sorting
			*/
			?>
			<div class="categorytopbarWraper sidebarShop">
			<form class="woocommerce_ordering" method="POST">
				<select name="sort" class="orderby">
					<?php
						$catalog_orderby = apply_filters('woocommerce_catalog_orderby','');

						foreach ($catalog_orderby as $id => $name) echo '<option value="'.$id.'" '.selected( isset($_SESSION['orderby']), $id, false ).'>'.$name.'</option>';
					?>
				</select>
			</form>
			
			</div>
			
			<div class="sidebar woosidebar">

				<?php dynamic_sidebar( 'sidebar_category' ); ?>

			</div>
			
			<div class="homeRacent shopSidebar">
			<div class="wocategory">
				<div class="productR">
					<?php
					$currentindex = '';
					$count = 1;
					$countitem = 1;

					

					while ( have_posts() ) : the_post(); global $product;
					$postmeta = get_post_custom($post->ID);
				
					if($count != 2){
						echo '<div class="one_half" >';
					}
					else{
						echo '<div class="one_half last" >';
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
											echo '<iframe class = "productIframe withsidebar" src="http://player.vimeo.com/video/'.$postmeta["video_post_url"][0].'" width="280" height="224" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';  
										}  
										else if ($postmeta["selectv"][0] == 'youtube')  
										{  
											echo '<iframe class = "productIframe withsidebar youtube"  width="280" height="224" src="http://www.youtube.com/embed/'.$postmeta["video_post_url"][0].'" frameborder="0" allowfullscreen></iframe>';  
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
									<?php if (has_post_thumbnail( $post->ID )) echo get_image_pmc(280,222,$post->ID); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />'; ?>
								</div>
							</div>						
							<?php  }  ?>
						</a>
							<div class="recentdescription">
								<?php woocommerce_show_product_sale_flash( $post, $product ); ?>
								<h3><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php the_title() ?>"><?php echo substr(the_title(' ', ' ', false),0,99) ?></a></h3>
								<div class="borderLine"><div class="borderLineLeft"></div><div class="borderLineRight"></div></div>
								<div class="shortDescription"><?php echo shortcontent('[', ']', '', $post->post_content ,95);?> ...</strong></div>
								<h3 class="category"><span class="price"><?php echo $product->get_price_html(); ?></span></h3>	
							</div>
							<div class="recentCart"><?php woocommerce_template_loop_add_to_cart( $post->ID, $product ); ?></div>
						
						</div>
					<?php 
					$count++;
					
					$countitem++;

					 endwhile; // end of the loop. ?>

				</div>
				<?php
				
					include(TEMPLATEPATH .'/includes/wp-pagenavi.php');
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				?>
				<?php do_action('woocommerce_after_shop_loop'); ?>
			</div>
		<?php else : ?>

			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>

				<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>

			<?php endif; ?>
		
		<?php endif; ?>
		

		</div>
		
		</div>
	</div>

<?php get_footer('shop'); ?>
