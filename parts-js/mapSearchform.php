<?php
global $csearch;
$post_map_area = $csearch->get_subquery_args();
$lat_init = 35.681236;
$lng_init = 139.767125;
?>

<script>
var mapSearchformMarker = [];
jQuery(function($) {
  $(function(){
    // var marker;
    /*
     * TOPページ
    */
    // 遅延読み込み部分
    var mapSearchDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapSearchform', mapLatLng, 10.0 );
      var query_args = <?php echo json_encode($post_map_area); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapSearchformFunc',
            'query_args' : query_args,
            'mapid'     : 'mapSearchform',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            mapSearchformMarker = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapSearchform').myLazyLoadingObj({
      callback : mapSearchDone,
    });
  });
});
function mapSearchformClick( linkid ) {
  google.maps.event.trigger(mapSearchformMarker['mapSearchform_' + linkid], "click");
  document.getElementById('mapSearchformWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>