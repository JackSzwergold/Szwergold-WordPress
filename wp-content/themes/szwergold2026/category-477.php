<?php get_header(); ?>

<div id="content">
<div class="leftBanner width-archives">
<!-- where am I? -->

    <?php if (is_single()) { ?>
    	<div class="post_nav">
    		<p>You are currently reading <strong><?php the_title(); ?></strong> at
    		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>.</p>
    	
    		<h3>meta</h3>
    		<ul class="single_post_meta">
    			
    			<li><strong>Comments: </strong><?php comments_number('No Comments', '1 Comment', '% Comments' );?></li> 
    			<li><strong>Categories:</strong> <?php the_category(', ') ?></li>
    		</ul>	
    	</div>		
    <?php } elseif (is_category()) { ?>
		<div class="post_nav">
			<p>You are currently browsing the <strong><?php single_cat_title(''); ?></strong></p>
			<div class="spacer"></div>
		</div>		
    <?php } elseif (is_tag()) { ?>
		<div class="post_nav">
		<h3>Where Am I?</h3>
				<p>You are currently browsing stories tagged with <strong><?php single_tag_title(); ?></strong></p>
				<div class="spacer"></div>
		</div>			
    <?php } elseif (is_month()) { ?>
		<div class="post_nav">
		<p>You are currently viewing the stories for <strong><?php the_time('F, Y'); ?></strong></p>
		<div class="spacer"></div>
		</div>		
    <?php } elseif (is_year ()) { ?>
		<div class="post_nav">
			<p>You are currently viewing the stories for <strong><?php the_time('Y'); ?></strong></p>
			<div class="spacer"></div>
		</div>		
    <?php } elseif (is_day()) { ?>
		<div class="post_nav">
		<p>You are currently viewing the stories for <strong><?php the_time('l, F j, Y'); ?></strong></p>
		<div class="spacer"></div>
		</div>		
    <?php } elseif (is_search()) {?>
		<div class="post_nav">
		<h3>Search Results</h3>
		<p>You are currently viewing the search results for <strong><?php the_search_query(); ?></strong>.</p>
		<div class="spacer"></div>
		</div>
    <?php } elseif (is_page('contact')) {?>
    <?php } ?>

<!-- where am I ends -->
			

  <?php if (have_posts()) : ?>
    <?php $i=0; ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php if($i==0) : ?>
        <?php $leftArchivesWrapClose = false; ?>
        <div class="leftArchivesWrap">
    <?php endif; ?>
        <div class="leftArchives">
            
            <h3 id="post_<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            <span>by <?php beller_author(); ?> <?php the_time('F j, Y') ?></span><br />
            <span>Neighborhood: <?php the_category(', '); ?></span>
            <p>
            <?php //echo get_the_excerpt(); ?>
            <?php echo apply_filters('get_the_excerpt', ''); ?>
            </p>
            
        </div>    
    <?php $i++; if($i>2) : ?>
        <?php $leftArchivesWrapClose = true; ?>
        </div>
        <?php $i = 0; ?>
    <?php endif; ?>
    <?php endwhile; ?>
    
    <?php if(!$leftArchivesWrapClose) :?>
        </div>
    <?php endif; ?> 
    <div class="navigation">
			<p class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></p>
			<p class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
    </div>

	<?php else : ?>		
		<div class="entry">
		<span class="error"><img src="<?php bloginfo('template_directory'); ?>/images/mal.png" alt="error duck" /></span>
		<p>Hmmm, seems like what you were looking for isn't here.  You might want to give it another try - the server might have hiccuped - or maybe you even spelled something wrong (though it's more likely <strong>I</strong> did).</p>
		</div>
	<?php endif; ?>



</div>
 </div>
<?php get_sidebar(); ?>
 
<?php get_footer(); ?>