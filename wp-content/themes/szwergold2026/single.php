<?php

	/**********************************************************************/
	// Set the header.
	get_header();

?>

<header class="p-0 m-0">
	<div class="p-0 m-0 mx-3">
		<div class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">

		<?php

			/*****************************************************************************************/
			// Set the template directory and related blog info valiables.
			$template_directory = get_bloginfo('template_directory');

			if (TRUE && have_posts()) {

				while (have_posts()) {

					the_post();

					if (is_home()) {
						if (function_exists('wp_list_comments')) {
							post_class();
						} // if
					} // if

					global $post;
					global $authordata;

					/********************************************************************************/
					// Set the main post ID.
					$main_post_ID_array = array();
					$main_post_ID_array[] = get_the_ID();

					/********************************************************************************/
					// Set the blog post info valiables.
					$story_author_id = $post->post_author;	//	important for sidebar!
					$permalink = get_the_permalink();
					$title = get_the_title();
					$title_attribute = the_title_attribute(array('echo' => false));
					$the_author = get_the_author();
					$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
		            $display_date = get_the_time('F j, Y');
		            $address = get_post_meta($post->ID, 'address', true);

					echo '<div class="h2 p-0 m-0 fw-bold">';
					echo '<a href="' . $permalink . '" title="Permanent Link to ' . $title_attribute . '" class="text-decoration-none text-dark">';
					echo $title;
					echo '</a>';
					echo '</div>';

					echo '<div class="p-0 m-0">';
					echo 'By ';
					echo '<a href="' . $the_author_url . '" title="Posts by ' . $the_author . '" class="text-decoration-none text-dark">';
					echo $the_author;
					echo '</a>';
					echo '</div>';

					echo '<div class="text-secondary p-0 m-0">';
					echo $display_date;
					echo '</div>';

					// Set the categories array.
					$categories_array = array();
					$categories = get_the_category();
					foreach ($categories AS $value) {
						if ($value->slug == 'featured') {
							continue;
						} // if
						$category_link = get_category_link($value->term_id);
						$categories_array[] =
								'<a href="' . $category_link . '" title="View all the stories from ' . $value->name . '" class="text-dark">' 
							. $value->name
							. '</a>'
							;
					} // foreach

					echo '<div class="text-secondary p-0 m-0">';
					echo $address;
					echo '</div>';
					echo '<div class="text-secondary">';
					echo 'Neighborhood: ';
					echo implode(', ', $categories_array);
					echo '</div>';

			?>

		</div>
	</div>
</header>

<main class="p-0 m-0">
	<div class="p-0 m-0 mx-3">

		<?php

				/************************************************************************************/
				// Display the main entry.
				echo '<div class="container m-0 p-0 mb-2 border-bottom border-dark">';
				echo '<div class="row m-0 p-0">';
				echo '<div class="col col-12 col-lg-8 m-0 p-0 mbn_body_text">';
				the_content('&raquo; Read the rest of the story &laquo;');
				echo '</div>';
				echo '</div>';
				echo '</div>';

				/************************************************************************************/
				// Display the tags.
				wp_link_pages(array('before' => '<p>Page: ', 'after' => '</p>', 'next_or_number' => 'number'));
				ob_start();
				the_tags('<span class="fw-bold">Tagged:</span> ', ', ', '');
				$the_tags = ob_get_contents();
				ob_end_clean();
				if (!empty($the_tags)) {
					$the_tags = str_replace('<a href=', '<a class="text-dark" href=', $the_tags);;
					echo '<div class="container m-0 p-0 pb-2 mb-2">';
					echo '<div class="row m-0 p-0">';
					echo '<div class="col col-12 m-0 p-0">';
					echo $the_tags;
					echo '</div>';
					echo '</div>';
					echo '</div>';
				} // if

				echo '</div>';
				echo '</div>';
				echo '</div>';

				break;

			} // while
		}
		else {

			echo '<div class="h1 p-0 m-0 fw-bold">';
			echo 'Whoops!';
			echo '</div>';

		?>

		</div>
	</div>
</header>

<main class="p-0 m-0">
	<div class="p-0 m-0 mx-3">

	<?php

		echo '<span class="error"><img src="' . $template_directory . '/images/mal.png" alt="error duck"></span>';
		echo '<p>';
		echo "Hmmm, seems like what you were looking for isn't here. You might want to give it another try - the server might have hiccuped - or maybe you even spelled something wrong (though it's more likely <strong>I</strong> did).";
		echo '</p>';

	} // else
	?>

	</div>
</main>

<?php

	/**********************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>