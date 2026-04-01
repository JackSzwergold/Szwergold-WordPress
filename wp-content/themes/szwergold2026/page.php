<?php

	/**********************************************************************/
	// Set the header.
	get_header();

	/**********************************************************************/
	// Set the post content if we have post content.
	if (have_posts()) {
		while (have_posts()) {

			/********************************************************************/
			// Get the post.
			the_post();

			global $post;
			global $authordata;

			/********************************************************************************/
			// Set the item info variables.
			$the_ID = get_the_ID();
			$permalink = get_the_permalink();
			$title = get_the_title();
			$title_attribute = the_title_attribute(array('echo' => false));
			$excerpt = get_the_excerpt();
			$the_author = $authordata->display_name;
			$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
			$update_date = get_the_time('F j, Y');
			$update_time = get_the_time('g:i:sa');

			/********************************************************************************/
			// Begin the header.
			echo '<header class="col col-12 p-0 m-0 pb-2">';

			/********************************************************************************/
			// Show the title.
			echo '<div class="h1 p-0 m-0 text-railroadgothic">';
			echo '<a href="' . $permalink . '" rel="bookmark" title="A link to &ldquo;' . $title_attribute . '.&rdquo;" class="text-darkblue text-decoration-none">';
			echo $title;
			echo '</a>';
			echo '</div>';

			/********************************************************************************/
			// Show the excerpt.    
			if (is_front_page() && !empty($excerpt)) {
				echo '<div class="h4 text-georgia-regular py-1">';
				echo $excerpt;
				echo '</div>';        
			} // if

			/********************************************************************************/
			// Show the author, date and time.
			// if (!empty($the_author)) {
			// 	echo '<div class="h5 p-0 m-0 text-railroadgothic">';
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

			echo '<hr class="p-0 m-0 mt-2 mb-2 border border-darkblue border-1 opacity-100">';

			/********************************************************************************/
			// End the header.
			echo '</header>';

			/********************************************************************************/
			// Show the main area.
			echo '<main class="col col-12 p-0 m-0">';
			echo '<article class="col col-12 p-0 m-0">';
			echo '<div class="text-georgia-regular">';

			/********************************************************************/
			// Show the content.
			the_content();

			/********************************************************************************/
			// End the header.
			echo '</div>';
			echo '</article>';
			echo '</main>';

		} // while

        /**********************************************************************************/
        // Init variables.
        $home_featured_1 = null;
        $home_featured_2 = null;

        /**********************************************************************************/
        // Home featured 1 stuff.
        if (is_active_sidebar('home-featured-1')) {

          /********************************************************************************/
          // Capture the content and set it in a variable so we can tweak the links.
          ob_start();
          dynamic_sidebar('home-featured-1');
          $home_featured_1 = ob_get_contents();
          ob_end_clean();

          /********************************************************************************/
          // Filter the content in the variable.
          // $home_featured_1 = str_replace('<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a href=', '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a class="text-decoration-none text-dark" href=', $home_featured_1);

        } // if

        /**********************************************************************************/
        // Home featured 2 stuff.
        if (is_active_sidebar('home-featured-2')) {
 
          /********************************************************************************/
          // Capture the content and set it in a variable so we can tweak the links.
          ob_start();
          dynamic_sidebar('home-featured-2');
          $home_featured_2 = ob_get_contents();
          ob_end_clean();

          /********************************************************************************/
          // Filter the content in the variable.
          // $home_featured_2 = str_replace('<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a href=', '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a class="text-decoration-none text-dark" href=', $home_featured_2);

        } // if

?>

		<div class="row p-0 m-0 me-xl-3">
			<div class="col col-12 col-xl-3 m-0 p-0 mb-3">
				<div class="container">
					<div class="row"> 
			        <?php
			          echo $home_featured_1;
			        ?>
					</div>
				</div>
			</div>
			<div class="col col-12 col-xl-3 m-0 p-0 mb-3">
				<div class="container">
					<div class="row"> 
			        <?php
			          echo $home_featured_2;
			        ?>
					</div>
				</div>
			</div>
			<div class="col col-12 col-xl-3 m-0 p-0 mb-3">
				<div class="container">
					<div class="row"> 
						Three
					</div>
				</div>
			</div>
			<div class="col col-12 col-xl-3 m-0 p-0 mb-3">
				<div class="container">
					<div class="row"> 
						Four
					</div>
				</div>
			</div>
		</div>

<?php

	} // if
	else {

		echo '<div>';
		echo "<p>Nothing.</p>";
		echo '</div>';

	} // else

	/**********************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>