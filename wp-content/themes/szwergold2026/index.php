<?php
  get_header();
?>
<!-- Content Core BEGIN -->
<div class="container m-0 p-0">
  <div class="row m-0 p-0">
    <div class="col col-12 col-xl-10 m-0 p-0">

      <?php

        /**********************************************************************************/
        // Init variables.
        $home_latest = null;
        $home_featured_main = null;
        $home_featured_1 = null;
        $home_featured_2 = null;

        /**********************************************************************************/
        // Main featured stuff.
        if (is_active_sidebar('home-featured-main')) {

          /********************************************************************************/
          // Grab the 'main-featured' into a variable.
          ob_start();
          dynamic_sidebar('home-featured-main');
          $home_featured_main = ob_get_contents();
          ob_end_clean();
 
        } // if

 
        /**********************************************************************************/
        // Post sidebar 1 stuff.
        if (is_active_sidebar('home-latest')) {

          /********************************************************************************/
          // Capture the content and set it in a variable so we can tweak the links.
          ob_start();
          dynamic_sidebar('home-latest');
          $home_latest = ob_get_contents();
          ob_end_clean();

          /********************************************************************************/
          // Filter the content in the variable.
          $home_latest = str_replace('<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a href=', '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a class="text-decoration-none text-dark" href=', $home_latest);

        } // if

        /**********************************************************************************/
        // Home featured 1 stuff.
        if (is_active_sidebar('home-featured-1')) {

          /********************************************************************************/
          // Capture the content and set it in a variable so we can tweak the links.
          ob_start();
          dynamic_sidebar('home-featured-1');
          $home_featured_1 = ob_get_contents();
          ob_end_clean();

          /********************************************************************************/
          // Filter the content in the variable.
          $home_featured_1 = str_replace('<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a href=', '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a class="text-decoration-none text-dark" href=', $home_featured_1);

        } // if

        /**********************************************************************************/
        // Home featured 2 stuff.
        if (is_active_sidebar('home-featured-2')) {
 
          /********************************************************************************/
          // Capture the content and set it in a variable so we can tweak the links.
          ob_start();
          dynamic_sidebar('home-featured-2');
          $home_featured_2 = ob_get_contents();
          ob_end_clean();

          /********************************************************************************/
          // Filter the content in the variable.
          $home_featured_2 = str_replace('<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a href=', '<div class="widget-title h5 text-capitalize p-0 m-0 pb-1 mb-2 border-bottom border-dark"><a class="text-decoration-none text-dark" href=', $home_featured_2);

        } // if

      ?>

      <div class="row p-0 m-0 me-xl-3">
        <div class="col col-12 col-xl-3 m-0 p-0 mb-3 order-2 order-xl-first">
          <div class="container">
            <div class="row"> 
              <?php
                echo $home_latest;
              ?>
            </div>
          </div>
        </div>
        <div class="col col-12 col-xl-9 m-0 p-0 mb-3 order-1 order-xl-last">
          <div class="container">
            <div class="row"> 
              <?php
                echo $home_featured_main;
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="row p-0 m-0 me-xl-3">
        <div class="col col-12 col-xl-3 m-0 p-0 mb-3">
          <div class="container">
            <div class="row m-0 p-0"> 
              <?php
                echo $home_featured_1;
              ?>
            </div>
          </div>
        </div>
        <div class="col col-12 col-xl-9 m-0 p-0 mb-3">
          <div class="container">
            <div class="row m-0 p-0"> 
              <?php
                echo $home_featured_2;
              ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col col-12 col-xl-2 m-0 p-0">
      <?php
        include_once('sidebar-index.php');
      ?>
    </div>
  </div>
</div>
<!-- Content Core END -->
<?php
  get_footer();
?>