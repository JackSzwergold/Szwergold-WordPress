<?php
/*
YARPP Template: MBN — “Other Stories…”
Description: A template for the Mr. Beller’s Neighborhood “Other Stories…”
Author: Jack Szwergold
*/
?>

<?php

if ($related_query->have_posts()) {

	while ($related_query->have_posts()) {

		$related_query->the_post();

		global $post;
		global $authordata;

		/********************************************************************************/
		// Set the blog post info valiables.
		$story_author_id = $post->post_author;	//	important for sidebar!
		$excerpt = wp_trim_words(get_the_content(), 35, ' [...]');
		// $excerpt = get_the_experpt();
		$permalink = get_the_permalink();
		$the_ID = get_the_ID();
		$title = get_the_title();
		$title_attribute = the_title_attribute(array('echo' => false));
		$the_author = get_the_author();
		$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
        $display_date = get_the_time('F j, Y');
        $address = get_post_meta($post->ID, 'address', true);
        $score = get_the_score();

		/********************************************************************************/
		// Return the final return values.
		echo '<div class="h5 p-0 m-0 fw-bold" id="post_' . $the_ID . '">';
		echo '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark" rel="bookmark">';
		echo $title;
		echo '</a>';
		echo '</div>';
		echo '<div class="small p-0 m-0">';
		echo 'By ';
		echo '<a href="' . $the_author_url . '" title="Posts by ' . $the_author . '" class="text-decoration-none text-dark fw-normal">';
		echo $the_author;
		echo '</a>';
		echo '</div>';
		echo '<!-- ';
		echo $score;
		echo ' -->';
		echo '<div class="p-0 m-0 mb-3">';
		echo '<small>';
		echo '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark fw-normal">';
		echo $excerpt;
		echo '</a>';
		echo '</small>';
		echo '</div>';

	} // while

} // if
else {

	echo '<p class="small p-0 m-0 mb-3">No related stories found.</p>';

} // else

?>
