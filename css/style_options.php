<?php
global $data; 
$use_bg = ''; $background = ''; $custom_bg = ''; $body_face = ''; $use_bg_header =''; $background_header = ''; $custom_bg_header = '';

if(isset($data['background_image'])) {
	$use_bg = $data['background_image'];
}


if(isset($data['background_image_header'])) {
	$use_bg_header = $data['background_image_header'];
}

if($use_bg) {

	$custom_bg = $data['body_bg_custom'];
	
	if(!empty($custom_bg)) {
		$bg_img = $custom_bg;
	} else {
		$bg_img = $data['body_bg'];
	}
	
	$bg_prop = $data['body_bg_properties'];
	
	$background = 'url('. $bg_img .') '.$bg_prop ;

}


if($use_bg_header) {

	$custom_bg_header = $data['header_bg_custom'];
	
	if(!empty($custom_bg)) {
		$bg_img_header = $custom_bg;
	} else {
		$bg_img_header = $data['header_bg'];
	}
	
	$bg_prop_header = $data['header_bg_properties'];
	
	$background_header = 'url('. $bg_img_header .') '.$bg_prop_header ;

}

function ieOpacity($opacityIn){
	
	$opacity = explode('.',$opacityIn);
	if($opacity[0] == 1)
		$opacity = 100;
	else
		$opacity = $opacity[1] * 10;
		
	return $opacity;
}

function HexToRGB($hex,$opacity) {
		$hex = ereg_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
 
		return 'rgba('.$color['r'] .','.$color['g'].','.$color['b'].','.$opacity.')';
	}
	


?>
::selection { background: <?php echo $data['mainColor']; ?>; color:#2a2b2c; text-shadow: none; }
body {	 
	background:<?php echo $data['body_background_color'].' '.$background ?>  !important;
	color:<?php echo $data['body_font']['color']; ?>;
	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif;
	font-size: <?php echo $data['body_font']['size']; ?>;
	font-weight: normal;
	line-height: 1.65em;
	letter-spacing: normal;
}
h1,h2,h3,h4,h5,h6, .blogpostcategory .posted-date p, .team .title, .term-description p{
	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['heading_font']['face'])))); ?> !important;
	<?php if(strpos($data['heading_font']['face'],'200')) {?>
		font-weight: 300;
	<?php } else { ?>
		font-weight: normal;
	<?php }  ?>
	line-height: 110%;
}

h1 { 	
	color:<?php echo $data['heading_font_h1']['color']; ?>;
	font-size: <?php echo $data['heading_font_h1']['size'] ?> !important;
	}
	
h2, .term-description p { 	
	color:<?php echo $data['heading_font_h2']['color']; ?>;
	font-size: <?php echo $data['heading_font_h2']['size'] ?> !important;
	}

h3 { 	
	color:<?php echo $data['heading_font_h3']['color']; ?>;
	font-size: <?php echo $data['heading_font_h3']['size'] ?> !important;
	}

h4 { 	
	color:<?php echo $data['heading_font_h4']['color']; ?>;
	font-size: <?php echo $data['heading_font_h4']['size'] ?> !important;
	}	
	
h5 { 	
	color:<?php echo $data['heading_font_h5']['color']; ?>;
	font-size: <?php echo $data['heading_font_h5']['size'] ?> !important;
	}	

h6 { 	
	color:<?php echo $data['heading_font_h6']['color']; ?>;
	font-size: <?php echo $data['heading_font_h6']['size'] ?> !important;
	}	
h2.title a {color:<?php echo $data['heading_font_h2']['color']; ?>;}
a, a:active, a:visited, .footer_widget .widget_links ul li a{color: <?php echo $data['body_link_coler']; ?>;}	
.widget_nav_menu ul li a  {color: <?php echo $data['body_link_coler']; ?>;}
a:hover, h2.title a:hover, .item3 h3:hover, .item4 h3:hover, .item3 h3 a:hover, #portitems2 h3 a:hover {color: <?php echo $data['mainColor']; ?>;}
.item3 h3, .item4 h3, .item3 h3 a, .item4 h3 a, .item3 h4, .item2 h4, .item4 h4, #portitems2 h3 a {color:<?php echo $data['heading_font_h3']['color']; ?>;}

/* ***********************
--------------------------------------
------------EXTRA TYPOGRAPHY----------
-----------------------------------*/
.homeRacent h3 a, .item4 h3, .item4 h3 a, .boxdescwraper h2, #footer .widget h3, .socialfooter h3, .widget h3, .item3 h3, #portitems2 h3, h3#comments, .relatedtitle h3,
.content ol.commentlist li .comment-author .fn a, #commentform  h3, .projectdescription h2, .team .title, .recentdescription h3
{ font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important;}


/* ***********************
--------------------------------------
------------NIVO SLIDER----------
--------------------------------------
*********************** */
.homeBox h2 a {color:<?php echo $data['heading_font_h2']['color']; ?>;}
.nivo-caption { 
	position:absolute; 
	background-color: <?php echo$data['slider_backColorNivo'] ?>;
	background-color: <?php echo HexToRGB($data['slider_backColorNivo'],$data['slider_opacity'])?>;
	border: 1px solid <?php echo $data['slider_borderColorNivo']; ?>; 
	color: <?php echo $data['slider_fontSize_colorNivo']['color']; ?>; 
	font-size: <?php echo $data['slider_fontSize_colorNivo']['size']; ?>;
	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['heading_font']['face'])))); ?> !important;
	letter-spacing: normal;
	padding:5px 15px 5px 5px;
	z-index:99;
	top:50px;
	left:0px;
	text-align:center;
	line-height:120%;
}
a.nivo-nextNav , a.nivo-prevNav {background: url(images/slideshowArrowForward.png)   <?php echo$data['slider_backColorNivo'] ?>;}
a.nivo-prevNav {background: url(images/slideshowArrowBackward.png)   <?php echo$data['slider_backColorNivo'] ?>;}

.nivo-caption a { 
	color: <?php echo $data['slider_fontSize_colorNivo']['color']; ?>;  
	text-decoration: underline; 
}	

.caption-content { padding:0px 0px 200px 0px; color:<?php echo $data['slider_fontSize_color']['color']; ?>; font-size: <?php echo $data['slider_fontSize_color']['size']; ?>; font-family: <?php echo str_replace("%20"," ",$data['']['face']); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif; text-shadow: 1px 1px 0px black; filter:alpha(opacity=<?php echo ieOpacity($data['slider_opacity']); ?>);letter-spacing: normal;}
.caption-content h1{width:250px !important; background: <?php echo HexToRGB($data['mainColor'],$data['slider_opacity']) ?>;  padding:10px ;text-align:center;  line-height:120%;}
.caption-content h2 {	color:<?php echo $data['slider_fontSize_color']['color'] ;?>!important;
						font-size:<?php echo $data['slider_fontSize_color']['size'] ;?>!important;
						text-shadow: 1px 1px 0px black;}
.caption-content p{ }




.caption-content h1{
	color:<?php echo $data['slider_HfontSize_color']['color'] ;?>!important;
	font-size:<?php echo $data['slider_HfontSize_color']['size'] ;?>!important;
	text-shadow: 1px 1px 0px black;
}

.caption-content h2{
	background: <?php echo HexToRGB($data['slider_backColor'], $data['slider_opacity']); ?>;  padding:10px ;text-align:center;  line-height:120%;
}

.homeRacent h2 ,.advertise h2,.slider-category .anythingBase,#nslider img, .related h3, .widget h3, .projectdescription h3, .portsingle .portfolio h3, .titleborderh,
.socialsingle h2{
	background:<?php echo $data['body_background_color'].' '.$background  ?>  !important;
	}

#headerwrap, #footer, #slider-wrapper-iframe, #slider-wrapper {background:<?php echo $data['header_background_color'].' '.$background_header  ?>  !important;}

	


/* ***********************
--------------------------------------
------------MAIN COLOR----------
--------------------------------------
*********************** */

#footer .product_list_widget li del, #footer .widget del span, .footer_widget h3 span,.catlinkhover,.item h3 a:hover, .item2 h3 a:hover, .item4 h3 a:hover,.catlink:hover,.infotext span, .homeRacent h3 a:hover, .item4 h4 a:hover,.tags a:hover,
.blogpost .link:hover,.blogpost .postedin:hover ,.blogpost .postedin:hover, .blogpost .link a:hover,.blogpostcategory a.textlink:hover,
.footer_widget .widget_links ul li a:hover, .footer_widget .widget_categories  ul li a:hover,  .footer_widget .widget_archive  ul li a:hover,
#footerb .footernav ul li a:hover,.footer_widget  ul li a:hover,.tags span a:hover,.more-link:hover,.showpostpostcontent h1 a:hover,
.menu li a:hover,.menu li a:hover strong, .menu li ul li:hover ul li:hover a,
.menu > li.current-menu-item a strong,.menu > li.current-menu-ancestor a strong,.blogpostcategory .meta .written:hover a ,.blogpostcategory .meta .comments:hover a ,
#wp-calendar a , .widgett a:hover ,.widget_categories li.current-cat a, .widget_categories li.current-cat, .blogpostcategory .meta .time a:hover,.homeRacent h2 span, .advertise h2 span, 
.related h3 span, .homeremove .catlink .sortingword:hover, .homeremove .catlinkhover .sortingword, .blogpost .datecomment  .link a,
.titleborderh span, .textSlide .box, .widget_login p a:hover, .priceSP ins,  .boxmore a:hover,
.homeRacent .productF h3.category, .textSlide .salePrice1 a, .textSlide .salePrice2 a, .textSlide .salePrice3 a, .textSlide span, .homeRacent .recentmore:hover,
.widget_login p a:hover, .priceSP ins, .cartTopDetails .product_list_widget li a:hover, .top-nav li a:hover
{color:<?php echo $data['mainColor']; ?> !important;}

.socialsingle h2 span, .homeRacent h2 span, .advertise h2 span, .related h3 span, .infotext span,  .portfolio h3 span, .portsingleshare span, .titleborderh span,
.blogpostcategory .meta .category a, .singledefult .meta .category a, #portitems2 .category a, .homeRacent .category a, .portcategories a
{background:<?php echo $data['mainColor']; ?> !important; color: <?php echo $data['body_box_coler']; ?> !important;text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;padding:2px 6px 3px 6px; }
.widget del .amount {background:none !important;}

.homeRacent .overdefult, .item3 .overdefult, .item4 .overdefult {border-top:5px solid <?php echo $data['mainColor']; ?>;}
.leftContentSP .thumbnails img:hover, .product_list_widget li  img:hover {border:5px solid <?php echo $data['mainColor']; ?>;}
.textSlide h1.underline {border-bottom:6px solid <?php echo $data['mainColor']; ?>;}

.advertise .bx-wrapper:hover .bx-next{background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowForward.png) no-repeat 0px 1px;margin-left:940px;}
.advertise .bx-wrapper:hover .bx-prev {background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowBackward.png) no-repeat 0px 1px;margin-left:0px;}
 .page .homeRacent .bx-next,.homeRacent.SP .bx-next{background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowForward.png) no-repeat 0px 1px;}
 .page .homeRacent .bx-prev,.homeRacent.SP .bx-prev {background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowBackward.png) no-repeat 0px 1px;}

/* ***********************
--------------------------------------
------------BOX COLOR----------
--------------------------------------
*********************** */
#footer, #homeRecent .one_fourth, .item3 h3, .item4 h3, .item3 h3 a, .item4 h3 a ,.homewrap .homesingleleft,.homewrap .homesingleright

{ background:<?php echo $data['boxColor']; ?>}
.team .icon, .image-gallery, .gallery-item, .posttext .blogsingleimage img, .blogpostcategory .blogimage, .blogpostcategory iframe, #slider-category, .blogFullWidth #slider-category, 
.category_posts .widgett img,.recent_posts .widgett  img,.blogpostcategory .commentblog .circleHolder, .singledefult .commentblog .circleHolder, .related .one_third .image img
{ background:<?php echo $data['boxColor']; ?> !important;}

.category_posts .widgett img:hover,.recent_posts .widgett  img:hover,.related .one_third .image img:hover,#fancybox-close:hover, .cartWrapper, .homeRacent .productR .recentdescription .onsale,
.homeRacent .productF .recentCart a:hover, .homeRacent .productR .recentCart a:hover, .cartPS .price, .widget_shopping_cart .total .amount
{background:<?php echo $data['mainColor']; ?> !important;}

.homeRacent h3 a, .item4 h3, .item4 h3 a {color:<?php echo $data['body_font']['color']; ?>;}
#remove a, #remove a span{color:<?php echo $data['body_font']['color']; ?>;font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif;} 

/* ***********************
--------------------------------------
------------BOX FONT COLOR----------
--------------------------------------
*********************** */

.homeRacent h3.category a, .blogpostcategory .meta .category a, .singledefult .meta .category a, .blogpost .posted-date a, #portitems2 h3.category a, .team .role,.portcategories a,
.wp-pagenavi a:hover, .wp-pagenavi span.current, #respond #commentform input#submit:hover, #contactform .contactbutton .contact-button:hover, .blogpostcategory .date-inside, .singledefult .date-inside,
 .pagecontent h1, .pagecontent p, .pagecontent p a, .homeRacent h3.category a:hover,
.homeremove .catlink span, .errorpage .postcontent h2, .errorpage .posttext, .blogpostcategory .date-inside .day, .singledefult .date-inside .day,.blogpostcategory .date-inside .month, .singledefult .date-inside .month,textSlide .quote, textSlide .quote2, .infotext span,
.widget_tag_cloud a:hover, .widget_product_tag_cloud a:hover, .content ol.commentlist li .reply a:hover, .relatedtitle h3, h3#comments, .boxmore a , #commentform h3, .homeRacent .productR .recentdescription .onsale, ins, .titleSP h2, .cartPS .price

 {color: <?php echo $data['body_box_coler']; ?> !important;}
.homeremove .catlinkhover .sortingword, .homeremove .catlink .sortingword:hover {background:<?php echo $data['body_box_coler']; ?>;}
.boxDescription .homeboxmore:hover {background:<?php echo $data['body_box_coler']; ?> !important;}
/* ***********************
--------------------------------------
------------MAIN COLOR BOXED----------
--------------------------------------
*********************** */
#contactform  .contactbutton .contact-button:hover, .gototop ,.role, .team .icon img,.pagewrap, .blogpostcategory .posted-date .date-inside,.singledefult .posted-date .date-inside,
.errorpage,  ins, .widget_login .submitbutton, .relatedtitle,.commenttitle, .related .one_third .image img:hover, .content ol.commentlist li .reply a:hover,
.item4 .image, .item3 .image, .item2 .image, .boxDescription .homeboxmore,#fancybox-close:hover ,.item2 .image, .category_posts .widgett img:hover, .recent_posts .widgett  img:hover,
#commentform  h3, #portitems2 .image, .widget_login .submitbutton, .widget_price_filter_custom .ui-slider .ui-slider-handle,
.widget_price_filter_custom .ui-widget-content, .item4 .image, .item3 .image, .item2 .image, table.shop_table .carButtons .button:hover, table.shop_table .coupon .button:hover, .cartTopDetails .product_list_widget .buttons a:hover,
.widget_price_filter_custom  .price_slider_amount .button:hover,  .cartTopDetails .total .amount
{background:<?php echo $data['mainColor']; ?> ;}
.widget_tag_cloud a:hover, .widget_product_tag_cloud a:hover, #respond #commentform input#submit:hover{background:<?php echo $data['mainColor']; ?> !important;}

.wp-pagenavi a:hover, .wp-pagenavi span.current, #content input.button,
a.button:hover, button.button:hover, input.button:hover, #respond input#submit:hover, #content input.button:hover, 
.titleSP h2, mark
  {background:<?php echo $data['mainColor']; ?>; text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;}
.blogpostcategory .comment-inside a, .singledefult .comment-inside a, .blogpostcategory .date-inside,.singledefult .date-inside,textSlide .quote, textSlide .quote2 {color: <?php echo $data['body_box_coler']; ?> !important; text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;}
.textSlide .button, .textSlide .box {text-shadow:none;}
/* ***********************
--------------------------------------
------------MAIN BORDER COLOR----------
--------------------------------------
*********************** */
#logo a, .recentborder,.item4 .recentborder, .item3 .recentborder,.afterlinehome,.TopHolder ,#footer ,.borderLineLeft, .borderLineLeftSlideshow {border-color:<?php echo $data['mainColor']; ?> !important;}


/* ***********************
--------------------------------------
------------BODY COLOR----------
--------------------------------------
*********************** */

.blogpost .link a,.datecomment span,.homesingleleft .tags a,.homesingleleft .postedin a,.blogpostcategory .category a,.singledefult .category a,.blogpostcategory .comments a,.singledefult .comments a,
.blogpostcategory a.textlink ,.singledefult a.textlink ,.written a, .blogpostcategory .meta .time a, .singledefult .meta .time a	
{ color:<?php echo $data['body_font']['color']; ?>}
.homeRacent.SP h3 { color:<?php echo $data['heading_font_h3']['color']; ?> !important;}

/* ***********************
--------------------------------------
------------MENU----------
--------------------------------------
*********************** */

.menu li:hover ul {border-bottom: 5px solid <?php echo $data['mainColor']; ?>;}
.menu li ul li a, .item4 h4 a, #portitems2 .category a, .homeRacent .category a, .item3 h4 a, .homeRacent .productF h3.category, .homeRacent .productR h3.category
{	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important; }
.menu > li a {	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['menu_font'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important; color:#2e2d2d;letter-spacing: normal;}
.menu a span{ 	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif  !important; color:#aaa !important;letter-spacing: normal;}

.top-nav a {color:#fff;}
/* ***********************
--------------------------------------
------------BLOG----------
-----------------------------------*/
.blogpostcategory h2 {line-height: 110% !important;}
.wp-pagenavi span.pages {font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif;}
.wp-pagenavi a, .showpostpostcontent h1 a {color:<?php echo $data['heading_font_h2']['color']; ?>;}
.wp-pagenavi a:hover,ul.tabs a:hover, h2.trigger:hover, .nextbutton, .prevbutton  { background-color:<?php echo $data['mainColor']; ?> !important; }
ul.tabs.woo a.current{  background-color:#3A3F43; }
.nextbutton.port {background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowForward.png) no-repeat 0px 1px !important;}
.prevbutton.port {background: <?php echo $data['mainColor']; ?> url(images/slideshowArrowBackward.png) no-repeat 0px 1px !important;}
ul.tabs.woo .active a, ul.tabs a.current{  background-color:<?php echo $data['mainColor']; ?>; }
.blogpost .datecomment a, .related h4 a, .content ol.commentlist li .comment-author .fn a{color:<?php echo $data['body_font']['color']; ?>;}
.blogpost .datecomment a:hover, .tags a:hover, .related h4 a:hover, .content ol.commentlist li .comment-author .fn a:hover{ color:<?php echo $data['mainColor']; ?>; }
.comment-author .fn a{font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['heading_font']['face'])))); ?> !important;}
.image-gallery, .gallery-item { border: 2px dashed <?php echo $data['mainColor']; ?>;}
.blogpostcategory .posted-date p, .singledefult .posted-date p{font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important;text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;}
.pagecontent h1, .pagecontent p,  .team .role,  .pagecontentContent #breadcrumb {text-shadow:0 1px 0 <?php echo HexToRGB($data['ShadowColorFont'],$data['ShadowOpacittyColorFont'])?>;}
/* ***********************
--------------------------------------
------------Widget----------
-----------------------------------*/
.wttitle a {color:<?php echo $data['heading_font_h4']['color']; ?>;}

.widgetline{<?php echo $bordersidebar; ?>}
.widgett a:hover, .widget_nav_menu ul li a:hover{color:<?php echo $data['mainColor']; ?> !important;}
 .widget_nav_menu ul li a{	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important; }
.related h4{	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important; }
.widget_search form div {	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important;}
.widgett a {	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important;}
.widget_tag_cloud a{	font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['body_font']['face'])))); ?>, "Helvetica Neue", Arial, Helvetica, Verdana, sans-serif !important;}

/* ***********************
--------------------------------------
------------BUTTONS WITH SHORTCODES----------
--------------------------------------
*********************** */
.button_purche_right_top,.button_download_right_top,.button_search_right_top {font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['heading_font']['face'])))); ?> !important;color:<?php echo $data['heading_font_h2']['color']; ?>;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);}
.button_purche:hover,.button_download:hover,.button_search:hover {color:<?php echo $data['mainColor']; ?> !important;}
.ribbon_center_red a, .ribbon_center_blue a, .ribbon_center_white a, .ribbon_center_yellow a, .ribbon_center_green a {font-family: <?php echo str_replace("%20"," ",str_replace(":300"," ",str_replace(":200"," ",str_replace(":400"," ",$data['heading_font']['face'])))); ?> !important;}
a.button.loading::before, button.button.loading::before, input.button.loading::before {content: "";position: absolute;height: 32px;width: 32px;bottom: 20px;left: 150px;text-indent: 0;background:url(images/loading.gif) no-repeat;}

<?php echo stripText($data['custom_style']) ?>