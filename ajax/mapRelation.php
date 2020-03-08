<?php
/*
 * Google Map Ajax
*/
function mapRelationFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $place_arr = $_POST['place_arr'];



  // ob_start();
  // var_dump( $query_args );
  // $out = ob_get_contents();
  // ob_end_clean();
  // file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);

  if ( $place_arr!='' ) {
    $i=0;
    $tag  = '';
    foreach ($place_arr as $place) {
      // photo
      if( $place['photo']!='' ) {
        $temp_img = wp_get_attachment_image_src( $place['photo'] , 'img_square_w100' );
        $img_url = $temp_img[0];
      } else {
        $img_url   = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
      }

      $marker = $osfw->get_thumbnail( $place['marker'], 'full', get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );


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