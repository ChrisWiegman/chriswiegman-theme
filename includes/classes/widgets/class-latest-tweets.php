<?php
/**
 * Provides a "latest tweets" widget
 *
 * @since   4.1.0
 *
 * @package CW\Plugin\Widgets
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Widgets;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Class Latest_Tweets
 */
class Latest_Tweets extends \WP_Widget {

	/**
	 * Mood widget constructor.
	 */
	public function __construct() {

		// Make sure access information is defined.
		if (
			! defined( 'CW_TWITTER_OAUTH_CONSUMER_KEY' ) ||
			! defined( 'CW_TWITTER_OAUTH_CONSUMER_SECRET' ) ||
			! defined( 'CW_TWITTER_OAUTH_ACCESS_TOKEN' ) ||
			! defined( 'CW_TWITTER_OAUTH_ACCESS_SECRET' )
		) {
			return;
		}

		$widget_ops = array(
			'classname'   => 'latest_tweets',
			'description' => esc_html__( 'Latest Tweets Widget', 'chriswiegman' ),
		);

		parent::__construct( 'latest_tweets', esc_html__( 'Latest Tweets', 'chriswiegman' ), $widget_ops );

		add_action( 'wp_ajax_get_latest_tweets', array( $this, 'action_wp_ajax_get_latest_tweets' ) );
		add_action( 'wp_ajax_nopriv_get_latest_tweets', array( $this, 'action_wp_ajax_get_latest_tweets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );

	}

	/**
	 * Action wp_ajax_get_latest_tweets
	 *
	 * Handles AJAX request for retrieving latest tweets
	 *
	 * @since 4.1.0
	 *
	 * @return void
	 */
	public function action_wp_ajax_get_latest_tweets() {

		check_ajax_referer( 'cw-latest-tweets-nonce', 'nonce' );

		$latest_tweets = get_transient( 'cw_latest_tweets' );

		if ( false === $latest_tweets ) {

			$latest_tweets = array();
			$max_tweets    = ( isset( $_POST['count'] ) ) ? absint( $_POST['count'] ) : 7; // WPCS: input var OK.

			// Require the twitter auth library.
			require( CW_THEME_INCLUDES . '/vendor/twitteroauth/autoload.php' );

			$twitter_connection = new TwitterOAuth(
				CW_TWITTER_OAUTH_CONSUMER_KEY,
				CW_TWITTER_OAUTH_CONSUMER_SECRET,
				CW_TWITTER_OAUTH_ACCESS_TOKEN,
				CW_TWITTER_OAUTH_ACCESS_SECRET
			);

			$raw_tweets = $twitter_connection->get(
				'statuses/user_timeline',
				array(
					'screen_name'     => sanitize_text_field( $_POST['userName'] ), // WPCS: input var ok.
					'count'           => 200,
					'exclude_replies' => true,
					'include_rts'     => false,
				)
			);

			if ( 200 === $twitter_connection->getLastHttpCode() && ! empty( $raw_tweets ) ) {

				$hashtag_link_pattern      = '<a href="http://twitter.com/search?q=%%23%s&src=hash" rel="nofollow" target="_blank">#%s</a>';
				$url_link_pattern          = '<a href="%s" rel="nofollow" target="_blank" title="%s">%s</a>';
				$user_mention_link_pattern = '<a href="http://twitter.com/%s" rel="nofollow" target="_blank" title="%s">@%s</a>';
				$media_link_pattern        = '<a href="%s" rel="nofollow" target="_blank" title="%s">%s</a>';
				$tweet_count               = 0;

				foreach ( $raw_tweets as $tweet ) {

					if ( $tweet_count >= $max_tweets ) {
						break;
					}

					$text          = $tweet->text;
					$entity_holder = array();

					foreach ( $tweet->entities->hashtags as $hashtag ) {

						$entity          = new \stdClass();
						$entity->start   = $hashtag->indices[0];
						$entity->end     = $hashtag->indices[1];
						$entity->length  = $hashtag->indices[1] - $hashtag->indices[0];
						$entity->replace = sprintf( $hashtag_link_pattern, strtolower( $hashtag->text ), $hashtag->text );

						$entity_holder[ $entity->start ] = $entity;

					}

					foreach ( $tweet->entities->urls as $url ) {

						$entity          = new \stdClass();
						$entity->start   = $url->indices[0];
						$entity->end     = $url->indices[1];
						$entity->length  = $url->indices[1] - $url->indices[0];
						$entity->replace = sprintf( $url_link_pattern, $url->url, $url->expanded_url, $url->display_url );

						$entity_holder[ $entity->start ] = $entity;

					}

					foreach ( $tweet->entities->user_mentions as $user_mention ) {

						$entity          = new \stdClass();
						$entity->start   = $user_mention->indices[0];
						$entity->end     = $user_mention->indices[1];
						$entity->length  = $user_mention->indices[1] - $user_mention->indices[0];
						$entity->replace = sprintf( $user_mention_link_pattern, strtolower( $user_mention->screen_name ), $user_mention->name, $user_mention->screen_name );

						$entity_holder[ $entity->start ] = $entity;

					}

					foreach ( $tweet->entities->media as $media ) {

						$entity          = new \stdClass();
						$entity->start   = $media->indices[0];
						$entity->end     = $media->indices[1];
						$entity->length  = $media->indices[1] - $media->indices[0];
						$entity->replace = sprintf( $media_link_pattern, $media->url, $media->expanded_url, $media->display_url );

						$entity_holder[ $entity->start ] = $entity;

					}

					krsort( $entity_holder );

					foreach ( $entity_holder as $entity ) {
						$text = substr_replace( $text, $entity->replace, $entity->start, $entity->length );
					}

					$text = '<div class="cw_tweet"><span class="cw_tweet_text">' . $text . '</span><span class="cw_tweet_time"><a href="' . esc_url( 'https://twitter.com/ChrisWiegman/statuses/' . $tweet->id ) . '" target="_blank">' . esc_html( date( 'F jS, Y g:i a', strtotime( $tweet->created_at ) ) ) . '</a></span></div>';

					$latest_tweets[] = $text;

					$tweet_count ++;

				}
			}

			// Save our new transient.
			set_transient( 'cw_latest_tweets', $latest_tweets, 3600 );

		}

		wp_send_json_success( $latest_tweets );

	}

	/**
	 * Handles any scripts needed by the front-end of the site.
	 *
	 * @since 4.1.0
	 *
	 * @return void
	 */
	public static function action_wp_enqueue_scripts() {

		$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_script( 'cw_tweets_js', CW_THEME_URL . '/assets/js/cw-latest-tweets' . $min . '.js', array( 'jquery' ), CW_THEME_VERSION, true );

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @since 4.1.0
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		$title       = ( isset( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'My Latest Tweets', 'chriswiegman' );
		$user_name   = ( isset( $instance['user_name'] ) ) ? $instance['user_name'] : '';
		$tweet_count = ( isset( $instance['tweet_count'] ) ) ? $instance['tweet_count'] : 7;

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'chriswiegman' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( esc_attr( $title ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'user_name' ) ); ?>"><?php esc_html_e( 'Twitter User:', 'chriswiegman' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'user_name' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'user_name' ) ); ?>" type="text"
			       value="<?php echo esc_attr( esc_attr( $user_name ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tweet_count' ) ); ?>"><?php esc_html_e( 'Number of Tweets:', 'chriswiegman' ); ?></label>
			<?php $counts = range( 1, 20 ); ?>

			<select id="<?php echo esc_attr( $this->get_field_id( 'tweet_count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'tweet_count' ) ); ?>">
			<?php foreach ( $counts as $count ) { ?>
			<option value="<?php echo esc_attr( $count ); ?>" <?php selected( $count, $tweet_count ); ?>><?php echo esc_html( $count ); ?></option>
		<?php } ?>

			</select>
		</p>
		<?php

	}

	/**
	 * Processes widget options to be saved
	 *
	 * @since 4.1.0
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                = array();
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['user_name']   = sanitize_text_field( str_replace( '@', '', $new_instance['user_name'] ) );
		$instance['tweet_count'] = absint( $new_instance['tweet_count'] );

		return $instance;

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @since 4.1.0
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		wp_enqueue_script( 'cw_tweets_js' );

		wp_localize_script(
			'cw_tweets_js',
			'cwLatestTweets',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'cw-latest-tweets-nonce' ),
				'userName' => isset( $instance['user_name'] ) ? esc_attr( $instance['user_name'] ) : '',
				'count'    => isset( $instance['tweet_count'] ) ? absint( $instance['tweet_count'] ) : '',
			)
		);

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		echo '<div id="cw-latest-tweets">';
		echo '</div>';

		echo wp_kses_post( $args['after_widget'] );

	}
}