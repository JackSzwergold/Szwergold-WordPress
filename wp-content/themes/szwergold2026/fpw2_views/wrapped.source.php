<?php
/**
 * "Wrapped Image" Layout Template File
 * 
 * DO NOT MODIFY THIS FILE!
 * 
 * To override, copy the /fpw2_views/ folder to your active theme's folder.
 * Modify the file in the theme's folder and the plugin will use it.
 * See: http://wordpress.org/extend/plugins/feature-a-page-widget/faq/
 * 
 * Note: Feature a Page Widget provides a variety of filters and options that may alter the output of the_title, the_excerpt, and the_post_thumbnail in this template.
 */
// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
       global $post;
	return '<a class="more-link" href="'. get_permalink($post->ID) . '"> Read more...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
?>



<article class="fpw-clearfix fpw-layout-wrapped">
		<?php if ( isset($post) && has_post_thumbnail( $post->ID ) ) : ?>
				<header class="has-thumb">
			<?php else : ?>
				<header>
			<?php endif; ?>
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>" class="fpw-featured-link"><?php the_post_thumbnail( 'medium_large' ); ?></a>
		</div>
		<?php endif; ?>
		<h4 class="fpw-page-title entry-title">	<a href="<?php the_permalink(); ?>" class="fpw-featured-link">
<?php the_title(); ?></a></h4>
		<div class="entry-meta">
				<time class="date published"><?php the_time('F j, Y g:i a') ?></time> <span class="author">by <?php beller_author(); ?></span></div>
		</header>
	<div class="fpw-excerpt entry-summary">
		<?php the_excerpt(); ?>
	</div>

</article>