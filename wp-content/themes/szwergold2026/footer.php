                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Core Wrapper END -->

<?php

// Set the items in the footer array.
$footer_items_array = array();
$footer_items_array[] = '<a href="/about" title="About" class="text-white m-0 p-0">About</a>';
$footer_items_array[] = '<a href="/what" title="What’s this?" class="text-white m-0 p-0">What’s this?</a>';
$footer_items_array[] = '<a href="/feed" title="RSS feed" class="text-white m-0 p-0">RSS feed</a>';
$footer_items_array[] = '<a href="#" title="top of page" class="text-white m-0 p-0">Top of Page</a>';
$footer_items_array[] = '<span class="text-white m-0 p-0">All Materials &copy; ' . date('Y') . ' MrBellersNeighborhood</span>';

// Set the footer string.
$footer_items_string = implode('<span class="text-white m-0 p-0 px-1">&bull;</span>', $footer_items_array);

?>

<div class="container-fluid m-0 p-0">
  <div class="row m-0 p-0">
    <div class="col col-12 m-0 p-0 bg-black">

      <div class="container">
        <div class="row m-0 p-0">
          <div class="col col-12 m-0 p-0 py-3">

            <!-- Footer BEGIN -->
            <footer class="user-select-none">

              <span><?php echo $footer_items_string; ?></span>
              <span>&nbsp;</span>

              <!-- Performance benchmarking. -->
              <?php
              if (TRUE && is_user_logged_in() && current_user_can('edit_pages') ){
                global $wpdb;
                echo '<div class="clsQueries text-white">' . $wpdb->num_queries . ' queries. ';
                timer_stop(1);
                echo ' seconds.</div>';
              }
              ?>

            </footer>
            <!-- Footer END -->

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Disabling this stuff since it looks like it is no longer being used. -->
<!-- <script type="text/javascript">
  var sc_project=5412846; 
  var sc_invisible=1; 
  var sc_partition=53; 
  var sc_click_stat=1; 
  var sc_security="7e77eada"; 
</script>

<script type="text/javascript" src="https://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="joomla stats" href="https://www.statcounter.com/joomla/" target="_blank"><img class="statcounter" src="https://c.statcounter.com/5412846/0/7e77eada/1/" alt="joomla stats" ></a></div></noscript> -->

<?php

  /****************************************************************************************/
  // This 'wp_footer' call sets all of the JavaScript and related stuff that WordPress needs to insert in the page.
  wp_footer();

?>

</body>
</html>