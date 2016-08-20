<?php
/**
 * Provides a mood widget using Chart.js
 *
 * @since   3.2.0
 *
 * @package chriswiegman
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Widgets;

/**
 * Class Mood
 */
class Mood extends \WP_Widget {

	/**
	 * Mood widget constructor.
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'mood-widget',
			'description' => esc_html__( 'Journal Mood Widget', 'chriswiegman' ),
		);

		parent::__construct( 'mood', esc_html__( 'Mood Widget', 'chriswiegman' ), $widget_ops );

		add_action( 'wp_ajax_get_mood_data', array( $this, 'action_wp_ajax_get_mood_data' ) );
		add_action( 'wp_ajax_nopriv_get_mood_data', array( $this, 'action_wp_ajax_get_mood_data' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );

	}

	/**
	 * Action wp_ajax_get_mood_data
	 *
	 * Handles AJAX request for mood chart data.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public function action_wp_ajax_get_mood_data() {

		check_ajax_referer( 'cw-plugin-nonce', 'nonce' );

		if ( ! isset( $_POST['start'] ) || ! isset( $_POST['days'] ) ) {
			wp_send_json_error( esc_html__( 'Invalid start or end date', 'chriswiegman' ) );
		}

		$start_day   = absint( $_POST['start'] );
		$number_days = absint( $_POST['days'] );

		$data_set                       = new \stdClass();
		$data_set->label                = esc_html__( 'My mood data', 'chriswiegman' );
		$data_set->fillColor            = 'rgba(220,220,220,0.2)';
		$data_set->strokeColor          = 'rgba(220,220,220,1)';
		$data_set->pointColor           = 'rgba(220,220,220,1)';
		$data_set->pointStrokeColor     = '#fff';
		$data_set->pointHighlightFill   = '#fff';
		$data_set->pointHighlightStroke = 'rgba(220,220,220,1)';
		$data_set->data                 = array();

		$labels = array();
		$moods  = array();

		$start_date = strtotime( '-' . ( $start_day ) . ' days' );

		$args = array(
			'post_type'      => array(
				'morning-journal',
				'evening-journal',
			),
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'date_query'     => array(
				array(
					'after'     => date( 'F jS, Y', $start_date ),
					'inclusive' => true,
				),
			),
			'posts_per_page' => - 1,
		);

		$mood_query = new \WP_Query( $args );

		if ( $mood_query->have_posts() ) {

			while ( $mood_query->have_posts() ) {

				$mood_query->the_post();

				$mood      = get_post_meta( get_the_ID(), '_journal_mood', true );
				$mood_date = date( 'M j', $mood['d'] );

				if ( isset( $moods[ $mood_date ] ) ) {

					$moods[ $mood_date ] = absint( ( $moods[ $mood_date ] + $mood['mood'] ) / 2 );

				} else {

					$moods[ $mood_date ] = $mood['mood'];

				}

				wp_reset_postdata();

			}
		}

		for ( $i = ( $start_day - 1 ); 0 <= $i; $i -- ) {

			$labels[]         = date( 'M j', ( current_time( 'timestamp' ) - ( 86400 * $i ) ) );
			$data_set->data[] = 0;

		}

		foreach ( $moods as $date => $mood ) {

			$data_set->data[ array_search( $date, $labels, true ) ] = $mood;

		}

		$chart_data = array(
			'labels'   => $labels,
			'datasets' => array( $data_set ),
		);

		wp_send_json_success( $chart_data );

	}

	/**
	 * Handles any scripts needed by the front-end of the site.
	 *
	 * @since 3.2.0
	 *
	 * @return void
	 */
	public static function action_wp_enqueue_scripts() {

		$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_script( 'cw_mood_js', CW_THEME_PATH . '/assets/js/cw-mood' . $min . '.js', array(), CW_THEME_VERSION, true );

		wp_register_style( 'cw_mood_css', CW_THEME_PATH . 'assets/css/mood' . $min . '.css', array(), CW_THEME_VERSION );

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @since 3.2.0
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'My Mood', 'chriswiegman' );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'chriswiegman' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( esc_attr( $title ) ); ?>"/>
		</p>
		<?php

	}

	/**
	 * Processes widget options to be saved
	 *
	 * @since 3.2.0
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @since 3.2.0
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		wp_enqueue_script( 'cw_mood_js' );
		wp_enqueue_style( 'cw_mood_css' );

		wp_localize_script(
			'cw_mood_js',
			'cwMood',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'cw-plugin-nonce' ),
			)
		);

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		echo '<div class="chart-container">';
		echo '<canvas id="mood-chart"></canvas>';
		echo '<div id="chartjs-tooltip"></div>';
		echo '</div>';

		echo wp_kses_post( $args['after_widget'] );

	}
}
