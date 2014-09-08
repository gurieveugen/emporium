<?php get_header(); 

?>

<script type="text/javascript">
jQuery(document).ready(function($){
	    $('.slider').anythingSlider({
		hashTags : false,
		expand		: true,
		autoPlay	: true,
		resizeContents  : false,
		pauseOnHover    : true,
		buildArrows     : false,
		buildNavigation : false,
		delay		: 4000,
		resumeDelay	: 0,
		animationTime	: 800,
		delayBeforeAnimate:0,	
		easing : 'easeInOutQuint',
	    })


	});
	
</script>	
<div id="mainwrap">

	<div id="main" class="clearfix">
	
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorder"></div>
				<h2><?php echo  translation('translation_blog_page', 'Welcome to <span>our blog</span>, we will keep you informed'); ?></h2>
				<div class="infotextBorder"></div>
			</div>
		</div>

		<div class="pad"></div>	
					
			<div class="content blog">
						
				<?php if (have_posts()) : ?>
				
				<?php while (have_posts()) : the_post();
				$postmeta = get_post_custom($post->ID); 
				if ( has_post_format( 'gallery' , $post->ID)) { 
				?>
				<div class="slider-category">
				
					<div class="blogpostcategory">
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
						<div id="slider-category" class="slider-category">
							<ul id="slider" class="slider">
								<?php
									foreach ($attachments as $attachment) {
										$image =  wp_get_attachment_image_src( $attachment->ID, 'full' ); ?>	
											<li>
											<div class="slider-item">
												<img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $image[0] ?>&amp;height=280&amp;width=580" />					
													
											</div>			
											</li>
											<?php } ?>
							</ul>
							
						</div>
				  <?php } else { 
				  $image = get_template_directory_uri() .'/images/placeholder-580-gallery.png'; ?>
				  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $image ?>&amp;height=280&amp;width=580" alt="<?php the_title(); ?>"></a>
				  <?php }?>
						<div class="entry">
							
							<div class="leftholder">
									<div class = "posted-date"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
								<div class="commentblog"><div class = "circleHolder"><div class = "comment-inside"><?php socialLinkCat(get_permalink(),get_the_title(),false) ?></div></div></div>
							</div>
							<div class = "meta">
									
									<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <?php the_author_posts_link(); ?></div>
									<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>							
											<?php   if(get_query_var('portfoliocategory')){ 
												echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
											} else {
												the_category(', '); 
											}?></div>
									<div class="blogcontent"><?php echo shortcontent('[', ']', '', $post->post_content ,300);?> ...</div>
									<a class="blogmore" href="<?php the_permalink() ?>"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_morelink']); } else {  _e('Read more','wp-emporium'); } ?> &rarr;</a>

							</div>
							
						</div>	
					</div>
				</div>
				<?php } 
				if ( has_post_format( 'video' , $post->ID)) { ?>
				<div class="slider-category">
				
					<div class="blogpostcategory">
					<div class="loading"></div>
					<?php
					
					if(!empty($postmeta["video_post_url"][0])) {?>
					<?php  
						if ($postmeta["selectv"][0] == 'vimeo')  
						{  
							echo '<iframe src="http://player.vimeo.com/video/'.$postmeta["video_post_url"][0].'" width="580" height="280" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';  
						}  
						else if ($postmeta["selectv"][0] == 'youtube')  
						{  
							echo '<iframe width="580" height="280" src="http://www.youtube.com/embed/'.$postmeta["video_post_url"][0].'" frameborder="0" allowfullscreen></iframe>';  
						}  
						else  
						{  
							echo 'Please select a Video Site via the WordPress Admin';  
							}  
					}
					else{ 
						  $image = get_template_directory_uri() .'/images/placeholder-580-video.png'; ?>
						  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $image ?>&amp;height=280&amp;width=580" alt="<?php the_title(); ?>"></a>
						
					<?php } ?>
						<div class="entry">
							
							<div class="leftholder">
								<div class = "posted-date"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
								<div class="commentblog"><div class = "circleHolder"><div class = "comment-inside"><?php socialLinkCat(get_permalink(),get_the_title(),false) ?></div></div></div>
							</div>
							<div class = "meta">
									
									<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <?php the_author_posts_link(); ?></div>
									<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>						
											<?php   if(get_query_var('portfoliocategory')){ 
												echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
											} else {
												the_category(', '); 
											}?></div>
									<div class="blogcontent"><?php echo shortcontent('[', ']', '', $post->post_content ,300);?> ...</div>
									<a class="blogmore" href="<?php the_permalink() ?>"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_morelink']); } else {  _e('Read more','wp-emporium'); } ?> &rarr;</a>

							</div>
							
						</div>	
					</div>
				</div>
				<?php } 
				if ( has_post_format( 'link' , $post->ID)) {?>
				<div class="link-category">
					<div class="blogpostcategory">
					<span><?php echo the_content(); ?> </span>


					<div class="entry">
						
						<div class="leftholder">
								<div class = "posted-date link"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
							<div class="commentblog"></div>
						</div>
						<div class = "meta">
								
								<h2 class="title"><a href="<?php echo $postmeta["link_post_url"][0]  ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <?php the_author_posts_link(); ?></div>
									<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>							
										<?php   if(get_query_var('portfoliocategory')){ 
											echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
										} else {
											the_category(', '); 
										}?></div>
								<a class="blogmore" href="<?php echo $postmeta["link_post_url"][0]  ?>"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_morelink']); } else {  _e('Read more','wp-emporium'); } ?> &rarr;</a>

						</div>
						
					</div>	
						
					</div>
				</div>
				
				<?php 
				} 				
				if ( !get_post_format() ) {?>
						
				<div class="blogpostcategory">
																
						<a class="overdefultlink" href="<?php the_permalink() ?>">
						<div class="overdefult">
						</div>
						</a>
						
						<div class="blogimage">	
									
							<?php	
								if ( has_post_thumbnail() ){
									$image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog', false);
									$image = $image[0];
									}
								else
									$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
							?>
							
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>"></a>
						</div>
						
						<div class="entry">
							
							<div class="leftholder">
								<div class = "posted-date"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
								<div class="commentblog"><div class = "circleHolder"><div class = "comment-inside"><?php socialLinkCat(get_permalink(),get_the_title(),false) ?></div></div></div>
							</div>
							<div class = "meta">
									
									<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <?php the_author_posts_link(); ?></div>
									<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>							
											<?php   if(get_query_var('portfoliocategory')){ 
												echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
											} else {
												the_category(', '); 
											}?></div>
									<div class="blogcontent"><?php echo shortcontent('[', ']', '', $post->post_content ,300);?> ...</div>
									<a class="blogmore" href="<?php the_permalink() ?>"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_morelink']); } else {  _e('Read more','wp-emporium'); } ?> &rarr;</a>

							</div>
							
						</div>		
				</div>	
				<?php } ?>		
					<?php endwhile; ?>
					
						<?php
						
							include('includes/wp-pagenavi.php');
							if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						?>
						
						<?php else : ?>
						
							<div class="postcontent">
								<h1><?php echo $data['errorpagetitle'] ?></h1>
								<div class="posttext">
									<?php echo $data['errorpage'] ?>
								</div>
							</div>
							
						<?php endif; ?>
					
			</div>
		
					<div class="sidebar">	
		
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('blog-sidebar') ) : ?>
            <?php endif; ?>
			
					</div>

	</div>
	
</div>				
							
<?php get_footer(); ?>
