<?php

	/********************************************************************************/
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

	/****************************************************************************/
	// If there are posts, do something with them.
	if (TRUE && is_archive() && have_posts()) {
		while (have_posts()) {

			/********************************************************************/
			// Get the post.
			the_post();

			// /********************************************************************/
			// // Set the category array options.
			// $category_settings = array();
			// $category_settings['taxonomy'] = 'category';
			// $category_settings['type'] = 'post';
			// $category_settings['child_of'] = false;
			// $category_settings['parent'] = '';
			// $category_settings['orderby'] = 'name';
			// $category_settings['order'] = 'ASC';
			// $category_settings['hide_empty'] = true;
			// $category_settings['hierarchical'] = true;
			// $category_settings['exclude'] = '';
			// $category_settings['include'] = '';
			// $category_settings['number'] = false;
			// $category_settings['pad_counts'] = false;

			// /********************************************************************/
			// // Get the categories.
			// $categories = get_categories($category_settings);
			// echo '<pre>';
			// print_r($categories);
			// echo '</pre>';

			/********************************************************************/
			// Set the temp array values.
			$temp = array();
			$temp['category'] = get_the_category();
			$temp['permalink'] = get_the_permalink();
			$temp['title'] = get_the_title();
			$temp['title_attribute'] = the_title_attribute(array('echo' => false));
			$temp['excerpt'] = get_the_excerpt();
			$temp['date'] = get_the_time('F j, Y');
			$temp['time'] = get_the_time('g:i:sa');

			/********************************************************************/
			// Set the content array values.
			$content[] = $temp;

		} // while
	} // if
	else {

		/********************************************************************/
		// Set the temp array values.
		$temp = array();
		$temp['permalink'] = null;
		$temp['title'] = null;
		$temp['title_attribute'] = null;
		$temp['excerpt'] = 'Nothing was found.';
		$temp['date'] = null;
		$temp['time'] = null;

		/********************************************************************/
		// Set the content array values.
		$content[] = $temp;

	} // else

	echo '<pre>';
	print_r($temp);
	echo '</pre>';


	/************************************************************************/
	/************************************************************************/
	/************************************************************************/

	/****************************************************************************/
	// Init variables.
	$final = array();

	/************************************************************************/
	// Display the content.
	foreach ($content as $value) {

		/********************************************************************/
		// Init variables.
		$title = null;
		$excerpt = null;

		/********************************************************************/
		// Set the title.
		if (!empty($value['permalink']) && !empty($value['title_attribute']) && !empty($value['title'])) {
			$title =
				  '<span class="p-0 m-0 text-windsorpro-bold">'
				. '<a href="' . $value['permalink'] . '" rel="bookmark" title="A link to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">'
				. $value['title']
				. '</a>'
				. '</span>'
				;
		} // if

		/********************************************************************/
		// Set the excerpt.
		if (!empty($value['permalink']) && !empty($value['excerpt'])) {
			$excerpt = !empty($value['excerpt']) ? $value['excerpt'] : null;
			if (!empty($value['permalink'])) {
				$excerpt =
					  '<a href="' . $value['permalink'] . '" title="A link to &ldquo;' . $value['title_attribute'] . '.&rdquo;" class="text-decoration-none text-dark">'
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

		$date = '<span class="text-windsorpro-regular">' . $value['date'] . '</span>';
		$time = '<span class="text-windsorpro-regular">' . $value['time'] . '</span>';

		/********************************************************************/
		// Set the final row.
		$final[] = 
			  '<div class="col col-12 p-0 m-0 mb-1">'
			. $title
			. '<span class="text-windsorpro-regular">: </span>'
			. $excerpt
			// . '<span class="text-windsorpro-regular"> &mdash; </span>'
			// . $date
			. '</div>'
			;

	} // foreach

	/**********************************************************************/
	// Show the content.
	echo '<div class="archive_content p-0 m-0">';
	echo implode('', $final);
	echo '</div>';

	/**********************************************************************/
	// Set the sidebar.
	get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>