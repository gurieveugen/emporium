<?php

add_action( 'widgets_init', 'WooCommerce_widget_random_products_Custom_widget' );

function WooCommerce_widget_random_products_Custom_widget() {
	register_widget( 'WooCommerce_widget_random_products_Custom' );
}

class WooCommerce_widget_random_products_Custom extends WP_Widget {

	/**
	 * constructor
	 *
	 * @access public
	 * @return void
	 */
		function WooCommerce_widget_random_products_Custom()  {

		
		$widget_ops = array( 'classname' => 'widget_random_products_custom_Custom', 'description' => 'Emporium Random Products' );



		/* Create the widget. */
		$this->WP_Widget( 'woocommerce_random_products_custom', __('Emporium Random Products', 'wp-emporium'), $widget_ops, '' );
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		global $woocommerce;

		// Use default title as fallback
		$title = ( '' === $instance['title'] ) ? __('Random Products', 'woocommerce') : $instance['title'];
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		// Setup product query
		$query_args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $instance['number'],
			'orderby'        => 'rand',
			'no_found_rows'  => 1
		);

		$query_args['meta_query'] = array();

		if ( ! $instance['show_variations'] ) {
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			$query_args['post_parent'] = 0;
		}

	    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			echo $args['before_widget'];

			if ( '' !== $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			} ?>

			<ul class="product_list_widget">
				<?php while ($query->have_posts()) : $query->the_post(); global $product; ?>
					<li>
						<a href="<?php the_permalink() ?>">
						<?php echo get_image_pmc(100,75,$query->post->ID);?> </a>
						</a>	
						<a href="<?php the_permalink() ?>">
							<?php the_title() ?>
						</a>
						<?php echo $product->get_price_html() ?>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php
			echo $args['after_widget'];
		}
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array(
			'title'           => strip_tags($new_instance['title']),
			'number'          => min(15, max(1, (int) $new_instance['number'])),
			'show_variations' => ! empty($new_instance['show_variations'])
		);

		return $instance;
	}

	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		// Default values
		$title           = isset( $instance['title'] ) ? $instance['title'] : '';
		$number          = isset( $instance['number'] ) ? (int) $instance['number'] : 5;
		$show_variations = ! empty( $instance['show_variations'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title:', 'woocommerce' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name('title') ) ?>" type="text" value="<?php echo esc_attr( $title ) ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ) ?>"><?php _e( 'Number of products to show:', 'woocommerce' ) ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name('number') ) ?>" type="text" value="<?php echo esc_attr( $number ) ?>" size="3" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_variations' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name('show_variations') ) ?>" <?php checked( $show_variations ) ?> />
			<label for="<?php echo $this->get_field_id( 'show_variations' ) ?>"><?php _e( 'Show hidden product variations', 'woocommerce' ) ?></label>
		</p>

		<?php
	}

}