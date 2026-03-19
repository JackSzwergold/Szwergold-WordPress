<?php
/*
Template Name: Tell Mr. Beller a Story
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="entry_content">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
				<?php if(is_home()) { if ( function_exists('wp_list_comments') ) { ?> <div <?php post_class(); ?>> <?php }} ?>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				<p class="date"><?php edit_post_link('Edit', '', ''); ?></p>
				
				<div class="entry">
				    <?php the_content() ?>
				    <br />
				    <div class="articlesubmission"><?php
				    global $current_user;
				    wp_get_current_user();
				    if ($current_user->ID == 0) {
					    $form = '<form action="https://mrbellersneighborhood.com/tell-mr-beller-a-story" method="POST" id="articlesubmission"><table>
					        <tr>
						        <td>
							        Your name:
						        </td>
						        <td>
							        <input size="50" type="text" name="name" value="" />
						        </td>
					        </tr>
					        <tr>
						        <td>
							        Your email address:
						        </td>
						        <td>
							        <input size="50" type="text" name="email" value="" />
						        </td>
					        </tr>
					        <tr>
						        <td>
							        Where your story takes place (in New York):
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_where" value="" />
						        </td>
					        </tr>
					        <tr>
						        <td>
							        When the story happened:
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_when" value="" />
						        </td>
					        </tr>
						        <tr>
						        <td>
							        Title of story:
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_title" value="" />
						        </td>
					        </tr>
					        </table>';
	                 } 
	                 else {
					    $form = '<form action="https://mrbellersneighborhood.com/tell-mr-beller-a-story" method="POST" id="articlesubmission">
					    <input type="hidden" name="name" value="' . $current_user->user_login . '" />
					    <input type="hidden" name="email" value="' . $current_user->user_email . '" />
					    <table>                        
					        <tr>
						        <td>
							        Where your story takes place (in New York):
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_where" value="" />
						        </td>
					        </tr>
					        <tr>
						        <td>
							        When the story happened:
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_when" value="" />
						        </td>
					        </tr>
					        <tr>
						        <td>
							        Title of story:
						        </td>
						        <td>
							        <input size="50" type="text" name="meta_title" value="" />
						        </td>
					        </tr>
					    </table>';
	                }
                    $form .= '<p>Write your story here. Please use two new-lines for paragraphs.</p>
				    <p>
					    <textarea name="story" rows="24" cols="100"></textarea>
					    <input type="hidden" name="post_title" value="Story submission" />
					    <input type="submit" value="Send your story" /></p>
					    <p><small>By pressing this button you give Thomas Beller the right to publish the above material on mrbellersneighborhood.com.</small></p>
				    </form>';
				    echo apply_filters('the_content', $form); ?>
											
				</div>
				
		<?php endwhile; ?>

	<?php endif; ?>

    </div> <!-- close entry_content -->

</div>


<?php get_sidebar(); ?>
  
<?php get_footer(); ?>