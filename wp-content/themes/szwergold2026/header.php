<?php

	/****************************************************************************************/
	// Set the page title.
	$title = null;
	if (is_single()) {
		$title = get_the_title();
	} // if
	else if (is_page()) {
		$title = get_the_title();
	} // else if
	else if (is_archive()) {
		$title = get_the_archive_title();
	} // else if
	else if (is_category()) {
		$title = single_cat_title();
	}  // else if
	else if (is_tag()) {
		$title = single_tag_title();
	} // else if
	else if (is_year()) {
		$title = the_time('Y');
	} // else if
	else if (is_month()) {
		$title = the_time('F Y');
	} // else if
	else if (is_day()) {
		$title = the_time('l, F j, Y');
	} // else if

	/****************************************************************************************/
	// If we are on the front page, no need for the page title.
	if (is_front_page() && !empty($title)) {
		$title = null;
	} // if

	/****************************************************************************************/
	// Set the template directory and related blog info valiables.
	$template_directory = get_bloginfo('template_directory');
	$stylesheet_url = get_bloginfo('stylesheet_url');
	$name = get_bloginfo('name');
	$description = get_bloginfo('description');
	$atom_url = get_bloginfo('atom_url');
	$rss2_url = get_bloginfo('rss2_url');
	$url = get_bloginfo('url');
	$pingback_url = get_bloginfo('pingback_url');

    global $post;

	/**********************************************************************/
	// Get the current selected post slug.
    $post_slug = $post->post_name;

	/**********************************************************************/
	// Get the current selected category info.
	$page_category = get_the_category();
	$page_category_shifted = array();
	$page_category_parent = null;
	$page_category_slug = null;
	$page_category_name = null;
	if (!empty($page_category)) {
		$page_category_shifted = array_shift($page_category);
		$page_category_parent = isset($page_category_shifted->parent) ? $page_category_shifted->parent : null;
		$page_category_slug = isset($page_category_shifted->slug) ? $page_category_shifted->slug : null;
		$page_category_name = isset($page_category_shifted->name) ? $page_category_shifted->name : null;
	} // if

	/**********************************************************************/
	// Get the current selected parent category info.
	$page_parent_category = get_category($page_category_parent);
	$page_parent_category_shifted = array();
	$page_parent_category_parent = null;
	$page_parent_category_slug = null;
	$page_parent_category_name = null;
	if (!empty($page_parent_category)) {
		$page_parent_category_slug = isset($page_parent_category->slug) ? $page_parent_category->slug : null;
		$page_parent_category_name = isset($page_parent_category->name) ? $page_parent_category->name : null;
	} // if

	/**********************************************************************/
	// Set the page slugs string.
	$page_slugs_array = array();
	$page_slugs_string = null;
	if (!empty($page_category_slug)) {
		$page_slugs_array[] = $page_category_slug;
	} // if
	if (!empty($page_parent_category_slug)) {
		$page_slugs_array[] = $page_parent_category_slug;
	} // if
	if (!empty($post_slug)) {
		$page_slugs_array[] = $post_slug;
	} // if
	if (!empty($page_slugs_array)) {
		$page_slugs_string = implode(' ', $page_slugs_array);
	} // if

	/**********************************************************************/
	// Set the page title string.
	$page_title_array = array();
	$page_title_string = null;
	if (!empty($title)) {
		$page_title_array[] = $title;
	} // if
	if (!empty($page_category_name)) {
		$page_title_array[] = $page_category_name;
	} // if
	if (!empty($page_parent_category_name)) {
		$page_title_array[] = $page_parent_category_name;
	} // if
	if (!empty($name)) {
		$page_title_array[] = $name;
	} // if
	if (!empty($page_title_array)) {
		$page_title_string = implode(' | ', $page_title_array);
	} // if

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
	<?php

		/****************************************************************************************/
		// Render the page title.
		echo '<title>' . $page_title_string . '</title>';

		/****************************************************************************************/
		// Set the different 'link' items.
		$link_array = array();
		$link_array[] = '<link rel="stylesheet" href="' . $stylesheet_url . '?version=1.1.20" media="screen">';
		$link_array[] = '<link rel="alternate" type="application/atom+xml" title="' . $name . ' Atom" href="' . $atom_url . '">';
		$link_array[] = '<link rel="alternate" type="application/rss+xml" title="' . $name . ' RSS" href="' . $rss2_url . '">';
		$link_array[] = '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . $url . '/xmlrpc.php?rsd">';
		$link_array[] = '<link rel="pingback" href="' . $pingback_url . '">';
		$link_array[] = '<link rel="shortcut icon" href="' . $url . '/favicon.ico">';

		/****************************************************************************************/
		// Render the different 'link' items.
		echo implode('', $link_array);

		/****************************************************************************************/
		// This 'wp_head' call sets all of the JavaScript and metadata that WordPress needs to insert in the page.
		echo '<!-- WordPress HEADER STUFF BEGIN -->';
		wp_head();
		echo '<!-- WordPress HEADER STUFF END -->';

	?>
</head>
<body id="top" class="p-0 m-0<?php echo $page_slugs_string; ?>">

	<nav class="header sticky-top p-0 m-0 px-2 bg-darkblue">
		<div class="col col-12 p-0 m-0 px-2 pt-1 pb-3">
			<div class="h1 text-railroadgothic p-0 m-0"><a href="<?php echo $url; ?>" class="text-offwhite"><?php echo $name; ?></a></div>
			<div class="h4 text-georgia-regular p-0 m-0"><a href="<?php echo $url; ?>" class="text-offwhite"><?php echo $description; ?></a></div>
		</div>
	</nav>

	<!-- Content Core BEGIN -->
	<div class="container">
		<div class="row">
			<div class="col px-3 px-md-4 mx-3 mx-md-0 my-3 my-md-4 bg-offwhite border border-2 border-darkblue rounded-3">

				<div class="container">
					<div class="row">
						<div class="col py-3 py-md-4 text-left">

							<?php

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('header-1')) {
									dynamic_sidebar('header-1');
								} // if

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('header-2')) {
									dynamic_sidebar('header-2');
								} // if

							?>