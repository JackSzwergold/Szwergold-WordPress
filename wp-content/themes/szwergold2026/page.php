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

	    /********************************************************************/
	    // Set the variables.
	    // $the_title_attribute = get_the_title_attribute();
	    $permalink = get_the_permalink();
	    $title = get_the_title();

	    /********************************************************************************/
	    // Set the blog post info valiables.
	    $story_author_id = $post->post_author;
	    $permalink = get_the_permalink();
	    $title = get_the_title();
	    $title_attribute = the_title_attribute(array('echo' => false));
	    $the_author = get_the_author();
	    $the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));
	    $display_date = get_the_time('F j, Y');

	    echo '<header class="col col-12 p-0 m-0 pb-2">';
	    echo '<div class="h1 p-0 m-0 text-windsorpro-bold">';
	    echo '<a href="' . $permalink . '" rel="bookmark" title="Permanent Link to ' . $title . '" class="text-dark text-decoration-none">';
	    echo $title;
	    echo '</a>';
	    echo '</div>';
	    // <div class="h2 p-0 m-0 text-windsorpro-regular">{% if header.description %}{{ header.description }}{% endif %}</div>
	    echo '<hr class="border border-dark border-1 opacity-100">';
	    echo '</header>';

	    echo '<main class="col col-12 p-0 m-0">';
	    echo '<article class="col col-12 p-0 m-0">';
	    echo '<div class="text-georgia-regular">';

	    /********************************************************************/
	    // Grab the content into a variable.
	    ob_start();
	    the_content('Read the rest of this entry &raquo;');
	    $the_content = ob_get_contents();
	    ob_end_clean();

	    /********************************************************************/
	    // Output the content.
	    echo $the_content;

	    echo '</div>';
	    echo '</article>';
	    echo '</main>';

	    /********************************************************************/
	    // Grab the content into a variable.
	    ob_start();
	    edit_post_link();
	    $edit_post_link = ob_get_contents();
	    ob_end_clean();

	  } // while

	  // echo '<div class="navigation">';
	  // echo '<div class="alignleft">';
	  // next_posts_link('&laquo; Older Entries');
	  // echo '</div>';
	  // echo '<div class="alignright">';
	  // previous_posts_link('Newer Entries &raquo;');
	  // echo '</div>';
	  // echo '</div>';

	} // if
	else {

		// echo '<div>';
		// echo '<p></p>';
		// echo '<p class="error">???????????????????</p>';
		// echo '<p class="error">???????????????????</p>';
		// echo '<p class="error">???????????????????</p>';
		// echo "<p>Looks like what you were looking for isn't here. You might want to give it another try, perhaps the server hiccuped, or perhaps you spelled something wrong (or maybe I did).</p>";
		// echo '</div>';

	} // else

	/**********************************************************************/
	// Set the sidebar.
	// get_sidebar();

	/**********************************************************************/
	// Set the footer.
	get_footer();

?>