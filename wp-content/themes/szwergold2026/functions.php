<?php 

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