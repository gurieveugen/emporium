<?php
/* code to integrate in template content-single-product.php
path: public-html/wp-content/themes/emporium/woocommerce */

$idcheck= get_the_ID();
$term_list = wp_get_post_terms($idcheck,'product_cat');
$cat= $term_list[0]->name;
?>
                               
<?php 
$menus=wp_nav_menu_top(array('container' =>false, 'container_class' => 'menu-header',        'theme_location' => 'main-menu','echo' => true, 'fallback_cb' => 'emporium_fallback_menu', 'before' => '', 'after' => '', 'link_before' => '','link_after' =>''),$cat); 
//print_r($menus);
?>