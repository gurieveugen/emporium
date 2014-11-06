<?php
/*
Template Name: Home with Nivo Slider
*/
?>

<?php get_header(); ?>


<script type="text/javascript">
jQuery(document).ready(function () {
jQuery('#nslider').nivoSlider({
		effect:'<?php if(isset($data['effect'] )) echo $data['effect']; else echo 'fade'; ?>', // Specify sets like: 'fold,fade,sliceDown'
        slices: <?php if(isset($data['slices'] )) echo $data['slices']; else echo '8'; ?>   , // For slice animations
        boxCols: <?php if(isset($data['boxcols'] )) echo $data['boxcols']; else echo '5'; ?>  , // For box animations
        boxRows: <?php if(isset($data['boxrows'] )) echo $data['boxrows']; else echo '500'; ?>  , // For box animations
        animSpeed:<?php if(isset($data['anispeed'] )) echo $data['anispeed']; else echo '500'; ?>, // Slide transition speed
        pauseTime:<?php if(isset($data['pausetime'] )) echo $data['pausetime']; else echo '3000'; ?>, // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav:true, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
		controlNav:false, // 1,2,3... navigation
		pauseOnHover:false,
		startSlide: 0,
		controlNavThumbs: false,
		controlNavThumbsFromRel: false,
		controlNavThumbsSearch: '',
		controlNavThumbsReplace: '',
		captionOpacity:1 
    });
});	
</script>	
<div id="nslider-wrapper">
	<div class="sliderNivo">
	<div id="nslider" class="nivoSlider">
	
	<?php 
	if(isset($data['nivo_slider'])){
		$slides = $data['nivo_slider']; 
		if(!empty($slides)){
		foreach ($slides as $slide) { 
	
          if($slide['url'] != '') :
                   
             if($slide['link'] != '') : ?>
   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=380&amp;width=940" title="<?php echo stripText($slide['description']); ?>" /></a>
            <?php else: ?>
	<img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=380&amp;width=940" title="<?php echo stripText($slide['description']); ?>" />
            <?php endif; ?>
                    
        <?php endif; ?>
	<?php } }}?>
</div></div>
	
</div>

	<div class="clear"></div>
	
	<div id="mainwrap" class="homewrap">

		<div id="main" class="clearfix">

			<?php if(isset($data['infotext_status'])) { ?>
				<div class="infotextwrap">
					<div class="infotext">
						<div class="infotextBorder"></div>
						<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['infotext']); } else {  _e('Welcome to <span>emporium</span> - A Minimal Business Theme','wp-emporium'); } ?></h2>
						<?php if(isset($data['quote_bottom_border'])) { ?>				
							<div class="infotextBorder"></div>
						<?php }?>	
					</div>
				</div>
			<?php }?>
			
			<div class="clear"></div>
			
			<?php if(isset($data['box_status'])) { ?>

				<?php include('includes/boxes/homebox.php'); ?>
				
			<?php }?>				
			
			<div class="clear"></div>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			
			<div class="usercontent homeuser"><?php the_content(); ?></div>
			
			
			<?php endwhile; endif; ?>
			
			
			<div class="clear"></div>		

			<?php if(isset($data['racent_status_productF']) && function_exists( 'is_woocommerce' )) { ?>
				<?php include('includes/boxes/homeracentProductF.php'); ?>
			
			<?php }?>	
			
			<?php if(isset($data['racent_status_product']) && function_exists( 'is_woocommerce' )) { ?>
				<?php include('includes/boxes/homeracentProduct.php'); ?>
			
			<?php }?>			

			<?php if(isset($data['racent_status_port'])) { ?>
				<?php include('includes/boxes/homeracentPort.php'); ?>
			
			<?php }?>
			
			<?php if(isset($data['racent_status'])) { ?>
			
				<?php 
				if(isset($data['hoemrecentdesign'])) {
					if($data['hoemrecentdesign'] == 1) 
						include(BOX_PATH . 'homeracentPost.php'); 
					else
						include(BOX_PATH . 'homeracentPostPortDesign.php'); 
				}
				?>
			
			<?php }?>	

			<div class="clear"> </div>
			
			<?php if(isset($data['showadvertise'])) { ?>

				<?php include('includes/boxes/advertise.php'); ?>
				
			<?php }?>		

			<div class="clear"> </div>	

		</div>
	</div>


<?php get_footer(); ?>
<!-- 
/***************back up***************
   <a href="<?php //echo $slide['link']; ?>"><img src="<?php //echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $slide['url']; ?>&amp;h=380&amp;w=940" title="<?php// echo stripText($slide['description']); ?>" /></a>

	<img src="<?php //echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $slide['url']; ?>&amp;h=380&amp;w=940" title="<?php// echo stripText($slide['description']); ?>" />



-->

