<?php

    /*********************************************************************************/
    // Init some variables.
    $ret = null;

    $before = null;
    $after = null;
    $final = array();

    $header = null;
    $content = null;
    $footer = null;

    /*********************************************************************************/
    // Set the before stuff.
    if ($instance['before_posts']) {
      $before =
          '<div class="upw-before m-0 p-0">'
        . wpautop($instance['before_posts'])
        . '</div>'
        ;
    } // if

    if ($upw_query->have_posts()) {

      while ($upw_query->have_posts()) {

        $upw_query->the_post();

        $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : '';

        /******************************************************************************/
        // Set the variables.
        $title = get_the_title();
        $post_class = get_post_class($current_post);
        $permalink = get_the_permalink();
        $the_ID = get_the_ID();
        $display_date = get_the_time($instance['date_format']);
        $iso_8601_date = get_the_time('c');
        $excerpt = get_the_excerpt();
        $the_author = get_the_author();
        $the_author_url = get_author_posts_url(get_the_author_meta('ID'));

        $comments_link = get_comments_link();
        $comments_number = get_comments_number(__('No comments', 'upw'), __('One comment', 'upw'), __('% comments', 'upw'));

        $categories = get_the_term_list($post->ID, 'category', '', ', ');
        $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');

        /******************************************************************************/
        // The article image stuff.
        $article_image = null;
        if ($instance['show_thumbnail']) {
          $article_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $instance['thumb_size']);     
        } // if

        /******************************************************************************/
        // Header stuff.
        if (get_the_title() && $instance['show_title']) {
          $header =
              '<div class="h5 p-0 m-0 text-railroadgothic" id="featured_post_' . $the_ID . '">'
            . '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-darkblue">'
            . $title
            . '</a>'
            . '</div>'
            ;
        } // if

        if ($instance['show_author']) {
          $header .=
              '<div class="small p-0 m-0">'
            . 'By '
            . '<a href="' . $the_author_url . '" title="Posts by ' . $the_author . '" class="text-decoration-none text-darkblue">'
            . $the_author
            . '</a>'
            . '</div>'
            ;
          if ($instance['show_date'] && $instance['show_author']) {
            $header .=
                '<div class="small m-0 p-0 text-darkblue">'
              . $display_date
              . '</div>'
              ;
          } // if
          if ($instance['show_comments']) {
            $header .=
                '<div class="small m-0 p-0">'
              . '<a class="comments text-secondary" href="' . $comments_link . '">'
              . $comments_number
              . '</a>'
              . '</div>'
              ;
          } // if
        } // if

        /******************************************************************************/
        // Content stuff.
        if ($instance['show_excerpt'] && !empty($excerpt)) {
          $content = null;
          if (FALSE && isset($article_image) && !empty($article_image)) {
            $content .=
                '<div class="col col-12 col-md-6 m-0 p-0 pb-2 ps-md-3 float-end">'
              . '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-darkblue">'
              . '<img src="' . $article_image . '" alt="' . $title . '" class="img-fluid">'
              . '</a>'
              . '</div>'
              ;
          } // if
          if ($instance['show_readmore']) {
            $excerpt = substr($excerpt, 0, -3);
          } // if
          $content .=
              '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-darkblue">'
            . $excerpt
            . '</a>'
            ;
          if ($instance['show_readmore']) {
            $content .=
                ' '
              . '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-darkblue">'
              . $instance['excerpt_readmore']
              . '</a>'
              ;
          } // if
          $content =
              '<span class="small text-georgia-regular">'
            // . '<a href="' . $permalink . '" title="' . $title . '" class="text-decoration-none text-darkblue">'
            . $content
            // . '</a>'
            . '</span>'
            ;
        } // if

        /******************************************************************************/
        // Footer stuff.
        // $footer = '<footer>';

        // if ($instance['show_cats'] && $categories) {
        //   $footer .=
        //       '<div class="entry-categories">'
        //     . '<strong class="entry-cats-label">'
        //     . __('Posted in', 'upw')
        //     . ': '
        //     . '</strong>'
        //     . '<span class="entry-cats-list">'
        //     . $categories
        //     . '</span>'
        //     . '</div>'
        //     ;
        // } // if

        // if ($instance['show_tags'] && $tags) {
        //   $footer .=
        //       '<div class="entry-tags">'
        //     . '<strong class="entry-tags-label">'
        //     . __('Tagged', 'upw')
        //     . ': '
        //     . '</strong>'
        //     . '<span class="entry-tags-list">'
        //     . $tags
        //     . '</span>'
        //     . '</div>'
        //     ;
        // } // if

        // if ($custom_fields) {
        //   $custom_field_name = explode(',', $custom_fields);
        //   $footer .= '<div class="entry-custom-fields">';
        //   foreach ($custom_field_name as $name) {
        //     $name = trim($name);
        //     $custom_field_values = get_post_meta($post->ID, $name, true);
        //     if ($custom_field_values) { 
        //       $footer .= '<div class="custom-field custom-field-' . $name . '">';
        //       if (!is_array($custom_field_values)) {
        //         echo $custom_field_values;
        //       } // if
        //       else {
        //         $last_value = end($custom_field_values);
        //         foreach ($custom_field_values as $value) {
        //           echo $value;
        //           if ($value != $last_value){
        //             echo ', ';
        //           } // if
        //         } // foreach
        //       } // else
        //     $footer .= '</div>';
        //     } // if
        //   } // foreach
        //   $footer .= '</div>';
        // } // if

        // $footer .= '</footer>';


        /******************************************************************************/
        // Set the divider.
        $divider = null;
        if (!empty($title) && !empty($excerpt)) {
          $divider = '<span class="text-railroadgothic">: </span>';
        } // if

        /******************************************************************************/
        // Custom cointainer begins.
        $final[] =
            '<div class="col col-12 m-0 p-0 pe-md-3 pe-xl-0">'
          . '<div class="' . implode(' ' , get_post_class($post_class))  . ' p-0 m-0">'
          . $header
          . $content
          . $footer
          . '</div>'
          . '</div>'
          ;

      } // while

    } // if
    else {

      $final[] =
          '<div class="upw-not-found m-0 p-0">'
        . wpautop($instance['custom_empty'])
        . '</div>'
        ;
 
    } // else
 
    /*********************************************************************************/
    // Set the after stuff.
    if ($instance['after_posts']) {
      $after =
          '<div class="upw-after m-0 p-0">'
        . wpautop($instance['after_posts'])
        . '</div>'
        ;
        } // if

    /*********************************************************************************/
    // If we hvae stuff to output, set the final output value.
    if (!empty($before) || !empty($final) || !empty($after)) {
        $ret = 
            $before
          . '<div class="upw-posts hfeed row m-0 p-0">'
          . implode('', $final)
          . '</div>'
          . $after
          ;
    } // if

    /*********************************************************************************/
    // Output the final value.
    echo $ret;

?>
