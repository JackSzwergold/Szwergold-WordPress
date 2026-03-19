<?php
  get_header();
?>
<!-- Content Core BEGIN -->
<body id="top" class="{{ page.header.body_classes|e }}">

  <nav class="navbar p-0 m-0 px-2 sticky-top navbar-light bg-dark border-bottom border-dark">
    <div class="col col-12 p-0 m-0 px-2 py-1">
      <h1 class="p-0 m-0 text-windsorpro-bold"><a href="{{ home_url|e }}"><span class="text-white">{{ site.title|e }}</span></a></h1>
      <h2 class="p-0 m-0 text-windsorpro-regular"><a href="{{ home_url|e }}"><span class="text-white">{{ config.site.metadata.description|e }}</span></a></h2>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col px-3 px-md-4 mx-3 mx-md-0 my-3 my-md-4 bg-white shadow-lg border border-dark">

        <div class="container-fluid">
          <div class="row">
            <div class="col py-3 py-md-4 text-left">

            {% block header %}
                <header class="col col-12 p-0 m-0 pb-2">
                    <div class="h1 p-0 m-0 text-windsorpro-bold">{% if header.title %}{{ header.title|e }}{% endif %}</div>
                    <div class="h2 p-0 m-0 text-windsorpro-regular">{% if header.description %}{{ header.description }}{% endif %}</div>
                    <hr class="border border-dark border-1 opacity-100">
                </header>
            {% endblock %}

            <!-- {% block header_navigation %}
                {% include 'partials/navigation.html.twig' %}
            {% endblock %} -->

            {% block body %}
              <main class="col col-12 p-0 m-0">
                <article class="col col-12 p-0 m-0">
                  <div class="text-georgia-regular">
                    {% block content %}{% endblock %}
                  </div>
                </article>
              </main>
            {% endblock %}

            {% block bottom %}
                {{ assets.js('bottom')|raw }}
            {% endblock %}

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</body>
<!-- Content Core END -->

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