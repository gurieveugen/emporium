<?php
/*
Template Name: Team Page
*/
?>

<?php get_header(); ?>
			
<div id="mainwrap">

	<div id="main" class="clearfix">
		<div class="infotextwrap">			<div class="infotext">				<div class="infotextBorderSingle"></div>					<h1><?php the_title();?></h1>					<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>				<div class="infotextBorderSingle"></div>			</div>		</div>	

		<div class="content fullwidth">
		
			<?php $teams = $data['team']; 
			$count = 1;
			foreach ($teams as $team) { ?>
		
				<div class="one_third team <?php if($count == 3){ $count=0; echo 'last';} ?>">
					<div class="title"><?php echo stripText($team['title']) ?></div>
					<div class="role"><?php echo stripText($team['role']) ?></div>
					<div class="social"><?php echo socialLinkTeam($team['facebook'],$team['twitter'],$team['vimeo'],$team['dribble'],$team['mail']); ?></div>
					<div class="image"><img src="<?php echo $team['url'] ?>"></div>
					<div class="iconwrap"><div class="icon"><img src="<?php echo $team['icon'] ?>"></div></div>
					<p class="description"><?php echo stripText($team['description']) ?></p>
				</div>
			<?php $count ++ ?>
			<?php } ?>	
		
		</div>
	</div>
</div>
<?php get_footer(); ?>
