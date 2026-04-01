<?php

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
	// Get the current selected category slug.
	$page_category = get_the_category();
	$page_category_shifted = null;
	$page_category_slug = null;
	if (!empty($page_category )) {
		$page_category_shifted = array_shift($page_category);
		$page_category_slug = $page_category_shifted->slug;				
	} // if

	/**********************************************************************/
	// Set the page slugs string.
	$page_slugs_array = array();
	$page_slugs_string = null;
	if (!empty($post_slug)) {
		$page_slugs_array[] = $page_category_slug;
	} // if
	if (!empty($post_slug)) {
		$page_slugs_array[] = $post_slug;
	} // if
	if (!empty($page_slugs_array)) {
		$page_slugs_string = implode(' ', $page_slugs_array);
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
		// Render the title/name.
		echo '<title>' . $name . '</title>';

		/****************************************************************************************/
		// Render the different 'link' items.
		echo '<link rel="stylesheet" href="' . $stylesheet_url . '?version=1.1.20" media="screen">';
		echo '<link rel="alternate" type="application/atom+xml" title="' . $name . ' Atom" href="' . $atom_url . '">';
		echo '<link rel="alternate" type="application/rss+xml" title="' . $name . ' RSS" href="' . $rss2_url . '">';
		echo '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . $url . '/xmlrpc.php?rsd">';
		echo '<link rel="pingback" href="' . $pingback_url . '">';
		echo '<link rel="shortcut icon" href="' . $url . '/favicon.ico">';

		/****************************************************************************************/
		// This 'wp_head' call sets all of the JavaScript and metadata that WordPress needs to insert in the page.
		echo '<!-- WordPress HEADER STUFF BEGIN -->';
		wp_head();
		echo '<!-- WordPress HEADER STUFF END -->';

	?>
</head>
<body id="top" class="p-0 m-0<?php echo $page_slugs_string; ?>">

	<nav class="header p-0 m-0 px-2 sticky-top bg-darkblue">
		<div class="col col-12 p-0 m-0 px-2 pt-1 pb-3">
			<div class="h1 text-railroadgothic p-0 m-0"><a href="<?php echo $url; ?>" class="text-offwhite"><?php echo $name; ?></a></div>
			<div class="h4 text-georgia-regular p-0 m-0"><a href="<?php echo $url; ?>" class="text-offwhite"><?php echo $description; ?></a></div>
		</div>
	</nav>

	<!-- Content Core BEGIN -->
	<div class="container">
		<div class="row">
			<div class="col px-3 px-md-4 mx-3 mx-md-0 my-3 my-md-4 bg-offwhite shadow-lg border border-2 border-darkblue rounded">

				<div class="container">
					<div class="row">
						<div class="col py-3 py-md-4 text-left">

							<?php

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('widget-header-1')) {
									dynamic_sidebar('widget-header-1');
								} // if

								/**********************************************************************************************/
								// If we have a widget header, show the widget header.
								if (is_active_sidebar('widget-header-2')) {
									dynamic_sidebar('widget-header-2');
								} // if

							?>