<?php
$lat_init = 35.681236;
$lng_init = 139.767125;

// query args
$post_map_area = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
);

// 特集テーマ
global $post_map_sp;
// 投稿件数だけ無限大に
$post_map_sp['posts_per_page'] = -1;
?>

<script>
jQuery(function($) {
  $(function(){
    var markerMapArea = [];
    // var marker;
    /*
     * TOPページ
    */
    // 遅延読み込み部分
    var mapAreaDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapArea', mapLatLng, 10.0 );
      var disp_num = 2;
      var query_args = <?php echo json_encode($post_map_area); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'get_wp_posts_map',
            'query_args' : query_args,
            'map_id'     : 'mapArea',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapArea').myLazyLoadingObj({
      callback : mapAreaDone,
    });


    /*
     * TOPページ
     * 特集テーマ
    */
    // 遅延読み込み部分
    var mapAreaSpDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapAreaSp', mapLatLng, 10.0 );
      // var disp_num = 2;
      var query_args = <?php echo json_encode($post_map_sp); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'get_wp_posts_map',
            'query_args' : query_args,
            'map_id'     : 'mapAreaSp',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapAreaSp').myLazyLoadingObj({
      callback : mapAreaSpDone,
    });

    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });

  });
});
</script>