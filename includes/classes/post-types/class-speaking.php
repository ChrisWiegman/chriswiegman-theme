<?php
/**
 * Set up "Speaking" Custom Post Type
 *
 * Sets up a speaking Custom Post Type to save speaking data.
 *
 * @since   1.0.0
 *
 * @package chriswiegman
 */

namespace CW\Theme\Post_Types;

/**
 * Class Speaking
 */
class Speaking {

	/**
	 * Register functions
	 *
	 * Initializes CPTs and registers hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'create_speaking_type' ) );
		add_action( 'save_post', array( $this, 'speaking_save_meta' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'pre_get_posts', array( $this, 'action_pre_get_posts' ) );
		add_filter( 'manage_speaking_posts_columns', array( $this, 'speaking_edit_columns' ) );
		add_action( 'manage_speaking_posts_custom_column', array( $this, 'speaking_custom_columns' ), 10, 2 );
		add_filter( 'manage_edit-speaking_sortable_columns', array( $this, 'speaking_sortable_columns' ) );

	}

	/**
	 * Action pre_get_posts
	 *
	 * Sort speaking gigs by the appropriate columns.
	 *
	 * @since 3.1.0
	 *
	 * @param \WP_Query $query The query object.
	 */
	public function action_pre_get_posts( $query ) {

		/**
		 * We only want our code to run in the main WP query
		 * AND if an orderby query variable is designated.
		 */
		if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

			switch ( $orderby ) {

				case 'location':

					$query->set( 'meta_key', '_conference_location' );

					break;

				case 'conference':

					$query->set( 'meta_key', '_conference_name' );

					break;

				case 'conference_date':

					$query->set( 'meta_key', '_presentation_date' );

					break;

			}

			$query->set( 'orderby', 'meta_value' );

		}
	}

	/**
	 * Adds meta box
	 *
	 * Adds the metabox for the Speaking CPT.
	 *
	 * @since 1.0.0
	 */
	public function add_speaking_metabox() {

		add_meta_box(
			'speaking',
			esc_html__( 'Talk Information', 'chriswiegman' ),
			array( $this, 'speaking_metabox' ),
			'speaking',
			'normal',
			'high'
		);

	}

	/**
	 * Add CSS and JS
	 *
	 * Adds CSS and JS for the speaking content type.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {

		if ( isset( get_current_screen()->id ) && false !== strpos( get_current_screen()->id, 'speaking' ) ) {

			wp_register_style( 'cw-jquery-ui-css', CW_THEME_URL . '/assets/css/vendor/jquery-ui.min.css', array(), '1.11.4' );
			wp_enqueue_style( 'cw-jquery-ui-css' );

			wp_enqueue_script( 'jquery-ui-datepicker' );

			$min = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_script( 'chriswiegman_speaking_date', CW_THEME_URL . '/assets/js/admin-speaking' . $min . '.js', array( 'jquery-ui-datepicker' ), CW_THEME_VERSION );
			wp_enqueue_script( 'chriswiegman_speaking_date' );

		}
	}

	/**
	 * Register the post type
	 *
	 * Registers the "speaking" CPT.
	 *
	 * @since 1.0.0
	 */
	public function create_speaking_type() {

		register_post_type(
			'speaking',
			array(
				'labels'               => array(
					'name'               => esc_html_x( 'Speaking Gigs', 'post type general name', 'chriswiegman' ),
					'singular_name'      => esc_html_x( 'Speaking Gig', 'post type singular name', 'chriswiegman' ),
					'menu_name'          => esc_html_x( 'Speaking Gigs', 'admin menu', 'chriswiegman' ),
					'name_admin_bar'     => esc_html_x( 'Speaking Gigs', 'add new on admin bar', 'chriswiegman' ),
					'add_new'            => esc_html_x( 'Add New', 'book', 'chriswiegman' ),
					'add_new_item'       => esc_html__( 'Add New Speaking Gig', 'chriswiegman' ),
					'new_item'           => esc_html__( 'New Speaking Gig', 'chriswiegman' ),
					'edit_item'          => esc_html__( 'Edit Speaking Gig', 'chriswiegman' ),
					'view_item'          => esc_html__( 'View Speaking Gig', 'chriswiegman' ),
					'all_items'          => esc_html__( 'All Speaking Gigs', 'chriswiegman' ),
					'search_items'       => esc_html__( 'Search Speaking Gigs', 'chriswiegman' ),
					'parent_item_colon'  => esc_html__( 'Parent Speaking Gigs:', 'chriswiegman' ),
					'not_found'          => esc_html__( 'No speaking gigs found.', 'chriswiegman' ),
					'not_found_in_trash' => esc_html__( 'No speaking gigs found in Trash.', 'chriswiegman' ),
				),
				'description'          => esc_html__( 'A place to list speaking gigs.', 'chriswiegman' ),
				'public'               => true,
				'has_archive'          => false,
				'capability_type'      => 'post',
				'supports'             => array(
					'title',
					'editor',
					'thumbnail',
				),
				'exclude_form_search'  => true,
				'publicly_queryable'   => false,
				'rewrite'              => false,
				'register_meta_box_cb' => array( $this, 'add_speaking_metabox' ),
				'menu_icon'            => 'dashicons-megaphone',
				'menu_position'        => 20,
			)
		);

	}

	/**
	 * Output columns
	 *
	 * Outputs the speaking data columns.
	 *
	 * @since 2.2.0
	 *
	 * @param array $column  array of column info.
	 * @param int   $post_id The post ID.
	 */
	public function speaking_custom_columns( $column, $post_id ) {

		switch ( $column ) {

			case 'location':

				$conference_location = get_post_meta( $post_id, '_conference_location', true );

				echo esc_html( $conference_location );

				break;

			case 'conference_date':

				$raw_presentation_date = get_post_meta( $post_id, '_presentation_date', true );
				$presentation_date     = empty( $raw_presentation_date ) ? '' : date( 'F Y', $raw_presentation_date );

				echo esc_html( $presentation_date );

				break;

			case 'conference':

				$conference_name = get_post_meta( $post_id, '_conference_name', true );
				$conference_url  = get_post_meta( get_the_ID(), '_conference_url', true );

				if ( empty( $conference_url ) ) {

					echo esc_html( $conference_name );

				} else {

					printf(
						'<a href="%s" title="%s" target="_blank">%s</a>',
						esc_url( $conference_url ),
						esc_attr( $conference_name ),
						esc_html( $conference_name )
					);

				}

				break;

		}
	}

	/**
	 * Set data columns
	 *
	 * Set columns on speaking table.
	 *
	 * @since 2.2.0
	 *
	 * @return array Array of columns
	 */
	public function speaking_edit_columns() {

		$columns = array(
			'cb'              => 'input type="checkbox"',
			'title'           => 'Speaking Title',
			'conference'      => 'Conference',
			'conference_date' => 'Conference Date',
			'location'        => 'Location',
		);

		return $columns;

	}

	/**
	 * Echo metabox content
	 *
	 * Echos the content of the metabox for this CPT.
	 *
	 * @since 1.0.0
	 */
	public function speaking_metabox() {

		global $post;

		// Create nonce.
		echo '<input type="hidden" name="speaking_post_noncename" id="speaking_post_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';
		?>
		<table id="repeatable-fieldset" class="speaking-fields">
			<tr class="main">
				<td>
					<table class="form-table">
						<tr>
							<td colspan="2">
								<a class="button remove-row" href="#"><?php esc_html_e( 'Remove', 'chriswiegman' ); ?></a>
							</td>
						</tr>

						<?php

						// Get conference name.
						$conference_name = get_post_meta( $post->ID, '_conference_name', true );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_name"><?php esc_html_e( 'Conference Name', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_name" name="conference_name" class="large-text" value="<?php echo esc_attr( $conference_name ); ?>">
							</td>
						</tr>

						<?php

						// Get conference URL data.
						$conference_url = get_post_meta( $post->ID, '_conference_url', true );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_url"><?php esc_html_e( 'Conference URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_url" name="conference_url" class="large-text" value="<?php echo esc_url( $conference_url ); ?>">
							</td>
						</tr>

						<?php

						// Get slide URL data.
						$slide_url = get_post_meta( $post->ID, '_slide_url', true );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="slide_url"><?php esc_html_e( 'Slide URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="slide_url" name="slide_url" class="large-text" value="<?php echo esc_url( $slide_url ); ?>">
							</td>
						</tr>

						<?php

						// Get presentation URL data.
						$presentation_url = get_post_meta( $post->ID, '_presentation_url', true );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="presentation_url"><?php esc_html_e( 'Presentation URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="presentation_url" name="presentation_url" class="large-text" value="<?php echo esc_url( $presentation_url ); ?>">
							</td>
						</tr>

						<?php

						// Get Presentation date data.
						$raw_presentation_date = get_post_meta( $post->ID, '_presentation_date', true );
						$presentation_date     = empty( $raw_presentation_date ) ? current_time( 'm/d/Y' ) : date( 'm/d/Y', $raw_presentation_date );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="presentation_date"><?php esc_html_e( 'Presentation Date', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="presentation_date" name="presentation_date" class="medium-text" value="<?php echo esc_attr( $presentation_date ); ?>">
							</td>
						</tr>

						<?php

						// Get conference name.
						$conference_location = get_post_meta( $post->ID, '_conference_location', true );

						?>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_location"><?php esc_html_e( 'Conference Location', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_location" name="conference_location" class="medium-text" value="<?php echo esc_attr( $conference_location ); ?>">
							</td>
						</tr>

					</table>
				</td>
			</tr>

			<!-- empty hidden one for jQuery -->
			<tr class="main empty-row screen-reader-text">
				<td>
					<table class="form-table">
						<tr>
							<td colspan="2">
								<a class="button remove-row" href="#"><?php esc_html_e( 'Remove', 'chriswiegman' ); ?></a>
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_name"><?php esc_html_e( 'Conference Name', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_name" name="conference_name" class="large-text">
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_url"><?php esc_html_e( 'Conference URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_url" name="conference_url" class="large-text">
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="slide_url"><?php esc_html_e( 'Slide URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="slide_url" name="slide_url" class="large-text">
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="presentation_url"><?php esc_html_e( 'Presentation URL', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="presentation_url" name="presentation_url" class="large-text">
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="presentation_date"><?php esc_html_e( 'Presentation Date', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="presentation_date" name="presentation_date" class="medium-text" value="<?php echo current_time( 'm/d/Y' ); ?>">
							</td>
						</tr>

						<tr class="width_normal p_box">
							<th scope="row">
								<label for="conference_location"><?php esc_html_e( 'Conference Location', 'chriswiegman' ); ?></label>
							</th>
							<td>
								<input type="text" id="conference_location" name="conference_location" class="medium-text">
							</td>
						</tr>

					</table>
				</td>
			</tr>
		</table>

		<p>
			<a id="add-row" class="button" href="#"><?php esc_html_e( 'Add Presentation', 'chriswiegman' ); ?></a>
		</p>
		<p class="description"><?php esc_html_e( 'Use the "Add Presentation" or "Remove" buttons to add one or more presentations of this talk.', 'chriswiegman' ); ?></p>
		<?php
	}

	/**
	 * Save post data
	 *
	 * Saves the custom post data as meta information.
	 *
	 * @since 1.0.0
	 *
	 * @param int      $post_id ID of the current post.
	 * @param \WP_POST $post    The current post.
	 *
	 * @return int|void post ID on failure or void on success
	 */
	public function speaking_save_meta( $post_id, $post ) {

		// @codingStandardsIgnoreStart
		// Verify nonce.
		if ( ! isset( $_POST['speaking_post_noncename'] ) || ! wp_verify_nonce( $_POST['speaking_post_noncename'], plugin_basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// Verify credentials.
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$project_post_meta['_slide_url']           = esc_url( $_POST['slide_url'] );
		$project_post_meta['_presentation_url']    = esc_url( $_POST['presentation_url'] );
		$project_post_meta['_conference_url']      = esc_url( $_POST['conference_url'] );
		$project_post_meta['_conference_name']     = sanitize_text_field( $_POST['conference_name'] );
		$project_post_meta['_conference_location'] = sanitize_text_field( $_POST['conference_location'] );
		$project_post_meta['_presentation_date']   = strtotime( $_POST['presentation_date'] );

		// Add values as custom fields.
		foreach ( $project_post_meta as $key => $value ) { // Cycle through the $quote_post_meta array.

			$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely).

			if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.

				update_post_meta( $post->ID, $key, $value );

			} else { // If the custom field doesn't have a value.

				add_post_meta( $post->ID, $key, $value );

			}

			if ( ! $value ) { // Delete if blank.

				delete_post_meta( $post->ID, $key );

			}
		}

		return null;
		// @codingStandardsIgnoreEnd

	}

	/**
	 * Filter sortable table comments
	 *
	 * Adds time and conference to sortables.
	 *
	 * @since 3.1.0
	 *
	 * @param array $sortable_columns Array of sortable columns.
	 *
	 * @return array Filtered array of sortable columns.
	 */
	public function speaking_sortable_columns( $sortable_columns ) {

		$sortable_columns['location']        = 'location';
		$sortable_columns['conference_date'] = 'conference_date';
		$sortable_columns['conference']      = 'conference';

		return $sortable_columns;

	}
}
