<?php

global $authordata;

/******************************************************************************/
// Set the variables.
$title = get_the_title();
$time = get_the_time('F j, Y');
// $excerpt = get_the_excerpt();
$excerpt = wp_trim_words(get_the_content(), 80, ' [...]');
$permalink = get_the_permalink();
$the_ID = get_the_ID();
// $author = get_beller_author();
$the_author = get_the_author();
$the_author_url = esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename));

/******************************************************************************/
// Set the final return values.
$fpw_widget = null;
$fpw_widget .= '<article class="fpw-clearfix fpw-layout-wrapped">';
$fpw_widget .= '<div class="container m-0 p-0 pb-3">';
$fpw_widget .= '<div class="row m-0 p-0">';
$fpw_widget .= '<div class="col col-12 m-0 p-0">';

$fpw_widget .= '<div class="' . implode(' ' , get_post_class()) . '">';
$fpw_widget .= '<div class="h4 p-0 m-0 fw-bold" id="post_' . $the_ID . '">';
$fpw_widget .= '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark">';
$fpw_widget .= $title;
$fpw_widget .= '</a>';
$fpw_widget .= '</div>';
$fpw_widget .= '<div class="small p-0 m-0">';
$fpw_widget .= 'By ';
$fpw_widget .= '<a href="' . $the_author_url . '" title="Posts by ' . $the_author . '" class="text-decoration-none text-dark">';
$fpw_widget .= $the_author;
$fpw_widget .= '</a>';
$fpw_widget .= '</div>';
$fpw_widget .= '<div class="small text-secondary">';
$fpw_widget .= $time;
$fpw_widget .= '</div>';
$fpw_widget .= '<p class="small p-0 m-0 mt-1">';
$fpw_widget .= '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-dark">';
$fpw_widget .= $excerpt;
$fpw_widget .= '</a>';
$fpw_widget .= '</p>';
$fpw_widget .= '</div>';

$fpw_widget .= '</div>';
$fpw_widget .= '</div>';
$fpw_widget .= '</div>';
$fpw_widget .= '</article>';

/******************************************************************************/
// Set the final return values.
echo $fpw_widget;

?>
