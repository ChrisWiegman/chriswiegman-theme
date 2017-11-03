<?php
/**
 * Set up "Journal" Custom Post Type
 *
 * Sets up a journal Custom Post Type to save daily journal entries.
 *
 * @since   2.0.0
 *
 * @package chriswiegman
 */

namespace CW\Theme\Post_Types;

/**
 * Class Journal
 */
class Journal {

	/**
	 * Title of each post.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	private $title;

	/**
	 * Register functions
	 *
	 * Initializes CPTs and registers hooks.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$this->title = date( 'F jS, Y', current_time( 'timestamp' ) );

		add_action( 'edit_form_top', array( $this, 'action_edit_form_top' ) );
		add_action( 'init', array( $this, 'create_journal_type' ) );
		add_action( 'save_post', array( $this, 'journal_save_morning_meta' ), 10, 2 );
		add_action( 'save_post', array( $this, 'journal_save_evening_meta' ), 10, 2 );
		add_filter( 'wp_insert_post_data', array( $this, 'filter_wp_insert_post_data' ), 10, 2 );

	}

	/**
	 * Action edit_form_top
	 *
	 * Adds the journal title where it belongs.
	 *
	 * @since 7.0
	 */
	public function action_edit_form_top() {

		$screen = get_current_screen()->id;

		if ( 'morning-journal' === $screen || 'evening-journal' === $screen ) {

			$type = ( 'morning-journal' === $screen ) ? esc_html__( 'Morning', 'chriswiegman' ) : esc_html__( 'Evening', 'chriswiegman' );

			echo '<h2>' . sprintf( esc_html__( 'My %s Journal Entry for %s', 'chriswiegman' ), $type, $this->title ) . '</h2>';

		}
	}

	/**
	 * Adds meta box
	 *
	 * Adds the metabox for the evening journal CPTs.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function add_evening_journal_metabox() {

		add_meta_box(
			'evening_journal',
			esc_html__( 'Journal Details', 'chriswiegman' ),
			array( $this, 'evening_journal_metabox' ),
			'evening-journal',
			'normal',
			'high'
		);

	}

	/**
	 * Adds meta box
	 *
	 * Adds the metabox for the morning journal CPTs.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function add_morning_journal_metabox() {

		add_meta_box(
			'morning_journal',
			esc_html__( 'Journal Details', 'chriswiegman' ),
			array( $this, 'morning_journal_metabox' ),
			'morning-journal',
			'normal',
			'high'
		);

	}

	/**
	 * Register the post type
	 *
	 * Registers the journal CPTs.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function create_journal_type() {

		register_post_type(
			'morning-journal',
			array(
				'labels'               => array(
					'name'               => esc_html_x( 'Morning Entries', 'post type general name', 'chriswiegman' ),
					'singular_name'      => esc_html_x( 'Morning Entry', 'post type singular name', 'chriswiegman' ),
					'menu_name'          => esc_html_x( 'Morning Journal', 'admin menu', 'chriswiegman' ),
					'name_admin_bar'     => esc_html_x( 'Morning Entry', 'add new on admin bar', 'chriswiegman' ),
					'add_new'            => esc_html_x( 'Add New', 'book', 'chriswiegman' ),
					'add_new_item'       => esc_html__( 'Add New Entry', 'chriswiegman' ),
					'new_item'           => esc_html__( 'New Entry', 'chriswiegman' ),
					'edit_item'          => esc_html__( 'Edit Entry', 'chriswiegman' ),
					'view_item'          => esc_html__( 'View Entry', 'chriswiegman' ),
					'all_items'          => esc_html__( 'All Entries', 'chriswiegman' ),
					'search_items'       => esc_html__( 'Search Entries', 'chriswiegman' ),
					'parent_item_colon'  => esc_html__( 'Parent Entries:', 'chriswiegman' ),
					'not_found'          => esc_html__( 'No entries found.', 'chriswiegman' ),
					'not_found_in_trash' => esc_html__( 'No entries found in Trash.', 'chriswiegman' ),
				),
				'description'          => esc_html__( 'Morning journal entries.', 'chriswiegman' ),
				'public'               => false,
				'has_archive'          => false,
				'capability_type'      => 'post',
				'supports'             => array( 'editor' ),
				'show_ui'              => true,
				'can_export'           => false,
				'register_meta_box_cb' => array( $this, 'add_morning_journal_metabox' ),
				'menu_icon'            => 'dashicons-book-alt',
				'menu_position'        => 20,
				'rewrite'              => array(
					'slug' => 'journal/morning',
				),
			)
		);

		register_post_type(
			'evening-journal',
			array(
				'labels'               => array(
					'name'               => esc_html_x( 'Evening Entries', 'post type general name', 'chriswiegman' ),
					'singular_name'      => esc_html_x( 'Evening Entry', 'post type singular name', 'chriswiegman' ),
					'menu_name'          => esc_html_x( 'Evening Journal', 'admin menu', 'chriswiegman' ),
					'name_admin_bar'     => esc_html_x( 'Evening Entry', 'add new on admin bar', 'chriswiegman' ),
					'add_new'            => esc_html_x( 'Add New', 'book', 'chriswiegman' ),
					'add_new_item'       => esc_html__( 'Add New Entry', 'chriswiegman' ),
					'new_item'           => esc_html__( 'New Entry', 'chriswiegman' ),
					'edit_item'          => esc_html__( 'Edit Entry', 'chriswiegman' ),
					'view_item'          => esc_html__( 'View Entry', 'chriswiegman' ),
					'all_items'          => esc_html__( 'All Entries', 'chriswiegman' ),
					'search_items'       => esc_html__( 'Search Entries', 'chriswiegman' ),
					'parent_item_colon'  => esc_html__( 'Parent Entries:', 'chriswiegman' ),
					'not_found'          => esc_html__( 'No entries found.', 'chriswiegman' ),
					'not_found_in_trash' => esc_html__( 'No entries found in Trash.', 'chriswiegman' ),
				),
				'description'          => esc_html__( 'Evening journal entries.', 'chriswiegman' ),
				'public'               => false,
				'has_archive'          => false,
				'capability_type'      => 'post',
				'supports'             => array( 'editor' ),
				'show_ui'              => true,
				'can_export'           => false,
				'register_meta_box_cb' => array( $this, 'add_morning_journal_metabox' ),
				'menu_icon'            => 'dashicons-book-alt',
				'menu_position'        => 20,
				'rewrite'              => array(
					'slug' => 'journal/evening',
				),
			)
		);

	}

	/**
	 * Echo metabox content
	 *
	 * Echos the content of the metabox for the evening journal CPT.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function evening_journal_metabox() {

		global $post;

		?>

		<input type="hidden" name="evening_journal_post_noncename" id="evening_journal_post_noncename" value="<?php echo esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ); ?>"/>

		<table class="form-table">

			<?php $this->field_mood(); ?>

			<tr class="width_normal p_box">
				<td colspan="2"><h3><?php esc_html_e( 'List 3 Amazing things happened today:', 'chriswiegman' ); ?></h3>
				</td>
			</tr>

			<tr class="width_normal p_box">
				<th scope="row"><label for="amazing_1"><?php esc_html_e( '1', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="amazing_1" name="amazing_1" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_amazing_1', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="amazing_2"><?php esc_html_e( '2', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="amazing_2" name="amazing_2" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_amazing_2', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="amazing_3"><?php esc_html_e( '3', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="amazing_3" name="amazing_3" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_amazing_3', true ) ); ?>">
				</td>
			</tr>

			<tr class="width_normal p_box">
				<td colspan="2"><h3><?php esc_html_e( 'How could you have made today better?', 'chriswiegman' ); ?></h3>
				</td>
			</tr>

			<tr class="width_normal p_box">
				<th scope="row"><label for="better_1"><?php esc_html_e( '1', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_1" name="better_1" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_better_1', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="better_2"><?php esc_html_e( '2', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_2" name="better_2" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_better_2', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="better_3"><?php esc_html_e( '3', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_3" name="better_3" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_evening_better_3', true ) ); ?>">
				</td>
			</tr>

		</table>

		<?php

	}

	/**
	 * Echo mood field
	 *
	 * Echos the mood field for use in both journal types.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	private function field_mood() {

		global $post;

		?>

		<tr class="width_normal p_box">
			<th scope="row"><label for="mood"><?php esc_html_e( 'Energy/Mood:', 'chriswiegman' ); ?></label></th>
			<td>
				<select name="mood" id="mood">
					<option><?php esc_html_e( 'Select', 'chriswiegman' ); ?></option>
					<?php
					$mood_array = get_post_meta( $post->ID, '_journal_mood', true );

					if ( is_array( $mood_array ) ) {

						$mood = $mood_array['mood'];

					} else {

						$mood = $mood_array;

					}
					?>
					<option value="5" <?php selected( $mood, 5 ); ?>><?php esc_html_e( 'Excellent', 'chriswiegman' ); ?></option>
					<option value="4" <?php selected( $mood, 4 ); ?>><?php esc_html_e( 'Good', 'chriswiegman' ); ?></option>
					<option value="3" <?php selected( $mood, 3 ); ?>><?php esc_html_e( 'OK', 'chriswiegman' ); ?></option>
					<option value="2" <?php selected( $mood, 2 ); ?>><?php esc_html_e( 'Bad', 'chriswiegman' ); ?></option>
					<option value="1" <?php selected( $mood, 1 ); ?>><?php esc_html_e( 'Horrible', 'chriswiegman' ); ?></option>
				</select>
			</td>
		</tr>

		<?php
	}

	/**
	 * Add title
	 *
	 * Pragmatically generates the appropriate title.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data An array of slashed post data.
	 *
	 * @return array The filtered data array
	 */
	public function filter_wp_insert_post_data( $data ) {

		if ( isset( $data['post_status'] ) && 'auto-draft' === $data['post_status'] && isset( $data['post_type'] ) && ( 'morning-journal' === $data['post_type'] || 'evening-journal' === $data['post_type'] ) ) {

			$title = date( 'F jS, Y', current_time( 'timestamp' ) );

			$current_post = get_page_by_title( $title, OBJECT, $data['post_type'] );

			if ( $current_post ) {

				$redirect = add_query_arg(
					array(
						'post'   => $current_post->ID,
						'action' => 'edit',
					),
					get_admin_url( get_current_blog_id(), 'post.php' )
				);

				wp_safe_redirect( $redirect );
				exit();

			} else {

				$data['post_title'] = $this->title;

			}
		}

		return $data;

	}

	/**
	 * Save post data
	 *
	 * Saves the custom post data as meta information.
	 *
	 * @since 2.0.0
	 *
	 * @param int      $post_id ID of the current post.
	 * @param \WP_POST $post    The current post.
	 *
	 * @return int|null post ID on failure or void on success
	 */
	public function journal_save_evening_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['evening_journal_post_noncename'] ) || ! wp_verify_nonce( $_POST['evening_journal_post_noncename'], plugin_basename( __FILE__ ) ) ) { // WPCS: Input var ok. Sanitization ok.
			return $post_id;
		}

		// Verify credentials.
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$journal_post_meta['_journal_evening_amazing_1'] = sanitize_text_field( wp_unslash( $_POST['amazing_1'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_evening_amazing_2'] = sanitize_text_field( wp_unslash( $_POST['amazing_2'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_evening_amazing_3'] = sanitize_text_field( wp_unslash( $_POST['amazing_3'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_evening_better_1']  = sanitize_text_field( wp_unslash( $_POST['better_1'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_evening_better_2']  = sanitize_text_field( wp_unslash( $_POST['better_2'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_evening_better_3']  = sanitize_text_field( wp_unslash( $_POST['better_3'] ) ); // WPCS: Input var ok.

		if ( isset( $_POST['mood'] ) && 0 < absint( $_POST['mood'] ) ) { // WPCS: Input var ok.

			$journal_post_meta['_journal_mood']['mood'] = absint( $_POST['mood'] ); // WPCS: Input var ok.
			$journal_post_meta['_journal_mood']['d']    = current_time( 'timestamp' );
			$journal_post_meta['_journal_mood']['t']    = 'e';

		}

		// Add values as custom fields.
		$this->save_post_meta( $journal_post_meta, $post );

		return null;

	}

	/**
	 * Save the meta
	 *
	 * Saves the meta fields.
	 *
	 * @since 2.0.0
	 *
	 * @param array    $journal_post_meta Array of meta fields to save.
	 * @param \WP_POST $post              the current post object.
	 *
	 * @return void
	 */
	private function save_post_meta( $journal_post_meta, $post ) {

		// Add values as custom fields.
		foreach ( $journal_post_meta as $key => $value ) { // Cycle through the $quote_post_meta array.

			if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.

				update_post_meta( $post->ID, $key, $value );

			} else { // If the custom field doesn't have a value.

				add_post_meta( $post->ID, $key, $value );

			}

			if ( ! $value ) { // Delete if blank.

				delete_post_meta( $post->ID, $key );

			}
		}
	}

	/**
	 * Save post data
	 *
	 * Saves the custom post data as meta information.
	 *
	 * @since 2.0.0
	 *
	 * @param int      $post_id ID of the current post.
	 * @param \WP_POST $post    The current post.
	 *
	 * @return int|null post ID on failure or void on success
	 */
	public function journal_save_morning_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['morning_journal_post_noncename'] ) || ! wp_verify_nonce( $_POST['morning_journal_post_noncename'], plugin_basename( __FILE__ ) ) ) { // WPCS: Input var ok. Sanitization ok.
			return $post_id;
		}

		// Verify credentials.
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$journal_post_meta['_journal_morning_grateful_1']    = sanitize_text_field( wp_unslash( $_POST['grateful_1'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_grateful_2']    = sanitize_text_field( wp_unslash( $_POST['grateful_2'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_grateful_3']    = sanitize_text_field( wp_unslash( $_POST['grateful_3'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_better_1']      = sanitize_text_field( wp_unslash( $_POST['better_1'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_better_2']      = sanitize_text_field( wp_unslash( $_POST['better_2'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_better_3']      = sanitize_text_field( wp_unslash( $_POST['better_3'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_affirmation_1'] = sanitize_text_field( wp_unslash( $_POST['affirmation_1'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_affirmation_2'] = sanitize_text_field( wp_unslash( $_POST['affirmation_2'] ) ); // WPCS: Input var ok.
		$journal_post_meta['_journal_morning_affirmation_3'] = sanitize_text_field( wp_unslash( $_POST['affirmation_3'] ) ); // WPCS: Input var ok.

		if ( isset( $_POST['mood'] ) && 0 < absint( $_POST['mood'] ) ) { // WPCS: Input var ok.

			$journal_post_meta['_journal_mood']['mood'] = absint( $_POST['mood'] ); // WPCS: Input var ok.
			$journal_post_meta['_journal_mood']['d']    = current_time( 'timestamp' );
			$journal_post_meta['_journal_mood']['t']    = 'm';

		}

		// Add values as custom fields.
		$this->save_post_meta( $journal_post_meta, $post );

		return null;

	}

	/**
	 * Echo metabox content
	 *
	 * Echos the content of the metabox for the morning journal CPT.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function morning_journal_metabox() {

		global $post;

		?>

		<input type="hidden" name="morning_journal_post_noncename" id="morning_journal_post_noncename" value="<?php echo esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ); ?>"/>

		<table class="form-table">

			<?php $this->field_mood(); ?>

			<tr class="width_normal p_box">
				<td colspan="2"><h3><?php esc_html_e( "I'm grateful for:", 'chriswiegman' ); ?></h3></td>
			</tr>

			<tr class="width_normal p_box">
				<th scope="row"><label for="grateful_1"><?php esc_html_e( '1', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="grateful_1" name="grateful_1" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_grateful_1', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="grateful_2"><?php esc_html_e( '2', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="grateful_2" name="grateful_2" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_grateful_2', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="grateful_3"><?php esc_html_e( '3', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="grateful_3" name="grateful_3" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_grateful_3', true ) ); ?>">
				</td>
			</tr>

			<tr class="width_normal p_box">
				<td colspan="2"><h3><?php esc_html_e( 'What would make today better:', 'chriswiegman' ); ?></h3></td>
			</tr>

			<tr class="width_normal p_box">
				<th scope="row"><label for="better_1"><?php esc_html_e( '1', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_1" name="better_1" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_better_1', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="better_2"><?php esc_html_e( '2', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_2" name="better_2" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_better_2', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="better_3"><?php esc_html_e( '3', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="better_3" name="better_3" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_better_3', true ) ); ?>">
				</td>
			</tr>

			<tr class="width_normal p_box">
				<td colspan="2"><h3><?php esc_html_e( 'Daily Affirmation:', 'chriswiegman' ); ?></h3></td>
			</tr>

			<tr class="width_normal p_box">
				<th scope="row"><label for="affirmation_1"><?php esc_html_e( '1', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="affirmation_1" name="affirmation_1" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_affirmation_1', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="affirmation_2"><?php esc_html_e( '2', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="affirmation_2" name="affirmation_2" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_affirmation_2', true ) ); ?>">
				</td>
			</tr>
			<tr class="width_normal p_box">
				<th scope="row"><label for="affirmation_3"><?php esc_html_e( '3', 'chriswiegman' ); ?></label></th>
				<td>
					<input type="text" id="affirmation_3" name="affirmation_3" class="large-text" value="<?php echo esc_html( get_post_meta( $post->ID, '_journal_morning_affirmation_3', true ) ); ?>">
				</td>
			</tr>

		</table>

		<?php

	}
}
