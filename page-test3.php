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

    <div id="map" style="width:100%;height: 500px"></div>

  </div>
</section>

  <?php wp_footer(); ?>

<script>
function initMap() {
    // ルート検索の条件
    var request = {
        origin: new google.maps.LatLng(35.681382,139.766084), // 出発地
        destination: new google.maps.LatLng(34.73348,135.500109), // 目的地
        waypoints: [
        // 経由地点(指定なしでも可)
          { location: new google.maps.LatLng(35.630152,139.74044) },
          { location: new google.maps.LatLng(35.507456,139.617585) },
          { location: new google.maps.LatLng(35.25642,139.154904) },
          { location: new google.maps.LatLng(35.103217,139.07776) },
          { location: new google.maps.LatLng(35.127152,138.910627) },
          { location: new google.maps.LatLng(35.142365,138.663199) },
          { location: new google.maps.LatLng(34.97171,138.38884) },
          { location: new google.maps.LatLng(34.769758,138.014928) },
        ],
        travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
    };

    // マップの生成
    var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(35.681382,139.766084), // マップの中心
        zoom: 7 // ズームレベル
    });


// ルート検索のデフォのとは違ういつものマーカーを配置
var marker = [];
var infoWindow = [];
for (var i = 0; i < request.waypoints.length; i++) {
  markerLatLng = request.waypoints[i].location; // 緯度経度のデータ作成
  marker[i] = new google.maps.Marker({
    position: markerLatLng,
    map: map
  });
  infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
     content: '<div class="sample">Point Of Name</div>' // 吹き出しに表示する内容
   });
  markerEvent(i);
}

// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() {
      infoWindow[i].open(map, marker[i]);
  });
}

// var directions = new GDirections(map, document.getElementById('map'));

    // https://maps.multisoup.co.jp/blog/2931/
    var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
    var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
        map: map, // 描画先の地図
        preserveViewport: true, // 描画後に中心点をずらさない
        suppressMarkers: true, // trueでマーカーを表示しない
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
}
initMap();
</script>




<?php
$base_url = 'https://maps.googleapis.com/maps/api/directions/json?origin=Adelaide,SA&destination=Adelaide,SA&waypoints=optimize:true|Barossa+Valley,SA|Clare,SA|Connawarra,SA|McLaren+Vale,SA&key=AIzaSyBjYTWYNKXOkeVC6fofHCDHEJVhiTIVTIE';
$tag = 'PHP';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $base_url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
/*
一括で指定することもできる
$option = [
    CURLOPT_URL => $base_url.'/api/v2/tags/'.$tag.'/items',
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_SSL_VERIFYPEER => false,
];
curl_setopt_array($curl, $option);
*/
$response = curl_exec($curl);
$result = json_decode($response, true);
curl_close($curl);

var_dump($result);
?>



</body>
</html>