<?php
// set query
if( is_post_type_archive('landmark') ) {
  $query_args = array(
    'post_type' => 'landmark',
    'posts_per_page' => -1
  );
}  else {
  $qobj = $queried_object = get_queried_object();
  $taxonomy = $qobj->taxonomy;
  $term_id  = $qobj->term_id;
  $query_args = array( 
    'post_type'=>'landmark',
    'posts_per_page'=>-1,
    'tax_query'      => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $term_id,
      )
    )
  );
}

$query_args_encode = json_encode($query_args);
// zoom level
$gmap_ajax_search = get_field('acf_option_gmap_archive','option');
if( $gmap_ajax_search ) {
  $zoom = $gmap_ajax_search['zoom'];
} else {
  $zoom = 14;
}

?>

<script>
var mapArchiveMarker = [];
jQuery(function($) {
  $(function(){
    var markerSize ='img_marker_large';
    var query_args = JSON.parse('<?php echo $query_args_encode; ?>');
    // 遅延読み込み部分
    var mapArchiveDone = function() {
      var markerData = [];
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'    : 'mapArchiveFunc',
            'mapid'     : 'mapArchive',
            'marker_size' : markerSize,
            'query_args' : query_args,
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            var last_lat = markerData[markerData.length - 1]['lat'];
            var last_lng = markerData[markerData.length - 1]['lng'];
            var mapLatLng = getCenerLatLng( last_lat, last_lng );
            var map = initMap( 'mapArchive', mapLatLng, <?php echo $zoom; ?> );
            mapArchiveMarker = dispMarker2( map, markerData );
            // $('#mapArchiveHtml').html(jsonData['tags']);
          }
      });
    }
    mapArchiveDone();

    $('input[name="chgmarker"]').change(function() {
      markerSize = $("input[name='chgmarker']:checked").val();
      mapArchiveDone();
    });

  });
});
function mapArchiveClick( linkid ) {
  google.maps.event.trigger(mapArchiveMarker['mapArchive_' + linkid], "click");
  document.getElementById('mapArchiveLink').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>