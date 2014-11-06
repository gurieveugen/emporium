<?php
  global $data;
  
	if($data['catwootype'] == 1 && !isset($_GET['shop'])){
		include('archive-product_template_2.php');
	}
	if($data['catwootype'] == 2 && !isset($_GET['shop'])){
		include('archive-product_template_1.php');
	}
	if(isset($_GET['shop']) == 'sidebar'){
		include('archive-product_template_1.php');
	}	
?>