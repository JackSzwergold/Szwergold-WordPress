<?php

	/********************************************************************************/
	// Set the header.
	get_header();

?>
<div class="row p-0 m-0">
	<?php

		/****************************************************************************/
		// Show the archive info.
		echo '<div class="post_nav col col-12 p-0 m-0">';

		/****************************************************************************/
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

		/****************************************************************************/
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

		/****************************************************************************/
		// Arhcive info ends.
		echo '</div>';

		/****************************************************************************/
		// Init variables.
		$content = array();

		/****************************************************************************/
		// If there are posts, do something with them.
		if (have_posts()) {
			while (have_posts()) {

				/********************************************************************/
				// Get the post.
				the_post();

				/********************************************************************/
				// Set the temp array values.
				$temp = array();
				$temp['permalink'] = get_the_permalink();
				$temp['title'] = get_the_title();
				$temp['title_attribute'] = the_title_attribute(array('echo' => false));
				$temp['excerpt'] = get_the_excerpt();

				/********************************************************************/
				// Set the content array values.
				$content[] = $temp;

			} // while
		} // if
		else {

			/********************************************************************/
			// Begin the container.
			echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

			/********************************************************************/
			// Show the main area.
			echo '<div class="text-georgia-regular small">';

			/********************************************************************/
			// Show the excerpt.
			echo "Nothing found.";

			/********************************************************************/
			// End the header.
			echo '</div>';

			/********************************************************************/
			// End the container.
			echo '</div>';

		} // else

		/************************************************************************/
		// Display the content.
		foreach ($content as $value) {

			/********************************************************************/
			// Begin the container.
			echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

			/********************************************************************/
			// Begin the header.
			echo '<header class="col col-12 p-0 m-0">';

			/********************************************************************/
			// Show the title.
			echo '<div class="h5 p-0 m-0 text-windsorpro-bold">';
			echo '<a href="' . $value['permalink'] . '" rel="bookmark" title="A link to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-dark text-decoration-none">';
			echo $value['title'];
			echo '</a>';
			echo '</div>';

			/********************************************************************/
			// End the header.
			echo '</header>';

			/********************************************************************/
			// Show the main area.
			echo '<div class="text-georgia-regular small">';

			/********************************************************************/
			// Show the excerpt.
			echo '<a href="' . $value['permalink'] . '" title="A link to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">';
			echo $value['excerpt'];
			echo '</a>';

			/********************************************************************/
			// End the header.
			echo '</div>';

			/********************************************************************/
			// End the container.
			echo '</div>';

		} // foreach

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