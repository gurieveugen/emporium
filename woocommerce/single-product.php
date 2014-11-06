<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); ?>


	<div id="mainwrap" class="homewrap single-product">

		<div id="main" class="clearfix">
			<div class="infotextwrap">
				<div class="infotext">
					<div class="infotextBorderSingle"></div>
						<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
						<!--<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>-->
					<div class="infotextBorderSingle"></div>
				</div>
			</div>				
			<div class="content fullwidth">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div>
	

		</div>
	</div>

<?php get_footer('shop'); ?>
