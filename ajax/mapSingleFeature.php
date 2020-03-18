<?php
/*
 * Google Map Ajax
*/
function mapSingleFeatureFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $select_id = $_POST['select_id'];
  $marker_size = $_POST['marker_size'];
  $page_in_link = $_POST['page_in_link'];
  // get posts
  $select_posts = get_post_meta( $select_id, 'acf_feature_posts', true );


ob_start();
var_dump( $page_in_link );
$out = ob_get_contents();
ob_end_clean();
file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);


  $args = array(
    'post_type' => 'landmark',
    'post__in' => $select_posts,
    'posts_per_page' => -1
  );
  $the_query = new WP_Query( $args );
  if ($the_query->have_posts()) {
    $i=0;
    while($the_query->have_posts()) {
      $the_query->the_post();

      $loop_gmap = get_post_meta( get_the_ID(), 'acf_landmark_gmap', true );
      $loop_address = get_post_meta( get_the_ID(), 'acf_landmark_address', true );

      // eyecatch image
      $thumb_id = get_post_thumbnail_id(); 
      $temp_img = wp_get_attachment_image_src( $thumb_id, 'img_square_w100' );


      if( $temp_img ) {
        $img_url = $temp_img[0];
      } else {
        $img_url   = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
      }
      // marker size
      if( $marker_size==='img_marker_large' ) {
        $set_marker_size = 'img_marker_large';
      } else if( $marker_size==='img_marker_middle' ) {
        $set_marker_size = 'img_marker_middle';
      } else if( $marker_size==='img_marker_small' ) {
        $set_marker_size = 'img_marker_small';
      } else {
        $set_marker_size = 'full';
      }
      // marker image
      $loop_marker_id = get_post_meta( get_the_ID(), 'acf_landmark_gmap_marker', true );
      if( $loop_marker_id ) {
        $temp_marker = $osfw->get_thumbnail( $loop_marker_id, $set_marker_size );
        $marker = $temp_marker['src'];
      } else {
        $marker = get_stylesheet_directory_uri() . '/images/common/icon-marker-noimage.png';
      }

      // 一覧
      $tag .= '<li class="block4__mapside-list-item">';
      $tag .= '<div class="block4__mapside-link">';
      $tag .= '<div class="block4__box">';
      $tag .= '<div class="block4__box-sub">';
      $tag .= '<img src="' . esc_url($img_url) . '">';
      $tag .= '</div>';
      $tag .= '<div class="block4__box-main">';
      $tag .= '<div class="block4__box-mainTable">';
      $tag .= '<div class="block4__box-mainTableCell">';
      $tag .= '<h4 class="block4__box-subttl">' . get_the_title() . '</h4>';
      if( $page_in_link==='1' ) {
        $tag .= '<div>[ <a class="block4__box-link" href="javascript:mapSingleFeatureClick(\'' . $mapid . '_' . $i . '\')">地図</a> ][ <a class="block4__box-link" href="#Landmark_' . get_the_ID() . '">詳細</a> ]</div>';
      } else if( $page_in_link==='0' ) {
        $tag .= '<div>[ <a class="block4__box-link" href="javascript:mapSingleFeatureClick(\'' . $mapid . '_' . $i . '\')">地図</a> ][ <a class="block4__box-link" href="' . get_the_permalink() . '">詳細ページ</a> ]</div>';
      }
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</li>';

      // マーカーオブジェクトをつくる
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . $i;
      $returnObj['markerDataAjax'][$i]['name'] = $place['title'];
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = mapRelationSideText( get_the_title(), $thumb_id, get_the_content() );
      // $returnObj['tags'] .= get_tag_postlist( get_the_ID(), 'landmark_cateogry', $loop_address );
      $i++;
    }
    $returnObj['tags'] = $tag;
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapSingleFeatureFunc', 'mapSingleFeatureFunc' );
add_action( 'wp_ajax_nopriv_mapSingleFeatureFunc', 'mapSingleFeatureFunc' );