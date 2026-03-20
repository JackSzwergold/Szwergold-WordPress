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
		echo '<div class="h2 text-windsorpro-bold p-0 m-0 fw-bold pb-1 mb-2 border-bottom border-dark">';
		echo 'Posts for &ldquo;';
		if (is_category()) {
			single_cat_title();
		} // if
		else if (is_tag()) {
			echo single_tag_title();
		} // else if
		echo '.&rdquo;</div>';
		echo '<p class="text-windsorpro-regular">You are currently browsing posts about <strong>&ldquo;';
		if (is_category()) {
			single_cat_title();
		} // if
		else if (is_tag()) {
			echo single_tag_title();
		} // else if
		echo '.&rdquo;</strong></p>';
		echo '</div>';

		if (have_posts()) {

			while (have_posts()) {

				global $authordata;

				/********************************************************************/
				// Get the post.
				the_post();

				/********************************************************************************/
				// Set the item info variables.
				$the_ID = get_the_ID();
				$permalink = get_the_permalink();
				$title = get_the_title();
				$title_attribute = the_title_attribute(array('echo' => false));
				$excerpt = get_the_excerpt();
				$the_author = $authordata->user_nicename;
				$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
				$update_date = get_the_time('F j, Y');
				$update_time = get_the_time('g:i:sa');

				/********************************************************************************/
				// Begin the container.
				echo '<div class="col col-12 col-xl-4 p-0 m-0 pe-3 pb-3">';

				/********************************************************************************/
				// Begin the header.
				echo '<header class="col col-12 p-0 m-0 pb-2">';

				/********************************************************************************/
				// Show the title.
				echo '<div class="h2 p-0 m-0 text-windsorpro-bold">';
				echo '<a href="' . $permalink . '" rel="bookmark" title="A link to &ldquo;' . $title_attribute . '.&rdquo;" class="text-dark text-decoration-none">';
				echo $title;
				echo '</a>';
				echo '</div>';

				/********************************************************************************/
				// Show the author, date and time.
				if (!empty($the_author)) {
					echo '<div class="p-0 m-0 text-windsorpro-regular">';
					echo 'By ' . $the_author;
					if (!empty($update_date)) {
						echo ' on ' . $update_date;
						if (!empty($update_time)) {
							echo ' at ' . $update_time;
						} // if
					} // if
					echo '.';
					echo '</div>';				
				} // if

				/********************************************************************************/
				// End the header.
				echo '</header>';

				/********************************************************************************/
				// Show the main area.
				// echo '<main class="col col-12 p-0 m-0">';
				// echo '<article class="col col-12 p-0 m-0">';
				echo '<div class="text-georgia-regular">';
				echo '<span class="small">';

				/********************************************************************/
				// Show the excerpt.
				echo '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark">';
				echo $excerpt;
				echo '</a>';

				/********************************************************************************/
				// End the header.
				echo '</span>';
				echo '</div>';
				// echo '</article>';
				// echo '</main>';

				echo '</div>';

			} // while


			/************************************************************************/
			// Allow these globals to be accessed.
			global $wp_query;
			global $wp;

			/************************************************************************/
			// Get the next and previous links.
			$next_posts_link = get_next_posts_page_link();
			$previous_posts_link = get_previous_posts_page_link();

			/************************************************************************/
			// Get the current page URL and the current page.
			$current_url = home_url($wp->request);
			$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;

			/************************************************************************/
			// Compare them to the current URL value.
			if (strstr($next_posts_link, '?', true) == $current_url) {
				$next_posts_link = null;
			} // if
			if (strstr($previous_posts_link, '?', true) == $current_url) {
				$previous_posts_link = null;
			} // if

			/************************************************************************/
			// Check to display the next and previous links.
			if ($wp_query->found_posts > $wp_query->post_count) {
				if (!empty($next_posts_link) || !empty($previous_posts_link)) {
					echo '<div class="navigation col col-12 p-0 m-0 py-1 mt-2 border-top border-bottom border-dark">';
					if (!empty($next_posts_link)) {
						if ($current_page != $wp_query->max_num_pages) {
							echo '<p class="float-start p-0 m-0">';
							echo '<a href="' . $next_posts_link . '" title="&laquo; Older Entries" class="text-dark">';
							echo '&laquo; Older Entries';
							echo '</a>';
							echo '</p>';
						} // if
					} // if
					if (!empty($previous_posts_link)) {
						if ($current_page != 1) {
							echo '<p class="float-end p-0 m-0">';
							echo '<a href="' . $previous_posts_link . '" title="Newer Entries &raquo;" class="text-dark">';
							echo 'Newer Entries &raquo;';
							echo '</a>';
							echo '</p>';
						} // if
					} // if
					echo '</div>';
				} // if
			} // if

		} // if
		else {

			/**********************************************************************/
			// Set the variables.
			$template_directory = get_bloginfo('template_directory');

			echo '<div class="entry">';
			echo '<span class="error">';
			echo '<img src="' . $template_directory. '/images/mal.png" alt="error duck">';
			echo '</span>';
			echo '<p>';
			echo "Hmmm, seems like what you were looking for isn't here. You might want to give it another try - the server might have hiccuped - or maybe you even spelled something wrong (though it's more likely <strong>I</strong> did).";
			echo '</p>';
			echo '</div>';

		} // else
	?>
</div>
<?php

	/**********************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>