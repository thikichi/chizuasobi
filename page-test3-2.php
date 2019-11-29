<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no,address=no,email=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="<?php bloginfo('rss2_url'); ?>" rel="alternate" type="application/rss+xml" title="RSSフィード">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<section class="mt-50">
  <div class="container">
    <div id="map" style="width:100%;height:50vh"></div>
    <div id="panel" style="width:100%; height:50vh;overflow:scroll;"></div>
  </div>
</section>


<?php


?>
<?php
$args = array(
  'post_type' => 'course',
  'numberposts' => 10
);
$post_course = get_posts($args);
$post_course_single = $post_course[0];
$recommend_post_ids = get_post_meta( $post_course_single->ID, 'acf_course_recommend_post', true );
$recommend_post_ttl = $post_course_single->post_title;
$waypoints = '';
foreach ($recommend_post_ids as $recommend_post_id) {
  $gmap_arr = get_post_meta( $recommend_post_id, 'acf_landmark_gmap', true );
  if ($recommend_post_id === reset($recommend_post_ids)) {
    // 最初
    // $origin = 'new google.maps.LatLng(' . esc_js($gmap_arr['lat']) . ',' . esc_js($gmap_arr['lng']) . ')';
    $origin = '\'' . esc_js( get_the_title($recommend_post_id) ) . '\'';
    continue;
  }
  if ($recommend_post_id === end($recommend_post_ids)) {
    // 最後
    // $destination = 'new google.maps.LatLng(' . esc_js($gmap_arr['lat']) . ',' . esc_js($gmap_arr['lng']) . ')';
    $destination = '\'' . esc_js( get_the_title($recommend_post_id) ) . '\'';
    continue;
  }
  // $waypoints .= '{ location: new google.maps.LatLng(' . esc_js($gmap_arr['lat']) . ',' . esc_js($gmap_arr['lng']) . ') },';
  $waypoints .= '{ location: "' . esc_js( get_the_title($recommend_post_id) ) . '" },';
}
?>





<?php wp_footer(); ?>

<script>
// https://vintage.ne.jp/blog/2016/01/780
function initMap() {
    // ルート検索の条件
    var request = {
        origin: <?php echo $origin; ?>, // 出発地
        destination: <?php echo $destination; ?>, // 目的地
        waypoints: [
        // 経由地点(指定なしでも可)
          <?php echo $waypoints; ?>
          // { location: new google.maps.LatLng(35.630152,139.74044) },
          // { location: new google.maps.LatLng(35.507456,139.617585) },
          // { location: new google.maps.LatLng(35.25642,139.154904) },
          // { location: new google.maps.LatLng(35.103217,139.07776) },
          // { location: new google.maps.LatLng(35.127152,138.910627) },
          // { location: new google.maps.LatLng(35.142365,138.663199) },
          // { location: new google.maps.LatLng(34.97171,138.38884) },
          // { location: new google.maps.LatLng(34.769758,138.014928) },
        ],
        travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
    };

    // マップの生成
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(35.681382,139.766084), // マップの中心
        zoom: 14 // ズームレベル
    });


// ルート検索のデフォのとは違ういつものマーカーを配置
// var marker = [];
// var infoWindow = [];
// for (var i = 0; i < request.waypoints.length; i++) {
//   markerLatLng = request.waypoints[i].location; // 緯度経度のデータ作成
//   marker[i] = new google.maps.Marker({
//     position: markerLatLng,
//     map: map
//   });
//   infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
//      content: '<div class="sample">Point Of Name</div>' // 吹き出しに表示する内容
//    });
//   markerEvent(i);
// }
// // マーカーにクリックイベントを追加
// function markerEvent(i) {
//     marker[i].addListener('click', function() {
//       infoWindow[i].open(map, marker[i]);
//   });
// }


    var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
    var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
        map: map, // 描画先の地図
        preserveViewport: true, // 描画後に中心点をずらさない
        suppressMarkers: false, // trueでマーカーを表示しない
        polylineOptions: {
            strokeColor: '#ff0000',
            strokeOpacity: 0.5,
            strokeWeight: 3
        }
    });
    // ルート検索
    d.route(request, function(result, status){
        // OKの場合ルート描画
        if (status == google.maps.DirectionsStatus.OK) {
            r.setDirections(result);
        }
    });
    r.setPanel(document.getElementById('panel'));
}
initMap();
</script>




<?php

// https://qiita.com/kngsym2018/items/15f19a88ea37c1cd3646


// $base_url = 'https://maps.googleapis.com/maps/api/directions/json?origin=Adelaide,SA&destination=Adelaide,SA&waypoints=optimize:true|Barossa+Valley,SA|Clare,SA|Connawarra,SA|McLaren+Vale,SA&key=AIzaSyBjYTWYNKXOkeVC6fofHCDHEJVhiTIVTIE';
// $tag = 'PHP';
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $base_url);
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
// /*
// 一括で指定することもできる
// $option = [
//     CURLOPT_URL => $base_url.'/api/v2/tags/'.$tag.'/items',
//     CURLOPT_CUSTOMREQUEST => 'GET',
//     CURLOPT_SSL_VERIFYPEER => false,
// ];
// curl_setopt_array($curl, $option);
// */
// $response = curl_exec($curl);
// $result = json_decode($response, true);
// curl_close($curl);

// var_dump($result);
?>



</body>
</html>