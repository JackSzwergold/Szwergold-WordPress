<?php 
if ( function_exists('register_sidebar') )
    register_sidebars(2, array('name'=>'Sidebar %d'));

$GLOBALS['content_width'] = 470;

add_filter( 'comments_template', 'legacy_comments' );
function legacy_comments( $file ) {
	if ( !function_exists('wp_list_comments') )
		$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

function get_top_rated_posts_by_tag_id($id) {
  global $wpdb;
  $posts = $wpdb->get_results("
  SELECT a.* FROM 
  	(SELECT p.* FROM {$wpdb->prefix}posts AS p JOIN {$wpdb->prefix}term_taxonomy AS x 
  		JOIN {$wpdb->prefix}term_relationships AS r ON p.ID = r.object_id AND r.term_taxonomy_id = x.term_taxonomy_id WHERE x.term_id = '{$id}') AS a 
  		LEFT JOIN (SELECT DISTINCT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ratings_average') AS b ON a.ID = b.post_id 
  		WHERE a.post_status = 'publish'
  		ORDER BY b.meta_value DESC, a.post_date DESC LIMIT 0,5;");
  return $posts;
}


function mrbellersneighborhood_shares_sorter($a, $b)
{
    if ($a->shares == $b->shares) {
        return 0;
    }
    return ($a->shares < $b->shares) ? 1 : -1;
}


function mrbellersneighborhood_get_top_shared_posts_by_tag_id($name) {
   global $wpdb;
   $wpdb->queries[] = array( 'mrbellersneighborhood_get_top_shared_posts_by_tag_id_start' );
/*
   $posts = get_posts( 'numberposts=-1&tag='.$name );

   $aIDs = array();
   $strIDsWhere = '';
   foreach( $posts AS $key => $item ) {
      $aIDs[] = $item->ID;
      $strIDsWhere .= $item->ID . ",";
   }
   $strIDsWhere = rtrim($strIDsWhere, ',');
   $strQuery = "SELECT * from {$wpdb->postmeta} where post_id in ($strIDsWhere) and meta_key in ( 'fvfb_tweets', 'fvfb', 'ratings_average' )";
   $aTweetsLikesRatings = $wpdb->get_results( $strQuery, ARRAY_A );
   $aMetaInfo = array();
   foreach( $aTweetsLikesRatings as $aRow ) {
      $aMetaInfo[$aRow['post_id']][$aRow['meta_key']] = maybe_unserialize( $aRow['meta_value'] );
   }

   foreach( $posts AS $key => $item ) {
      if( isset( $aMetaInfo[$item->ID] ) ) {
         $tweets = ( isset( $aMetaInfo[$item->ID]['fvfb_tweets'] ) ? $aMetaInfo[$item->ID]['fvfb_tweets'] : array( 'url_count' => 0 ) );
         $tweets = $tweets['url_count'];
         $likes = ( isset( $aMetaInfo[$item->ID]['fvfb'] ) ? $aMetaInfo[$item->ID]['fvfb'] : array( 'fblike' => 0, 'fbshare' => 0 ) );
         $likes = $likes['fblike'] + $likes['fbshare'];
         $rating = ( isset( $aMetaInfo[$item->ID]['ratings_average'] ) ? $aMetaInfo[$item->ID]['ratings_average'] : 0 );
         $posts[$key]->shares = $likes+$tweets+$rating*10;
      } else {
         $posts[$key]->shares = 0;
      }
   }
*/

   $top_posts = new WP_Query( array('tag'=> $name, 'posts_per_page' => -1, 'update_post_meta_cache' => true ) );
   $posts = $top_posts->posts;
   if( 0 < count( $posts ) )
      foreach( $top_posts->posts AS $key => $item ) {
         $tweets = get_post_meta( $item->ID, 'fvfb_tweets', true );
         if( isset( $tweets['url_count'] ) )
            $tweets = $tweets['url_count']; //backward compatibility with FV Sharing < 0.3.8
         $likes = get_post_meta( $item->ID, 'fvfb', true );
         if( isset( $likes['fblike'] ) )
            $likes = $likes['fblike'] + $likes['fbshare']; //backward compatibility with FV Sharing < 0.3.8
         $rating = get_post_meta( $item->ID, 'ratings_average', true );
         $posts[$key]->shares = $likes+$tweets+$rating*10;
      }
   else
      $posts[$key]->shares = 0;

   usort( $posts, 'mrbellersneighborhood_shares_sorter' );
   $posts = array_slice($posts,0,5);
   $wpdb->queries[] = array( 'mrbellersneighborhood_get_top_shared_posts_by_tag_id_end' );
   return $posts;
}


function mrbellers_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Home Latest' ),
		'id'            => 'home-latest',
		'description'   => __( 'Widget placed here will display the latest items on the homepage.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Featured Main' ),
		'id'            => 'home-featured-main',
		'description'   => __( 'Widget placed here will display the main featured item on the homepage.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Featured 1' ),
		'id'            => 'home-featured-1',
		'description'   => __( 'Add widgets here to appear on your homepage.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s m-0 p-0 col col-12 col-md-6 col-xl-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Featured 2' ),
		'id'            => 'home-featured-2',
		'description'   => __( 'Add widgets here to appear on your homepage.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s m-0 p-0 col col-12 col-md-6 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Footer 1' ),
		'id'            => 'post-footer-1',
		'description'   => __( 'Add widgets here to appear in your post footer.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Footer 2' ),
		'id'            => 'post-footer-2',
		'description'   => __( 'Add widgets here to appear in your post footer.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Sidebar 1' ),
		'id'            => 'post-sidebar-1',
		'description'   => __( 'Add widgets here to appear in your post sidebar.', 'mrbeller' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	) );
}
add_action( 'widgets_init', 'mrbellers_widgets_init' );


function get_post_categories_links() {
    $output = '';
    $cats = get_the_category();
    foreach($cats AS $cat) {
        if($cat->slug == 'featured')
            continue;
        $output .= '<a title="View all the stories from '.$cat->name.'" href="/'.$cat->slug.'">'.$cat->name.'</a>, ';
    }    
    $output = trim($output,', ');
    echo $output;
    return;
}

function get_posts_from_post_category() {
    global $post;
    $cats = get_the_category();
    
    foreach($cats AS $cat) {
        if($cat->slug == 'featured')
            continue;
        $output[] = $cat->cat_ID;
    }    
    $output = implode(',',$output);
    
    query_posts ( array(
        'cat' => $output,
        'showposts' => 5,
        'post__not_in' => array($post->ID),
        'orderby' => 'rand'
    ));            
}

function get_beller_excerpt() {
  global $post;
  if( !$post->post_excerpt ) {
     $post->post_excerpt = '';
   
   	$text = get_the_content('');
   
   	$text = strip_shortcodes( $text );
   
   	$text = apply_filters('the_content', $text);
   	$text = str_replace(']]>', ']]&gt;', $text);
   	$text = preg_replace('/\n+/','',trim(strip_tags($text)));
   	
   	$excerpt_length = 20;//apply_filters('excerpt_length', 55);
   	$words = explode(' ', $text, $excerpt_length + 1);
   	if (count($words) > $excerpt_length) {
   		array_pop($words);
   		array_push($words, '[...]');
   		$text = implode(' ', $words);
   	}
   	$raw_excerpt = '';
   	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
  } else {
    return $post->post_excerpt; 
  }
}

function beller_excerpt( $class = '' ) {
  if( $class ) {
	  echo '<p class="'.$class.'">'.get_beller_excerpt().'</p>';
  } else {
    echo '<p>'.get_beller_excerpt().'</p>';
  }
}

//  Get ratings made by logged in user count
function get_user_ratings_count($id) {
    global $wpdb;
    
    return $wpdb->get_var("SELECT COUNT(rating_postid) FROM $wpdb->ratings WHERE rating_userid = '$id'");
}

//  Get ratings made by logged in user
function get_user_ratings($id) {
    global $ratings;
    global $wpdb;
    
    $ratings = $wpdb->get_results("SELECT rating_postid, rating_posttitle, rating_rating, rating_timestamp FROM $wpdb->ratings WHERE rating_userid = '$id'");
}

//  Get pending stories by user login
function get_user_pending_stories($ID) {
    global $stories_pending;
    global $wpdb;
    //$regexp = '"name";s:[0-9]+:"'.$login.'"';
    //$stories_pending = $wpdb->get_results("SELECT id, created, data FROM {$wpdb->prefix}filled_in_data WHERE (form_id = 1 OR form_id = 2) AND data REGEXP '{$regexp}'");
    $stories_pending = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type='post' AND post_status='draft' AND post_author = '{$ID}'");
}

//  Get stories by user login
function get_user_stories($ID) {
    global $wpdb;
    global $stories;
    
    //$stories = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='author_name' AND meta_value='{$login}'");
    $stories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type='post' AND post_status='publish' AND post_author = '{$ID}'");
} 

function beller_author() {
    global $post;
    //echo $post->post_author.' ';
    $author = get_post_meta($post->ID,'author_name',true);
    if($author == '') {
        the_author_posts_link();
    } // if
    else {
        echo $author;
    } // else
}

function get_beller_author() {
    global $post;
    //echo $post->post_author.' ';
    $author = get_post_meta($post->ID,'author_name',true);
    if($author == '') {
        return get_the_author_posts_link();
    } // if
    else {
        return $author;
    } // else
}

/*
A copy of default WP function which uses category name for value
*/
function wp_dropdown_categories_names( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => '',
		'orderby' => 'id', 'order' => 'ASC',
		'show_last_update' => 0, 'show_count' => 0,
		'hide_empty' => 1, 'child_of' => 0,
		'exclude' => '', 'echo' => 1,
		'selected' => 0, 'hierarchical' => 0,
		'name' => 'cat', 'class' => 'postform',
		'depth' => 0, 'tab_index' => 0
	);

	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;

	$r = wp_parse_args( $args, $defaults );
	$r['include_last_update_time'] = $r['show_last_update'];
	extract( $r );

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";

	$categories = get_categories( $r );
	$name = esc_attr($name);
	$class = esc_attr($class);

	$output = '';
	if ( ! empty( $categories ) ) {
		$output = "<select name='$name' id='$name' class='$class' $tab_index_attribute>\n";

		if ( $show_option_all ) {
			$show_option_all = apply_filters( 'list_cats', $show_option_all );
			$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}

		if ( $show_option_none ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
		}

		if ( $hierarchical )
			$depth = $r['depth'];  // Walk the full depth.
		else
			$depth = -1; // Flat.

		$output .= walk_category_dropdown_tree_names( $categories, $depth, $r );
		$output .= "</select>\n";
	}

	$output = apply_filters( 'wp_dropdown_cats', $output );

	if ( $echo )
		echo $output;

	return $output;
} 

function walk_category_dropdown_tree_names() {
	$args = func_get_args();
	// the user's options are the third parameter
	if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
		$walker = new Walker_CategoryDropdown_names;
	else
		$walker = $args[2]['walker'];

	return call_user_func_array(array( &$walker, 'walk' ), $args );
}

class Walker_CategoryDropdown_names extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category. Used for padding.
	 * @param array $args Uses 'selected', 'show_count', and 'show_last_update' keys, if they exist.
	 */
	function start_el(&$output, $category, $depth=0, $args=array(),$id=0) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		$cat_name = apply_filters('list_cats', $category->name, $category);
		//$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->name.", NYC\"";
		if ( $category->term_id == $args['selected'] )
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		if ( $args['show_last_update'] ) {
			$format = 'Y-m-d';
			$output .= '&nbsp;&nbsp;' . gmdate($format, $category->last_update_timestamp);
		}
		$output .= "</option>\n";
	}
} 
 
 
/*
A copy of default WP function which uses category slug for value
*/
function wp_dropdown_categories_slug( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => '',
		'orderby' => 'id', 'order' => 'ASC',
		'show_last_update' => 0, 'show_count' => 0,
		'hide_empty' => 1, 'child_of' => 0,
		'exclude' => '', 'echo' => 1,
		'selected' => 0, 'hierarchical' => 0,
		'name' => 'cat', 'class' => 'postform',
		'depth' => 0, 'tab_index' => 0
	);

	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;

	$r = wp_parse_args( $args, $defaults );
	$r['include_last_update_time'] = $r['show_last_update'];
	extract( $r );

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";

	$categories = get_categories( $r );
	$name = esc_attr($name);
	$class = esc_attr($class);

	$output = '';
	if ( ! empty( $categories ) ) {
		$output = "<select name='$name' id='$name' class='$class' $tab_index_attribute>\n";

		if ( $show_option_all ) {
			$show_option_all = apply_filters( 'list_cats', $show_option_all );
			$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}

		if ( $show_option_none ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
		}

		if ( $hierarchical )
			$depth = $r['depth'];  // Walk the full depth.
		else
			$depth = -1; // Flat.

		$output .= walk_category_dropdown_tree_slug( $categories, $depth, $r );
		$output .= "</select>\n";
	}

	$output = apply_filters( 'wp_dropdown_cats', $output );

	if ( $echo )
		echo $output;

	return $output;
} 

function walk_category_dropdown_tree_slug() {
	$args = func_get_args();
	// the user's options are the third parameter
	if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
		$walker = new Walker_CategoryDropdown_slug;
	else
		$walker = $args[2]['walker'];

	return call_user_func_array(array( &$walker, 'walk' ), $args );
}

class Walker_CategoryDropdown_slug extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category. Used for padding.
	 * @param array $args Uses 'selected', 'show_count', and 'show_last_update' keys, if they exist.
	 */
	function start_el(&$output, $category, $depth=0, $args=array(),$id=0) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		$cat_name = apply_filters('list_cats', $category->name, $category);
		//$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\"";
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->slug."\"";
		if ( $category->term_id == $args['selected'] )
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		if ( $args['show_last_update'] ) {
			$format = 'Y-m-d';
			$output .= '&nbsp;&nbsp;' . gmdate($format, $category->last_update_timestamp);
		}
		$output .= "</option>\n";
	}
} 

add_filter( 'the_content', 'fv_next_page', 1 );

function fv_next_page( $content ) {
  $content = str_replace( '<!--nextpage-->','<!--break-->',$content ); 
  return $content;
}

/*add_filter( 'request', 'fv_mrb_query_vars' );

function fv_mrb_query_vars( $vars ) {
  echo '<!--query_vars '.var_export( $vars, true ).' -->';
  return $vars;
}*/


function fv_display_image_from_fv_image_uploader_plugin( $content ) {
	global $post;
	if ( is_single() || is_page() )
		$content = fv_image_uploader_get_img($post->ID).$content;
	return $content;
}
//add_filter( 'the_content', 'fv_display_image_from_fv_image_uploader_plugin', 20 );

/********************************************************************************/
// 2025-11-20: Adding HTML5 support.
function register_html_support() {
    add_theme_support('html5', array('script', 'style'));
}
add_action('after_setup_theme', 'register_html_support');

/********************************************************************************/
// 2025-11-20: An attempt to remove trailing slashes from '<link rel' tags and such.
ob_start();
add_action('shutdown', function () {
    $content = ob_get_clean();
	$content = str_replace(' />', '>', $content);
    echo $content;
    exit();
}, 0);

/********************************************************************************/
// 2025-11-21: To disable the 'contain-intrinsic-size' kludge that WordPress has implemented in newer versions.
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

/********************************************************************************/
// 2025-11-21: To disable the 'speculationrules' script stuff.
add_filter('wp_speculation_rules_configuration', '__return_null');

/********************************************************************************/
// 2025-12-07: An attempt to figure out this lack of thumbnails stuff.
add_theme_support('post-thumbnails');

/********************************************************************************/
// 2025-12-09: Properly setting the Bootstrap CSS and JavaScript.
function load_bootstrap_files() {
	wp_register_style('bootstrap-53', get_template_directory_uri() . '/css/bootstrap-5.3.8/bootstrap.min.css', array(), '5.3.8');
	wp_enqueue_style('bootstrap-53');
	wp_register_script('bootstrap-53', get_template_directory_uri() . '/script/bootstrap-5.3.8/bootstrap.bundle.min.js', array('jquery'), '5.3.8');
	wp_enqueue_script('bootstrap-53');
}
add_action('wp_enqueue_scripts', 'load_bootstrap_files', 10);

/********************************************************************************/
// 2025-12-09: Properly setting the Font Awesome CSS.
function load_fontawesome_files() {
	wp_register_style('fontawesome', get_template_directory_uri() . '/fonts/font-awesome-4.7.0/css/font-awesome.min.css', array(), '4.7.0');
	wp_enqueue_style('fontawesome');
}
add_action('wp_enqueue_scripts', 'load_fontawesome_files', 10);

?>