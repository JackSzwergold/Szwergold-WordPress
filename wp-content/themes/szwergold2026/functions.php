<?php 

/********************************************************************************/
// 2025-11-20: Adding HTML5 support.
function register_html_support() {
    add_theme_support('html5', array('script', 'style'));
}
add_action('after_setup_theme', 'register_html_support');

/********************************************************************************/
// 2025-11-20: An attempt to remove trailing slashes from '<link rel' tags and such.
if (!is_admin()) {
	ob_start();
	add_action('shutdown', function () {
		$content = ob_get_clean();
		// $find_array = array(' />', '/>');
		// $replace_array = array('>', '>');
		$find_array = array(' />');
		$replace_array = array('>');
		$content = str_replace($find_array, $replace_array, $content);
		echo $content;
		exit();
	}, 0);
}

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

/********************************************************************************/
// 2026-03-19: Enabling excerpts on all pages.
add_post_type_support('page', 'excerpt');

/********************************************************************************/
// 2026-03-20: Adding widgets.
function szwergold_widgets_init() {
	register_sidebar(array(
		'name'          => __('Home Latest'),
		'id'            => 'home-latest',
		'description'   => __('Widget placed here will display the latest items on the homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Home Featured Main'),
		'id'            => 'home-featured-main',
		'description'   => __('Widget placed here will display the main featured item on the homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Home Featured 1'),
		'id'            => 'home-featured-1',
		'description'   => __('Add widgets here to appear on your homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s m-0 p-0 col col-12 col-md-6 col-xl-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Home Featured 2'),
		'id'            => 'home-featured-2',
		'description'   => __('Add widgets here to appear on your homepage.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s m-0 p-0 col col-12 col-md-6 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Header 1'),
		'id'            => 'widget-header-1',
		'description'   => __('Add widgets here to appear in your post header.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Header 2'),
		'id'            => 'widget-header-2',
		'description'   => __('Add widgets here to appear in your post header.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Footer 1'),
		'id'            => 'widget-footer-1',
		'description'   => __('Add widgets here to appear in your post footer.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Footer 2'),
		'id'            => 'widget-footer-2',
		'description'   => __('Add widgets here to appear in your post footer.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12 pe-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Sidebar 1'),
		'id'            => 'widget-sidebar-1',
		'description'   => __('Add widgets here to appear in your post sidebar.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
	register_sidebar(array(
		'name'          => __('Widget Sidebar 2'),
		'id'            => 'widget-sidebar-2',
		'description'   => __('Add widgets here to appear in your post sidebar.', 'szwergold'),
		'before_widget' => '<div id="%1$s" class="widget %2$s col col-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark">',
		'after_title'   => '</div>',
	));
}
add_action( 'widgets_init', 'szwergold_widgets_init' );

?>