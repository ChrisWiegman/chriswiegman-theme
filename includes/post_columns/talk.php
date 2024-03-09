<?php
/**
 * Modifies the admin columns for the talk post type.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme\Post_Columns\Talk;

/**
 * Setup theme hooks.
 *
 * @since 12.0.0
 */
function init() {
	// Add and remove the columns we need.
	add_filter( 'manage_talk_posts_columns', 'CW\Theme\Post_Columns\Talk\filter_manage_talk_posts_columns' );

	// Edit each column as needed.
	add_action( 'manage_talk_posts_custom_column', 'CW\Theme\Post_Columns\Talk\action_manage_talk_posts_custom_column', 10, 2 );

	// Make the columns sortable.
	add_filter( 'manage_edit-talk_sortable_columns', 'CW\Theme\Post_Columns\Talk\filter_manage_edit_talk_sortable_columns' );
	add_filter( 'posts_join_request', 'CW\Theme\Post_Columns\Talk\filter_posts_join_request', 10, 2 );
	add_filter( 'posts_orderby_request', 'CW\Theme\Post_Columns\Talk\filter_posts_orderby_request', 10, 2 );
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

	if ( ! is_admin() || ! is_main_query() || 'talk' !== $post_type || 'title' === $order_by_var ) {
		return $orderby;
	}

	if ( '' === $order_by_var ) {
		$order_by_var = 'talk_date';
		$order_var    = 'DESC';
	}

	return sprintf( 'wp_pods_talk.%s %s', $order_by_var, $order_var );
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

	if ( ! is_admin() || ! is_main_query() || 'talk' !== $post_type || 'title' === $order_by_var ) {
		return $join;
	}

	return 'JOIN wp_pods_talk ON wp_posts.ID = wp_pods_talk.id';
}

/**
 * Filter manage_edit-talk_sortable_columns
 *
 * @since 12.0.0
 *
 * @param array $columns Associative array of sortable columns.
 *
 * @return array
 */
function filter_manage_edit_talk_sortable_columns( $columns ) {

	$columns['talk_type']   = 'talk_type';
	$columns['talk_date']   = 'talk_date';
	$columns['keynote']     = 'keynote';
	$columns['talk_link']   = 'talk_link';
	$columns['slides_link'] = 'slides_link';
	$columns['video_link']  = 'video_link';

	return $columns;
}

/**
 * Filter manage_talks_posts_columns
 *
 * Manages post columns for the talks post type.
 *
 * @since 12.0.0
 *
 * @param array $post_columns An associative array of column headings.
 *
 * @return array
 */
function filter_manage_talk_posts_columns( $post_columns ) {

	unset( $post_columns['date'] );

	$post_columns['title']       = 'Talk Title';
	$post_columns['talk_type']   = 'Talk Type';
	$post_columns['talk_date']   = 'Talk Date';
	$post_columns['event']       = 'Event';
	$post_columns['location']    = 'Location';
	$post_columns['keynote']     = 'Keynote';
	$post_columns['talk_link']   = 'Talk Link';
	$post_columns['slides_link'] = 'Slides';
	$post_columns['video_link']  = 'Video';

	return $post_columns;
}

/**
 * Action manage_talk_posts_custom_column.
 *
 * Populate the talk columns.
 *
 * @since 12.0.0
 *
 * @param string $column_name The name of the column to display.
 * @param int    $post_id The current post ID.
 */
function action_manage_talk_posts_custom_column( $column_name, $post_id ) {

	$talk = pods( 'talk', $post_id );

	switch ( $column_name ) {
		case 'talk_type':
			echo esc_html( $talk->display( 'talk_type' ) );
			break;
		case 'talk_date':
			$talk_date = $talk->field( 'talk_date' );
			if ( '0000-00-00' !== $talk_date ) {
				echo esc_html( gmdate( 'M j, Y', strtotime( $talk_date ) ) );
			}
			break;
		case 'event':
			echo esc_html( $talk->display( 'event' ) );
			break;
		case 'location':
			echo esc_html( $talk->display( 'talk_location' ) );
			break;
		case 'keynote':
			$organizer = $talk->field( 'keynote' );
			if ( '1' === $organizer ) {
				echo 'yes';
			}
			break;
		case 'talk_link':
			if ( '' !== $talk->display( 'talk_link' ) ) {
				printf( '<a href="%s" target="_blank" title="%s">Link</a>', esc_url( $talk->display( 'talk_link' ) ), esc_url( $talk->display( 'talk_link' ) ) );
			}
			break;
		case 'slides_link':
			if ( '' !== $talk->display( 'slides_link' ) ) {
				printf( '<a href="%s" target="_blank" title="%s">Slides</a>', esc_url( $talk->display( 'slides_link' ) ), esc_url( $talk->display( 'slides_link' ) ) );
			}
			break;
		case 'video_link':
			if ( '' !== $talk->display( 'video_link' ) ) {
				printf( '<a href="%s" target="_blank" title="%s">Video</a>', esc_url( $talk->display( 'video_link' ) ), esc_url( $talk->display( 'video_link' ) ) );
			}
			break;
	}
}

init();
