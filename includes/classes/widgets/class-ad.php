<?php
/**
 * Show ad Widget
 *
 * Shows the ad widget.
 *
 * @package CW\Plugin\Widgets
 *
 * @since   5.1.0
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */
namespace CW\Theme\Widgets;

/**
 * Class Ad
 */
class Ad extends \WP_Widget {

	/**
	 * Setup and add Ad Widget
	 *
	 * Sets up the Widget options
	 *
	 * @since 5.1.0
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'ad_widget',
			'description' => esc_html__( 'Recommended Services', 'chriswiegman' ),
		);

		\WP_Widget::__construct( 'ad', esc_html__( 'Recommended Services', 'chriswiegman' ), $widget_ops );

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

		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recommended Services', 'chriswiegman' );

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
	 * Renders the ad widget.
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

		$image_path = str_replace( 'www.chriswiegman.com', 'cdn1.chriswiegman.com', CW_THEME_PATH ) . '/assets/images/';

		echo '<div id="cw_affiliates">';
		echo '<a href="http://cfw.bz/Linode" class="small-image left-image" target="_blank" title="VPS Hosting with Linode"><img src="' . esc_url( $image_path . '/linode.jpg' ) . '" alt="VPS Hosting with Linode" width="125" height="125"></a>';
		echo '<a href="http://cfw.bz/GravityForms" class="small-image right-image" target="_blank" title="WordPress Forms with Gravity Forms"><img src="' . esc_url( $image_path . '/gravity-forms.gif' ) . '" alt="WordPress Forms with Gravity Forms" width="125" height="125"></a><br />';
		echo '<a href="http://cfw.bz/Namecheap" class="small-image left-image" target="_blank" title="SSL Certificates and Domains from Namecheap"><img src="' . esc_url( $image_path . '/namecheap.gif' ) . '" alt="SSL Certificates and Domains from Namecheap" width="125" height="125"></a>';
		echo '<a href="http://cfw.bz/MailChimp" class="small-image right-image" target="_blank" title="Get the word out with MailChimp"><img src="' . esc_url( $image_path . '/mailchimp.gif' ) . '" alt="Get the word out with MailChimp" width="125" height="125"></a><br />';
		echo '<a href="http://cfw.bz/DepositPhotos" class="small-image left-image" target="_blank" title="Quality stock photos for your site"><img src="' . esc_url( $image_path . '/depositphotos.jpg' ) . '" alt="Quality stock photos for your site" width="125" height="125"></a>';
		echo '<a href="http://cfw.bz/dnsmadeeasy" class="small-image right-image" target="_blank" title="Upgrade your DNS with DNSMadeEasy"><img src="' . esc_url( $image_path . '/dnsmadeeasy.jpg' ) . '" alt="Upgrade your DNS with DNSMadeEasy" width="125" height="125"></a>';
		echo '</div>';

		echo wp_kses_post( $args['after_widget'] );

	}
}