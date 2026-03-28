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
	// Get the current selected parent category ID and slug.
	$page_category_parent = get_category(get_query_var('cat'));
	$page_category_id = $page_category_parent->cat_ID;
	$page_category_slug = $page_category_parent->slug;
	if (!empty($page_category_parent->parent)) {
		$page_category_parent = get_category($page_category_parent->parent);
		if (empty($page_category_parent->parent)) {
			$page_category_id = $page_category_parent->cat_ID;
			$page_category_slug = $page_category_parent->slug;
		} // if
		else {
			$page_category_grandparent = get_category($page_category_parent->parent);
			if (empty($page_category_grandparent->parent)) {
				$page_category_id = $page_category_grandparent->cat_ID;
				$page_category_slug = $page_category_grandparent->slug;
			} // if
		} // else	
	} // if

	/********************************************************************/
	// Set the category
	$page_category_child = get_the_category();

	/****************************************************************************/
	// Get the current selected child category ID and slug.
	$page_subcategory_id = null;
	$page_subcategory_slug = null;
	if (count($page_category_child) > 0) {
		$page_subcategory = array_shift($page_category_child);
		$page_subcategory_id = $page_subcategory->cat_ID;
		$page_subcategory_slug = $page_subcategory->slug;
	} // if

	/******************************************************************************/
	// Set what to exclude and to exlcude in the categories settings.
	$exclude = null;
	$include = null;
	if (get_query_var('cat') == $page_category_id) {
		$exclude = $page_category_id;
	} // if
	if (get_query_var('cat') == $page_subcategory_id) {
		$exclude = $page_category_id;
		$include = $page_subcategory_id;
	} // if

	/******************************************************************************/
	// Set the category array options.
	$category_settings = array();
	$category_settings['taxonomy'] = 'category';
	$category_settings['type'] = 'post';
	$category_settings['child_of'] = false;
	$category_settings['parent'] = '';
	$category_settings['orderby'] = 'name';
	$category_settings['order'] = 'ASC';
	$category_settings['hide_empty'] = true;
	$category_settings['hierarchical'] = true;
	$category_settings['exclude'] = $exclude;
	$category_settings['include'] = $include;
	$category_settings['number'] = false;
	$category_settings['pad_counts'] = false;

	/******************************************************************************/
	// Get the categories.
	$categories_test = get_categories($category_settings);

	/******************************************************************************/
	// If we have categories, do something.
	$category_details = array();
	if (!empty($categories_test)) {
		foreach ($categories_test as $key => $value) {
			$category_details[$value->slug] = $value;
		} // foreach
	} // if

	/****************************************************************************/
	// Set the globals.
	global $wp_query;

	/****************************************************************************/
	// Init variables.
	$content = array();
	$subcategory_slug = 'default';

	/****************************************************************************/
	// Roll through the category details.
	foreach ($category_details as $category_slug => $category_data) {

		/************************************************************************/
		// 2026-03-25: Sort posts by title instead of date.
		$query_vars = $wp_query->query_vars;
		$query_vars['category__in'] = $category_data->cat_ID;
		$query_vars['post_type'] = 'post';	
		if (in_array($page_category_slug, array('tech'))) {
			$query_vars['orderby']['title'] = 'ASC';
		} // if
		else {
			$query_vars['orderby']['modified'] = 'DESC';
			$query_vars['orderby']['title'] = 'ASC';
		} // else

		/************************************************************************/
		// Run 'query_posts' and retrieve the items.
		query_posts($query_vars);			

		/************************************************************************/
		// If there are posts, do something with them.
		if (TRUE && is_archive() && have_posts()) {
			while (have_posts()) {

				/****************************************************************/
				// Get the post.
				the_post();

				/****************************************************************/
				// Set the post related values.
				$post_name = get_post_field('post_name');
				$post_ID = get_the_ID();
				$post_name_slug = get_post_field('post_name') . '_' . $post_ID;

				/****************************************************************/
				// Set the category
				$categories = get_the_category();

				/****************************************************************/
				// Process the categories to set the parent value as the key.
				foreach ($categories as $key => $value) {
					$new_key = $value->parent;
					$categories[$new_key] = $value;
					unset($categories[$key]);
				} // foreach

				/****************************************************************/
				// Set the subcategory slug.
				$subcategory_slug = $post_name;
				if (count($categories) > 0) {
					$subcategory = array_shift($categories);
					$subcategory_slug = $subcategory->slug;
				} // if

				/****************************************************************/
				// Set the title values.
				$title = get_the_title();
				$title_attribute = the_title_attribute(array('echo' => false));

				/****************************************************************/
				// Set the temp array values.
				$temp = array();
				$temp['permalink'] = get_the_permalink();
				$temp['post_name'] = $post_name;
				$temp['title'] = $title;
				$temp['title_attribute'] = $title_attribute;
				$temp['excerpt'] = get_the_excerpt();
				$temp['date'] = get_the_time('F j, Y');
				$temp['time'] = get_the_time('g:i:sa');

				/****************************************************************/
				// Set the content array values.
				$content[$subcategory_slug][$post_name_slug] = $temp;

			} // while
		} // if
		// else {

		// 	/********************************************************************/
		// 	// Set the temp array values.
		// 	$temp = array();
		// 	$temp['permalink'] = null;
		// 	$temp['post_name'] = null;
		// 	$temp['title'] = null;
		// 	$temp['title_attribute'] = null;
		// 	$temp['excerpt'] = 'Nothing was found.';
		// 	$temp['date'] = null;
		// 	$temp['time'] = null;

		// 	/********************************************************************/
		// 	// Set the content array values.
		// 	$content[$subcategory_slug][] = $temp;

		// } // else

	} // foreach

	/****************************************************************************/
	// Init variables.
	$final = array();

	/****************************************************************************/
	// Display the parent content.
	foreach ($content as $parent_key => $parent_value) {

		/************************************************************************/
		// Init variables.
		$temp = array();

		/************************************************************************/
		// Display the child content.
		foreach ($parent_value as $child_key => $child_value) {

			/********************************************************************/
			// Set the title.
			$title = null;
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
			// Set the excerpt and permalink.
			$excerpt = !empty($child_value['excerpt']) ? $child_value['excerpt'] : null;
			$permalink = !empty($child_value['permalink']) ? $child_value['permalink'] : null;

			/********************************************************************/
			// Link the excerpt.
			if (!empty($excerpt) && !empty($permalink)) {
				$excerpt =
					  '<a href="' . $permalink . '" title="A link to &ldquo;' . $permalink . '.&rdquo;" class="text-decoration-none text-dark">'
					. $excerpt
					. '</a>'
					;
			} // if

			/********************************************************************/
			// Wrap the excerpt.
			if (!empty($excerpt)) {
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
			// Set the divider.
			$divider = null;
			if (!empty($title) && !empty($excerpt)) {
				$divider = '<span class="text-windsorpro-regular">: </span>';
			} // if

			/********************************************************************/
			// Set the final row.
			$temp[] = 
				  '<div class="d-inline-block col col-12 p-0 m-0 mb-2">'
				. $title
				. $divider
				. $excerpt
				. '</div>'
				;

		} // foreach

		/************************************************************************/
		// Set a category name and category link.
		$category_name = null;
		$category_link = null;
		if ((count($category_details) > 1) && isset($category_details[$parent_key])) {
			$category_name = $category_details[$parent_key]->name;
			$category_link = get_category_link($category_details[$parent_key]->term_id);
		} // if

		/************************************************************************/
		// Wrap the category block value.
		$category_block = implode('', $temp);
		if (!empty($category_name)) {
			$category_block  =
			      '<div class="col col-12 p-0 m-0 mb-3 border-bottom border-dark px-2 py-1 mb-2 bg-warning">'
				. '<div class="h3 text-windsorpro-bold col col-12 p-0 m-0 mb-1">'
				. '<a href="' . $category_link . '">'
				. $category_name
				. '</a>'
				. '</div>'
				. $category_block
				. '</div>'
				;
		} // if

		/************************************************************************/
		// Set the final array value.
		$final[] = $category_block;

	} // foreach

	/****************************************************************************/
	// Show the content.
	echo '<div class="archive_content p-0 m-0">';
	foreach ($final as $key => $value) {
		echo $value;
	} // foreach
	echo '</div>';

	/****************************************************************************/
	// Set the sidebar.
	get_sidebar();

	/****************************************************************************/
	// Set the footer.
	get_footer();

?>