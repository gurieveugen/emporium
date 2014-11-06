<div id="mainwrap">
	<?php if (have_posts()) : while (have_posts()) : the_post();  $postmeta = get_post_custom($post->ID);  ?>
	<div id="main" class="clearfix">	
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorderSingle"></div>
					<h1><?php the_title();?></h1>
					<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>
				<div class="infotextBorderSingle"></div>
			</div>
		</div>	
	<div class="content singledefult">
		<div class="postcontent singledefult" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
			<div class="blogpost">		
				<div class="posttext">
				<?php if( !get_post_format()){?> 
				
				<?php } ?>
					<?php if ( !has_post_format( 'gallery' , $post->ID)) { ?>
						<div class="blogsingleimage">			
							<?php	
							if ( !get_post_format() ) {
								if ( has_post_thumbnail() ){
									$image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog', false);
									$image = $image[0];
									}
								else
									$image = get_template_directory_uri() . '/images/placeholder-580.png';
								
							?>
							<a href="<?php echo $image_full[0]; ?>" rel="lightbox[single-gallery]" title="<?php the_title(); ?>">
							<img src="<?php echo $image; ?>" /> 
								
							</a>
							<?php } ?>
							<?php if ( has_post_format( 'video' , $post->ID)) {?>
							
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
								?>
							<?php
							}
							?>							
							
							<div class="leftholder">
									<div class = "posted-date"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
								<div class="commentblog"><div class = "circleHolder"><div class = "comment-inside"><?php socialLinkCat(get_permalink(),get_the_title(),false) ?></div></div></div>
							</div>
							<?php if(has_post_format( 'video' , $post->ID)){ ?>
								<div class = "meta videoGallery">
							<?php } 
							
							else {?>
								<div class = "meta">
							<?php } ?>		
									<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <a href="https://plus.google.com/111513593421048693902?rel=author" target="_blank">Jerome Fryer</a><?php //the_author_posts_link(); ?></div>
									<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>							
										<?php   if(get_query_var('portfoliocategory')){ 
											echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
										} else {
											the_category(', '); 
										}?></div>
									

							</div>
							
						</div>
					<?php } else {?>
						<?php
						$args = array(
							'post_type' => 'attachment',
							'numberposts' => -1,
							'post_status' => null,
							'post_parent' => $post->ID
						);
						$attachments = get_posts($args);
						if ($attachments) {?>
						<div class="gallery-single">
						<?php
							foreach ($attachments as $attachment) {
								$title = '';
								//echo apply_filters('the_title', $attachment->post_title);
								$image =  wp_get_attachment_image_src( $attachment->ID, 'blog_thumb' ); 	
								$image_full =  wp_get_attachment_image_src( $attachment->ID, 'full' ); 	
								$alt = get_post_meta( $attachment->ID ,'_wp_attachment_image_alt', true);
								if(count($alt)) $title =  $alt; ?>
									<div class="image-gallery">
										<a href="<?php echo $image_full[0] ?>" rel="lightbox[single-gallery]" title="<?php echo $attachment->post_title ?>"><div class = "over"></div>
										<img src="<?php echo $image[0] ?>" />					
											<!--<img src="<?php echo $image[0] ?>" height="95" width="95" />		 -->			
										</a>	
									</div>			
									<?php } ?>
						</div>
						<?php } ?>
							<div class="leftholder">
									<div class = "posted-date"><div class = "date-inside"><a href="<?php 
									$arc_year = get_the_time('Y'); 
									$arc_month = get_the_time('m'); 
									$arc_day = get_the_time('d');
									echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><div class="day"><?php the_time('j') ?></div><div class="month"><?php the_time('M') ?></div> </a></div></div>
								<div class="commentblog"><div class = "circleHolder"><div class = "comment-inside"><?php socialLinkCat(get_permalink(),get_the_title(),false) ?></div></div></div>
							</div>
							<div class = "meta videoGallery">

									<div class="authorblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_by']); } else {  _e('By: ','wp-emporium'); } ?></strong> <?php the_author_posts_link(); ?></div>
								<div class="categoryblog"><strong><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_categories']); } else {  _e('Categories: ','wp-emporium'); } ?></strong>							
										<?php   if(get_query_var('portfoliocategory')){ 
											echo get_the_term_list( $post->ID, 'portfoliocategory', '', ', ', '' ); 
										} else {
											the_category(', '); 
										}?></div>
									

							</div>
					<?php }  ?>
					<div class="sentry">
						<?php if ( has_post_format( 'video' , $post->ID)) {?>
							<div><?php the_content(); ?></div>
						<?php
						}			
						if(has_post_format( 'gallery' , $post->ID)){?>
							<div class="gallery-content"><?php the_content(); 	?></div>
						<?php } 
						if( !get_post_format()){?> 
						    <?php add_filter('the_content', 'addlightboxrel_replace'); ?>
							<div><?php the_content(); ?></div>		
						<?php } ?>
						<div class="singleBorder"></div>
					</div>
				</div>
				
				<?php if(has_tag()) { ?>
					<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $tagsTR = stripText($data['translation_tags']); } else {  $tagsTR = __('Tags: ','wp-emporium'); } ?>
					<div class="tags"><?php the_tags($tagsTR,', ',''); ?></div>	
				<?php } ?>
					

				
			</div>						
			
		</div>		
		<?php
		$posttags = wp_get_post_tags($post->ID, array( 'fields' => 'ids' ));
		$query = new WP_Query(
			array( "tag__in" => $posttags,
				   "orderby" => 'rand',
				   "showposts" => 3,
				   "post__not_in" => array($post->ID)
			) );
		if ($query->have_posts()) : ?>
			<div class="relatedtitle">
				<h3><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['translation_relatedpost']); } else {  _e('Related post','wp-emporium'); } ?></h3>
			</div>
			<div class="related">	
			
			<?php
			$count = 0;
			while ($query->have_posts()) : $query->the_post(); 
				if ( has_post_thumbnail() ){
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog_thumb', false);
					$image = $image[0];
					}
				else
					$image =  get_template_directory_uri() .'/images/placeholder-580.png';
					
				if($count != 2){ ?>
					<div class="one_third">
				<?php } else { ?>
					<div class="one_third last">
				<?php } ?>
				<!--<img src="<?php// echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php// echo $image ?>&amp;h=83&amp;w=146"> -->
						<div class="image"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo $image ?>"></a></div>
						<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h4>			
					</div>
						
				<?php 
				$count++;
			endwhile; ?>
			</div>
		<?php endif;
		wp_reset_query();?>	
	
	
	<?php comments_template(); ?>
					
	<?php endwhile; else: ?>
					
		<?php include_once(TEMPLATEPATH."/404.php"); ?>
					
	<?php endif; ?>
	</div>

	<div class="sidebar">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('blog-sidebar') ) : ?>
    <?php endif; ?>
  </div>
</div>
