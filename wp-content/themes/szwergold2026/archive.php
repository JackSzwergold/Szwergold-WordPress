<?php

	/**********************************************************************/
	// Set the header.
	get_header();

?>
<div class="row p-0 m-0">
	<?php

		/********************************************************************************/
		// Show the archive info.
		echo '<div class="post_nav col col-12 p-0 m-0">';

		/********************************************************************************/
		// Header begins.
		echo '<div class="h2 text-windsorpro-bold p-0 m-0 fw-bold pb-1 mb-2 border-bottom border-dark">';
		echo 'Posts for &ldquo;';
		if (is_category()) {
			single_cat_title();
		} // if
		else if (is_tag()) {
			echo single_tag_title();
		} // else if
		echo '.&rdquo;';
		echo '</div>';

		/********************************************************************************/
		// Header ends
		echo '<p class="text-windsorpro-regular">';
		$category_description = category_description();
		if (!empty($category_description)) {
			$category_description = strip_tags($category_description);
			echo $category_description;
		} // if
		else {
			echo 'You are currently browsing posts about <strong>&ldquo;';
			if (is_category()) {
				single_cat_title();
			} // if
			else if (is_tag()) {
				echo single_tag_title();
			} // else if
			echo '.&rdquo;</strong>';
		} // else
		echo '</p>';

		/********************************************************************************/
		// Arhcive info ends.
		echo '</div>';

		if (TRUE && have_posts()) {

			while (have_posts()) {

				global $authordata;

				/********************************************************************/
				// Get the post.
				the_post();

				/********************************************************************/
				// Set the item info variables.
				// $the_ID = get_the_ID();
				$permalink = get_the_permalink();
				$title = get_the_title();
				$title_attribute = the_title_attribute(array('echo' => false));
				$excerpt = get_the_excerpt();
				// $the_author = $authordata->user_nicename;
				// $the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
				// $update_date = get_the_time('F j, Y');
				// $update_time = get_the_time('g:i:sa');

				/********************************************************************/
				// Begin the container.
				echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

				/********************************************************************/
				// Begin the header.
				echo '<header class="col col-12 p-0 m-0">';

				/********************************************************************/
				// Show the title.
				echo '<div class="h5 p-0 m-0 text-windsorpro-bold">';
				echo '<a href="' . $permalink . '" rel="bookmark" title="A link to &ldquo;' . $title_attribute . '.&rdquo;" class="text-dark text-decoration-none">';
				echo $title;
				echo '</a>';
				echo '</div>';

				/********************************************************************/
				// Show the author, date and time.
				// if (!empty($the_author)) {
				// 	echo '<div class="p-0 m-0 text-windsorpro-regular">';
				// 	echo 'By ' . $the_author;
				// 	if (!empty($update_date)) {
				// 		echo ' on ' . $update_date;
				// 		if (!empty($update_time)) {
				// 			echo ' at ' . $update_time;
				// 		} // if
				// 	} // if
				// 	echo '.';
				// 	echo '</div>';				
				// } // if

				/********************************************************************/
				// End the header.
				echo '</header>';

				/********************************************************************/
				// Show the main area.
				echo '<div class="text-georgia-regular">';
				echo '<span class="small">';

				/********************************************************************/
				// Show the excerpt.
				echo '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark">';
				echo $excerpt;
				echo '</a>';

				/********************************************************************/
				// End the header.
				echo '</span>';
				echo '</div>';

				/********************************************************************/
				// End the container.
				echo '</div>';

			} // while

		} // if
		else {

			/********************************************************************/
			// Begin the container.
			echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

			/********************************************************************/
			// Show the main area.
			echo '<div class="text-georgia-regular">';
			echo '<span class="small">';

			/********************************************************************/
			// Show the excerpt.
			echo "Nothing found.";

			/********************************************************************/
			// End the header.
			echo '</span>';
			echo '</div>';

			/********************************************************************/
			// End the container.
			echo '</div>';

		} // else
	?>
</div>
<?php

	/**********************************************************************/
	// Set the sidebar.
	get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>