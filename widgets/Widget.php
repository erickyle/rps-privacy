<?php

namespace rpsPluginBoilerplate\widgets;

use \WP_Widget;

/**
 * A Widget.
 *
 * This class defines all code necessary to create a widget.
 *
 * @since 				1.0.0
 * @package 			rps-plugin-boilerplate
 * @subpackage 			rps-plugin-boilerplate/widgets
 * @author 				Red Pixel Studios <support@redpixel.com>
 */
class Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rps_plugin_boilerplate_widget', // Base ID
			esc_html__( 'RPS Plugin Boilerplate Widget', 'rps-plugin-boilerplate' ), // Name
			array( 'description' => esc_html__( 'Description of widget.', 'rps-plugin-boilerplate' ), )
		);
	}
		
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param 				array 				$args     				Widget arguments.
	 * @param 				array 				$instance 				Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		echo $args['before_widget'];
		
		echo $args['before_title'];
		echo apply_filters( 'widget_title', $instance['title'] );
		echo $args['after_title'];

		echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'rps-plugin-boilerplate' ); ?>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" placeholder="" type="text" value="<?php echo esc_attr( $title ); ?>"></label>
		</p>

	<?php
	}
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		
		return $instance;
					
	}
	
}

?>