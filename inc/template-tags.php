<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ChrisWiegman
 */

if ( ! function_exists( 'chriswiegman_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function chriswiegman_paging_nav() {

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'chriswiegman' ); ?></h1>

			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
					<div
						class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'chriswiegman' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div
						class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'chriswiegman' ) ); ?></div>
				<?php endif; ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;

if ( ! function_exists( 'chriswiegman_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function chriswiegman_post_nav() {

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'chriswiegman' ); ?></h1>

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
endif;

if ( ! function_exists( 'chriswiegman_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function chriswiegman_posted_on() {

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
		                        esc_attr( get_the_date( 'c' ) ),
		                        esc_html( get_the_date( 'F jS, Y' ) ),
		                        esc_attr( get_the_modified_date( 'c' ) ),
		                        esc_html( get_the_modified_date( 'F jS, Y' ) )
		);

		$posted_on = $time_string;

		$byline = sprintf(
			_x( 'by %s', 'post author', 'chriswiegman' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span> '
		);

		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {

			$comments = sprintf( '| <span class="comments-link">%s</span>', chriswiegman_get_comments_popup_link( __( 'Leave a comment', 'chriswiegman' ), __( '1 Comment', 'chriswiegman' ), __( '% Comments', 'chriswiegman' ) ) );

		} else {

			$comments = '';

		}

		$edit_link = get_edit_post_link();

		if ( $edit_link != null ) {

			$edit = sprintf( '| <span class="edit-link"><a href="%s">%s</a></span>', $edit_link, __( 'Edit', 'chriswiegman' ) );

		} else {

			$edit = '';

		}

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>' . $comments . ' ' . $edit;

	}
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function chriswiegman_categorized_blog() {

	if ( false === ( $all_the_cool_cats = get_transient( 'chriswiegman_categories' ) ) ) {
// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			                                     'fields'     => 'ids',
			                                     'hide_empty' => 1,

			                                     // We only need to know if there is more than one category.
			                                     'number'     => 2,
		                                     ) );

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
 */
function chriswiegman_category_transient_flusher() {

// Like, beat it. Dig?
	delete_transient( 'chriswiegman_categories' );
}

add_action( 'edit_category', 'chriswiegman_category_transient_flusher' );
add_action( 'save_post', 'chriswiegman_category_transient_flusher' );

/**
 * Displays the link to the comments popup window for the current post ID.
 *
 * Is not meant to be displayed on single posts and pages. Should be used
 * on the lists of posts
 *
 * @global string $wpcommentspopupfile  The URL to use for the popup window.
 * @global int    $wpcommentsjavascript Whether to use JavaScript. Set when function is called.
 *
 * @since 0.71
 *
 * @param string  $zero                 Optional. String to display when no comments. Default false.
 * @param string  $one                  Optional. String to display when only one comment is available.
 *                                      Default false.
 * @param string  $more                 Optional. String to display when there are more than one comment.
 *                                      Default false.
 * @param string  $css_class            Optional. CSS class to use for comments. Default empty.
 * @param string  $none                 Optional. String to display when comments have been turned off.
 *                                      Default false.
 *
 * @return null Returns null on single posts and pages.
 */
function chriswiegman_get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {

	global $wpcommentspopupfile, $wpcommentsjavascript;

	$id = get_the_ID();

	if ( false === $zero ) {
		$zero = __( 'No Comments' );
	}

	if ( false === $one ) {
		$one = __( '1 Comment' );
	}

	if ( false === $more ) {
		$more = __( '% Comments' );
	}

	if ( false === $none ) {
		$none = __( 'Comments Off' );
	}

	$number = get_comments_number( $id );

	if ( 0 == $number && ! comments_open() && ! pings_open() ) {
		return '<span' . ( ( ! empty( $css_class ) ) ? ' class="' . esc_attr( $css_class ) . '"' : '' ) . '>' . $none . '</span>';
	}

	if ( post_password_required() ) {
		return __( 'Enter your password to view comments.' );
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

	} else { // if comments_popup_script() is not in the template, display simple comment link

		if ( 0 == $number ) {

			$return_string .= get_permalink() . '#respond';

		} else {

			$return_string .= get_comments_link();

		}

		$return_string .= '"';

	}

	if ( ! empty( $css_class ) ) {
		$return_string .= ' class="' . $css_class . '" ';
	}

	$title = the_title_attribute( array( 'echo' => 0 ) );
	$attributes = '';

	$return_string .= apply_filters( 'comments_popup_link_attributes', $attributes );
	$return_string .= ' title="' . esc_attr( sprintf( __( 'Comment on %s' ), $title ) ) . '">';
	$return_string .= chriswiegman_getcomments_number( $zero, $one, $more );
	$return_string .= '</a>';

	return $return_string;

}

/**
 * Display the language string for the number of comments the current post has.
 *
 * @since 0.71
 *
 * @param string $zero       Optional. Text for no comments. Default false.
 * @param string $one        Optional. Text for one comment. Default false.
 * @param string $more       Optional. Text for more than one comment. Default false.
 * @param string $deprecated Not used.
 */
function chriswiegman_getcomments_number( $zero = false, $one = false, $more = false, $deprecated = '' ) {

	if ( ! empty( $deprecated ) ) {
		_deprecated_argument( __FUNCTION__, '1.3' );
	}

	$number = get_comments_number();

	if ( $number > 1 ) {

		$output = str_replace( '%', number_format_i18n( $number ), ( false === $more ) ? __( '% Comments' ) : $more );

	} elseif ( $number == 0 ) {

		$output = ( false === $zero ) ? __( 'No Comments' ) : $zero;

	} else {

		$output = ( false === $one ) ? __( '1 Comment' ) : $one;

	}

	return apply_filters( 'comments_number', $output, $number );

}
