jQuery(function($) {

  /* コンポーネント以外の自作スクリプトはこの中へ記述します */
  /*============================================================*/

  $('.toggleSlide-nextElem').on('click', function(event) {
    // event.preventDefault();
    $(this).toggleClass('__avtive');
    $(this).siblings('ul').slideToggle('fast');
  });


  $(window).on('load scroll', function() {
    $('[data-bgsize]').each(function(index, el) {
      var thisWidth  = $(this).width();
      switch( $(this).data('bgsize') ) {
        // 黄金比
        case 'goldenRatio' :
        var thisHeight = thisWidth / 1.6;
        break;
        // 黄金比　縦
        case 'goldenRatioV' :
        var thisHeight = thisWidth * 1.6;
        break;
        // ３：４
        case 'commonRatio' :
        var thisHeight = thisWidth * 0.75;
        break;
        // ３：４　縦
        case 'commonRatioV' :
        var thisHeight = thisWidth / 0.75;
        break;
        // square
        case 'square' :
        var thisHeight = thisWidth * 1;
        break;
      }
      $(this).height(thisHeight);
    });
  });

  // TAB切り替わりの部分
  $('.tab-switch').each(function(index, el) {
    var thisTab = $(this);
    thisTab.find('.tab-switch-nav').on('click', function(event) {
      event.preventDefault();
      /* Act on the event */
      $(this).addClass('_active');
      $(this).siblings('.tab-switch-nav').removeClass('_active');
      // content switch
      thisTab.find('.tab-switch-content').removeClass('_active');
      var thisIndex = $(this).index();
      thisTab.find('.tab-switch-content').eq(thisIndex).addClass('_active');
    });
  });

  // pc sp 要素移動
  $(window).on('load resize', function() {
    var winWidth = $(window).width();
    if (winWidth < 768) {
      $('.spmoveto').each(function(index, el) {
        var moveToObj = $(this).data('spmoveto');
        $('#' + moveToObj).append( $(this).children() );
      });
    } else {
      $('.pcmoveto').each(function(index, el) {
        var moveToObj = $(this).data('pcmoveto');
        $('#' + moveToObj).append( $(this).children() );
      });
    }
  });

});

/* コンポーネント付随のスクリプトはこの下へ記述します */
/*============================================================*/

var cWinFunc = function() {
  var cInfoWin = '';
  function getCWin(win) {
    cInfoWin = win;
  }
  return cInfoWin;
}

//マーカーを削除する
function deleteMakers(markerData, offset=0, marker) {
  for (var i = offset; i < markerData.length; i++) {
    if(marker[i]) marker[i].setMap(null);
  }
}

// マーカーにクリックイベントを追加
function markerEvent(i, marker, infoWindow, map) {
    marker[i].addListener('click', function() { // マーカーをクリックしたとき
      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
  });
}

var currentWin = '';
function markerEvent2(marker, infoWindow, map) {
  marker.addListener('click', function() {
    if(currentWin) currentWin.close();
    infoWindow.open(map, marker); // 吹き出しの表示ß
    currentWin = infoWindow;
  });
}








// ズームレベルを変更する
function changeZoom( zoom, map ) {
  map.setZoom( parseInt(zoom) );
}

// 半径の表示円を描画
function paintCircleMap( map, mapLatLng, currentDist ) {
  circleObj = new google.maps.Circle({
    center: mapLatLng,       // 中心点(google.maps.LatLng)
    fillColor: '#ff0000',   // 塗りつぶし色
    fillOpacity: 0.1,       // 塗りつぶし透過度（0: 透明 ⇔ 1:不透明）
    map: map,             // 表示させる地図（google.maps.Map）
    radius: parseInt(currentDist),          // 半径（ｍ）
    strokeColor: '#ff0000', // 外周色 
    strokeOpacity: 0.5,       // 外周透過度（0: 透明 ⇔ 1:不透明）
    strokeWeight: 1         // 外周太さ（ピクセル）
  });
  return circleObj;
}
// 半径の表示円を削除
function dalatePaintCircleMap( circleObj ) {
  circleObj.setMap(null);
}

function initMapDist( mapID, mapLatLng, centerMap, zoomLevel ) {
  // mapLatLng = new google.maps.LatLng({lat: centerMap['lat'], lng: centerMap['lng']}); // 緯度経度のデータ作成
  map = new google.maps.Map(document.getElementById(mapID), { // #sampleに地図を埋め込む
    center: mapLatLng, // 地図の中心を指定
    zoom: zoomLevel // 地図のズームを指定
  });
  return map;
}

function initMap( mapID, mapLatLng, zoomLevel ) {
  map = new google.maps.Map(document.getElementById(mapID), { // #sampleに地図を埋め込む
    center: mapLatLng, // 地図の中心を指定
    zoom: zoomLevel, // 地図のズームを指定
    styles: [
  {
    "featureType": "road.local",
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "on"
      }
    ]
  }
]
  });
  return map;
}


function getCenerLatLng( lat, lng ) {
  mapLatLng = new google.maps.LatLng({lat: lat, lng: lng});
  return mapLatLng;
}

// 緯度・経度から中心座標のオブジェクトを取得する
function getCenterMap( lat, lng ) {
  return new google.maps.LatLng({lat: lat, lng: lng});
}

// マーカー毎の処理
function dispMarker(map, markerData, marker, currentDist, offset=0, infoWindow) {
  for (var i = offset; i < markerData.length; i++) {
    if( currentDist > markerData[i]['dist'] ) {
      markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
      if( i < 1 ) {
        marker[i] = new google.maps.Marker({ // マーカーの追加
        position: markerLatLng, // マーカーを立てる位置を指定
        icon: {
          fillColor: "#FF0000",                //塗り潰し色
          fillOpacity: 0.8,                    //塗り潰し透過率
          path: google.maps.SymbolPath.CIRCLE, //円を指定
          scale: 16,                           //円のサイズ
          strokeColor: "#FF0000",              //枠の色
          strokeWeight: 1.0                    //枠の透過率
        },
        map: map // マーカーを立てる地図を指定
        });
      } else {
        marker[i] = new google.maps.Marker({ // マーカーの追加
        position: markerLatLng, // マーカーを立てる位置を指定
        animation: google.maps.Animation.DROP,
            map: map // マーカーを立てる地図を指定
        });
      }
      infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
         content: markerData[i]['infoWindowContent'] // 吹き出しに表示する内容
      });
      markerEvent(i, marker, infoWindow, map); // マーカーにクリックイベントを追加
    }
  }
}

function getInfoWindow( markerData ) {
  infoWindow = new google.maps.InfoWindow({ // 吹き出しの追加
     content: markerData // 吹き出しに表示する内容
  });
  return infoWindow;
}


// マーカー毎の処理
function dispMarker2(map, markerData) {
  var marker = [];
  //var infoWinDataArr = [];
  for (var i = 0; i < markerData.length; i++) {
    markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
    marker[markerData[i]['id']] = new google.maps.Marker({ // マーカーの追加
      position: markerLatLng, // マーカーを立てる位置を指定
      icon: markerData[i]['cat_icon'],
      map: map // マーカーを立てる地図を指定
    });
    infoWinData = getInfoWindow( markerData[i]['infoWindowContent'] );
    markerEvent2(marker[markerData[i]['id']], infoWinData, map);
  }
  return marker;
}

// Google MapInfowindow
function getInfowinContent( post_id, map_id, img_url, post_title, address, link ) {
  var tag = '';
  tag += "<div id='infoWin-" + post_id + "' class='infwin cf' style='position:relative'>";
  tag += "<a id='AAAAA" + map_id + "-" + post_id + "' style='position:absolute;top:-150px'></a>";
  tag += "<div class='infwin-thumb'>";
  tag += "<img class='img-responsive' src='" + img_url + "'></div>";
  tag += "<div class='infwin-main'>";
  tag += "<h3>" + post_title + "</h3>";
  tag += "<p>" + address + "</p>";
  tag += "<p class='infwin-link'><a href='" + link + "'>この記事を見る</a></p>";
  tag += "</div>";
  tag += "</div>";
  return tag;
}

// function clickViewMap( mapDistInfoWins, linkid ) {
//   google.maps.event.trigger(mapDistInfoWins[linkid], "click");
//   document.getElementById('mapArea2').scrollIntoView({behavior: 'smooth'});
// }