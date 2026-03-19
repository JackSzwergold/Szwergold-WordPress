<?php

	/****************************************************************************************/
	// Set the template directory and related blog info valiables.
	$template_directory = get_bloginfo('template_directory');
	$stylesheet_url = get_bloginfo('stylesheet_url');
	$name = get_bloginfo('name');
	$atom_url = get_bloginfo('atom_url');
	$rss2_url = get_bloginfo('rss2_url');
	$url = get_bloginfo('url');
	$pingback_url = get_bloginfo('pingback_url');
	$search_query = get_search_query(false);

	/****************************************************************************************/
	// Set the title.
	$title = '';
	if (is_home()) {
		$title = $name;
	} // if
	else if (is_404()) {
		$title = '404 Not Found';
	} // else if
	else if (is_category()) {
		$title = 'Category: ' . wp_title('', FALSE) . ' - ' . $name;
	} // else if
	else if (is_search()) {
		$title = $name . ' - Search Results';
	} // else if
	else if (is_day() || is_month() || is_year()) {
		$title = $name . ' - Archives: ' . wp_title('', FALSE);
	} // else if
	else {
		$title = wp_title('', FALSE) . ' - ' . $name;
	} // else

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
		// Render the title.
		echo '<title>' . $title . '</title>';

		/****************************************************************************************/
		// Render the different 'link' items.
		echo '<link rel="stylesheet" href="' . $stylesheet_url . '?version=1.1.20" media="screen">';
		echo '<link rel="alternate" type="application/atom+xml" title="' . $name . ' Atom" href="' . $atom_url . '">';
		echo '<link rel="alternate" type="application/rss+xml" title="' . $name . ' RSS" href="' . $rss2_url . '">';
		echo '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . $url . '/xmlrpc.php?rsd">';
		echo '<link rel="pingback" href="' . $pingback_url . '">';
		echo '<link rel="shortcut icon" href="' . $url . '/favicon.ico">';

		/****************************************************************************************/
		// NOTE: No idea what this is for.
		if (is_singular()) {
			wp_enqueue_script('comment-reply');
		} // if

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

		/****************************************************************************************/
		// Remnant logic for the map.
		global $post;
		if ((isset($post->ID) && !is_null($post->ID)) && $post->ID == 2405) {
			$is_map = true;
		}
	?>
</head>
<?php
	$body_onload = '';
	if (isset($is_map)) {
		$body_onload = 'onload="FVLoadGoogleMap();" onunload="GUnload();"';
	} // if
	echo '<body ' . $body_onload . '>'
?>

<div class="container-fluid m-0 p-0">
    <div class="row m-0 p-0">
        <div class="col col-12 m-0 p-0 bg-black">

			<!-- Site Header BEGIN -->
            <div class="container">
				<div class="row m-0 p-0">
					<div class="col col-12 col-lg-6 m-0 p-0 pt-md-3 pb-lg-2 pe-lg-2 text-center text-lg-start overflow-hidden">

					</div>

					<div class="col col-12 col-lg-6 m-0 p-0 px-3 px-md-0 pt-md-4 pb-2">
						<div class="row">
							<div class="col col-12 col-sm-6 pt-1 ps-sm-4 pt-sm-2 pt-md-2 pb-2">
								<div class="row text-center text-md-start">

								</div>
							</div>
							<div class="col col-12 col-sm-6 ms-auto mb-2">
								<div class="row text-center text-md-start">

								</div>
							</div>

							<div class="col col-12 text-end">
								<div class="row">
									<div class="col col-12 text-end">
										<span class="small user-select-none text-white">

										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
			<!-- Site Header END -->

            <div class="container">
                <div class="row m-0 p-0 mx-3">
                    <div class="col col-12 m-0 p-0 overflow-hidden">

                    	<?php
	                    	if (FALSE) {
                		?>
						<!-- Site Header BEGIN -->
						<header class="headerWrapper mx-auto">

							<div class="loginInfo">
								<?php

									global $current_user;

									wp_get_current_user();

									if ($current_user->ID != 0) {
										global $stories_pending;

										get_user_pending_stories($current_user->ID);

										/****************************************************************************************/
										// Handle the messaging for the user bio.
										if (!$current_user->description && ($current_user->wp_user_level > 0 || count($stories_pending) > 0 )) {
											echo '<a href="/profile">' . $current_user->display_name . '</a>, <span class="text-danger">you have not entered a bio. <a href="/wp-admin/profile.php">Add it here!</a></span> |';
										} // if
										else {
											echo 'Logged in as <a href="/profile">' . $current_user->display_name . '</a> | ';
										} // if

										/****************************************************************************************/
										// Set the WordPress logout URL.
										if (is_single()) {
										    $wp_logout_url = wp_logout_url(get_permalink());
										} // if
										else {
										    $wp_logout_url = wp_logout_url('/');
										} // else

										echo '<a href="' . $wp_logout_url . '">Logout</a>';
									} // if
									else {
									    echo '<a href="/login">Login</a> or <a href="/register">Register</a>';
									} // else

								?>
							</div><!-- loginInfo -->

						</header>
						<!-- Site Header END -->
                    	<?php
							} // if
                		?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Core Wrapper BEGIN -->
<div class="container-fluid bg-white">
    <div class="row">
        <div class="col col-12">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col col-12 m-0 p-0 py-2 bg-white">