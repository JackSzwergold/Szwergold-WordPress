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
		// Grab the 'wp_head' into a variable.
		ob_start();
		wp_head();
		$wp_head = ob_get_contents();
		ob_end_clean();

		/****************************************************************************************/
		// This 'wp_head' call sets all of the JavaScript and metadata that WordPress needs to insert in the page.
		echo '<!-- WordPress HEADER STUFF BEGIN -->';
		echo $wp_head;
		echo '<!-- WordPress HEADER STUFF END -->';

	?>
</head>
<body id="top" class="p-0 m-0">

	<nav class="navbar p-0 m-0 px-2 sticky-top navbar-light bg-dark border-bottom border-dark">
		<div class="col col-12 p-0 m-0 px-2 py-1">
		  <h1 class="p-0 m-0 text-windsorpro-bold"><a href="<?php echo $url; ?>"><span class="text-white"><?php echo $name; ?></span></a></h1>
		  <h2 class="p-0 m-0 text-windsorpro-regular"><a href="<?php echo $url; ?>"><span class="text-white"><?php echo $description; ?></span></a></h2>
		</div>
	</nav>

	<!-- Content Core BEGIN -->
	<div class="container">
		<div class="row">
			<div class="col px-3 px-md-4 mx-3 mx-md-0 my-3 my-md-4 bg-white shadow-lg border border-dark">

				<div class="container-fluid">
					<div class="row">
						<div class="col py-3 py-md-4 text-left">

							<?php

								/**********************************************************************************/
								// Show widget header 1 if it is set.
								if (is_active_sidebar('widget-header-1')) {
									echo '<div class="p-0 m-0 px-2 py-1 mb-1 rounded-pill text-windsorpro-regular bg-light">';
									dynamic_sidebar('widget-header-1');
									echo '</div>';
								} // if

								/**********************************************************************************/
								// Show widget header 2 if it is set.
								if (is_active_sidebar('widget-header-2')) {
									echo '<div class="p-0 m-0 px-2 py-1 mb-1 rounded-pill text-windsorpro-regular bg-light">';
									dynamic_sidebar('widget-header-2');
									echo '</div>';
								} // if

							?>