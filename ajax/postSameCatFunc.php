<?php
/*
 * Google Map Ajax
*/
function postSameCatFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $disp_num   = $_POST['disp_num']; // 表示させたい記事件数
  $query_args = $_POST['query_args'];


// ob_start();
// var_dump( $query_args );
// $out = ob_get_contents();
// ob_end_clean();
// file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);


  $the_query = new WP_Query( $query_args );
  if ($the_query->have_posts()) {
    $i=0;
    while($the_query->have_posts()) {
      $the_query->the_post();
      $loop_gmap = get_post_meta( get_the_ID(), 'acf_landmark_gmap', true );
      $loop_address = get_post_meta( get_the_ID(), 'acf_landmark_address', true );

      $terms = get_the_terms(get_the_ID(), 'landmark_cateogry');
      if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
        $term_list = '[';
        foreach ( $terms as $term ) {
          $term_list .= "'" . $term->term_id . "'";
          if ($term !== end($terms)) {
            $term_list .= ',';
          }
        }
        $term_list .= ']';
      }
      // thumbnail
      $temp_img = $osfw->get_thumbnail_by_post( get_the_ID(), 'img_square' );
      $post_map_img = $temp_img['src'] ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
      // InfoWindow
      $infoWin  = '';
      $infoWin .= "<div id='" . $mapid . "_" . get_the_ID() . "' class='infwin cf' style='position:relative'>";
      $infoWin .= "<a style='position:absolute;top:-150px'></a>";
      $infoWin .= "<div class='infwin-thumb'>";
      $infoWin .= "<img class='img-responsive' src='" . $post_map_img . "'></div>";
      $infoWin .= "<div class='infwin-main'>";
      $infoWin .= "<h3>" . get_the_title() . "</h3>";
      $infoWin .= "<p>" . $loop_address . "</p>";
      $infoWin .= "<p class='infwin-link'><a href='" . get_the_permalink() . "'>この記事を見る</a></p>";
      $infoWin .= "</div>";
      $infoWin .= "</div>";
      // マーカーオブジェクトをつくる
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . get_the_ID();
      $returnObj['markerDataAjax'][$i]['name'] = get_the_title();
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = $infoWin;
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_postSameCatFunc', 'postSameCatFunc' );
add_action( 'wp_ajax_nopriv_postSameCatFunc', 'postSameCatFunc' );