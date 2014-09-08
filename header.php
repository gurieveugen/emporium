<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta content="True" name="HandheldFriendly">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<meta name="viewport" content="width=device-width">
		<?php
			global $data;
			$favicon = '';
			if (isset($data['favicon']))
				$favicon = $data['favicon'];
			if (empty($favicon)) { $favicon = get_template_directory_uri() . '/images/favicon.ico';
			}
	?>
		<title>	<?php
			global $page, $paged;
			wp_title('|', true, 'right');
			bloginfo('name');
			$site_description = get_bloginfo('description', 'display');
			if ($site_description && (is_home() || is_front_page()))
				echo " | $site_description";
			if ($paged >= 2 || $page >= 2)
				echo ' | ' . sprintf('Page %s', max($paged, $page));
	?>
		</title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<link rel="icon" type="image/png" href="<?php echo $data['favicon'] ?>">
		<link rel='stylesheet' id='prettyp-css'  href='/wp-content/themes/emporium/prettyPhoto.css?ver=3.4.2' type='text/css' media='all' />
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
		<?php
			if (is_singular() && get_option('thread_comments'))
				wp_enqueue_script('comment-reply');
 ?>	<?php
			if (isset($data['google_analytics']))
				echo stripText($data['google_analytics']);
 ?>
		<link rel="root" id="root" type="text/css" href="<?php echo get_template_directory_uri() ?>" >
		<?php wp_head();
			global $sitepress;
		?>
		<link rel='stylesheet' id="stylesheet" type="text/css" href="" rel="stylesheet" />
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53736932-1', 'auto');
  ga('send', 'pageview');

</script>
	</head>
	<body <?php body_class(); ?>>
	  <div class="global-box" style="padding: 0;">
		<header id='header-container' class="position-fixed" style="position: relative;">
			<div class="TopHolder">
				<?php showTopCart()	?>
			</div>
			<div id="headerwrap" >
				<div id="header">
					<div id="logo">
						<?php $logo = $data['logo']; ?> <a href="<?php echo home_url(); ?>"><img src="<?php if ($logo != '') {?><?php echo $logo; ?><?php } else { ?><?php get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description') ?>" /></a>
					</div>
					<div id="responsive-menu">
						<a href="#">MENU</a>
					</div>
					<div id="responsive-cart">
						<a href="/cart/">VIEW CART</a>
					</div>
					<div class="pagenav">
						<?php
						if (has_nav_menu('main-menu')) {					 wp_nav_menu(array('container' => false, 'container_class' => 'menu-header', 'theme_location' => 'main-menu', 'echo' => true, 'fallback_cb' => 'emporium_fallback_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'depth' => 0, 'walker' => new description_walker()));
						}
				?>
					</div>
				</div>
			</div>
			<link rel='stylesheet' id='options-css'  href='<?php echo site_url();?>/wp-content/themes/emporium/css/options.css?ver=3.4.2' type='text/css' media='all' />
		</header>