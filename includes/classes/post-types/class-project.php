<?php
/**
 * Set up "Project" Custom Post Type
 *
 * Sets up a project Custom Post Type to save project data.
 *
 * @since   1.0.0
 *
 * @package ChrisWiegman
 */

namespace CW\Theme\Post_Types;

/**
 * Class Project
 */
class Project {

	/**
	 * Register functions
	 *
	 * Initializes CPTs and registers hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'project_taxonomy' ) );
		add_action( 'init', array( $this, 'create_project_type' ) );
		add_action( 'save_post', array( $this, 'project_save_meta' ), 10, 2 );

	}

	/**
	 * Adds meta box
	 *
	 * Adds the metabox for the Project CPT.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_project_metabox() {

		add_meta_box(
			'project',
			__( 'Project URL', 'chriswiegman' ),
			array( $this, 'project_metabox' ),
			'project',
			'normal',
			'high'
		);

	}

	/**
	 * Register the post type
	 *
	 * Registers the "project" CPT.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function create_project_type() {

		register_post_type(
			'project',
			array(
				'labels'               => array(
					'name'               => esc_html_x( 'Projects', 'post type general name', 'chriswiegman' ),
					'singular_name'      => esc_html_x( 'Project', 'post type singular name', 'chriswiegman' ),
					'menu_name'          => esc_html_x( 'Projects', 'admin menu', 'chriswiegman' ),
					'name_admin_bar'     => esc_html_x( 'Project', 'add new on admin bar', 'chriswiegman' ),
					'add_new'            => esc_html_x( 'Add New', 'book', 'chriswiegman' ),
					'add_new_item'       => esc_html__( 'Add New Project', 'chriswiegman' ),
					'new_item'           => esc_html__( 'New Project', 'chriswiegman' ),
					'edit_item'          => esc_html__( 'Edit Project', 'chriswiegman' ),
					'view_item'          => esc_html__( 'View Project', 'chriswiegman' ),
					'all_items'          => esc_html__( 'All Projects', 'chriswiegman' ),
					'search_items'       => esc_html__( 'Search Projects', 'chriswiegman' ),
					'parent_item_colon'  => esc_html__( 'Parent Projects:', 'chriswiegman' ),
					'not_found'          => esc_html__( 'No projects found.', 'chriswiegman' ),
					'not_found_in_trash' => esc_html__( 'No projects found in Trash.', 'chriswiegman' ),
				),
				'description'          => esc_html__( 'A place to list ongoing and archived projects', 'chriswiegman' ),
				'public'               => true,
				'has_archive'          => false,
				'exclude_form_search'  => true,
				'publicly_queryable'   => false,
				'rewrite'              => false,
				'capability_type'      => 'post',
				'supports'             => array(
					'title',
					'editor',
				),
				'taxonomies'           => array( 'project_type' ),
				'register_meta_box_cb' => array( $this, 'add_project_metabox' ),
				'menu_icon'            => 'dashicons-welcome-view-site',
				'menu_position'        => 20,
			)
		);

	}

	/**
	 * Echo metabox content
	 *
	 * Echos the content of the metabox for this CPT.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function project_metabox() {

		global $post;

		// Create nonce.
		echo '<input type="hidden" name="project_post_noncename" id="project_post_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';
		echo '<table class="form-table">';

		// Get URL data.
		$project_url = get_post_meta( $post->ID, '_project_url', true );

		?>

		<tr class="width_normal p_box">
			<th scope="row"><label for="project_url"><?php esc_html_e( 'URL', 'chriswiegman' ); ?></label></th>
			<td>
				<input type="text" id="project_url" name="project_url" class="large-text" value="<?php echo esc_url( $project_url ); ?>">
			</td>
		</tr>

		<?php
		echo '</table>';

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
	public function project_save_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['project_post_noncename'] ) || ! wp_verify_nonce( $_POST['project_post_noncename'], plugin_basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// Verify credentials.
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$project_post_meta['_project_url'] = esc_url( $_POST['project_url'] );

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

	}

	/**
	 * Setup taxonomies
	 *
	 * Sets up and registers taxonomies for the project post type.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function project_taxonomy() {

		// Type taxonomy.
		$type_labels = array(
			'name'              => esc_html_x( 'Project Types', 'taxonomy general name' ),
			'singular_name'     => esc_html_x( 'Project Type', 'taxonomy singular name' ),
			'search_items'      => esc_html__( 'Search Project Types' ),
			'all_items'         => esc_html__( 'All Project Types' ),
			'parent_item'       => esc_html__( 'Parent Project Type' ),
			'parent_item_colon' => esc_html__( 'Parent Project Type:' ),
			'edit_item'         => esc_html__( 'Edit Project Type' ),
			'update_item'       => esc_html__( 'Update Project Type' ),
			'add_new_item'      => esc_html__( 'Add New Project Type' ),
			'new_item_name'     => esc_html__( 'New Project Type Name' ),
			'menu_name'         => esc_html__( 'Type' ),
		);

		$type_args = array(
			'hierarchical'      => true,
			'labels'            => $type_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);

		register_taxonomy( 'project-type', 'project', $type_args );

		// Status Taxonomy.
		$status_labels = array(
			'name'              => esc_html_x( 'Project Status', 'taxonomy general name' ),
			'singular_name'     => esc_html_x( 'Project Status', 'taxonomy singular name' ),
			'search_items'      => esc_html__( 'Search Project Statuses' ),
			'all_items'         => esc_html__( 'All Project Statuses' ),
			'parent_item'       => esc_html__( 'Parent Project Status' ),
			'parent_item_colon' => esc_html__( 'Parent Project Status:' ),
			'edit_item'         => esc_html__( 'Edit Project Status' ),
			'update_item'       => esc_html__( 'Update Project Status' ),
			'add_new_item'      => esc_html__( 'Add New Project Status' ),
			'new_item_name'     => esc_html__( 'New Project Status Name' ),
			'menu_name'         => esc_html__( 'Status' ),
		);

		$status_args = array(
			'hierarchical'      => true,
			'labels'            => $status_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);

		register_taxonomy( 'project-status', 'project', $status_args );

	}
}
