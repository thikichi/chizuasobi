<?php
$gmap_ajax_search = get_field('acf_option_gmap_featurepostmap','option');
if( $gmap_ajax_search ) {
  $init_lat = $gmap_ajax_search['position_center']['lat'];
  $init_lng = $gmap_ajax_search['position_center']['lng'];
  $init_zoom = (int)$gmap_ajax_search['zoom'];
} else {
  $init_lat = 35.681236;
  $init_lng = 139.767125;
  $init_zoom = 10;
}
// 特集テーマ
global $post_map_sp;
// 投稿件数だけ無限大に
$post_map_sp['posts_per_page'] = -1;
?>

<script>
var mapFeatureMarker = [];
jQuery(function($) {
  $(function(){
    /*
     * TOPページ
     * 特集テーマ
    */
    // 遅延読み込み部分
    var mapFeatureDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $init_lat; ?>, <?php echo $init_lng; ?> );
      var map = initMap( 'mapFeature', mapLatLng, <?php echo $init_zoom; ?> );
      // var disp_num = 2;
      var query_args = <?php echo json_encode($post_map_sp); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapFeatureFunc',
            'query_args' : query_args,
            'mapid'     : 'mapFeature',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            mapFeatureMarker = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapFeature').myLazyLoadingObj({
      callback : mapFeatureDone,
    });

    // $('[data-mapid]').on('click', function(event) {
    //   var map_post_id = $(this).data('mapid');
    //   google.maps.event.trigger(mapFeatureMarker[map_post_id], "click");
    // });
  });
});
function mapFeatureClick( linkid ) {
  google.maps.event.trigger(mapFeatureMarker['mapFeature_' + linkid], "click");
  document.getElementById('mapFeature').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>