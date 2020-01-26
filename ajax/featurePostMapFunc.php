<?php
/*
 * Google Map Ajax
*/
function featurePostMapFunc(){
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
      // get main category of the landmark_cateogry post.
      $main_cat_id = '';
      $loop_catmain_id = get_post_meta( get_the_ID(), 'acf_landmark_cateogry_main', true );
      // get all taxonomy term list of 'landmark_cateogry' and set main category id
      $get_terms = get_the_terms(get_the_ID(), 'landmark_cateogry');
      if( $get_terms!='' && $loop_catmain_id!='' ) {
        foreach ($get_terms as $key => $get_term) {
          if( $get_term->term_id===(int)$loop_catmain_id ) {
            $main_cat_id = $get_term->term_id;
          }
        }
      } else {
        $main_cat_id = $get_terms[0]->term_id;
      }
      // set icon from taxonomy term ID.
      $cat_icon_id = $osfw->get_term_cfield('landmark_cateogry', $main_cat_id, 'acf_landmark_cateogry_icon');
      $cat_icon = $cat_icon_id!='' ? $osfw->get_thumbnail( $cat_icon_id, 'full' ) : '';
      $infoWin .= "</div>";
      // マーカーオブジェクトをつくる
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . get_the_ID();
      $returnObj['markerDataAjax'][$i]['name'] = get_the_title();
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = $infoWin;
      $returnObj['markerDataAjax'][$i]['cat_icon'] = isset($cat_icon['src']) ? $cat_icon['src'] : '';
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = gmap_infowindow( get_the_ID(), $mapid . "_" . get_the_ID() );
      $returnObj['tags'] .= get_tag_postlist( get_the_ID(), 'landmark_cateogry', $loop_address );
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_featurePostMapFunc', 'featurePostMapFunc' );
add_action( 'wp_ajax_nopriv_featurePostMapFunc', 'featurePostMapFunc' );