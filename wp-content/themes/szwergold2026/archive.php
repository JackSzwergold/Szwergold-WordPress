<?php

	/****************************************************************************/
	// Set the header.
	get_header();

	/****************************************************************************/
	// Begin the archive info area.
	echo '<div class="post_nav col col-12 p-0 m-0">';

	/****************************************************************************/
	// Header begins.
	echo '<div class="h2 text-windsorpro-bold p-0 m-0 pb-1 mb-2 border-bottom border-dark">';
	echo 'Posts for ';
	if (is_category()) {
		echo '&ldquo;';
		single_cat_title();
		echo '.&rdquo;';
	} // if
	else if (is_tag()) {
		echo '&ldquo;';
		echo single_tag_title();
		echo '.&rdquo;';
	} // else if
	else if (is_year()) {
		the_time('Y');
		echo '.';
	} // else if
	else if (is_month()) {
		the_time('F Y');
		echo '.';
	} // else if
	else if (is_day()) {
		the_time('l, F j, Y');
		echo '.';
	} // else if
	echo '</div>';

	/****************************************************************************/
	// Header ends
	echo '<p class="text-windsorpro-regular p-0 m-0 pb-1 mb-2 border-bottom border-secondary-subtle">';
	$category_description = category_description();
	if (!empty($category_description)) {
		echo strip_tags($category_description);
	} // if
	else {
		echo 'You are currently browsing posts about <strong>';
		if (is_category()) {
			echo '&ldquo;';
			single_cat_title();
			echo '.&rdquo;';
		} // if
		else if (is_tag()) {
			echo '&ldquo;';
			echo single_tag_title();
			echo '.&rdquo;';
		} // else if
		else if (is_year()) {
			the_time('Y');
			echo '.';
		} // else if
		else if (is_month()) {
			the_time('F Y');
			echo '.';
		} // else if
		else if (is_day()) {
			the_time('l, F j, Y');
			echo '.';
		} // else if
		echo '</strong>';
	} // else
	echo '</p>';

	/****************************************************************************/
	// End the archive info area.
	echo '</div>';

	/****************************************************************************/
	/****************************************************************************/
	/****************************************************************************/

	/****************************************************************************/
	// 2026-03-25: Sort posts by title instead of date.
	global $wp_query;
	$custom_criteria = array();
	$custom_criteria['order'] = 'ASC';
	$custom_criteria['orderby'] = 'title';
	$merged_criteria = array_merge($wp_query->query_vars, $custom_criteria);
	query_posts($merged_criteria);

	/****************************************************************************/
	// Init variables.
	$content = array();
	$category_details = array();
	$subcategory_slug = 'default';				

	/****************************************************************************/
	// If there are posts, do something with them.
	if (TRUE && is_archive() && have_posts()) {
		while (have_posts()) {

			/********************************************************************/
			// Get the post.
			the_post();

			/********************************************************************/
			// Set the post related values.
			$post_name = get_post_field('post_name');
			$post_ID = get_the_ID();
			$post_name_slug = get_post_field('post_name') . '_' . $post_ID;

			/********************************************************************/
			// Set the category
			$categories = get_the_category();

			/********************************************************************/
			// Process the categories to set the parent value as the key.
			foreach ($categories as $key => $value) {
				$new_key = $value->parent;
				$categories[$new_key] = (array) $value;
				unset($categories[$key]);
			} // foreach

			/********************************************************************/
			// Set the subcategory slug.
			if (count($categories) > 0) {
				$subcategory = array_shift($categories);
				$subcategory_slug = $subcategory['slug'];
				$category_details[$subcategory_slug] = $subcategory;
				$subcategory_new = array();
				$subcategory_new[$subcategory_slug] = $subcategory;
				$subcategory = $subcategory_new;
			} // if
			else {
				$subcategory_slug = $post_name;
			} // else

			/********************************************************************/
			// Append '_category' to the slug to differentiate it from the posts.
			// $subcategory_slug = $subcategory_slug . '_category';

			/********************************************************************/
			// Set the title values.
			$title = get_the_title();
			$title_attribute = the_title_attribute(array('echo' => false));

			/********************************************************************/
			// Set the temp array values.
			$temp = array();
			// $temp['categories'] = !empty($categories) ? $categories : null;
			// $temp['categories'] = !empty($subcategory) ? $subcategory : null;
			$temp['permalink'] = get_the_permalink();
			$temp['post_name'] = $post_name;
			$temp['title'] = $title;
			$temp['title_attribute'] = $title_attribute;
			$temp['excerpt'] = get_the_excerpt();
			$temp['date'] = get_the_time('F j, Y');
			$temp['time'] = get_the_time('g:i:sa');

			/********************************************************************/
			// Set the content array values.
			$content[$subcategory_slug][$post_name_slug] = $temp;

		} // while
	} // if
	else {

		/************************************************************************/
		// Set the temp array values.
		$temp = array();
		// $temp['categories'] = null;
		$temp['permalink'] = null;
		$temp['post_name'] = null;
		$temp['title'] = null;
		$temp['title_attribute'] = null;
		$temp['excerpt'] = 'Nothing was found.';
		$temp['date'] = null;
		$temp['time'] = null;

		/************************************************************************/
		// Set the content array values.
		$content[$subcategory_slug][] = $temp;

	} // else

	/****************************************************************************/
	// Key sort various items.
	ksort($category_details);
	ksort($content);

	/****************************************************************************/
	/****************************************************************************/
	/****************************************************************************/

	/****************************************************************************/
	// Init variables.
	$final = array();
	$category_prepend = null;
	$category_append = null;

	/****************************************************************************/
	// Display the parent content.
	foreach ($content as $parent_key => $parent_value) {

		/************************************************************************/
		// Init variables.
		$count = 0;
		$temp = array();

		/************************************************************************/
		// Set a prepend category value if one exists.
		if (isset($category_details[$parent_key])) {
			$category_prepend = $category_details[$parent_key]['name'];
			$category_link = get_category_link($category_details[$parent_key]['term_id']);
		} // if
		else {
			$category_prepend = null;
			$category_link = null;
		} // else

		/************************************************************************/
		// Display the child content.
		foreach ($parent_value as $child_key => $child_value) {

			/********************************************************************/
			// Init variables.
			$title = null;
			$excerpt = null;

			/********************************************************************/
			// Set the prepend.
			if (!empty($category_prepend) && $count == 0) {
				$category_prepend =
					  '<div class="h3 text-windsorpro-bold col col-12 p-0 m-0 mb-1">'
					. '<a href="' . $category_link . '">'
					. $category_prepend
					. '</a>'
					. '</div>'
					;
			} // if
			else {
				$category_prepend = null;
				$category_link = null;
			} // else

			/********************************************************************/
			// Set the prepend.
			if (isset($category_details[$parent_key]) && $count == (count($parent_value) - 1)) {
				$category_append = '<hr class="border border-dark border-1 opacity-100 p-0 m-0 mt-2 mb-3">';
			} // if
			else {
				$category_append = null;
			} // else

			/********************************************************************/
			// Set the title.
			if (!empty($child_value['permalink']) && !empty($child_value['title_attribute']) && !empty($child_value['title'])) {
				$title =
					  '<span class="p-0 m-0 text-windsorpro-bold">'
					. '<a href="' . $child_value['permalink'] . '" rel="bookmark" title="A link to &ldquo;' . $child_value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">'
					. $child_value['title']
					. '</a>'
					. '</span>'
					;
			} // if

			/********************************************************************/
			// Set the excerpt.
			if (!empty($child_value['permalink']) || !empty($child_value['excerpt'])) {
				$excerpt = !empty($child_value['excerpt']) ? $child_value['excerpt'] : null;
				if (!empty($child_value['permalink'])) {
					$excerpt =
						  '<a href="' . $child_value['permalink'] . '" title="A link to &ldquo;' . $child_value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">'
						. $excerpt
						. '</a>'
						;
				} // if
				$excerpt =
					  '<span class="text-windsorpro-regular">'
					. $excerpt
					. '</span>'
					;
			} // if

			/********************************************************************/
			// Set the date and time.
			$date = '<span class="text-windsorpro-regular">' . $child_value['date'] . '</span>';
			$time = '<span class="text-windsorpro-regular">' . $child_value['time'] . '</span>';

			/********************************************************************/
			// Set the final row.
			$temp[] = 
				  '<div class="col col-12 p-0 m-0 mb-1 bg-warning">'
				// . (!empty($category_prepend) ? $category_prepend : null)
				. (!empty($title) ? $title : null)
				. (!empty($title) ? '<span class="text-windsorpro-regular">: </span>' : null)
				. $excerpt
				// . '<span class="text-windsorpro-regular"> &mdash; </span>'
				// . $date
				// . $category_append
				. '</div>'
				;

			/********************************************************************/
			// Increment the counter.
			$count++;

		} // foreach

		$final[] = $temp;

	} // foreach

	print_r($final);

	// /****************************************************************************/
	// // Show the content.
	// $final = $temp;

	// /****************************************************************************/
	// // Show the content.
	// echo '<div class="archive_content p-0 m-0">';
	// echo implode('', $final);
	// echo '</div>';

	/****************************************************************************/
	// Set the sidebar.
	get_sidebar();

	/****************************************************************************/
	// Set the footer.
	get_footer();

?>