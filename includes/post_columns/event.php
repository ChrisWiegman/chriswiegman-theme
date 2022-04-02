<?php
/**
 * Modifies the admin colummns for the event post type.
 *
 * @package chriswiegman-theme
 */

namespace CW\Theme\Post_Columns;

/**
 * Setup theme hooks.
 *
 * @since 12.0.0
 */
function init() {

	$n = function ( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Add and remove the columns we need.
	add_filter( 'manage_event_posts_columns', $n( 'filter_manage_event_posts_columns' ) );

	// Edit each column as needed.
	add_action( 'manage_event_posts_custom_column', $n( 'action_manage_event_posts_custom_column' ), 10, 2 );
}

/**
 * Filter manage_events_posts_columns
 *
 * Manages post columns for the events post type.
 *
 * @since 12.0.0
 *
 * @param array $post_columns An associative array of column headings.
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
