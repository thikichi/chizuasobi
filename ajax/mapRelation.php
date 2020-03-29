<?php
/*
 * Google Map Ajax
*/
function mapRelationFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $place_arr = $_POST['place_arr'];
  $marker_size = $_POST['marker_size'];
  if ( $place_arr!='' ) {
    $i=0;
    $tag  = '';
    foreach ($place_arr as $place) {
      // photo
      if( $place['photo']!='' ) {
        $temp_img = wp_get_attachment_image_src( $place['photo'] , 'img_square_w100' );
        if ($_SERVER['HTTPS']) {
          $img_url = preg_replace( "/^http:/", "https:", $temp_img[0] );
        } else {
          $img_url = $temp_img[0];
        }
      } else {
        $img_url = '';
      }
      if( $marker_size==='img_marker_large' ) {
        $set_marker_size = 'img_marker_large';
      } else if( $marker_size==='img_marker_middle' ) {
        $set_marker_size = 'img_marker_middle';
      } else if( $marker_size==='img_marker_small' ) {
        $set_marker_size = 'img_marker_small';
      } else {
        $set_marker_size = 'full';
      }
      $marker = $osfw->get_thumbnail( $place['marker'], $set_marker_size, get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
      // 一覧
      $tag .= '<li class="block4__mapside-list-item">';
      $tag .= '<div class="block4__mapside-link">';
      $tag .= '<div class="block4__box">';
      if( $img_url ) {
        $tag .= '<div class="block4__box-sub">';
        $tag .= '<img src="' . esc_url($img_url) . '">';
        $tag .= '</div>';
        $style = '';
      } else {
        $style = ' style="width:100%;padding:0 15px"';
      }
      $tag .= '<div class="block4__box-main"' . $style . '>';
      $tag .= '<div class="block4__box-mainTable">';
      $tag .= '<div class="block4__box-mainTableCell">';
      $tag .= '<h4 class="block4__box-subttl">' . $place['title'] . '</h4>';
      $tag .= '<div>[ <a class="block4__box-link" href="javascript:mapRelationClick(\'' . $mapid . '_' . $i . '\')">地図</a> ][ <a class="block4__box-link" href="#mapRelationArticle_' . $i . '">詳細</a> ]</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</div>';
      $tag .= '</li>';

      // マーカーオブジェクトをつくる
      $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . $i;
      $returnObj['markerDataAjax'][$i]['name'] = $place['title'];
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($place['map']['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($place['map']['lng']);
      $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker['src'];
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = mapRelationSideText( $place['title'], $place['photo'], $place['textarea'], $place['quote'] );
      $i++;
    }
    $returnObj['tags'] = $tag;
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapRelationFunc', 'mapRelationFunc' );
add_action( 'wp_ajax_nopriv_mapRelationFunc', 'mapRelationFunc' );