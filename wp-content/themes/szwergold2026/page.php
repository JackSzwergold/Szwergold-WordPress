<?php
	get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
	<div class="row m-0 p-0">
		<div class="col col-12 col-lg-9 m-0 p-0 mb-3">

			<?php
				if (have_posts()) {
					while (have_posts()) {

						/********************************************************************/
						// Get the post.
						the_post();

						global $post;
						global $authordata;

						/********************************************************************/
						// Set the variables.
						// $the_title_attribute = get_the_title_attribute();
						$permalink = get_the_permalink();
						$title = get_the_title();

						/********************************************************************************/
						// Set the blog post info valiables.
						$story_author_id = $post->post_author;	//	important for sidebar!
						$permalink = get_the_permalink();
						$title = get_the_title();
						$title_attribute = the_title_attribute(array('echo' => false));
						$the_author = get_the_author();
						$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
						$display_date = get_the_time('F j, Y');

						echo '<header class="p-0 m-0">';
						echo '<div class="p-0 m-0 mx-3">';
						echo '<div class="container m-0 p-0 pb-2 mb-2 border-bottom border-dark">';
						echo '<div class="h4 p-0 m-0 fw-bold">';
						echo '<a href="' . $permalink . '" rel="bookmark" title="Permanent Link to ' . $title . '" class="text-dark text-decoration-none">';
						echo $title;
						echo '</a>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</header>';

						echo '<div class="p-0 m-0">';
						echo '<div class="p-0 m-0 mx-3">';
						echo '<div class="container m-0 p-0">';

						if (function_exists('fv_image_uploader_get_img')) {
							fv_image_uploader_get_img($post->ID);
						} // if

						/********************************************************************/
						// Grab the content into a variable.
						ob_start();
						the_content('Read the rest of this entry &raquo;');
						$the_content = ob_get_contents();
						ob_end_clean();

						/********************************************************************/
						// Filter the content.
						$the_content = str_replace('<h3 class="wp-block-heading">', '<div class="h5 p-0 m-0 fw-bold mb-1">', $the_content);
						$the_content = str_replace('</h3>', '</div>', $the_content);
						$the_content = str_replace('class="button button-primary button-large"', 'class="btn btn-outline-dark bg-white text-dark col col-12 col-sm-6"', $the_content);
						$the_content = str_replace('<input type="submit"', '<input type="submit" class="btn btn-outline-dark bg-white text-dark col col-12 col-sm-6"', $the_content);
						$the_content = str_replace('type="text"', 'type="text" class="form-control border border-dark"', $the_content);
						$the_content = str_replace('type="password"', 'type="password" class="form-control border border-dark"', $the_content);
						$the_content = str_replace('class="input"', 'class="input form-control border border-dark"', $the_content);
						$the_content = str_replace('class="usp-input"', 'class="usp-input form-control border border-dark"', $the_content);
						$the_content = str_replace('class="usp-textarea"', 'class="usp-textarea form-control w-100 border border-dark"', $the_content);
						$the_content = str_replace('rows="5"', 'rows="10"', $the_content);
						$the_content = str_replace('<a href="', '<a class="text-dark" href="', $the_content);

						/********************************************************************/
						// Output the content.
						echo $the_content;

						echo '</div>';
						echo '</div>';
						echo '</div>';

						/********************************************************************/
						// Grab the content into a variable.
						ob_start();
						edit_post_link();
						$edit_post_link = ob_get_contents();
						ob_end_clean();

						/********************************************************************/
						// Display the edit post link if it exists.
						if (!empty($edit_post_link)) {
							$edit_post_link = str_replace('<a class="post-edit-link" href="', '<a class="post-edit-link text-white text-decoration-none m-0 p-0 px-3 py-2" href="', $edit_post_link);
							echo '<div class="float-end bg-dark m-0 p-0 rounded">';
							echo $edit_post_link;
							echo '</div>';							
						} // if


					} // while

					echo '<div class="navigation">';
					echo '<div class="alignleft">';
					next_posts_link('&laquo; Older Entries');
					echo '</div>';
					echo '<div class="alignright">';
					previous_posts_link('Newer Entries &raquo;');
					echo '</div>';
					echo '</div>';

				} // if
				else {

					echo '<div class="entry">';
					echo '<p></p>';
					echo '<p class="error">???????????????????</p>';
					echo '<p class="error">???????????????????</p>';
					echo '<p class="error">???????????????????</p>';
					echo "<p>Looks like what you were looking for isn't here. You might want to give it another try, perhaps the server hiccuped, or perhaps you spelled something wrong (or maybe I did).</p>";
					echo '</div>';

				} // else
			?>

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