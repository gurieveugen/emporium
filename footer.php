<?php
footer();
global $data, $sitepress;
?>

<footer> 
  <!--<script src="<?php bloginfo('template_url'); ?>/js/mailchimp.js" ></script>-->
  <div id="footer">
    <div class="totop">
      <div class="gototop">
        <div class="arrowgototop"> </div>
      </div>
    </div>
    <div class="fshadow"></div>
    <div id="footerinside">
      <div class="footer_widget">
        <div class="footer_widget1">
          <?php dynamic_sidebar( 'footer1' ); ?>
          <?php if($data['showsocialfooter']){ ?>
          <div class="socialfooter">
            <h3>
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
            <div class="socialcategory">
              <?php socialLinkTop() ?>
              <a href="https://www.google.com/+Dynamicdiscdesigns?rel=author" target="_blank" class="googlelink top"></a> </div>
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
        </div>
      </div>
    </div>
    <div id="footerbwrap">
      <div id="footerb">
        <div class="footernav">
          <?php //if ( has_nav_menu( 'footer-menu' ) ) { wp_nav_menu( array( 'menu_class' => 'footernav','theme_location' => 'footer-menu' ) );} ?>
          <ul class="">
            <li><a href="/dynamic/privacy-policy/">Privacy Policy</a></li>
            <li><a href="/dynamic/terms-and-conditions/">Terms and Conditions</a></li>
            <li><a href="/dynamic/shipping-policy/">Shipping Policy</a></li>
            <li><a href="/dynamic/return-policy/">Return Policy</a></li>
            <li><a href="/dynamic/ordering-with-a-po/">Ordering with a PO</a></li>
            <li><a href="/dynamic/importing-into-the-usa/">Importing into the USA</a></li>
            <li><a href="/dynamic/warranty/">Warranty</a></li>
            <li><a href="/dynamic/forensic-medical-legal/ ">Forensic/Medical Legal</a></li>
            <li><a href="/dynamic/device-showcasing/">Device Showcasing</a></li>
            <li><a href="/dynamic/company-profile/">Company Profile</a></li>
            <li><a href="/dynamic/research/">Research</a></li>
            <li><a href="/dynamic/conferences/">Conferences</a></li>
            <li><a href="/dynamic/testimonials/">Testimonials</a></li>
            <li><a href="/sitemap/">Sitemap</a></li>
          </ul>
        </div>
        <div class="copyright">
          <?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['copyright']); } else {  _e('&copy; 2011 All rights reserved. ','wp-emporium'); } ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<script type="text/javascript" charset="utf-8"> 
jQuery(document).ready(function() {

jQuery("a[rel^='lightbox']").prettyPhoto({
	theme:'light_rounded',
    overlay_gallery: false,
    show_title: false,
    deeplinking: false
});
var logoHeight = jQuery("#logo").height();
var headerwrapHeight = jQuery("#headerwrap").height();
var pastWaypoint = false;
        
	jQuery(window).bind('scroll', function(){
         if (jQuery(window).width() > 755) {
             if (jQuery(window).scrollTop() < 110 && !pastWaypoint) {
                 jQuery('#headerwrap').css('min-height',headerwrapHeight + 'px').removeClass('css-header-fixed');;
                 jQuery('#logo').show();
				 jQuery('#logo-mini').hide();
				 jQuery('#header-container').removeClass("position-fixed");
				 jQuery('#visible-fixed').removeClass("menu-new");
                 pastWaypoint = true;
             }
             else if (jQuery(window).scrollTop() >= 110 && pastWaypoint)
             {	 jQuery('#headerwrap').css('min-height','80px').addClass('css-header-fixed');
				 jQuery('#header-container').addClass("position-fixed");       
                 jQuery('#logo').hide();
				 jQuery('#visible-fixed').addClass("menu-new");
				 jQuery('#logo-mini').show();
                 pastWaypoint = false;
             }
         }
     }); 
     jQuery(window).bind('scroll', update).resize(update);
     update();
 });
 function update()
 {
     var pos = jQuery(window).scrollTop(); 
     jQuery('#logo a').css('top', Math.round(pos*0.7) + 'px');
 }   
</script>
<?php wp_footer();  ?>
<?php if(is_page('checkout')){?>
<script type="text/javascript" charset="utf-8"> 
		jQuery(document).ready(function(){    		
			var payment_method_class = '';
			jQuery(".payment_methods li").each(function(){
				payment_method_class = jQuery(this).find("input.input-radio:checked").attr("id");
				if(payment_method_class != undefined ){	
					show_payment_method(payment_method_class);
				}			
			});	
		});
		function show_payment_method(payment_method_class){		
			setTimeout(function(){
				jQuery("div."+payment_method_class).show();
			}, 2000);		
		}		
		</script>
<?php }  ?>
</div>
</body></html>