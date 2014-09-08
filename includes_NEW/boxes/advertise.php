	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('.sliderAdvertise').bxSlider({
			controls: true,
			displaySlideQty: 6,
			moveSlideQty: 1,
			prevText : '',
			nextText : '',
			auto : true,
			easing : 'easeInOutQuint',
			pause : 6000
		});

		// Resize
		jQuery(window).resize(function(){

		$slider.reloadShow();

		});	  

		 });
	</script>
	
	<div class="advertise">
	<div class="title">
		<div class="titleborder"></div>
		<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_advertise_title']); } else {  _e('Our major brands','wp-emporium'); } ?></h2>
	</div>

		<?php 
		if(isset($data['advertiseimage'])){
			$slides = $data['advertiseimage']; ?>
			<ul class="sliderAdvertise">
			<?php foreach ($slides as $slide) {  ?>
				<li>
				<?php
				  if($slide['url'] != '') :
						   
					 if($slide['link'] != '') : ?>
					   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=130&amp;width=160"/></a>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=130&amp;width=160"/>
					<?php endif; ?>
							
				<?php endif; ?>
				</li>
			<?php } ?>
			</ul>
		<?php } ?>	
		
	</div>
	<!-- 
	/************back up*****
						   <a href="<?php// echo $slide['link']; ?>"><img src="<?php// echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $slide['url']; ?>&amp;h=130&amp;w=160"/></a>
						<img src="<?php //echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php //echo $slide['url']; ?>&amp;h=130&amp;w=160"/>

	
	-->
