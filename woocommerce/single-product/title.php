<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<div class = "outerpagewrap">
	<div class="pagewrap">
		<div class="pagecontent">
			<div class="pagecontentContent">
				<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
				<p><?php the_breadcrumb(); ?></p>
			</div>
			<!--<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>-->
		</div>

	</div>
</div>