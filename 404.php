 <?php get_header(); ?>

                       
<div id="mainwrap">

       <div id="main" class="clearfix">
       
               <div class="infotextwrap">
                       <div class="infotext">
                               <div class="infotextBorderSingle"></div>
                                       <h1><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['errorpagetitle']); } else {  _e('OOOPS! 404','wp-emporium'); } ?></h1>
                                       <div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>
                               <div class="infotextBorderSingle"></div>
                       </div>
               </div>                

               <div class="content fullwidth errorpage">
               <div style="float:left" class="page_base_links">
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/">SPINE EDUCATIONAL MODELS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/lumbar-models/">LUMBER MODELS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/cervical-models/">CERVICAL MODELS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/package-deals/">PACKAGE DEALS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/other-products/">OTHER PRODUCTS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/epidural-simulation/">EPIDURAL SIMULATION</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/stands/">STANDS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/thoracic-models/">THORACIC MODELS</a></span></p>
               <p><span style="font-weight:bold; text-decoration:underline"><a href="/product-category/mostpopularmodels/">MOST POPULAR</a></span></p>
               
               </div>
                               <div class="postcontent">
                                       <h2><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['errorpagetitle']); } else {  _e('OOOPS! 404','wp-emporium'); } ?></h2>
                                       <div class="posttext">
                                       
                                               <?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo stripText($data['errorpage']); } else {  _e('Sorry, but the page you are looking for has not been found.<br/>Try checking the URL for errors, then hit refresh.</br>Or you can simply click the icon below and go home:)','wp-emporium'); } ?>
                                       </div>
                                       <div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>
                                               <div class="page_base_links" align="middle">
                                               <a href="<?php echo get_permalink(5180); ?>">Shop</a> |
                                               <a href="<?php echo get_permalink(5181); ?>">Cart</a> |
                                               <a href="<?php echo get_bloginfo('url') ?>/product-category/custom-creations/">Custom Designs</a> |
                                               <a href="<?php echo get_permalink(6043); ?>">The Movement</a>
                                               </div>                                        
                               </div>                                                        
               </div>
       </div>
</div>

<?php get_footer(); ?>
