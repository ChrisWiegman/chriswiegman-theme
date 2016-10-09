<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @since   5.0.0
 *
 * @package chriswiegman
 *
 * @author  Chris Wiegman <chris@chriswiegman.com>
 */

namespace CW\Theme\Functions\Template_Tags;

/**
 * Show paging navigation
 *
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 5.0.0
 *
 * @param \WP_Query $query The global WP_Query.
 *
 * @return void
 */
function paging_nav( $query = null ) {

	if ( null === $query ) {
		$query = $GLOBALS['wp_query'];
	}

	// Don't print empty markup if there's only one page.
	if ( $query->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'chriswiegman' ); ?></h1>

		<div class="nav-links">

			<?php if ( get_next_posts_link( null, $query->max_num_pages ) ) { ?>

				<div class="nav-previous"><?php next_posts_link( sprintf( esc_html__( '%s Older posts', 'chriswiegman' ), '<span class="meta-nav">&larr;</span>' ), $query->max_num_pages ); ?></div>
			<?php } ?>

			<?php if ( get_previous_posts_link() ) { ?>
				<div
					class="nav-next"><?php previous_posts_link( sprintf( esc_html__( 'Newer posts %s', 'chriswiegman' ), '<span class="meta-nav">&rarr;</span>' ) ); ?></div>
			<?php } ?>

		</div>
		<!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Show post navigation
 *
 * Display navigation to next/previous post when applicable.
 *
 * @since 5.0.0
 *
 * @return void
 */
function post_nav() {

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'chriswiegman' ); ?></h1>

		<div class="nav-links">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'chriswiegman' ) );
			next_post_link( '<div class="nav-next">%link</div>', _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link', 'chriswiegman' ) );
			?>
		</div>
		<!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Show posted on
 *
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 5.0.0
 *
 * @return void
 */
function posted_on() {

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'F jS, Y' ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date( 'F jS, Y' ) )
	);

	$posted_on = '<span class="posted-on">' . $time_string . '</span>';

	if ( get_the_author_meta( 'ID' ) !== 2 ) {

		$byline = sprintf(
			_x( ' by %s', 'post author', 'chriswiegman' ),
			'<span class="byline"> <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span> </span>'
		);

	} else {

		$byline = '';

	}

	if ( ! post_password_required() && ( comments_open() || 0 !== get_comments_number() ) ) {

		$comments = sprintf( '<span class="comments-link">%s</span>', get_comments_popup_link() );

	} else {

		$comments = '';

	}

	$edit_link = get_edit_post_link();

	if ( null !== $edit_link ) {

		$edit = sprintf( ' | <span class="edit-link"><a href="%s">%s</a></span>', $edit_link, esc_attr__( 'Edit', 'chriswiegman' ) );

	} else {

		$edit = '';

	}

	echo $posted_on . $byline . $comments . $edit; // WPCS: XSS OK.

}

/**
 * Determine blog categories
 *
 * Returns true if a blog has more than 1 category.
 *
 * @since 5.0.0
 *
 * @return bool Returns true if a blog has more than 1 category.
 */
function categorized_blog() {

	if ( false === ( $all_the_cool_cats = get_transient( 'chriswiegman_categories' ) ) ) {

		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'chriswiegman_categories', $all_the_cool_cats );

	}

	if ( $all_the_cool_cats > 1 ) {

		// This blog has more than 1 category so chriswiegman_categorized_blog should return true.
		return true;

	} else {

		// This blog has only 1 category so chriswiegman_categorized_blog should return false.
		return false;

	}
}

/**
 * Flush out the transients used in chriswiegman_categorized_blog.
 *
 * @since 5.0.0
 *
 * @return void
 */
function category_transient_flusher() {

	delete_transient( 'chriswiegman_categories' );

}

add_action( 'edit_category', 'CW\Theme\Functions\Template_Tags\category_transient_flusher' );
add_action( 'save_post', 'CW\Theme\Functions\Template_Tags\category_transient_flusher' );

/**
 * Displays the link to the comments popup window for the current post ID.
 *
 * Is not meant to be displayed on single posts and pages. Should be used
 * on the lists of posts
 *
 * @since 5.0.0
 *
 * @param string|bool $zero      Optional. String to display when no comments. Default false.
 * @param string|bool $one       Optional. String to display when only one comment is available. Default false.
 * @param string|bool $more      Optional. String to display when there are more than one comment. Default false.
 * @param string|bool $css_class Optional. CSS class to use for comments. Default empty.
 * @param string|bool $none      Optional. String to display when comments have been turned off. Default false.
 *
 * @return null Returns null on single posts and pages.
 */
function get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {

	global $wpcommentspopupfile, $wpcommentsjavascript;

	$id = get_the_ID();

	if ( false === $zero ) {
		$zero = esc_html__( 'No Comments', 'chriswiegman' );
	}

	if ( false === $one ) {
		$one = esc_html__( '1 Comment', 'chriswiegman' );
	}

	if ( false === $more ) {
		$more = esc_html__( '% Comments', 'chriswiegman' );
	}

	if ( false === $none ) {
		$none = esc_html__( 'Comments Off', 'chriswiegman' );
	}

	$number = absint( get_comments_number( $id ) );

	if ( 0 === $number && ! comments_open() && ! pings_open() ) {
		return '<span' . ( ( ! empty( $css_class ) ) ? ' class="' . esc_attr( $css_class ) . '"' : '' ) . '>' . $none . '</span>';
	}

	if ( post_password_required() ) {
		return esc_html__( 'Enter your password to view comments.', 'chriswiegman' );
	}

	$return_string = '<a href="';

	if ( $wpcommentsjavascript ) {

		if ( empty( $wpcommentspopupfile ) ) {

			$home = home_url();

		} else {

			$home = get_option( 'siteurl' );

		}

		$return_string .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
		$return_string .= '" onclick="wpopen(this.href); return false"';

	} else { // If comments_popup_script() is not in the template, display simple comment link.

		if ( 0 === $number ) {

			$return_string .= get_permalink() . '#respond';

		} else {

			$return_string .= get_comments_link();

		}

		$return_string .= '"';

	}

	if ( ! empty( $css_class ) ) {
		$return_string .= ' class="' . $css_class . '" ';
	}

	$title      = the_title_attribute( array( 'echo' => 0 ) );
	$attributes = '';

	$return_string .= apply_filters( 'comments_popup_link_attributes', $attributes );
	$return_string .= ' title="' . esc_attr( sprintf( __( 'Comment on %s', 'chriswiegman' ), $title ) ) . '">';
	$return_string .= get_comments_number_string( $zero, $one, $more );
	$return_string .= '</a>';

	return $return_string;

}

/**
 * Display the language string for the number of comments the current post has.
 *
 * @since 5.0.0
 *
 * @param string|bool $zero       Optional. Text for no comments. Default false.
 * @param string|bool $one        Optional. Text for one comment. Default false.
 * @param string|bool $more       Optional. Text for more than one comment. Default false.
 *
 * @return string Number of comments
 */
function get_comments_number_string( $zero = false, $one = false, $more = false ) {

	$number = absint( get_comments_number() );

	if ( $number > 1 ) {

		$output = str_replace( '%', number_format_i18n( $number ), ( false === $more ) ? esc_html__( '% Comments', 'chriswiegman' ) : $more );

	} elseif ( 0 === $number ) {

		$output = ( false === $zero ) ? esc_html__( 'No Comments', 'chriswiegman' ) : $zero;

	} else {

		$output = ( false === $one ) ? esc_html__( '1 Comment', 'chriswiegman' ) : $one;

	}

	return apply_filters( 'comments_number', $output, $number );

}
