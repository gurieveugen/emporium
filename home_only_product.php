<?php
/*
Template Name: Home only products
*/
?>

<?php get_header(); ?>
<?php 
	wp_register_script('pmc_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js?domready=1', array(
		'jquery'
	), true);  
	wp_enqueue_script('pmc_addthis');


?>

<div id="mainwrap" class="homewrap">

<div id="main" class="clearfix">
	</br>
	<?php if(isset($data['infotext_status'])) { ?>
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorder"></div>
				<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['infotext']); } else {  _e('Welcome to <span>emporium</span> - A Minimal Business Theme','wp-emporium'); } ?></h2>				
			</div>
		</div>
	<?php }?>
	
	<div class="clear"></div>
	
	

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	
	<div class="usercontent homeuser"><?php the_content(); ?></div>
	
	
	<?php endwhile; endif; ?>
	
	
	<div class="clear"></div>	
	
	<?php if(isset($data['racent_status_productF']) && function_exists( 'is_woocommerce' )) { ?>
		<?php include(BOX_PATH .  'homeracentProductF.php'); ?>
	
	<?php }?>	
	
	<?php if(isset($data['racent_status_product']) && function_exists( 'is_woocommerce' )) { ?>
		<?php include(BOX_PATH .  'homeracentProduct.php'); ?>
	
	<?php }?>
	

	<div class="clear"> </div>
		
	
	<?php if($data['showadvertise']) { ?>

		<?php include(BOX_PATH . 'advertise.php'); ?>
		
	<?php }?>		

	<div class="clear"> </div>	

</div>
</div>


<?php get_footer(); ?>