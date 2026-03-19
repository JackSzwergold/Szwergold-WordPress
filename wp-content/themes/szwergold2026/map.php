<?php
/*
Template Name: Map
*/
?>

<?php get_header(); ?>

<?php

//if($_GET['version'] == 'slow')
//if(isset($wp_query->query_vars['map'])) 
  $single_neighborhood = true;

if($single_neighborhood) {
  $current = isset($wp_query->query_vars['map']) ? $wp_query->query_vars['map'] : 0;
  $selectedCat = get_category_by_slug($current); 
  $id = $selectedCat != false ? $selectedCat->term_id : 0;

  $i = 0;
  $locations = array();
  query_posts('cat='.$id.'&posts_per_page=5000');
  while (have_posts ()) {
    the_post ();
    $longitude = get_post_meta(get_the_ID(),'longitude',true);
    $latitude = get_post_meta(get_the_ID(),'latitude',true);
    if($latitude == NULL || $longitude == NULL)
      continue;
    
    $locations[$i]['id'] = $id;
    $locations[$i]['lon'] = $longitude;
    $locations[$i]['lat'] = $latitude;
    $i++;
  }
                

} else {
/*$locations = $wpdb->get_results("
    SELECT a.post_id as id, a.meta_value as lat, b.meta_value as lon, c.post_title AS title FROM {$wpdb->prefix}postmeta AS a 
    JOIN {$wpdb->prefix}postmeta AS b ON a.post_id = b.post_id JOIN {$wpdb->prefix}posts AS c ON c.id = a.post_id
    WHERE a.meta_key='latitude' AND b.meta_key='longitude' AND a.meta_value!='' AND b.meta_value!='' LIMIT 0,10000",ARRAY_A);*/
  $locations = $wpdb->get_results("
      SELECT a.post_id as id, a.meta_value as lat, b.meta_value as lon FROM {$wpdb->prefix}postmeta AS a 
      JOIN {$wpdb->prefix}postmeta AS b ON a.post_id = b.post_id 
      WHERE a.meta_key='latitude' AND b.meta_key='longitude' AND a.meta_value!='' AND b.meta_value!='' LIMIT 0,10000",ARRAY_A);
}  

?>

<div id="content">

	<div id="entry_content">
	
	<h2><?php _e('Select neighborhood'); ?></h2>
    
    <?php
    ////  different dropdown for easier version
    if($single_neighborhood) {
      $dropdown = wp_dropdown_categories_slug('show_option_none=Select Neighborhood&name=neigh&hierarchical=1&orderby=name&exclude=258,237,227,270,280,243,279,1,56&echo=0&selected='.($selectedCat != false ? $selectedCat->term_id : 0));
      $dropdown = str_replace('<select ','<select onchange=\'if(this.options[this.selectedIndex].value=="-1") location.href = "/map" ; else location.href = "/map/"+this.options[this.selectedIndex].value\' ',$dropdown);
      echo $dropdown;
    } else {
    ////  this is the dynamic dropdown
      $dropdown = wp_dropdown_categories_names('show_option_none=Select Neighborhood&name=neigh&hierarchical=1&exclude=258,237,227,270,280,243,279,1,56&echo=0');
      $dropdown = str_replace('<select ','<select onchange=\'if(this.options[this.selectedIndex].value=="-1") return false; var pos = new GClientGeocoder; pos.getLatLng( this.options[this.selectedIndex].value, function( point ) {  map.panTo(point); } )\' ',$dropdown);
      echo $dropdown;
    ?>
    
    <!--<select onchange='var pos = new GClientGeocoder; pos.getLatLng( this.options[this.selectedIndex].value, function( point ) { map.panTo(point); } )'>
        <option value='-1'>Select Neighborhood</option>
      	<option class="level-0" value="Bronx, NYC">Bronx&nbsp;&nbsp;(34)</option>
      	<option class="level-0" value="Brooklyn, NYC">Brooklyn&nbsp;&nbsp;(174)</option>
      	<option class="level-1" value="Bedford-Stuyvesant, NYC">&nbsp;&nbsp;&nbsp;Bedford-Stuyvesant&nbsp;&nbsp;(4)</option>
      	<option class="level-1" value="Boro Park, NYC">&nbsp;&nbsp;&nbsp;Boro Park&nbsp;&nbsp;(6)</option>
      
      	<option class="level-1" value="Brooklyn Heights, NYC">&nbsp;&nbsp;&nbsp;Brooklyn Heights&nbsp;&nbsp;(18)</option>
      	<option class="level-1" value="Caroll Gardens, NYC">&nbsp;&nbsp;&nbsp;Caroll Gardens&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="Carroll Gardens, NYC">&nbsp;&nbsp;&nbsp;Carroll Gardens&nbsp;&nbsp;(8)</option>
      	<option class="level-1" value="Clinton Hill, NYC">&nbsp;&nbsp;&nbsp;Clinton Hill&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="Cobble Hill, NYC">&nbsp;&nbsp;&nbsp;Cobble Hill&nbsp;&nbsp;(3)</option>
      
      	<option class="level-1" value="Coney Island, NYC">&nbsp;&nbsp;&nbsp;Coney Island&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="Flatbush, NYC">&nbsp;&nbsp;&nbsp;Flatbush&nbsp;&nbsp;(7)</option>
      	<option class="level-1" value="Fort Greene, NYC">&nbsp;&nbsp;&nbsp;Fort Greene&nbsp;&nbsp;(5)</option>
      	<option class="level-1" value="Greenpoint, NYC">&nbsp;&nbsp;&nbsp;Greenpoint&nbsp;&nbsp;(9)</option>
      	<option class="level-1" value="Kensington, NYC">&nbsp;&nbsp;&nbsp;Kensington&nbsp;&nbsp;(3)</option>
      
      	<option class="level-1" value="Long Island, NYC">&nbsp;&nbsp;&nbsp;Long Island&nbsp;&nbsp;(5)</option>
      	<option class="level-1" value="Long Island City, NYC">&nbsp;&nbsp;&nbsp;Long Island City&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="Park Slope, NYC">&nbsp;&nbsp;&nbsp;Park Slope&nbsp;&nbsp;(31)</option>
      	<option class="level-1" value="Red Hook, NYC">&nbsp;&nbsp;&nbsp;Red Hook&nbsp;&nbsp;(4)</option>
      	<option class="level-1" value="Rockaway, NYC">&nbsp;&nbsp;&nbsp;Rockaway&nbsp;&nbsp;(1)</option>
      
      	<option class="level-1" value="Shea Stadium, NYC">&nbsp;&nbsp;&nbsp;Shea Stadium&nbsp;&nbsp;(2)</option>
      	<option class="level-1" value="Sunset Park, NYC">&nbsp;&nbsp;&nbsp;Sunset Park&nbsp;&nbsp;(2)</option>
      	<option class="level-1" value="The East River, NYC">&nbsp;&nbsp;&nbsp;The East River&nbsp;&nbsp;(1)</option>
      	<option class="level-0" value="East Bronx, NYC">East Bronx&nbsp;&nbsp;(9)</option>
      	<option class="level-0" value="England, NYC">England&nbsp;&nbsp;(1)</option>
      
      	<option class="level-0" value="Jamaica, NYC">Jamaica&nbsp;&nbsp;(6)</option>
      	<option class="level-0" value="Letter From Abroad, NYC">Letter From Abroad&nbsp;&nbsp;(73)</option>
      	<option class="level-0" value="Manhattan, NYC">Manhattan&nbsp;&nbsp;(899)</option>
      	<option class="level-1" value="Central Park, NYC">&nbsp;&nbsp;&nbsp;Central Park&nbsp;&nbsp;(14)</option>
      
      	<option class="level-1" value="Chelsea, NYC">&nbsp;&nbsp;&nbsp;Chelsea&nbsp;&nbsp;(43)</option>
      	<option class="level-1" value="Chinatown, NYC">&nbsp;&nbsp;&nbsp;Chinatown&nbsp;&nbsp;(12)</option>
      	<option class="level-1" value="Clinton, NYC">&nbsp;&nbsp;&nbsp;Clinton&nbsp;&nbsp;(12)</option>
      	<option class="level-1" value="Dumbo, NYC">&nbsp;&nbsp;&nbsp;Dumbo&nbsp;&nbsp;(4)</option>
      	<option class="level-1" value="East Harlem, NYC">&nbsp;&nbsp;&nbsp;East Harlem&nbsp;&nbsp;(18)</option>
      
      	<option class="level-1" value="East Village, NYC">&nbsp;&nbsp;&nbsp;East Village&nbsp;&nbsp;(64)</option>
      	<option class="level-1" value="Financial District, NYC">&nbsp;&nbsp;&nbsp;Financial District&nbsp;&nbsp;(22)</option>
      	<option class="level-1" value="Gramercy Park, NYC">&nbsp;&nbsp;&nbsp;Gramercy Park&nbsp;&nbsp;(7)</option>
      	<option class="level-1" value="Greenwich Village, NYC">&nbsp;&nbsp;&nbsp;Greenwich Village&nbsp;&nbsp;(33)</option>
      	<option class="level-1" value="Harlem, NYC">&nbsp;&nbsp;&nbsp;Harlem&nbsp;&nbsp;(23)</option>
      
      	<option class="level-1" value="Inwood, NYC">&nbsp;&nbsp;&nbsp;Inwood&nbsp;&nbsp;(3)</option>
      	<option class="level-1" value="Lenox Hill, NYC">&nbsp;&nbsp;&nbsp;Lenox Hill&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="Lower East Side, NYC">&nbsp;&nbsp;&nbsp;Lower East Side&nbsp;&nbsp;(39)</option>
      	<option class="level-1" value="Lower Manhattan, NYC">&nbsp;&nbsp;&nbsp;Lower Manhattan&nbsp;&nbsp;(11)</option>
      	<option class="level-1" value="Midtown, NYC">&nbsp;&nbsp;&nbsp;Midtown&nbsp;&nbsp;(144)</option>
      
      	<option class="level-1" value="Morningside Heights, NYC">&nbsp;&nbsp;&nbsp;Morningside Heights&nbsp;&nbsp;(21)</option>
      	<option class="level-1" value="Murray Hill, NYC">&nbsp;&nbsp;&nbsp;Murray Hill&nbsp;&nbsp;(11)</option>
      	<option class="level-1" value="Nolita, NYC">&nbsp;&nbsp;&nbsp;Nolita&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="On the Waterfront, NYC">&nbsp;&nbsp;&nbsp;On the Waterfront&nbsp;&nbsp;(8)</option>
      	<option class="level-1" value="Outer Boroughsm, NYC">&nbsp;&nbsp;&nbsp;Outer Boroughs&nbsp;&nbsp;(35)</option>
      
      	<option class="level-1" value="Park Avenue South, NYC">&nbsp;&nbsp;&nbsp;Park Avenue South&nbsp;&nbsp;(1)</option>
      	<option class="level-1" value="SoHo, NYC">&nbsp;&nbsp;&nbsp;SoHo&nbsp;&nbsp;(19)</option>
      
      	<option class="level-1" value="Times Square, NYC">&nbsp;&nbsp;&nbsp;Times Square&nbsp;&nbsp;(20)</option>
      	<option class="level-1" value="Tribeca, NYC">&nbsp;&nbsp;&nbsp;Tribeca&nbsp;&nbsp;(17)</option>
      
      	<option class="level-1" value="Tudor City, NYC">&nbsp;&nbsp;&nbsp;Tudor City&nbsp;&nbsp;(2)</option>
      	<option class="level-1" value="Union Square, NYC">&nbsp;&nbsp;&nbsp;Union Square&nbsp;&nbsp;(12)</option>
      	<option class="level-1" value="Upper East Side, NYC">&nbsp;&nbsp;&nbsp;Upper East Side&nbsp;&nbsp;(59)</option>
      	<option class="level-1" value="Upper West Side, NYC">&nbsp;&nbsp;&nbsp;Upper West Side&nbsp;&nbsp;(86)</option>
      	<option class="level-1" value="Washington Heights, NYC">&nbsp;&nbsp;&nbsp;Washington Heights&nbsp;&nbsp;(9)</option>
      
      	<option class="level-1" value="West Village, NYC">&nbsp;&nbsp;&nbsp;West Village&nbsp;&nbsp;(89)</option>
      	<option class="level-1" value="Williamsburg, NYC">&nbsp;&nbsp;&nbsp;Williamsburg&nbsp;&nbsp;(24)</option>
      	<option class="level-1" value="World Trade Center, NYC">&nbsp;&nbsp;&nbsp;World Trade Center&nbsp;&nbsp;(36)</option>
      
      	<option class="level-1" value="Astoria, NYC">&nbsp;&nbsp;&nbsp;Astoria&nbsp;&nbsp;(17)</option>
      	<option class="level-0" value="Queens, NYC">Queens&nbsp;&nbsp;(50)</option>
      	<option class="level-0" value="Staten Island, NYC">Staten Island&nbsp;&nbsp;(5)</option>
      	<option class="level-0" value="The Catskills">The Catskills&nbsp;&nbsp;(1)</option>

        
    </select>-->
    <?php } ?>
    
    <span id="loading">Please wait while the map is loading...</span>
    <?php if($single_neighborhood) : ?>
    <!--<div><small>Currently viewing single neighborhood.</small></div>-->
    <?php else : ?>
    <div><small>If the map is too slow, you can switch to <a href="/map/central-park/">single neighborhood view</a>.</small></div>
    <?php endif; ?>
    <div id="mapContainer" style="width: 720px; height: 600px; margin: 30px 0px 30px 0px;"></div>
<script type="text/javascript">
    var map = new GMap2( document.getElementById( "mapContainer" ) );
	 map.setCenter(new GLatLng(40.724551, -74.001412), 13);
    var objGeo = new GClientGeocoder();
    var ptLocation = null;
    var infoOpened = '';
    //var latlngbounds = new GLatLngBounds( );

    function FVLoadGoogleMap(){
        if( GBrowserIsCompatible() ){
          map.addControl( new GLargeMapControl );
          map.addControl( new GMapTypeControl );
          map.setMapType( G_HYBRID_MAP );
          map.enableScrollWheelZoom();
          map.enableContinuousZoom();
            
          <?php echo fv_mnm_get_javascript_array($locations,'aLoc'); ?>
          var markers = [];
          var latlng;
          for(var i = 0; i < aLoc.length; i += 1) {
            latlng = new GLatLng( aLoc[i]['lat'], aLoc[i]['lon'] );
            var marker = new GMarker(latlng);
            //latlngbounds.extend( latlng );
            markers.push(marker);               
          }
          
          <?php if($single_neighborhood) : ?>
          for(var i = 0; i < markers.length; i +=1) {
            map.addOverlay( markers[i] );
          }
          //map.setCenter( latlngbounds.getCenter( ), map.getBoundsZoomLevel( latlngbounds ) );
          <?php else : ?>
          var mcOptions = { gridSize: 30, maxZoom: 15};
          var markerCluster = new MarkerClusterer(map, markers, mcOptions);
          //map.setCenter( new GLatLng( 40.7141, -73.9543  ), 12 );
			 //map.setZoom(13);
          <?php endif; ?>
          
          GEvent.addListener(map, "tilesloaded", function(){ jQuery("#loading").css('visibility', 'hidden'); } );
          
          GEvent.addListener(map, "click", function(overlay, latlng, overlaylatlng){
              //alert(var_dump(overlay)+' '+var_dump(latlng)+' '+var_dump(overlaylatlng));
              if(infoOpened != overlaylatlng) {
                infoOpened = overlaylatlng;
                if(overlay && !latlng) {
                  jQuery.get('<?php echo WP_PLUGIN_URL . "/fv-map/ajax.php" ?>', { lat: overlaylatlng.lat(), lng: overlaylatlng.lng() },
                  function(data){
                    map.openInfoWindowHtml( overlaylatlng, data, { maxWidth: 300 } );
                  });
                }
              }
              else
              infoOpened = '';
            });
          }
    }
    
    function FVHandleError( errorCode ){
        var divStreet = document.getElementById( "StreetViewContainer" );
        divStreet.parentNode.removeChild( divStreet );
    }
</script>
				
    </div> <!-- close entry_content -->

</div>


<?php get_sidebar(); ?>
  
<?php get_footer(); ?>