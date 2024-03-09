<?php
/**
 * Modifies the admin columns for the event post type.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme\Post_Columns\Event;

/**
 * Setup theme hooks.
 *
 * @since 12.0.0
 */
function init() {
	// Add and remove the columns we need.
	add_filter( 'manage_event_posts_columns', 'CW\Theme\Post_Columns\Event\filter_manage_event_posts_columns' );

	// Edit each column as needed.
	add_action( 'manage_event_posts_custom_column', 'CW\Theme\Post_Columns\Event\action_manage_event_posts_custom_column', 10, 2 );

	// Make the columns sortable.
	add_filter( 'manage_edit-event_sortable_columns', 'CW\Theme\Post_Columns\Event\filter_manage_edit_event_sortable_columns' );
	add_filter( 'posts_join_request', 'CW\Theme\Post_Columns\Event\filter_posts_join_request', 10, 2 );
	add_filter( 'posts_orderby_request', 'CW\Theme\Post_Columns\Event\filter_posts_orderby_request', 10, 2 );
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

	if ( ! is_admin() || ! is_main_query() || 'event' !== $post_type || 'title' === $order_by_var ) {
		return $orderby;
	}

	if ( '' === $order_by_var ) {
		$order_by_var = 'event_date';
		$order_var    = 'DESC';
	}

	return sprintf( 'wp_pods_event.%s %s', $order_by_var, $order_var );
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

	if ( ! is_admin() || ! is_main_query() || 'event' !== $post_type || 'title' === $order_by_var ) {
		return $join;
	}

	return 'JOIN wp_pods_event ON wp_posts.ID = wp_pods_event.id';
}

/**
 * Filter manage_edit-event_sortable_columns
 *
 * @since 12.0.0
 *
 * @param array $columns Associative array of sortable columns.
 *
 * @return array
 */
function filter_manage_edit_event_sortable_columns( $columns ) {

	$columns['event_type'] = 'event_type';
	$columns['event_date'] = 'event_date';
	$columns['organizer']  = 'organizer';

	return $columns;
}

/**
 * Filter manage_events_posts_columns
 *
 * Manages post columns for the events post type.
 *
 * @since 12.0.0
 *
 * @param array $post_columns An associative array of column headings.
 *
 * @return array
 */
function filter_manage_event_posts_columns( $post_columns ) {

	unset( $post_columns['date'] );

	$post_columns['title']      = 'Event';
	$post_columns['event_type'] = 'Event Type';
	$post_columns['event_date'] = 'Event Date';
	$post_columns['location']   = 'Location';
	$post_columns['organizer']  = 'Organizer';
	$post_columns['talk_count'] = 'Talk Count';

	return $post_columns;
}

/**
 * Action manage_event_posts_custom_column.
 *
 * Populate the event columns.
 *
 * @since 12.0.0
 *
 * @param string $column_name The name of the column to display.
 * @param int    $post_id The current post ID.
 */
function action_manage_event_posts_custom_column( $column_name, $post_id ) {

	$event = pods( 'event', $post_id );

	switch ( $column_name ) {
		case 'event_type':
			echo esc_html( $event->display( 'event_type' ) );
			break;
		case 'event_date':
			$event_date = $event->field( 'event_date' );
			if ( '0000-00-00' !== $event_date ) {
				echo esc_html( gmdate( 'M j, Y', strtotime( $event_date ) ) );
			}
			break;
		case 'location':
			echo esc_html( $event->display( 'location' ) );
			break;
		case 'organizer':
			$organizer = $event->field( 'organizer' );
			if ( '1' === $organizer ) {
				echo 'yes';
			}
			break;
		case 'talk_count':
			$talks = $event->field( 'talks' );
			if ( false !== $talks ) {
				echo count( $talks );
			}
			break;
	}
}

init();
