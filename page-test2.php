<?php get_header(); ?>

<section class="mt-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">




<?php
/* 初期値 */
$distance = 10;
// 東京タワー 座標(WGS84)　緯度: 35.658581 経度: 139.745433
$lat_init = 35.658581;
$lng_init = 139.745433;

$landmark_posts  = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
$marker_data_arr = array();
$i=0;
foreach ($landmark_posts as $landmark_post) {
    $map_center = get_post_meta( $landmark_post->ID, 'acf_landmark_gmap', true );
    $map_zoom   = get_post_meta( $landmark_post->ID, 'acf_landmark_zoom', true );
    $land_cat   = get_the_terms( $landmark_post->ID, 'landmark_cateogry' );
    // 起点となる史跡と距離を比較
    
    // $dist = distance($lat_init, $lng_init, $map_center['lat'], $map_center['lng'], true);
    // if( $dist < $distance ) {
    //   // get markerData
    //   $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    //   $marker_data_arr[$i]['lat']  = $map_center['lat'];
    //   $marker_data_arr[$i]['lng']  = $map_center['lng'];
    //   $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    //   $i++;
    // }
    $dist = distance($lat_init, $lng_init, $map_center['lat'], $map_center['lng'], true);

    // get markerData
    $marker_data_arr[$i]['id']   = $landmark_post->ID;
    $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    $marker_data_arr[$i]['lat']  = $map_center['lat'];
    $marker_data_arr[$i]['lng']  = $map_center['lng'];
    $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    $marker_data_arr[$i]['dist'] = floor($dist);
    $i++;
}


?>

<div id="map" style="width: 100%;height: 500px"></div>

<?php
$all_land_cats = get_terms( array( 'taxonomy'=>'landmark_cateogry', 'get'=>'all' ) );
foreach ($all_land_cats as $all_land_cat): ?>
  <input class="marker-check" data-termid="<?php echo esc_attr($all_land_cat->term_id); ?>" type="checkbox" value="<?php echo esc_attr($all_land_cat->term_id); ?>">
  <?php echo esc_html($all_land_cat->name); ?>
<?php endforeach; ?>
<select id="MarkerSelectDist">
  <option value="1000000" data-zoom="5.0">1000km以下</option>
  <option value="900000" data-zoom="5.0">900km以下</option>
  <option value="800000" data-zoom="6.0">800km以下</option>
  <option value="700000" data-zoom="6.0">700km以下</option>
  <option value="600000" data-zoom="6.0">600km以下</option>
  <option value="500000" data-zoom="6.0">500km以下</option>
  <option value="400000" data-zoom="7.0">400km以下</option>
  <option value="300000" data-zoom="7.0">300km以下</option>
  <option value="200000" data-zoom="8.0">200km以下</option>
  <option value="100000" data-zoom="9.0">100km以下</option>
  <option value="50000" data-zoom="10.0">50km以下</option>
  <option value="20000" data-zoom="11.0">20km以下</option>
  <option value="10000" data-zoom="12.0">10km以下</option>
  <option value="5000" data-zoom="13.0" selected>5km以下</option>
  <option value="2500" data-zoom="14.0">2.5km以下</option>
  <option value="1000" data-zoom="15.0">1.0km以下</option>
</select>

<script>
jQuery(function($) {
var map;
var marker = [];
var mapLatLng;
var circleObj;
var currentDist = 5000;
var infoWindow = [];
var markerData = [ // マーカーを立てる場所名・緯度・経度
<?php foreach ($marker_data_arr as $marker_data): ?>
 {
    id:   <?php echo esc_js($marker_data['id']); ?>,
    name: '<?php echo esc_js($marker_data['name']); ?>',
    lat:  <?php echo esc_js($marker_data['lat']); ?>,
    lng:  <?php echo esc_js($marker_data['lng']); ?>,
    cat:  <?php echo esc_js($marker_data['cat']); ?>,
    dist: <?php echo esc_js($marker_data['dist']); ?>,
 },
<?php endforeach; ?>
];
  
function initMap() {
 // 地図の作成
    mapLatLng = new google.maps.LatLng({lat: <?php echo $lat_init; ?>, lng: <?php echo $lng_init; ?>}); // 緯度経度のデータ作成
    map = new google.maps.Map(document.getElementById('map'), { // #sampleに地図を埋め込む
    center: mapLatLng, // 地図の中心を指定
    zoom: 13 // 地図のズームを指定
   });
   // dispMarker(markerData);
   paintCircleMap( mapLatLng, currentDist );
}
  
// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
  });
}

// マーカー毎の処理
function dispMarker(markerData, catNum) {
  for (var i = 0; i < markerData.length; i++) {
      if( markerData[i]['cat']===catNum ) {
        markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
        marker[i] = new google.maps.Marker({ // マーカーの追加
         position: markerLatLng, // マーカーを立てる位置を指定
         animation: google.maps.Animation.DROP,
            map: map // マーカーを立てる地図を指定
       });
       infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
           content: '<div class="map">' + markerData[i]['name'] + '</div>' // 吹き出しに表示する内容
       });
       markerEvent(i); // マーカーにクリックイベントを追加
     } 
  }
  hiddenMakersAll( markerData, currentDist );
}

//マーカーを削除する
function deleteMakers(markerData, catNum) {
  for (var i = 0; i < markerData.length; i++) {
    if( markerData[i]['cat']===catNum) {
      marker[i].setMap(null);
    }
  }
}

// マーカーを隠す
function hiddenMakersAll( markerData, dist=currentDist ) {
  $.each(marker, function(index, val) {
    if(marker[index]) {
      if( markerData[index]['dist'] < dist) {
        marker[index].setVisible(true);
      } else {
        marker[index].setVisible(false);
      }
    }
  });
}

// ズームレベルを変更する
function changeZoom( zoom=map.getZoom() ) {
  map.setZoom( parseInt(zoom) );
}

// 半径の表示円を描画
function paintCircleMap( myLatLng, dist=currentDist ) {
  circleObj = new google.maps.Circle({
    center: myLatLng,       // 中心点(google.maps.LatLng)
    fillColor: '#ff0000',   // 塗りつぶし色
    fillOpacity: 0.1,       // 塗りつぶし透過度（0: 透明 ⇔ 1:不透明）
    map: map,             // 表示させる地図（google.maps.Map）
    radius: parseInt(dist),          // 半径（ｍ）
    strokeColor: '#ff0000', // 外周色 
    strokeOpacity: 0.5,       // 外周透過度（0: 透明 ⇔ 1:不透明）
    strokeWeight: 1         // 外周太さ（ピクセル）
  });
}
// 半径の表示円を削除
function dalatePaintCircleMap( circleObj ) {
  circleObj.setMap(null);
}

initMap();

$(function() {
  $('.marker-check').click(function() {
    var termid = $(this).data('termid');
    if ( $(this).prop('checked') ) {
      dispMarker(markerData, termid);
    } else {
      deleteMakers(markerData, termid);
    }
  });

  $('#MarkerSelectDist').change(function() {
    //選択したvalue値を変数に格納
    var val = $(this).val();
    currentDist = val;
    // var zoom = $(this).data('zoom');
    var zoom = $(this).find('option:selected').data('zoom');
    hiddenMakersAll( markerData, currentDist );
    changeZoom(zoom);
    dalatePaintCircleMap(circleObj);
    paintCircleMap( mapLatLng, currentDist );
  });
});

});
</script>








      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>