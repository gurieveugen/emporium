<?php
/*
Template Name: Page with sidebar
*/
?>

<?php get_header(); ?>

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


		<div class="content pagesidebar sidebarWoo">
				<div class="postcontent">
					<div class="posttext">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						
						<div class="usercontent"><?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?></div>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
						<?php endwhile; endif; ?>
					</div>

				</div>
		</div>
			<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
