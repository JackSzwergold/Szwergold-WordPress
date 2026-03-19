<?php
	get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
	<div class="row m-0 p-0">
		<div class="col col-12 col-lg-9 m-0 p-0 mb-3">

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
							// No idea if this 'fv_sharing' is still being used.
							// do_action('fv_sharing');
							// fv_image_uploader_get_img($post->ID);
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
								echo '<div class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
								echo '<div class="row m-0 p-0">';
								echo '<div class="col col-12 m-0 p-0">';
								echo $the_tags;
								echo '</div>';
								echo '</div>';
								echo '</div>';
							} // if

							/************************************************************************************/
							// Display the bookmark/social links.
							echo '<div class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
							echo '<div class="row m-0 p-0">';
							echo '<div class="col col-12 m-0 p-0">';
							// the_bookmark_links();
							echo do_shortcode('[Sassy_Social_Share]');
							echo '</div>';
							echo '</div>';
							echo '</div>';

							/************************************************************************************/
							// Display the comments? Maybe? Seems to only display the heading.
							if (FALSE) {
								echo '<div id="showcomments_off" class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
								echo '<div class="row m-0 p-0">';
								echo '<div class="col col-12 m-0 p-0">';
								comments_number('Comments','Comments','Comments');
								echo '</div>';
								echo '</div>';
								echo '</div>';
							} // if

							/************************************************************************************/
							// The story rating logic.
							if (is_user_logged_in() ) {
								$the_ratings = the_ratings();
								if (!empty($the_ratings)) {
									$the_ratings = str_replace('class="post-ratings-image"', 'class="post-ratings-image" alt="Post Ratings Image"', $the_ratings);
								} // if
								echo '<div id="rating" class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
								echo '<div class="row m-0 p-0">';
								echo '<div class="col col-12 m-0 p-0">';
								echo 'Rate Story ';
								echo $the_ratings;
								echo '</div>';
								echo '</div>';
								echo '</div>';
							} // if
							else {
								$the_ratings = the_ratings('div', 0, false);
								$the_ratings = str_replace('class="post-ratings-image"', 'class="post-ratings-image" alt="Post Ratings Image"', $the_ratings);
								$the_ratings = str_replace('rate_post();', 'rate_unregistered();', $the_ratings);
								echo '<div id="rating_text" class="rating_off container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
								echo '<div class="row m-0 p-0">';
								echo '<div class="col col-12 m-0 p-0">';
								echo 'Rate Story ';
								echo $the_ratings;
								echo '</div>';
								echo '</div>';
								echo '</div>';
							} // else

							/************************************************************************************/
							// The comments area.
							echo '<div id="showcomments_off" class="rating_off container m-0 p-0 mb-3 border-bottom border-dark">';
							echo '<div class="row m-0 p-0">';
							echo '<div class="col col-12 m-0 p-0">';
							comments_template();
							echo '</div>';
							echo '</div>';
							echo '</div>';

							/************************************************************************************/
							// What is this for?
							if (TRUE) {
								if (is_home()) {
									if (function_exists('wp_list_comments')) { 
										echo ' | ';
										edit_post_link('Edit', '', '');
									} // if
								} // if
							} // if

							/************************************************************************************/
							// No idea if this is still being used.
							// $next_posts_link = get_next_posts_link('&laquo; Older Entries');
							// $previous_posts_link = get_previous_posts_link('Newer Entries &raquo;');
							// echo $next_posts_link;
							// echo $previous_posts_link;

							/************************************************************************************/
							// Set the core column break.
							$bootstrap_column_break = 'col-xl-6';

							echo '<div class="additional_stuff">';
							echo '<div class="row m-0 p-0">';
							echo '<div class="col col-12 ' . $bootstrap_column_break . ' m-0 p-3 mb-3 bg-light">';

							echo '<div class="h5 col-12 m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
							echo 'Other Stories You May Like';
							echo '</div>';

							/************************************************************************************/
							// Post footer 1 stuff.
							if (is_active_sidebar('post-footer-1')) {

								/********************************************************************************/
								// Get the content and set it in a variable.
								ob_start();
								dynamic_sidebar('post-footer-1');
								$post_footer_1 = ob_get_contents();
								ob_end_clean();

								/********************************************************************************/
								// Filter the content in the variable.
								$post_footer_1 = str_replace("<div class='yarpp yarpp-related", "<div class='m-0 p-0 yarpp yarpp-related", $post_footer_1);

								/********************************************************************************/
								// Output the related posts.
								echo $post_footer_1;

							} // if

							echo '</div>';
							echo '<div class="col col-12 ' . $bootstrap_column_break . ' m-0 p-3 mb-3 bg-light">';

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

							/****************************************************************************************/
							// Output the categories array.
							echo '<div class="h5 col-12 m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
							echo 'Nearby ';
							echo implode(', ', $categories_array);
							echo ' Stories';
							echo '</div>';

							/**********************************************************************************/
							// Post footer 2 stuff.
							if (is_active_sidebar('post-footer-2')) {

								/******************************************************************************/
								// Get the content and set it in a variable.
								ob_start();
								dynamic_sidebar('post-footer-2');
								$post_footer_1 = ob_get_contents();
								ob_end_clean();

								/******************************************************************************/
								// Filter the related posts.
								// $post_footer_2 = str_replace("<div class='yarpp yarpp-related", "<div class='m-0 p-0 yarpp yarpp-related", $post_footer_1);

								/******************************************************************************/
								// Output the related posts.
								echo $post_footer_1;

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

		</div>
		<div class="col col-12 col-lg-3 ms-auto m-0 p-0">

			<?php
				get_sidebar();
			?>

		</div>
	</div>
</div>
<!-- Content Core END -->
<?php
	get_footer();
?>