<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="content">

	<div id="entry_content">
		
    	  <h2>Archives</h2>
    			<ul style="margin: 0 0 30px 30px;">
    			<?php wp_get_archives('type=monthly'); ?>
    			</ul>  

		


</div> <!-- close entry_content -->



<?php get_sidebar(); ?>

<?php get_footer(); ?>