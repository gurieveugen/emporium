<?php
/*
Template Name: Full Width Page with Full Slider
*/
?>

<?php get_header(); ?>

<script type="text/javascript">
jQuery(document).ready(function($){
if ($.browser.msie && $.browser.version.substr(0,1)<9 && $.browser.version.substr(0,2)!=10) {

	    $('#slider').anythingSlider({
		hashTags : false,
		expand		: true,
		autoPlay	: true,
		resizeContents  : false,
		pauseOnHover    : true,
		buildArrows     : false,
		buildNavigation : false,
		delay		: <?php if(isset($data['pausetime'] )) echo $data['pausetime']; else echo '3000';?>,
		resumeDelay	: 0,
		animationTime	: <?php if(isset($data['anispeed'] )) echo $data['anispeed']; else echo '500'; ?>,
		delayBeforeAnimate:0,	
		easing : 'easeInOutQuint'
		
	
	    })
		
 }
  else{
 	    $('#slider').anythingSlider({
		hashTags : false,
		expand		: true,
		autoPlay	: true,
		resizeContents  : false,
		pauseOnHover    : true,
		buildArrows     : false,
		buildNavigation : false,
		delay		: <?php if(isset($data['pausetime'] )) echo $data['pausetime']; else echo '3000'; ?>,
		resumeDelay	: 0,
		animationTime	: <?php if(isset($data['anispeed'] )) echo $data['anispeed']; else echo '500'; ?>,
		delayBeforeAnimate:0,	
		easing : 'easeInOutQuint',		
		onBeforeInitialize   : function(e, slider) {
			$('.textSlide h1, .textSlide li, .textSlide img, .textSlide h2, .textSlide li.button').css('opacity','0'); 
			
		},
		
		onSlideBegin    : function(e, slider) {
		
		},
		onSlideComplete    : function(slider) {

			 $('.textSlide li.top,.textSlide li.top1,.textSlide li.top2,.textSlide li.top3,.textSlide li.bounceBall1, .textSlide li.bounceBall2, .textSlide li.bounceBall3, .textSlide li.bounceBall4,.textSlide li.bounceBall5,.textSlide li.bounceBall6').css('top','-900px');
		}
		
	
	    })
		
  .anythingSliderFx({ 
  
   // base FX definitions can be mixed and matched in here too. 
   '.fade' : [ 'fade' ], 

   // for more precise control, use the "inFx" and "outFx" definitions 
   // inFx = the animation that occurs when you slide "in" to a panel 
   inFx : { 
    '.textSlide h1'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' }, 
	'.textSlide h2'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' },
	'.textSlide li.object1'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' }, 
    '.textSlide li.left, .textSlide li.right'  : { opacity: 1, left : 0,  duration: 2000 ,easing : 'easeOutQuint'},
    '.textSlide li.top' : { opacity: 1,  top : 0,  duration: 1500 ,easing : 'easeOutQuint'}	,
    '.textSlide li.top1' : { opacity: 1,  top : 0, duration: 1500 ,  easing : 'easeOutQuint'}	,
    '.textSlide li.top2' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,
    '.textSlide li.top3' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,	
	'.textSlide li.top4' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,
	'.textSlide li.bottom'  : { opacity: 1,  bottom : 0, duration: 3000 ,easing : 'easeOutQuint'}	,	
	'.textSlide li.bottom2'  : { opacity: 1,  top : 0, duration: 2500 ,easing : 'easeOutQuint'}	,
	'.textSlide li.button'  : { opacity: 1,  top : 0, duration: 0,easing : 'easeOutQuint'}	,
	'.textSlide li.salePrice1'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
	'.textSlide li.salePrice2'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
	'.textSlide li.salePrice3'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
	'.textSlide li.bounceBall1'  : { opacity: 1,  top : 0, duration: 3100,easing : 'easeOutBounce'}	,
	'.textSlide li.bounceBall2'  : { opacity: 1,  top : 0, duration: 2800,easing : 'easeOutBounce'}	,
	'.textSlide li.bounceBall3'  : { opacity: 1,  top : 0, duration: 3500,easing : 'easeOutBounce'}	,
	'.textSlide li.bounceBall4'  : { opacity: 1,  top : 0, duration: 2200,easing : 'easeOutBounce'}	,
	'.textSlide li.bounceBall5'  : { opacity: 1,  top : 0, duration: 1900,easing : 'easeOutBounce'}	,
	'.textSlide li.bounceBall6'  : { opacity: 1,  top : 0, duration: 2700,easing : 'easeOutBounce'}	,
	'.textSlide li.quote'  : { opacity: 1,  top : 0, duration: 5600 ,easing : 'easeOutQuad'}
   }, 
   // out = the animation that occurs when you slide "out" of a panel 
   // (it also occurs before the "in" animation) 
   outFx : { 
    '.textSlide h1'      : { opacity: 0, top  : '0px', duration: 500 }, 
	'.textSlide li.object1'      : { opacity: 0, top  : '0px', duration: 500 }, 
    '.textSlide li.right'  : { opacity: 0, left : '0px', duration: 0 }, 
    '.textSlide li.left' : { opacity: 0, left : '0px',  duration: 0 },
    '.textSlide li.bottom' : { opacity: 0, top : '0px',  duration: 0 },
	'.textSlide li.bottom2' : { opacity: 0, top : '0px',  duration: 0 },
	'.textSlide li.top1' : { opacity: 0, top : '-900px',  duration: 1000},
	'.textSlide li.top2' : { opacity: 0, top : '-900px',  duration: 2200},
	'.textSlide li.top3' : { opacity: 0, top : '-900px',  duration: 3400},
	'.textSlide li.top4' : { opacity: 0, top : '-900px',  duration: 4600},
	 '.textSlide li.button' : { opacity: 0, top : '0px',  duration: 0 },
	 '.textSlide li.salePrice1' : { opacity: 0, top : '500px',  duration: 5000 },
	 '.textSlide li.salePrice2' : { opacity: 0, top : '500px',  duration: 5250 },
	 '.textSlide li.salePrice3' : { opacity: 0, top : '500px',  duration: 5500 },
	  '.textSlide li.quote' : { opacity: 0, top : '700px',  duration: 350 },
    '.textSlide img' : { opacity: 1, top : '0px',  duration: 600 },
   
   }
  
  }); 
  
  }
 
	    $(".slideforward").click(function(){
		$('#slider').data('AnythingSlider').goForward();
	    });
	    $(".slidebackward").click(function(){
		$('#slider').data('AnythingSlider').goBack();
	    });  
});
	
</script>	
	
<?php $slides = $data['demo_slider']; //get the slides array?>

<div id="slider-wrapper">
<div class="loading"></div>	
<div id="slider">

<?php 
$i = 0;
if(!empty($slides)){
foreach ($slides as $slide) { ?>
<div>
	
	<div class="panel-<?php echo $i ?>">

					
						<?php if (empty ($slide['video'])) { ?>
							<?php if(!empty($slide['url'])){ ?>
								<div class="images">
									<?php if (!empty ($slide['link'])) { ?>

										<a href="<?php echo $slide['link']; ?>" title="">
											
											<img width="" class="check"  src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=500&amp;width="  alt="<?php echo htmlspecialchars(stripslashes($slide['title'])); ?> "/>
										</a>
									
									<?php } else { ?>
										<img width="" class="check" src="<?php echo get_template_directory_uri() ?>/createthumb.php?path=<?php echo $slide['url']; ?>&amp;height=500&amp;width=" alt="<?php echo htmlspecialchars(stripslashes($slide['title'])); ?>" />	
			
									<?php } ?>

										<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

										<?php echo stripText($slide['description']); ?>	
										<div class="prevbutton slidebackward"></div>
										<div class="nextbutton slideforward"></div>											
										
										</div>
								</div>
							<?php } else { ?>
								<div class="images">
									<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

										<?php echo stripText($slide['description']); ?>	
										<div class="prevbutton slidebackward"></div>
										<div class="nextbutton slideforward"></div>											
										
									</div>
								</div>
							<?php } ?>
						<?php } else {?>
							<div id="slider-wrapper-iframe">
								<?php if(strpos($slide['video'], 'vimeo')){	?>
									<div class="iframes">
										<iframe src="<?php echo $slide['video'] ?>" width="550" height="320" frameborder="0"></iframe>
		
										<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

										<?php echo stripText($slide['description']); ?>	

										<div class="prevbutton slidebackward"></div>
										<div class="nextbutton slideforward"></div>												
										
										</div>
									</div>
								<?php } else { ?>
									<div class="iframes">
										<iframe src="<?php echo $slide['video'] ?>" width="550" height="320" rel="youtube" frameborder="0"></iframe>
											
										test3<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

										<?php echo stripText($slide['description']); ?>	
										
										<div class="prevbutton slidebackward"></div>
										<div class="nextbutton slideforward"></div>										
										
										</div>
									</div>								
								<?php } ?>
							</div>
							<?php } ?>
						
		</div>
</div>
<?php 
$i++;
} }?>
</div>


		
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


		<div class="content fullwidth">

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
