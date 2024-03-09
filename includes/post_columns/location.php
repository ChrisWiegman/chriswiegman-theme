<?php
/**
 * Modifies the admin columns for the location post type.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme\Post_Columns\Location;

/**
 * Setup theme hooks.
 *
 * @since 12.0.0
 */
function init() {
	// Add and remove the columns we need.
	add_filter( 'manage_location_posts_columns', 'CW\Theme\Post_Columns\Location\filter_manage_location_posts_columns' );

	// Edit each column as needed.
	add_action( 'manage_location_posts_custom_column', 'CW\Theme\Post_Columns\Location\action_manage_location_posts_custom_column', 10, 2 );

	// Make the columns sortable.
	add_filter( 'manage_edit-location_sortable_columns', 'CW\Theme\Post_Columns\Location\filter_manage_edit_location_sortable_columns' );
	add_filter( 'posts_join_request', 'CW\Theme\Post_Columns\Location\filter_posts_join_request', 10, 2 );
	add_filter( 'posts_orderby_request', 'CW\Theme\Post_Columns\Location\filter_posts_orderby_request', 10, 2 );
}

/**
 * Filter posts_orderby_request
 *
 * Creates the appropriate SQL to join by a pods field.
 *
 * @since 12.0.0
 *
 * @param string $orderby The ORDER BY clause of the query.
 *
 * @return string
 */
function filter_posts_orderby_request( $orderby ) {

	$order_by_var = get_query_var( 'orderby', false );
	$order_var    = get_query_var( 'order', false );
	$post_type    = get_query_var( 'post_type', false );

	if ( ! is_admin() || ! is_main_query() || 'location' !== $post_type || 'title' === $order_by_var || '' === $order_by_var ) {
		return $orderby;
	}

	return sprintf( 'wp_pods_location.%s %s', $order_by_var, $order_var );
}

/**
 * Filter posts_join_request
 *
 * Joins the appropriate Pods table for sorting
 *
 * @since 12.0.0
 *
 * @param string $join  The JOIN clause of the query.
 *
 * @return string
 */
function filter_posts_join_request( $join ) {

	$order_by_var = get_query_var( 'orderby', false );
	$post_type    = get_query_var( 'post_type', false );

	if ( ! is_admin() || ! is_main_query() || 'location' !== $post_type || 'title' === $order_by_var || '' === $order_by_var ) {
		return $join;
	}

	return 'JOIN wp_pods_location ON wp_posts.ID = wp_pods_location.id';
}

/**
 * Filter manage_edit-location_sortable_columns
 *
 * @since 12.0.0
 *
 * @param array $columns Associative array of sortable columns.
 *
 * @return array
 */
function filter_manage_edit_location_sortable_columns( $columns ) {

	$columns['latitude']  = 'latitude';
	$columns['longitude'] = 'longitude';

	return $columns;
}

/**
 * Filter manage_locations_posts_columns
 *
 * Manages post columns for the locations post type.
 *
 * @since 12.0.0
 *
 * @param array $post_columns An associative array of column headings.
 *
 * @return array
 */
function filter_manage_location_posts_columns( $post_columns ) {

	unset( $post_columns['date'] );

	$post_columns['title']       = 'Location';
	$post_columns['latitude']    = 'Latitude';
	$post_columns['longitude']   = 'Longitude';
	$post_columns['event_count'] = 'Event Count';
	$post_columns['talk_count']  = 'Talk Count';

	return $post_columns;
}

/**
 * Action manage_location_posts_custom_column.
 *
 * Populate the location columns.
 *
 * @since 12.0.0
 *
 * @param string $column_name The name of the column to display.
 * @param int    $post_id The current post ID.
 */
function action_manage_location_posts_custom_column( $column_name, $post_id ) {

	$location = pods( 'location', $post_id );

	switch ( $column_name ) {
		case 'latitude':
			echo esc_html( $location->display( 'latitude' ) );
			break;
		case 'longitude':
			echo esc_html( $location->display( 'longitude' ) );
			break;
		case 'event_count':
			$events = $location->field( 'events' );
			if ( false !== $events ) {
				echo count( $events );
			}
			break;
		case 'talk_count':
			$talks = $location->field( 'talks' );
			if ( false !== $talks ) {
				echo count( $talks );
			}
			break;
	}
}

init();
