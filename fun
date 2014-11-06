<?php
/*
Template Name: Full Width Page with Nivo slider
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
})
</script>	<div id = "page-template-slider">
<div id="nslider-wrapper">
	<div class="simple sliderNivo">
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
<!--	
/********back up*************/
                <img src="<?php// echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $slide['url']; ?>&amp;h=380&amp;w=940" title="<?php// echo stripText($slide['description']); ?>" />


-->
</div></div>
		

		
<div id="mainwrap">

	<div id="main" class="clearfix">

		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorderSingle"></div>
					<h1><?php the_title();?></h1>
					<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>
				<div class="infotextBorderSingle"></div>
			</div>
		</div>	

		<div class="content fullwidth nivo">
		
		
				<div class="postcontent">
					<div class="posttext">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						
						<div class="usercontent"><?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?></div>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
						<?php endwhile; endif; ?>
					</div>

	
				</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
