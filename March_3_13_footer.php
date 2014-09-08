<?php
footer();
global $data, $sitepress;
?>
<footer>
<div id="footer">	
<div class="totop">
<div class="gototop">
<div class="arrowgototop">
</div></div></div>	
<div class="fshadow"></div>	
<div id="footerinside">		
<div class="footer_widget">				
<div class="footer_widget1">				
<?php dynamic_sidebar( 'footer1' ); ?>				
<?php if($data['showsocialfooter']){ ?>				
<div class="socialfooter">				<h3>
<?php
		if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) 
		{ 
			echo stripText($data['translation_socialtitle']); 
		}
		 else { 
			  _e('SOCIALIZE WITH US','wp-emporium');
		} 
		?>
	</h3>	
	<div class="socialcategory"><?php socialLinkTop() ?>
	</div>		
			</div>	
	<?php } ?>			
	</div>		
		<div class="footer_widget2">		
		<?php dynamic_sidebar( 'footer2' ); ?>		
		</div>	

		<div class="footer_widget3">		
		<?php dynamic_sidebar( 'footer3' ); ?>		
		</div>			
		<div class="footer_widget4 last">		
		<?php dynamic_sidebar( 'footer4' ); ?>	
		</div>		</div>	</div>		
		<div id="footerbwrap">			
		<div id="footerb">			
		<div class="footernav">		

		<?php if ( has_nav_menu( 'footer-menu' ) ) { wp_nav_menu( array( 'menu_class' => 'footernav','theme_location' => 'footer-menu' ) );} ?>		
		</div>		
		<div class="copyright">		
		<?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['copyright']); } else {  _e('&copy; 2011 All rights reserved. ','wp-emporium'); } ?>			
		</div>		</div>	</div></div></footer>
		<script type="text/javascript" charset="utf-8"> 
		jQuery(document).ready(function()
		{    jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false});  });
		</script><?php wp_footer();  ?>
		</body>
</html>
																			
