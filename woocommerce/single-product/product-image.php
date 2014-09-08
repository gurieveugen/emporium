<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $woocommerce, $data;
$postmeta = get_post_custom($post->ID);
?>

<div class="imagesSPAll">

	<div class="images imagesSP">	
	<script type="text/javascript">
	jQuery(document).ready(function($){
			$('.slider.product').anythingSlider({
			hashTags : false,
			expand		: true,
			autoPlay	: false,
			resizeContents  : false,
			pauseOnHover    : true,
			buildArrows     : false,
			buildNavigation : false,
			delay		: <?php if(isset($data['pausetime'] )) echo $data['pausetime']; else echo '3000'; ?>,
			resumeDelay	: 0,
			animationTime	: <?php if(isset($data['anispeed'] )) echo $data['anispeed']; else echo '500'; ?>,
			delayBeforeAnimate:0,	
			easing : 'easeInOutQuint',	
			 onShowStart       : function(e, slider) {	$('.nextbutton').fadeIn();
				$('.prevbutton').fadeIn();},
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
			$(".slideforward").click(function(){
			$('#slider').data('AnythingSlider').goForward();
			});
			$(".slidebackward").click(function(){
			$('#slider').data('AnythingSlider').goBack();
			});  
		});    
         
		
	</script>		
		<?php
		$args = array(
			'post_type' => 'attachment',
			'post_parent' => $post->ID,
			'numberposts'     => 9999
		);
		$attachments = get_posts($args);
		if ($attachments) {?>
			<div class="loading"></div>
			<div id="slider" class="slider product">
					<?php 
					$i = 0;
					if(isset($postmeta["video_active"][0]) && $postmeta["video_active"][0] == 1) { 
					$i++;?>
						<div class="video-holder">
						<?php
						
							if ($postmeta["selectv"][0] == 'vimeo')  
							{  
								echo '<iframe class = "productIframe productSP" src="http://player.vimeo.com/video/'.$postmeta["video_post_url"][0].'" width="404" height="345" frameborder="0" ></iframe>';  
							}  
							else if ($postmeta["selectv"][0] == 'youtube')  
							{
								/*echo '<iframe class = "productIframe productSP youtube"  width="404" height="345" src="http://www.youtube.com/embed/'.$postmeta["video_post_url"][0].'?rel=0" frameborder="0" ></iframe>';*/
                                echo '<iframe class = "productIframe productSP youtube" width="404" height="345" src="//www.youtube.com/embed/'.$postmeta["video_post_url"][0].'?rel=0" frameborder="0" allowfullscreen></iframe>';  
							}  
							else  
							{  
								//echo 'Please select a Video Site via the WordPress Admin';  
							} 

						?>
						</div>						
					<?php } ?>
					<?php
						foreach ($attachments as $attachment) {
						
							//echo apply_filters('the_title', $attachment->post_title);
							$image =  wp_get_attachment_image_src( $attachment->ID, 'product_full' );
              $image_full = wp_get_attachment_image_src( $attachment->ID, 'full' ); 
					?>
								<div class="image-panel">
									<a href = "<?php echo $image_full[0] ?>" title="<?php echo esc_attr( $attachment->post_title ) ?>" rel="lightbox" ><img class="check" src="<?php echo $image[0] ?>" /></a>				
											
								</div>
								
								<?php 
								$i++;
								} ?>
		
				
			</div>
			<?php if($i > 1 ) { ?>
			<div class="navigationSP">
				<div class="prevbutton slidebackward port"></div>
				<div class="nextbutton slideforward port"></div>
			</div>	
			<?php } ?>
			<?php } else if ( has_post_thumbnail() ) { 
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
				<a href = "<?php echo $large_image_url[0] ?>" title="<?php echo esc_attr( $attachment->post_title ) ?>" rel ="lightbox[product-gallery-2]" ><img class="check" src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $large_image_url[0] ?>&amp;width=404&amp;height=345" /></a>				
				<?php
			} else { ?>
			
			<img src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo woocommerce_placeholder_img_src(); ?>&amp;width=460&amp;height=335" alt="Placeholder" />
			 
			<?php } ?>

	</div>
	<div class="thumbnails">
			<?php if(isset($postmeta["video_active"][0]) && $postmeta["video_active"][0] == 1) { ?>
				<?php
					if ($postmeta["selectv"][0] == 'vimeo')  
					{  
						echo '<a class="thumbSP" href="http://vimeo.com/'.$postmeta["video_post_url"][0].'" rel="lightbox" title="'.esc_attr( $attachment->post_title ).'"><img class="videoImage" src="'. getVimeoThumb($postmeta["video_post_url"][0]) .'" alt="" /></a>';  
					}  
					else if ($postmeta["selectv"][0] == 'youtube')  
					{  
						echo '<a  class="thumbSP" href="http://www.youtube.com/watch?v='.$postmeta["video_post_url"][0].'&rel=0" rel="lightbox[productLightBox]" title="'.esc_attr( $attachment->post_title ).'"><img class="videoImage"  src="http://img.youtube.com/vi/'. $postmeta["video_post_url"][0] .'/0.jpg" alt="" /></a>';  					
					}  
					else  
					{  
						//echo 'Please select a Video Site via the WordPress Admin';  
					} 				
				?>

			<?php } ?>
		<?php if ($attachments) {

			foreach ( $attachments as $key => $attachment ) {
			
				$image =  wp_get_attachment_image_src( $attachment->ID, 'carousel_thumb' ); 
				$image_full = wp_get_attachment_image_src( $attachment->ID, 'full' ); 
				//$image = get_template_directory_uri() .'/js/timthumb.php?src='.  $image[0] .'&amp;w=82&amp;h=82';
				//$image = get_template_directory_uri() .'/createthumb.php?path='.  $image[0] .'&amp;width=82&amp;height=82';

				printf( '<a href="%s" title="%s" rel="lightbox[productLightBox]" class="thumbSP"><img src="%s" ></a>', $image_full[0], esc_attr( $attachment->post_title ), $image[0] );

			}

		}
	?></div>
</div>	
