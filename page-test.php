<?php get_header(); ?>

<section class="mt-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">


<div id="map" style="width: 100%;height: 500px"></div>
<input id="MarkerCheck1" type="checkbox" name="marker-check-1" value="1">
<input id="MarkerCheck2" type="checkbox" name="marker-check-2" value="2">
<script>



jQuery(function($) {


var map;
var marker = [];
var infoWindow = [];
var markerData = [ // マーカーを立てる場所名・緯度・経度
 {
    name: '東京駅',
    lat: 35.681236,
    lng: 139.767125,
    cat: 10,
 }, {
    name: '淡路町駅',
    lat: 35.69496,
    lng: 139.76746000000003,
    cat: 10,
 }, {
    name: '御茶ノ水駅',
    lat: 35.6993529,
    lng: 139.765248,
    cat: 20,
 }, {
    name: '神保町駅',
    lat: 35.695932,
    lng: 139.757627,
    cat: 20,
 }
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
  $('#MarkerCheck1').click(function() {
    if ( $(this).prop('checked') ) {
      dispMarker(markerData, 10);
    } else {
      deleteMakers(markerData, 10);
    }
  });

  $('#MarkerCheck2').click(function() {
    if ( $(this).prop('checked') ) {
      dispMarker(markerData, 20);
    } else {
      deleteMakers(markerData, 20);
    }
  });
});

});
</script>


      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>