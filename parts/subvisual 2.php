<?php
if( is_singular('landmark') ) {
    $field_map = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
    // $jps_lat = convert_to_jgs( $map_location['lat'] );
    $lat = $field_map['lat'];
    $lng = $field_map['lng'];
} else {
    $lat = 139.76;
    $lng = 35.68;
}
?>

<div id="SubVisual" class="subvisual">
  <?php
  // 無料の地図アプリを呼び出す
  $location = array(
    'lat' => $lat,
    'lng' => $lng,
    'zoom'=>8,
  );
  echo get_openLayers_map( 'demoMap', $location, 'subvisual-inner', 'height:100%' );
  ?>
</div>