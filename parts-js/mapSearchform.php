<?php
global $csearch;
$post_map_area = $csearch->get_subquery_args();
$lat_init = 35.681236;
$lng_init = 139.767125;
?>

<script>
var markerMapArea = [];
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
      var map = initMap( 'mapSearch', mapLatLng, 10.0 );
      var query_args = <?php echo json_encode($post_map_area); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapSearchformFunc',
            'query_args' : query_args,
            'mapid'     : 'mapSearch',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapSearch').myLazyLoadingObj({
      callback : mapSearchDone,
    });
    // $('[data-mapid]').on('click', function(event) {
    //   var map_post_id = $(this).data('mapid');
    //   console.log( markerMapArea );
    //   google.maps.event.trigger(markerMapArea[map_post_id], "click");
    // });
  });
});
function clickViewMap( linkid ) {
  google.maps.event.trigger(markerMapArea['mapSearch_' + linkid], "click");
  document.getElementById('mapSearchWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>