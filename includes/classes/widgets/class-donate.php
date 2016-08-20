<?php
/**
 * Show donation Widget
 *
 * Shows the donation widget.
 *
 * @package CW\Plugin\Widgets
 *
 * @since   5.1.0
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */
namespace CW\Theme\Widgets;

/**
 * Class Donate
 */
class Donate extends \WP_Widget {

	/**
	 * Setup and add Donate Widget
	 *
	 * Sets up the Widget options
	 *
	 * @since 5.1.0
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'donate_widget',
			'description' => esc_html__( 'Support My Work', 'chriswiegman' ),
		);

		\WP_Widget::__construct( 'donate', esc_html__( 'Support My Work', 'chriswiegman' ), $widget_ops );

	}

	/**
	 * Setup Widget form
	 *
	 * Sets up the widget settings form
	 *
	 * @since 5.1.0
	 *
	 * @param array $instance Widget for instance.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Support My Work', 'chriswiegman' );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'chriswiegman' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>

		<?php

	}

	/**
	 * Update Widget options
	 *
	 * Update the options for the WordPress widget
	 *
	 * @since 5.1.0
	 *
	 * @param array $new_instance New options.
	 * @param array $old_instance Old widget options.
	 *
	 * @return array Widget options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;

	}

	/**
	 * Render the widget
	 *
	 * Renders the donation widget.
	 *
	 * @since 5.1.0
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget options.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		$image_path = str_replace( 'www.chriswiegman.com', 'cdn1.chriswiegman.com', CW_THEME_URL ) . 'assets/images/';

		?>
		<div class="cw_donate">
			<p><?php esc_html_e( 'If you find my work useful please consider a few dollars to help pay for this site.', 'chriswiegman' ); ?></p>
			<a href="/donate" title="Donate to my work">
				<img src="<?php echo esc_url( $image_path . 'paypal.gif' ); ?>" width="147" height="47" alt="Donate to my work" scale="0">
		</div>
		</a>
		<?php

		echo wp_kses_post( $args['after_widget'] );

	}
}