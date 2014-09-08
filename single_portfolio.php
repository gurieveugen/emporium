
<script type="text/javascript">
jQuery(document).ready(function($){
	    $('#slider').anythingSlider({
		hashTags : false,
		expand		: true,
		autoPlay	: true,
		resizeContents  : false,
		pauseOnHover    : true,
		buildArrows     : false,
		buildNavigation : false,
		delay		: <?php echo $data['pausetime'] ?>,
		resumeDelay	: 0,
		animationTime	: <?php echo $data['anispeed'] ?>,
		delayBeforeAnimate:0,	
		easing : 'easeInOutQuint',
		onSlideBegin    : function(e, slider) {
				$('.nextbutton').fadeOut();
				$('.prevbutton').fadeOut();
		
		},
		onSlideComplete    : function(slider) {
			$('.nextbutton').fadeIn();
			$('.prevbutton').fadeIn();
		
		}		
	    })

	    
	    $('.blogsingleimage').hover(function() {
		$(".slideforward").stop(true, true).fadeIn();
		$(".slidebackward").stop(true, true).fadeIn();
	    }, function() {
		$(".slideforward").fadeOut();
		$(".slidebackward").fadeOut();
	    });
	    $(".pauseButton").toggle(function(){
		$(this).attr("class", "playButton");
		$('#slider').data('AnythingSlider').startStop(false); // stops the slideshow
	    },function(){
		$(this).attr("class", "pauseButton");
		$('#slider').data('AnythingSlider').startStop(true);  // start the slideshow
	    });
	    $(".slideforward").click(function(){
		$('#slider').data('AnythingSlider').goForward();
	    });
	    $(".slidebackward").click(function(){
		$('#slider').data('AnythingSlider').goBack();
	    });  
	});
	
</script>	

<div id="mainwrap">
	<div id="main" class="clearfix portsingle">
	<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorderSingle"></div>
					<h1><?php the_title();?></h1>
					<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>
				<div class="infotextBorderSingle"></div>
			</div>
		</div>	
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php  $portfolio = get_post_custom($post->ID); ?>

	<div class="pad"></div>
	<div class="content fullwidth">

		<div class="blogpost postcontent port" >
			<div class="projectdetails">	
					<div class="blogsingleimage">	
					<?php 
						$args = array(
							'post_type' => 'attachment',
							'numberposts' => null,
							'post_status' => null,
							'post_parent' => $post->ID,
							'orderby' => 'menu_order ID',
						);
						$attachments = get_posts($args);
						if ($attachments) {?>
							<div id="slider" class="slider">
									<?php
										$i = 0;
										foreach ($attachments as $attachment) {
											//echo apply_filters('the_title', $attachment->post_title);
											$image =  wp_get_attachment_image_src( $attachment->ID, 'full' ); ?>	
												<div>
	<!--<img class="check" src="<?php// echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php //echo $image[0] ?>&amp;w=610" />-->				
													<img class="check" src="<?php echo $image[0] ?>" width="610" />				
															
												</div>
												
												<?php 
												$i++;
												} ?>
						
								
							</div>
							<?php if($i > 1){ ?>
						    <div class="prevbutton slidebackward port"></div>
							<div class="nextbutton slideforward port"></div>
							<?php } ?>
						  <?php } else { 
							$image_name = 'feature-image-2';  // sets image name as feature-image-1, feature-image-2 etc.
							if (MultiPostThumbnails::has_post_thumbnail('portfolioentry', $image_name)) {
								$image_id = MultiPostThumbnails::get_post_thumbnail_id( 'portfolioentry', $image_name, $post->ID );  // use the MultiPostThumbnails to get the image ID
								$image_feature_url = wp_get_attachment_image_src( $image_id,'feature-image' ); // define full size src based on image ID
								$image = $image_feature_url[0];
							}
							else{
								$image = get_template_directory_uri() . '/images/placeholder-port.png';
							}?>
							<!--<img src="<?php// echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $image ?>&amp;w=610" /> -->
							<a href="<?php echo $image ?>" rel="lightbox[port]" title="<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $image ?>&amp;width=610" /></a>
						  <?php } ?>
					
					</div>	
			</div>
			<div class="projectdescription">
				<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_details']); } else {  _e('Project details:','wp-emporium'); } ?></h2>
				<div class="datecomment">
					<p>
						<?php if($portfolio['detail_active'][0]) {
							if($portfolio['detail_active'][0]) { ?>
							  <?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_url']); } else {  _e('Project URL:','wp-emporium'); } ?> <span class="link"><a target="_blank" href="http://<?php echo $portfolio['website_url'][0] ?>" title="project url"><?php echo $portfolio['website_url'][0] ?></a></span>  </br>
						<?php } else { ?>
							   <?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_url']); } else {  _e('Project URL:','wp-emporium'); } ?> <span class="link"><a title="project url"><?php echo $portfolio['website_url'][0] ?></a></span> 
						<?php }  ?>	
						<?php } ?>
						<?php if($portfolio['author'][0] !='') {?>
							<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_designer']); } else {  _e('Project designer:','wp-emporium'); } ?> <span class="authorp port"><?php echo $portfolio['author'][0] ?></span><br>
						<?php } ?>
						<?php if($portfolio['date'][0] !='') {?>
							<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_date']); } else {  _e('Date of completion:','wp-emporium'); } ?> <span class="posted-date port"><?php echo $portfolio['date'][0] ?></span><br>
						<?php } ?>
						<?php if($portfolio['customer'][0] !='') {?>
							<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_client']); } else {  _e('Client:','wp-emporium'); } ?> <span class="author port"><?php echo $portfolio['customer'][0] ?></span><br>
						<?php } ?>								
					</p>
					<div class="titleborder"></div>		
				</div>	
						
				<div class="posttext"> 
						<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_description']); } else {  _e('Project description:','wp-emporium'); } ?></h2>
						<div> <?php  the_content(); ?> </div>	
						<div class="titleborder"></div>	
				</div>
				
				<h2 class="portsingleshare"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_share']); } else {  _e('Share the <span>project</span>','wp-emporium'); } ?></h2>	
				
				<div class="socialsingle"><?php socialLinkSingle() ?></div>	
				<div class = "portnavigation">
					<div class="portprev"><span title="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $next =  stripText($data['translation_next_project']); } else {  $next = __('Next project','wp-emporium'); } echo $next; ?>"><?php previous_post_link('%link', $next ,false,''); ?> </span></div>				
					<div class="portnext"><span title="<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $prev =  stripText($data['translation_previus_project']); } else {  $prev = __('Previous project','wp-emporium'); } echo $prev; ?>"><?php next_post_link('%link',$prev,false,''); ?> </span></div>
				</div>
			</div>
				
			</div>						
	</div>	

	
					
	<?php endwhile; else: ?>
	
	<?php endif; ?>
		<div class="portfolio">		
			<h3><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['port_project_related']); } else {  _e('Related <span>project</span>','wp-emporium'); } ?></h3>	
			<div class="titleborder"></div>		
			<div id="portitems4">
				<?php portfolio(135,233,4,'port',8,substr($cat_slug,0,-1)) ?>	
				
			</div>

		</div>	
	</div>

</div>


