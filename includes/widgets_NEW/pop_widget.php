<?php
/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'category_post_widget' );

/* Function that registers our widget. */
function category_post_widget() {
	register_widget( 'category_posts' );
}

class category_posts extends WP_Widget {
	function category_posts() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'category_posts', 'description' => 'Displays the post image and excerpt from a selected category **Does not work on singlepost sidebar**'.'wp-emporium' );

		/* Create the widget. */
		$this->WP_Widget( 'category_posts-widget', __('Emporium Popular Posts Widget', 'wp-emporium'), $widget_ops, '' );
	}

	function widget( $args, $instance ) {
		global $sitepress, $data;
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		// to sure the number of posts displayed isn't negative or more than 10
		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 10 )
			$number = 10;

		//the query that will get post from a specific category. 
		//Wr slug the category because you actualy need the slug and not the name
		$pc = new WP_Query("orderby=comment_count&showposts=".$number."&nopaging=0&post_status=publish&ignore_sticky_posts=1");
		
		//display the posts title as a link
		if ($pc->have_posts()) : 
		
			echo $before_widget; 
		
				if ( $title ) echo $before_title . $title . $after_title; 
		?>
		
		
		<?php  while ($pc->have_posts()) : $pc->the_post();  ?>
				
			
				
	
				<div class="widgett">
				
    <?php
	
		$image = '';
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', false);
			$image = $image[0];
			}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
			$no_comments = get_comments_number( $post-ID );
			if($no_comments == 0){
				if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_0 = stripText($data['translation_comment_no_responce']); } else {  $comment_0 = __('No Responses','wp-emporium'); } 
			}
			else if($no_comments == 1){
				if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_1 = stripText($data['translation_comment_one_comment']); } else {  $comment_1 = __('One Response','wp-emporium'); } 
			}
			else{
				if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { $comment_2 = stripText($data['translation_comment_max_comment']); } else {  $comment_2 = __('Responses','wp-emporium'); } 
			}
		
	?>			<div class="imgholder"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img src="<?php echo get_template_directory_uri() ?>/js/timthumb.php?src=<?php echo $image ?>&amp;h=55&amp;w=85" alt="<?php the_title(); ?>"></a></div>
				<div class="wttitle"><h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php $title = the_title('','',FALSE); echo substr($title, 0, 40); ?></a></h4></div>
				<div class="details2"><?php comments_popup_link($comment_0, $comment_1, '% '.$comment_2); ?></div>

				</div>
			
		<?php endwhile; ?>
	
		

		
		
	<?php
			wp_reset_query();  // Restore global post data stomped by the_post().
			endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Popular Posts', 'number' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wp-emporium') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'wp-emporium') ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
			<br /><small>(at most 10)</small>
		</p>

		<?php
	}

	function slug($string)
	{
		$slug = trim($string);
		$slug= preg_replace('/[^a-zA-Z0-9 -]/','', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug= str_replace(' ','-', $slug); // replace spaces by dashes
		$slug= strtolower($slug); // make it lowercase
		return $slug;
	}

}

?>
