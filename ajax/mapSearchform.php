<?php
/*
 * Google Map Ajax
*/
function mapSearchformFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $disp_num   = $_POST['disp_num']; // 表示させたい記事件数
  $query_args = $_POST['query_args'];
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

      // marker image
      $loop_marker_id = get_post_meta( get_the_ID(), 'acf_landmark_gmap_marker', true );
      if( $loop_marker_id ) {
        $temp_marker = $osfw->get_thumbnail( $loop_marker_id, 'full' );
        $marker = $temp_marker['src'];
      } else {
        $marker = get_stylesheet_directory_uri() . '/images/common/icon-marker-noimage.png';
      }
      
      // set icon from taxonomy term ID.
      $cat_icon_id = $osfw->get_term_cfield('landmark_cateogry', $main_cat_id, 'acf_landmark_cateogry_icon');
      $cat_icon = $cat_icon_id!='' ? $osfw->get_thumbnail( $cat_icon_id, 'full' ) : '';
      // マーカーオブジェクトをつくる
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . get_the_ID();
      $returnObj['markerDataAjax'][$i]['name'] = get_the_title();
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
      $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = gmap_infowindow( get_the_ID(), $mapid . "_" . get_the_ID() );
      $returnObj['tags'] .= get_tag_postlist( get_the_ID(), 'landmark_cateogry', $loop_address );
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapSearchformFunc', 'mapSearchformFunc' );
add_action( 'wp_ajax_nopriv_mapSearchformFunc', 'mapSearchformFunc' );