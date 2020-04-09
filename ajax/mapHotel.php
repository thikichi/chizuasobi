<?php
/*
 * Google Map Ajax
*/
function mapHotelFunc(){
  global $osfw;
  $returnObj  = array();
  $mapid     = $_POST['mapid'];
  $marker_size = $_POST['marker_size'];
  $post_id = $_POST['post_id'];

  $acf_landmark_gmap = get_post_meta( $post_id, 'acf_landmark_gmap', true );
  $lat_main = $acf_landmark_gmap['lat']; // 経度
  $lng_main = $acf_landmark_gmap['lng']; // 緯度
  $jx = ceil(($lng_main * 1.000106961 - $lat_main * 0.000017467 - 0.004602017) * 3600000);
  $jy = ceil(($lat_main * 1.000083049 + $lng_main * 0.000046047 - 0.010041046) * 3600000);
  $url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&x=" . $jx . "&y=" . $jy . "&range=50";
  $xml = @simplexml_load_file($url);
  // 中心の史跡の座標
  $returnObj['mapcenter']['lat'] = $lat_main;
  $returnObj['mapcenter']['lng'] = $lng_main;
  // マーカー画像
  $img_url = get_landmark_thumbnail( $post_id );
  $title   = esc_html(get_the_title( $post_id ));
  $address = esc_html(get_post_meta( $post_id, 'acf_landmark_address', true ));
  $link    = esc_url(get_the_permalink( $post_id ));
  // marker image
  $marker_id = get_post_meta( $post_id, 'acf_landmark_gmap_marker', true );
  if( $marker_id ) {
    $temp_marker = $osfw->get_thumbnail( $marker_id, 'full' );
    $marker_main = $temp_marker['src'];
  } else {
    $marker_main = get_stylesheet_directory_uri() . '/images/common/icon-marker-noimage.png';
  }

  // 中心のマーカーオブジェクト
  $returnObj['markerDataAjax'][0]['id']   = $mapid . "_" . 0;
  $returnObj['markerDataAjax'][0]['name'] = get_the_title( $post_id );
  $returnObj['markerDataAjax'][0]['lat']  = $lat_main;
  $returnObj['markerDataAjax'][0]['lng']  = $lng_main;
  $returnObj['markerDataAjax'][0]['cat_icon'] = $marker_main;
  $returnObj['markerDataAjax'][0]['infoWindowContent'] = get_infowindow_tag($mapid, $img_url, $title, $address, $link );

  $i=1;
  $tag = '';
  foreach ($xml->Hotel as $hotel) {
    // 日本測地系から世界測地系の緯度・経度に変更
    $rdata = change_geodetic_system_from_jp_to_wd( $hotel->Y, $hotel->X );
    $lat = $rdata['lat'];
    $lng = $rdata['lng'];
    // photo
    $img_url = $hotel->PictureURL;
    $args = array(
      'title'     => $hotel->HotelName,
      'image'     => esc_url($img_url),
      'text'      => $hotel->HotelCaption,
      'link_map'  => 'javascript:mapHotelClick(\'' . $mapid . '_' . $i . '\')',
      'link_main' => $hotel->HotelDetailURL,
      'id'        => '#mapHotel_' . $i,
      'link_text' => 'ホテルの詳細へ',
    );
    $tag .= slider_tags( $args );

    // マーカーオブジェクトをつくる
    $returnObj['markerDataAjax'][$i]['id']   = $mapid . "_" . $i;
    $returnObj['markerDataAjax'][$i]['name'] = $hotel->HotelName;
    $returnObj['markerDataAjax'][$i]['lat']  = $lat;
    $returnObj['markerDataAjax'][$i]['lng']  = $lng;
    $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker['src'];
    $returnObj['markerDataAjax'][$i]['infoWindowContent'] = get_infowindow_tag($mapid, $hotel->PictureURL, $hotel->HotelName, $hotel->HotelAddress, $hotel->HotelDetailURL, true );
    $i++;
  }
  $returnObj['tags'] = $tag;

  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapHotelFunc', 'mapHotelFunc' );
add_action( 'wp_ajax_nopriv_mapHotelFunc', 'mapHotelFunc' );