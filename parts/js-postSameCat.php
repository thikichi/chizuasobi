<?php
$post_map_center = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$lat_init = $post_map_center['lat'];
$lng_init = $post_map_center['lng'];

// get terms of this post.
$terms = get_the_terms($post->ID, 'landmark_cateogry');
$term_id_arr = array();
if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
  foreach ( $terms as $term ) { $term_id_arr[] = $term->term_id; }
}
// query args
$post_args_same_cat = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
  // 'offset' => $offset,
  'tax_query' => array( 
    array(
      'taxonomy' => 'landmark_cateogry', //タクソノミーを指定
      'field' => 'term_id', //ターム名をスラッグで指定する
      'terms' => $term_id_arr,
      'operator' => 'IN',
    ),
  ),
);
?>

<script>
jQuery(function($) {
  $(function(){
    var markerMapArea = [];
    /*
     * 同じカテゴリー
    */
    // 遅延読み込み部分
    var mapCatsDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapCats', mapLatLng, 10.0 );
      var disp_num = 2;
      var query_args = <?php echo json_encode($post_args_same_cat); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'get_wp_posts_map',
            'query_args' : query_args,
            'mapid'      : 'mapCats',
            'disp_num'   : disp_num, // 記事○件ずつ表示
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapCats').myLazyLoadingObj({
      callback : mapCatsDone,
    });
    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      console.log(map_post_id);
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });
  });
});
</script>