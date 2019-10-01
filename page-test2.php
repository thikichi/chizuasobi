<?php get_header(); ?>

<section class="mt-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">




<?php
$landmark_posts  = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
$marker_data_arr = array();
$i=0;
foreach ($landmark_posts as $landmark_post) {
    $map_center = get_post_meta( $landmark_post->ID, 'acf_landmark_gmap', true );
    $map_zoom   = get_post_meta( $landmark_post->ID, 'acf_landmark_zoom', true );
    $land_cat   = get_the_terms( $landmark_post->ID, 'landmark_cateogry' );
    // get markerData
    $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    $marker_data_arr[$i]['lat']  = $map_center['lat'];
    $marker_data_arr[$i]['lng']  = $map_center['lng'];
    $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    $i++;
}
// var_dump($marker_data_arr);
?>

<div id="map" style="width: 100%;height: 500px"></div>

<?php
$all_land_cats = get_terms( array( 'taxonomy'=>'landmark_cateogry', 'get'=>'all' ) );
foreach ($all_land_cats as $all_land_cat): ?>
  <input id="MarkerCheck-<?php echo esc_attr($all_land_cat->term_id); ?>" type="checkbox" name="marker-check-1" value="<?php echo esc_attr($all_land_cat->term_id); ?>">
  <?php echo esc_html($all_land_cat->name); ?>
<?php endforeach; ?>


<script>
jQuery(function($) {
var map;
var marker = [];
var infoWindow = [];
var markerData = [ // マーカーを立てる場所名・緯度・経度
<?php foreach ($marker_data_arr as $marker_data): ?>
 {
    name: '<?php echo esc_js($marker_data['name']); ?>',
    lat: <?php echo esc_js($marker_data['lat']); ?>,
    lng: <?php echo esc_js($marker_data['lng']); ?>,
    cat: <?php echo esc_js($marker_data['cat']); ?>,
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
}

//マーカーを削除する
function deleteMakers(markerData, catNum) {
  for (var i = 0; i < markerData.length; i++) {
    if( markerData[i]['cat']===catNum ) {
      marker[i].setMap(null);
    }
  }
}

initMap();

$(function() {
  <?php foreach ($all_land_cats as $all_land_cat): ?>
    $('#MarkerCheck-<?php echo esc_attr($all_land_cat->term_id); ?>').click(function() {
      if ( $(this).prop('checked') ) {
        dispMarker(markerData, <?php echo esc_attr($all_land_cat->term_id); ?>);
      } else {
        deleteMakers(markerData, <?php echo esc_attr($all_land_cat->term_id); ?>);
      }
    });
  <?php endforeach; ?>
});

});
</script>





<?php
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
  if( $dist < 10 ) {
    // get markerData
    $marker_data_arr[$i]['name'] = $landmark_post->post_title;
    $marker_data_arr[$i]['lat']  = $map_center['lat'];
    $marker_data_arr[$i]['lng']  = $map_center['lng'];
    $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
    $i++;
  }
}
var_dump($marker_data_arr);

?>


      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>