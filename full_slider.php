<?php
/*
Template Name: Home with Full Slider
*/
?>
<?php get_header(); ?>
<?php 
	wp_register_script('pmc_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js?domready=1', array(
		'jquery'
	), true);  
	wp_enqueue_script('pmc_addthis');
?>
<script src="<?php bloginfo('template_url'); ?>/js/full_slider_slider.js" ></script>
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
                    <img width="" height="500" class="check"  src="<?php echo $slide['url']; ?>"  alt="<?php echo htmlspecialchars(stripslashes($slide['title'])); ?> "/>
                </a>
                <?php } else { ?>
                <img width=""  height="500" class="check" src="<?php echo $slide['url']; ?>" alt="<?php echo htmlspecialchars(stripslashes($slide['title'])); ?>" />
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
                <iframe src="<?php echo $slide['video'] ?>" width="940" height="445" frameborder="0"></iframe>
                <div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">
                    <?php echo stripText($slide['description']); ?>
                    <div class="prevbutton slidebackward"></div>
                    <div class="nextbutton slideforward"></div>
                </div>
            </div>
            <?php } else { ?>
            <div class="iframes">
                <iframe src="<?php echo $slide['video'] ?>" width="940" height="445" rel="youtube" frameborder="0"></iframe>
                <div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">
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
</div>
<div id="mainwrap" class="homewrap">
<div id="main" class="clearfix">
	<?php if(isset($data['infotext_status'])) { ?>
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotextBorder"></div>
				<h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { /*echo stripText($data['infotext']);*/ } else {  _e('Welcome to <span>emporium</span> - A Minimal Business Theme','wp-emporium'); } ?></h2>
				<?php if(isset($data['quote_bottom_border'])) { ?>				
					<div class="infotextBorder"></div>
				<?php }?>	
			</div>
		</div>
	<?php }?>
	<div class="clear"></div>
	<?php if(isset($data['box_status'])) { ?>
		<?php include(BOX_PATH .  'homebox.php'); ?>
	<?php }?>
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
	<?php if(isset($data['racent_status_port'])) { ?>
		<?php include(BOX_PATH . 'homeracentPort.php'); ?>
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
		<?php include(BOX_PATH . 'advertise.php'); ?>
	<?php }?>
	<div class="clear"> </div>
</div>
</div>
<?php get_footer(); ?>
