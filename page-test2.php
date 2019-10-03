<?php get_header(); ?>

<section class="mt-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">




<?php
$distance = 10;
// 東京タワー 座標(WGS84)　緯度: 35.658581 経度: 139.745433
// 東京駅 座標(WGS84)　緯度: 35.681236 経度: 139.767125
$lat1 = 35.658581;
$lng1 = 139.745433;

$landmark_posts  = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
$marker_data_arr = array();
$i=0;
foreach ($landmark_posts as $landmark_post) {
    $map_center = get_post_meta( $landmark_post->ID, 'acf_landmark_gmap', true );
    $map_zoom   = get_post_meta( $landmark_post->ID, 'acf_landmark_zoom', true );
    $land_cat   = get_the_terms( $landmark_post->ID, 'landmark_cateogry' );
    // 起点となる史跡と距離を比較
    
    // $dist = distance($lat1, $lng1, $map_center['lat'], $map_center['lng'], true);
    // if( $dist < $distance ) {
    //   // get markerData
    //   $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    //   $marker_data_arr[$i]['lat']  = $map_center['lat'];
    //   $marker_data_arr[$i]['lng']  = $map_center['lng'];
    //   $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    //   $i++;
    // }
    $dist = distance($lat1, $lng1, $map_center['lat'], $map_center['lng'], true);

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
  <option value="100000" data-zoom="4.0"  selected>1000km以下</option>
  <option value="50000" data-zoom="5.0">500km以下</option>
  <option value="20000" data-zoom="6.0">200km以下</option>
  <option value="10000" data-zoom="7.0">100km以下</option>
  <option value="5000" data-zoom="8.0">50km以下</option>
  <option value="2000" data-zoom="9.0">20km以下</option>
  <option value="1000" data-zoom="10.0">10km以下</option>
  <option value="500" data-zoom="11.0">5km以下</option>
</select>

<script>
jQuery(function($) {
var map;
var marker = [];
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
    var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); // 緯度経度のデータ作成
    map = new google.maps.Map(document.getElementById('map'), { // #sampleに地図を埋め込む
    center: mapLatLng, // 地図の中心を指定
    zoom: 13 // 地図のズームを指定
   });
   // dispMarker(markerData);
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
  // hiddenMakersAll( markerData, 3000 );
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
function hiddenMakersAll( markerData, dist=3000 ) {
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
  map.setZoom( zoom );
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
    var zoom = $(this).data('zoom');
    hiddenMakersAll( markerData, val );
    changeZoom(zoom);
  });
});

});
</script>





<?php
$distance = 10; // 距離 km
// 東京タワー 座標(WGS84)　緯度: 35.658581 経度: 139.745433
$lat1 = 35.681236;  // 緯度
$lng1 = 139.767125; // 経度

// 半径xxKm圏内の史跡一覧を取得
$landmark_posts  = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
$marker_data_arr = array();
$i=0;
foreach ($landmark_posts as $landmark_post) {
  $map_center = get_post_meta( $landmark_post->ID, 'acf_landmark_gmap', true );
  $map_zoom   = get_post_meta( $landmark_post->ID, 'acf_landmark_zoom', true );
  $land_cat   = get_the_terms( $landmark_post->ID, 'landmark_cateogry' );

  // 起点となる史跡と距離を比較
  $dist = distance($lat1, $lng1, $map_center['lat'], $map_center['lng'], true);
  if( $dist < $distance ) {
    // get markerData
    $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    $marker_data_arr[$i]['lat']  = $map_center['lat'];
    $marker_data_arr[$i]['lng']  = $map_center['lng'];
    $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    $i++;
  } else {

  }
}
var_dump($marker_data_arr);


?>


      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>