	<div id="supplementary">
		<div class="meta">
		
			<ul>
				<?php if ( !function_exists('dynamic_sidebar')
					  || !dynamic_sidebar() ) : ?>
			
			<!--<li>
				<h3>About</h3>
			 	<p>Uncomment this section if you want to put some information about you or the site here</p>
			</li>-->
			
			<li>
				<h3>Categories</h3>	
				<ul id="categories">
					<?php wp_list_categories('orderby=name&title_li=&hierarchical=true'); ?>
				</ul>
			</li>
			
			<li>
				<h3>Archives</h3>
				<ul id="archives">
					<?php wp_get_archives('format=html&show_post_count=true'); ?>
				</ul>
			</li>
		
				<?php endif; ?>

			</ul>			
	
	</div> <!-- close meta -->
	</div> <!-- close supplementary -->

</div> <!-- close content -->