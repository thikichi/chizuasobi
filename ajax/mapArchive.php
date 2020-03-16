<?php
/*
 * Google Map Ajax
*/
function mapArchiveFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $marker_size = $_POST['marker_size'];
  $query_args = $_POST['query_args'];

  $the_query = new WP_Query( $query_args );
  if ($the_query->have_posts()) {
    $i=0;
    while($the_query->have_posts()) {
      $the_query->the_post();
      $loop_gmap = get_post_meta( get_the_id(), 'acf_landmark_gmap', true );
      $loop_address = get_post_meta( get_the_id(), 'acf_landmark_address', true );
      // marker image
      $marker_id = get_post_meta( get_the_ID(), 'acf_landmark_gmap_marker', true );
      if( $marker_size==='img_marker_large' ) {
        $set_marker_size = 'img_marker_large';
      } else if( $marker_size==='img_marker_middle' ) {
        $set_marker_size = 'img_marker_middle';
      } else if( $marker_size==='img_marker_small' ) {
        $set_marker_size = 'img_marker_small';
      } else {
        $set_marker_size = 'full';
      }
      $temp_marker = $osfw->get_thumbnail( $marker_id, $set_marker_size, get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
      $marker = $temp_marker['src'];
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . get_the_id();
      $returnObj['markerDataAjax'][$i]['name'] = get_the_title();
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
      $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = gmap_infowindow( get_the_id(), $mapid . "_" . get_the_id() );
      // $returnObj['tags'] .= get_tag_postlist( get_the_id(), 'landmark_cateogry', $loop_address );
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapArchiveFunc', 'mapArchiveFunc' );
add_action( 'wp_ajax_nopriv_mapArchiveFunc', 'mapArchiveFunc' );