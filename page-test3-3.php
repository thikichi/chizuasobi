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

<?php
$args = array(
  'post_type' => 'course',
  'numberposts' => 10
);
$post_course = get_posts($args);
$post_course_single = $post_course[1];
$recommend_post_ids = get_post_meta( $post_course_single->ID, 'acf_course_recommend_post', true );
$recommend_post_ttl = $post_course_single->post_title;
$waypoints = '';
$origin = $destination = array();
$previous_post_id = '';


$map_tag = '';
var_dump($recommend_post_ids);
foreach ($recommend_post_ids as $recommend_post_id) {
  // 前の投稿があれば取得
  if( $previous_post_id!='' ) {
    $map_tag .= '<div class="gmap-content">' . "\n";
    $map_tag .= '<div id="map-' . $previous_post_id . '" style="width:100%;height:50vh"></div>' . "\n";
    $map_tag .= '<div id="panel-' . $previous_post_id . '" style="width:100%; height:50vh;overflow:scroll;"></div>' . "\n";
    $map_tag .= '</div>' . "\n";
  }
  $previous_post_id = $recommend_post_id;
}

?>

<section class="mt-50">
  <div class="container">
    <?php echo $map_tag; ?>
  </div>
</section>



<?php wp_footer(); ?>

<script>
// https://vintage.ne.jp/blog/2016/01/780
function dispMapAndRoot( mapID, rootID, origin, destination ) {
    // ルート検索の条件
    console.log(origin);
    var request = {
      origin: new google.maps.LatLng(origin[0],origin[1]),
      destination: new google.maps.LatLng(destination[0],destination[1]),
      travelMode: google.maps.DirectionsTravelMode.WALKING,
    };

    // マップの生成
    var map = new google.maps.Map(document.getElementById(mapID), {
        center: new google.maps.LatLng(origin[0],origin[1]), // マップの中心
        zoom: 16 // ズームレベル
    });

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
    r.setPanel(document.getElementById(rootID));
}
</script>


<script>
<?php
$previous_post_id='';
foreach ($recommend_post_ids as $recommend_post_id) {
  // 前の投稿があれば取得
  if( $previous_post_id!='' ) {
    $gmap_origin = get_post_meta( $previous_post_id, 'acf_landmark_gmap', true );
    $gmap_destination = get_post_meta( $recommend_post_id, 'acf_landmark_gmap', true );
    // 出発点
    $origin['mapID']   = 'map-' . $previous_post_id;
    $origin['panelID'] = 'panel-' . $previous_post_id;
    $origin['lat'] = $gmap_origin['lat'];
    $origin['lng'] = $gmap_origin['lng'];
    // 到着点
    $destination['lat'] = $gmap_destination['lat'];
    $destination['lng'] = $gmap_destination['lng'];
    // JS
    echo 'dispMapAndRoot( "'. $origin['mapID'] .'", "'. $origin['panelID'] .'", [' . $origin['lat'] . ',' . $origin['lng'] . '], [' . $destination['lat'] . ',' . $destination['lng'] . '] );' . "\n";
  }
  $previous_post_id = $recommend_post_id;
}
?>

// dispMapAndRoot( 'map-34', 'panel-34', [35.681382,139.766084], [35.658565,139.745532] );
// dispMapAndRoot( 'map-44', 'panel-44', [35.681382,139.766084], [35.658565,139.745532] );

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