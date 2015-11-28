<?php
/**
 * Show morning and evening journal content.
 *
 * @package    WordPress

 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php $type = ( 'morning-journal' === get_post_type() ) ? 'Morning' : 'Evening'; ?>
		<?php the_title( '<h2 class="entry-title">', ' - ' . $type . '</h2>' ); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php

		if ( 'Evening' === $type ) {

			echo '<h3>List 3 Amazing things happened today:</h3>';

			echo '<ol>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_amazing_1', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_amazing_2', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_amazing_3', true ) ) . '</li>';
			echo '</ol>';

			echo '<h3>How could you have made today better?</h3>';

			echo '<ol>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_better_1', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_better_2', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_evening_better_3', true ) ) . '</li>';
			echo '</ol>';

		} else {

			echo '<h3>Context:</h3>';

			echo '<p>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_context', true ) ) . '</p>';

			echo '<h3>I\'m grateful for:</h3>';

			echo '<ol>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_grateful_1', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_grateful_2', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_grateful_3', true ) ) . '</li>';
			echo '</ol>';

			echo '<h3>What would make today better:</h3>';

			echo '<ol>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_better_1', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_better_2', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_better_3', true ) ) . '</li>';
			echo '</ol>';

			echo '<h3>Daily affirmation:</h3>';

			echo '<ol>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_affirmation_1', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_affirmation_2', true ) ) . '</li>';
			echo '<li>' . esc_html( get_post_meta( get_the_ID(), '_journal_morning_affirmation_3', true ) ) . '</li>';
			echo '</ol>';

		}
		?>
	</div>
	<!-- .entry-content -->

</article><!-- #post-## -->