<?php
$relationplace = get_field('relationplace');
// var_dump($relationplace);

$acf_landmark_gmap = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$relationplace_zoom = get_post_meta( $post->ID, 'relationplace_zoom', true );

$lat_init = $acf_landmark_gmap['lat'];
$lng_init = $acf_landmark_gmap['lng'];

?>

<script>
var markerMapArea = [];
jQuery(function($) {
  $(function(){
    
    // 遅延読み込み部分
    var mapAreaDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapRelation', mapLatLng, <?php echo $relationplace_zoom; ?> );
      var place_arr = <?php echo json_encode($relationplace); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'    : 'mapRelationFunc',
            'place_arr' : place_arr,
            'mapid'     : 'mapRelation',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
            console.log(jsonData['tags']);
            $('.block4__mapside-list').append(jsonData['tags']);
          }
      });
    }
    mapAreaDone();
    // $('[data-mapid]').on('click', function(event) {
    //   var map_post_id = $(this).data('mapid');
    //   google.maps.event.trigger(markerMapArea[map_post_id], "click");
    // });
  });
});
function clickViewMap( linkid ) {
  google.maps.event.trigger(markerMapArea[linkid], "click");
  document.getElementById('mapRelationWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>