<?php
/*--------------------------------------------------*/
/* ↓↓ コメントアウトを外して機能を有効にできます ↓↓ */
/*--------------------------------------------------*/

/*
 * アイキャッチやギャラリーの画像サイズを指定する
*/
require_once 'functions/add-image-size.php';

/*
 * 各種のバグを修正するコード
*/
require_once 'functions/debug.php';

/*
 * 各種プラグインのカスタマイズ
*/
require_once 'functions/plugins.php';

/*
 * 管理画面のカスタマイズ
*/
require_once 'functions/administration.php';

/*
 * サイドバーウィジェットを利用可能にする
*/
require_once 'functions/widget.php';

/*
 * テキストの処理に関する関数 抜粋の文字数などの変更
*/
require_once 'functions/text.php';

/*
 * ユーティリティーを集めたクラス
*/
require_once 'functions/utility.php';

/*
 * その他の便利な機能
*/
require_once 'functions/others.php';

/*
 * 複合検索フォーム
*/
require_once 'functions/os-subquery-search.php';

/*
 * オリジナルのカスタムフィールドを実装
*/
// require_once 'functions/custom-fields.php';

/*
 * カスタムメニューを利用可能にする
*/
// require_once 'functions/custom-menu.php';





function wp_enqueue_scripts_functions() {
/*--------------------------------------------------*/
/* ↓↓ コンポーネントライブラリからのソースを貼り付ける場合はこちら ↓↓ */
/*--------------------------------------------------*/










  /* ↑↑ すべてのページで読み込むスクリプト ↑↑ */
  if(is_front_page()) {
    /* ↓↓ TOPページのみに適用 ↓↓ */


    /* ↑↑ TOPページのみに適用 ↑↑ */
  } elseif(is_page()) {
    /* ↓↓ 上記以外の固定ページに適用 ↓↓ */


    /* ↑↑ 上記以外の固定ページに適用 ↑↑ */
  } elseif(is_post_type_archive('news') || is_singular('news') || is_tax('newscategory')) {
    /* ↓↓ 新着情報のみに適用（カスタム投稿） ↓↓ */


    /* ↑↑ 新着情報のみに適用（カスタム投稿） ↑↑ */
  } elseif(is_archive() || is_single() || is_home()) {
    /* ↓↓ ブログ（投稿）のみに適用 ↓↓ */


    /* ↑↑ ブログ（投稿）のみに適用 ↑↑ */
  } else if(is_404()) {
    /* ↓↓ 404ページのみに適用 ↓↓ */


    /* ↑↑ 404ページのみに適用 ↑↑ */
  } else {
    /* ↓↓ 上記以外の全てのページに適用 ↓↓ */


    /* ↑↑ 上記以外の全てのページに適用 ↑↑ */
  }









/* ↑↑↑ --- コンポーネントライブラリからの貼り付けはここまで--- ↑↑↑ */
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_functions' );
/*--------------------------------------------------*/
/* ↓↓ ここから通常のfunctionsの記述を追加してください ↓↓ */
/*--------------------------------------------------*/



$navigation = array(
  'company' => array(
    'label' => '会社概要',
    'link' => home_url('company'),
    'target' => '_blank',
    'class'  => 'item-company',
  ),
  'contact' => array(
    'label' => 'お問い合わせ',
    'link' => home_url('contact'),
    'target' => '_blank',
    'class'  => 'item-contact',
    'subnav' => array(
      'contactus1' => array(
        'label'   => '私たちへのお問い合わせ',
        'link'    => home_url('contact_us'),
        'target'  => '_blank',
        'class'   => 'item-contact',
      ),
      'contactus2' => array(
        'label'   => '私たちへのお問い合わせ２',
        'link'    => home_url('contact_us'),
        'target'  => '_blank',
        'class'   => 'item-contact',
      ),
    ),
  ),
);


function get_header_nav_li( $navlist ) {
  $tag = '';
  foreach ($navlist as $key => $nav) {
    $tag .= '<li>';
    $tag .= '<a';
    $tag .= ' href="' . $nav['link'] . '"';
    if( isset($nav['target']) && $nav['target'] ) $tag .= ' target="' . $nav['target'] . '"';
    if( isset($nav['class'])  && $nav['class'] )  $tag .= ' class="' . $nav['class'] . '"';
    if( isset($nav['id'])     && $nav['id'] )     $tag .= ' id="' . $nav['id'] . '"';
    $tag .= '>';
    $tag .= $nav['label'];
    $tag .= '</a>';
    if( isset($nav['subnav'])) {
      $tag .= '<ul class="_sub">';
      $tag .= get_header_nav_li( $nav['subnav'] );
      $tag .= '</ul>';
    }
    $tag .= '</li>';
  }
  return $tag;
}




/* テーマカスタマイザー
---------------------------------------------------------- */

function theme_customizer_extension($wp_customize) {
  //今月の特集
  $wp_customize->add_section( 'top_special', array (
    'title' => '今月の特集',
    'priority' => 100,
  ));

  //特集タイトル
  $wp_customize->add_setting( 'top_special_text_1', array (
    'default' => null,
  ));
  $wp_customize->add_control( 'top_special_text_1', array(
    'section' => 'top_special',
    'settings' => 'top_special_text_1',
    'label' =>'特集タイトル ※ 赤字部分',
    'description' => 'トップに表示される『特集』についての編集',
    'type' => 'text',
    'priority' => 70,
  ));

  $choices = array();
  $features = get_posts( array( 'post_type'=>'feature', 'get'=>'all', 'numberposts'=>-1 ) );
  foreach ($features as $feature_post) {
    $choices[$feature_post->ID] = $feature_post->post_title;
  }

  // セレクト
  $wp_customize->add_setting('top_special_select_1', array(
    'default' => null,
  ));
  $wp_customize->add_control( 'top_special_select_1', array(
    'section'  => 'top_special',
    'settings' => 'top_special_select_1',
    'label'    => '選択対象の特集',
    'description' => '選択対象となる投稿を選択',
    'type'    => 'select',
    'choices' => $choices,
    'priority' => 80,
  ));
}
add_action('customize_register', 'theme_customizer_extension');








function the_google_map_disp($map_id, $landmarks, $map_center=array(35.681236,139.767125,13), $field_params, $style='') {

  $map_center_lat  = $map_center[0];
  $map_center_lng  = $map_center[1];
  $map_center_zoom = $map_center[2];

  echo '<div id="' . $map_id . '" class="gmap-main" style="' . $style . '"></div>';
  echo '<script>';
$heredocs = <<< EOM
function mygooglemap_{$map_id}(){
  "use strict";
  var mapData    = { pos: { lat: {$map_center_lat}, lng: {$map_center_lng} }, zoom: {$map_center_zoom} };
  var markerData = [
EOM;
// echo $heredocs;



  // 投稿ごとのマーカーと情報ウィンドウ作成
  $post_ids =array();
  foreach ($landmarks as $landmark): ?>
    <?php
    $post_ids[] = $landmark->ID;
    // $map['Coordinate'] = get_post_meta( $landmark->ID, 'acf_landmark_gmap', true );
    // $map['address']    = get_post_meta( $landmark->ID, 'acf_landmark_address', true );
    // カスタムフィールド
    foreach ($field_params as $key => $field) {
      ${$key} = get_post_meta( $landmark->ID, $field, true );
    }


    $img_id  = get_post_thumbnail_id( $landmark->ID );
    if( $img_id ) {
      $img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
      $img_url = esc_url($img[0]);
    } else {
      $img_url = 'http://placehold.jp/18/cccccc/ffffff/100x100.png?text=NO IMAGE';
    }

    // Map Icon Image
    global $osfw;
    $terms       = get_the_terms( $landmark->ID, 'landmark_cateogry' );
    if( $terms ) {
      $icon_img_id = $osfw->get_term_cfield( 'landmark_cateogry', $terms[0]->term_id, 'acf_landmark_cateogry_map_icon' );
      $icon_img_temp = $osfw->get_thumbnail( $icon_img_id, 'thumbnail', '' );
    } else {
      $icon_img_temp = '';
    }
    $icon_img = $icon_img_temp=='' ? '' : $icon_img_temp['src'];
    $link = get_the_permalink( $landmark->ID );

$heredocs .= <<< EOM
{
  pos: { lat: {$gmap['lat']}, lng: {$gmap['lng']} }, 
  title: "{$landmark->post_title}", 
  icon: "{$icon_img}", 
  post_id: {$landmark->ID},
  infoWindowContent: getInfowinContent( {$landmark->ID}, {$map_id}, '{$img_url}', '{$landmark->post_title}', '{$address}', '{$link}' )
},
EOM;

endforeach;

$implode_post_ids = implode(',', $post_ids);
$heredocs .= <<< EOM
  ];
  // 投稿からMapの情報ウィンドウ呼び出し
  var map, infoWindow;
  var markers = [];
  var infoWinCnts = [];
  var suffixies  = [{$implode_post_ids}];
  jQuery(function($) {
    $.each(suffixies, function(index, post_id) {
      $("#HandleMap-{$map_id}-" + post_id).bind("click",function(){
        infoWindow.setContent(infoWinCnts[post_id]);
        infoWindow.open(map, markers[post_id]);
        infoWindow.open(map,markers[post_id]);
      });
    });
  });
  // Google Map 本体
  map = new google.maps.Map(document.getElementById('{$map_id}'), {
      center: mapData.pos,
      zoom:   mapData.zoom
  });
  infoWindow = new google.maps.InfoWindow();
  for( var i=0; i < markerData.length; i++ ) {
    var post_id = markerData[i].post_id;
    (function(){
        var marker = new google.maps.Marker({
            position: markerData[i].pos,
            title:    markerData[i].title,
            icon:     markerData[i].icon,
            map: map
        });
        if( markerData[i].infoWindowContent ) {
            var infoWindowContent = markerData[i].infoWindowContent;
            marker.addListener('click', function(){
                infoWindow.setContent(infoWindowContent);
                infoWindow.open(map, marker);
            });
        }
        infoWinCnts[post_id] = markerData[i].infoWindowContent;
        markers[post_id] = marker;
    }());
  }
};
// 遅延読み込み
jQuery(function($) {
  $(function(){
    // 遅延読み込み
    $('#{$map_id}').myLazyLoadingObj({
      callback : mygooglemap_{$map_id}
    });
  });
});




EOM;
  echo $heredocs;
  echo '</script>';
}




function the_google_map_disp_m($map_id, $hotels, $post_id ,$style) {

  global $osfw;
  // post
  $get_posts = get_posts( array('post_type'=>'landmark','include'=>$post_id) );
  $post_title = $get_posts[0]->post_title;

  // map lat and lng
  $post_map_field = get_post_meta( $post_id, 'acf_landmark_gmap', true );
  $post_map_address = get_post_meta( $post_id, 'acf_landmark_address', true );
  $post_map_link = get_the_permalink( $post_id );
  // thumbnail
  $temp_img = $osfw->get_thumbnail_by_post( $post->ID, 'img_square' );
  $post_map_img = isset($temp_img['src']) ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';

  $map_center_lat  = $post_map_field['lat'];
  $map_center_lng  = $post_map_field['lng'];
  $map_center_zoom = 13;

  // Map Icon Image
  global $osfw;
  $terms = get_the_terms( $post_id, 'landmark_cateogry' );
  if( $terms ) {
    $icon_img_id = $osfw->get_term_cfield( 'landmark_cateogry', $terms[0]->term_id, 'acf_landmark_cateogry_map_icon' );
    $icon_img_temp = $osfw->get_thumbnail( $icon_img_id, 'thumbnail', '' );
  } else {
    $icon_img_temp = '';
  }
  $icon_img = $icon_img_temp=='' ? '' : $icon_img_temp['src'];


  echo '<div id="' . $map_id . '" class="gmap-main" style="' . $style . '"></div>';
  echo '<script>';
$heredocs = <<< EOM
function mygooglemap_{$map_id}(){
  "use strict";
  var mapData    = { pos: { lat: {$map_center_lat}, lng: {$map_center_lng} }, zoom: {$map_center_zoom} };
  var markerData = [
  {
  pos: { lat: {$post_map_field['lat']}, lng: {$post_map_field['lng']} }, 
  title: "{$post_title}", 
  icon: "{$icon_img}", 
  post_id: {$post_id},
  infoWindowContent: getInfowinContent( {$post_id}, {$map_id}, '{$post_map_img}', '{$post_title}', '{$post_map_address}', '{$post_map_link}' )
  },

EOM;
// echo $heredocs;



  // 投稿ごとのマーカーと情報ウィンドウ作成
  $post_ids =array();
  foreach ($hotels as $hotel): ?>
    <?php
    $post_ids[] = $hotel->HotelID;
    // 表示したい項目のキー名とラベル名のセット
    // foreach ($field_params as $key => $label) {
    //   ${$key} = $value;
    // }

    // $img_id  = get_post_thumbnail_id( $hotel->ID );
    // if( $img_id ) {
    //   $img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
    //   $img_url = esc_url($img[0]);
    // } else {
    //   $img_url = 'http://placehold.jp/18/cccccc/ffffff/100x100.png?text=NO IMAGE';
    // }


// $jy = $hotel->X / 3600000;
// $jx = $hotel->Y / 3600000;
// $lng = $jy - $jy * 0.00010695 + $jx * 0.000017464 + 0.0046017;
// $lat = $jx - $jy * 0.000046038 - $jx * 0.000083043 + 0.010040;


$lat = $hotel->Y - $hotel->Y * 0.00010695 + $hotel->X * 0.000017464 + 0.0046017;
$lng = $hotel->X - $hotel->Y * 0.000046038 - $hotel->X * 0.000083043 + 0.010040;



$icon_hotel = get_stylesheet_directory_uri() . '/images/common/icon-hotel.png';

$heredocs .= <<< EOM
{
  pos: { lat: {$lat}, lng: {$lng} }, 
  title: "{$hotel->HotelName}", 
  icon: "{$icon_hotel}", 
  post_id: {$hotel->HotelID},
  infoWindowContent: getInfowinContent( {$hotel->HotelID}, {$map_id}-{$hotel->HotelID}, '{$hotel->PictureURL}', '{$hotel->HotelName}', '{$hotel->HotelAddress}', '{$hotel->HotelDetailURL}' )
},
EOM;

endforeach;

$implode_post_ids = implode(',', $post_ids);
$heredocs .= <<< EOM
  ];
  // 投稿からMapの情報ウィンドウ呼び出し
  var map, infoWindow;
  var markers = [];
  var infoWinCnts = [];
  var suffixies  = [{$implode_post_ids}];
  jQuery(function($) {
    $.each(suffixies, function(index, post_id) {
      $("#HandleMap-{$map_id}-" + post_id).bind("click",function(){
        infoWindow.setContent(infoWinCnts[post_id]);
        infoWindow.open(map, markers[post_id]);
        infoWindow.open(map,markers[post_id]);
      });
    });
  });
  // Google Map 本体
  map = new google.maps.Map(document.getElementById('{$map_id}'), {
      center: mapData.pos,
      zoom:   mapData.zoom
  });
  infoWindow = new google.maps.InfoWindow();
  for( var i=0; i < markerData.length; i++ ) {
    var post_id = markerData[i].post_id;
    (function(){
        var marker = new google.maps.Marker({
            position: markerData[i].pos,
            title:    markerData[i].title,
            icon:     markerData[i].icon,
            map: map
        });
        if( markerData[i].infoWindowContent ) {
            var infoWindowContent = markerData[i].infoWindowContent;
            marker.addListener('click', function(){
                infoWindow.setContent(infoWindowContent);
                infoWindow.open(map, marker);
            });
        }
        infoWinCnts[post_id] = markerData[i].infoWindowContent;
        markers[post_id] = marker;
    }());
  }
};
jQuery(function($) {
  $(function(){
    // 遅延読み込み
    $('#{$map_id}').myLazyLoadingObj({
      callback : mygooglemap_{$map_id}
    });
  });
});



EOM;
  echo $heredocs;
  echo '</script>';
}


function get_openLayers_map( $map_id, $location=array(35.681236,139.767125,13), $class='', $style='' ) {

  $tag  = '';
  $lat  = $location['lat'];
  $lng  = $location['lng'];
  $zoom = $location['zoom'];

  $tag  .= '<div id="' . $map_id . '" class="' . $class . '" style="' . $style . '"></div>';

$heredocs .= <<< EOM
<script>
function openLayersFuncSingle() {
    var options = {
        controls:[
            // new OpenLayers.Control.Navigation(),
            // new OpenLayers.Control.NavToolbar(),
            // new OpenLayers.Control.PanZoomBar(),
            // new OpenLayers.Control.ScaleLine(),
            // new OpenLayers.Control.ZoomPanel(),
            new OpenLayers.Control.Attribution()
            ],
    };
    var map = new OpenLayers.Map({$map_id}, options);
    map.addLayer(new OpenLayers.Layer.OSM());
    map.setCenter(new OpenLayers.LonLat( {$lng}, {$lat} )
        .transform(
                new OpenLayers.Projection("EPSG:4326"),  // WGS84
                new OpenLayers.Projection("EPSG:3857")   // Google Map / OSM / etc の球面メルカトル図法
        ), {$location['zoom']}
    );
    // マーカー
    var markers = new OpenLayers.Layer.Markers("Markers");
    map.addLayer(markers);
    var marker = new OpenLayers.Marker(
        new OpenLayers.LonLat( {$lng}, {$lat} )
            .transform(
                new OpenLayers.Projection("EPSG:4326"),
                new OpenLayers.Projection("EPSG:900913")
            )
    );
    markers.addMarker(marker);  
    // var marker2 = new OpenLayers.Marker(
    //         new OpenLayers.LonLat(140.76, 35.68)
    //             .transform(
    //                 new OpenLayers.Projection("EPSG:4326"),
    //                 new OpenLayers.Projection("EPSG:900913")
    //             )
    //     );
    // markers.addMarker(marker2);
}
openLayersFuncSingle();
</script>
EOM;

  $tag .= $heredocs;

  return $tag;

}

/**
 * ２地点間の距離(m)を求める
 * ヒュベニの公式から求めるバージョン
 *
 * @param float $lat1 緯度１
 * @param float $lng1 経度１
 * @param float $lat2 緯度２
 * @param float $lng2 経度２
 * @param boolean $mode 測地系 true:世界(default) false:日本
 * @return float 距離(m)
 */
function distance($lat1, $lng1, $lat2, $lng2, $mode=true) {
  // 緯度経度をラジアンに変換
  $radLat1 = deg2rad($lat1); // 緯度１
  $radlng1 = deg2rad($lng1); // 経度１
  $radLat2 = deg2rad($lat2); // 緯度２
  $radlng2 = deg2rad($lng2); // 経度２

  // 緯度差
  $radLatDiff = $radLat1 - $radLat2;

  // 経度差算
  $radLonDiff = $radlng1 - $radlng2;

  // 平均緯度
  $radLatAve = ($radLat1 + $radLat2) / 2.0;

  // 測地系による値の違い
  $a = $mode ? 6378137.0 : 6377397.155; // 赤道半径
  $b = $mode ? 6356752.314140356 : 6356078.963; // 極半径
  //$e2 = ($a*$a - $b*$b) / ($a*$a);
  $e2 = $mode ? 0.00669438002301188 : 0.00667436061028297; // 第一離心率^2
  //$a1e2 = $a * (1 - $e2);
  $a1e2 = $mode ? 6335439.32708317 : 6334832.10663254; // 赤道上の子午線曲率半径

  $sinLat = sin($radLatAve);
  $W2 = 1.0 - $e2 * ($sinLat*$sinLat);
  $M = $a1e2 / (sqrt($W2)*$W2); // 子午線曲率半径M
  $N = $a / sqrt($W2); // 卯酉線曲率半径

  $t1 = $M * $radLatDiff;
  $t2 = $N * cos($radLatAve) * $radLonDiff;
  $dist = sqrt(($t1*$t1) + ($t2*$t2));

  return $dist;
}
















/*
 * このテーマTOPの「すべてを表示」ボタンで表示される投稿
*/
function add_my_ajaxurl() {
  echo '<script>';
  echo 'var ajaxurl = "' . admin_url( 'admin-ajax.php') . '"';
  echo '</script>';
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );


require_once 'ajax/mapDistSearch.php';
require_once 'ajax/mapFeature.php';
require_once 'ajax/mapSearch.php';
require_once 'ajax/mapSamecat.php';
require_once 'ajax/mapSearchform.php';
require_once 'ajax/mapRelation.php';
require_once 'ajax/mapSingleFeature.php';
require_once 'ajax/mapArchive.php';
require_once 'ajax/mapHotel.php';

function gmap_infowindow( $post_id, $map_id ) {

  // Thumbnail
  $img_id = get_post_thumbnail_id( $post_id );
  if( $img_id!='' ) {
    $temp_img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
    if ($_SERVER['HTTPS']) {
      $img_url = preg_replace( "/^http:/", "https:", $temp_img[0] );
    } else {
      $img_url = $temp_img[0];
    }
  } else {
    $img_url   = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
  }
  $title = esc_html(get_the_title( $post_id ));
  $link  = esc_url(get_the_permalink( $post_id ));
  $address = esc_html(get_post_meta( $post_id, 'acf_landmark_address', true ));
  $tag = get_infowindow_tag($map_id, $img_url, $title, $address, $link );
  return $tag;
}

function get_infowindow_tag($map_id, $img_url, $title, $address, $link, $is_target_blank=false ) {
  $target = $is_target_blank ? ' target="_blank"' : '';
  $tag  = '';
  $tag .= "<div id='" . $map_id . "' class='infwin cf' style='position:relative'>";
  $tag .= "<a style='position:absolute;top:-150px'></a>";
  $tag .= "<div class='infwin-thumb'>";
  $tag .= "<img class='img-responsive' src='" . $img_url . "'></div>";
  $tag .= "<div class='infwin-main'>";
  $tag .= "<h3>" . $title . "</h3>";
  $tag .= "<p>" . $address . "</p>";
  $tag .= "<p class='infwin-link'><a href='" . $link . "'" . $target . ">この記事を見る</a></p>";
  $tag .= "</div>";
  $tag .= "</div>";
  return $tag;
}

function mapRelationSideText( $title, $thumb_id, $textarea, $quote_arr='' ) {
  $temp_img = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
  if ($_SERVER['HTTPS']) {
    $img_url = preg_replace( "/^http:/", "https:", $temp_img[0] );
  } else {
    $img_url = '';
  }
  $tag  = '';
  $tag .= "<div id='" . $map_id . "' class='infwin cf' style='position:relative'>";
  $tag .= "<a style='position:absolute;top:-150px'></a>";
  if( $img_url ) {
    $tag .= "<div class='infwin-thumb'>";
    $tag .= "<img class='img-responsive' src='" . $img_url . "'></div>";
    $style = "";
  } else {
    $style = " style='width:100%'";
  }
  $tag .= "<div class='infwin-main'" . $style . ">";
  $tag .= "<h3 class='infwin-ttl'>" . $title . "</h3>";
  $tag .= "<p class='infwin-textarea'>" . $textarea . "</p>";
  // if($quote_arr) {
  //   foreach ($quote_arr as $quote) {
  //     $tag .= '<blockquote class="infwin__blockquote" cite="' . $quote['url'] . '">';
  //     $tag .= '<p class="infwin__blockquote-text">' . $quote['textarea'] . '</p>';
  //     $tag .= '<cite class="infwin__blockquote-cite">';
  //     $tag .= $quote['site_name'];
  //     if($quote['page_title']) $tag .= '『' . $quote['page_title'] . '』';
  //     $tag .= '</cite>';
  //     $tag .= '</blockquote>';
  //   }
  // }
  $tag .= "</div>";
  $tag .= "</div>";
  return $tag;
}

function get_tag_postlist( $post_id ,$tax_slug='landmark_cateogry', $address, $func_name='' ) {

  // Thumbnail
  $img_id = get_post_thumbnail_id( $post_id );
  if( $img_id!='' ) {
    $temp_img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
    if ($_SERVER['HTTPS']) {
      $img_url = preg_replace( "/^http:/", "https:", $temp_img[0] );
    } else {
      $img_url = $temp_img[0];
    }
    $thumb = '<img src="' . $img_url . '" alt="">';
  } else {
    $thumb = '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
    $img_url = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
  }

  $theme_url = get_stylesheet_directory_uri();
  $permalink = get_the_permalink();

  $taxtag = '';
  $terms = get_the_terms(get_the_ID(), $tax_slug);
  if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
    $taxtag .= '<ul class="taglist-1 cf mt-xs-10">';
    foreach ( $terms as $term ) {
      $term_link = get_term_link( $term->term_id, $tax_slug );
      $taxtag .= '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
    }
    $taxtag .= '</ul>';
  }

  $tag  = '';
  $tag .= '<li class="col-md-6 mt-xs-15">';
  $tag .= '<div class="box-1 box-1-2col cf">';
  $tag .= '<div class="box-1-inner cf">';
  $tag .= '<div class="box-1-thumb matchHeight">';
  $tag .= $thumb;
  $tag .= '</div>';
  $tag .= '<div class="box-1-main matchHeight">';
  $tag .= '<div class="box-1-text">';
  $tag .= '<h3 class="subttl-1">';
  $tag .= get_the_title();
  $tag .= '<span class="subttl-1-mini">投稿日時 ' . get_the_time('Y.m.d') . '</span>';
  $tag .= '</h3>';
  $tag .= '<p class="mt-xs-5">' . $address . '</p>';
  $tag .= $taxtag;
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '<div class="box-1-btn matchHeight">';
  $tag .= '<div class="box-1-btnTop">';
  if( $func_name!='' ) {
    $tag .= '<a class="link-1" href="javascript:' . $func_name . '(\'' . $post_id . '\')">';
  } else {
    $tag .= '<a class="link-1" href="javascript:clickViewMap(\'' . $post_id . '\')">';
  }
  
  $tag .= '<span class="link-color-1">';
  $tag .= '<img class="_icon " src="' . $theme_url . '/images/common/icon-pin.svg">'; 
  $tag .= '<span class="_linkText box-1-btnText">地図を見る</span>';
  $tag .= '</span>';
  $tag .= '</a>';
  $tag .= '</div>';
  $tag .= '<div class="box-1-btnBottom">';
  $tag .= '<a class="link-1" href="' . $permalink . '">';
  $tag .= '<span class="link-color-1">';
  $tag .= '<img class="_icon" src="' . $theme_url . '/images/common/icon-book.svg">';
  $tag .= '<span class="_linkText box-1-btnText">記事を読む</span>';
  $tag .= '</span>';
  $tag .= '</a>';
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '<div class="box-1-bottom">';
  $tag .= $taxtag;
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '</li>';


// ob_start();
// var_dump($tag);
// $out = ob_get_contents();
// ob_end_clean();
// file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);


  return $tag;
}



/*
 * Google Map Ajax
*/
function get_wp_posts_only(){
  global $osfw;
  $returnObj = array();
  $disp_num  = $_POST['disp_num']; // 表示させたい記事件数
  $query_args = $_POST['query_args'];
  $the_query = new WP_Query( $query_args );
  if ($the_query->have_posts()) {
    $i=0;
    while($the_query->have_posts()) {
      $the_query->the_post();
      // custom field
      $loop_gmap = get_post_meta( get_the_ID(), 'acf_landmark_gmap', true );
      $loop_address = get_post_meta( get_the_ID(), 'acf_landmark_address', true );
      // thumbnail
      $temp_img = $osfw->get_thumbnail_by_post( get_the_ID(), 'img_square' );
      $post_map_img = $temp_img['src'] ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_get_wp_posts_only', 'get_wp_posts_only' );
add_action( 'wp_ajax_nopriv_get_wp_posts_only', 'get_wp_posts_only' );


/*
 * Button
*/
function button( $slug, $label = '過去の特集記事の一覧' ) {
  global $osfw;
  $rdata  = '';
  $rdata .= '<div class="btn-1">';
  $rdata .= '<a href="' . $osfw->get_archive_link( $slug ) . '">';
  $rdata .= $label . '<i class="fas fa-angle-double-right"></i>';
  $rdata .= '</a>';
  $rdata .= '</div>';
  echo $rdata;
}


/*
 * AFC PRO option page
*/
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => '全体設定',
    'menu_title'  => '全体設定',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array( // 子ページ
    'page_title'  => 'スライダー設定', // ページタイトル
    'menu_title'  => 'TOPスライダー設定', // メニュータイトル
    'menu_slug'   => 'slider-settings',
    'capability'  => 'edit_posts',
    'parent_slug' => 'theme-general-settings', // 親メニューのスラッグ
  ));

  acf_add_options_sub_page(array( // 子ページ
    'page_title'  => '地図設定', // ページタイトル
    'menu_title'  => '地図設定', // メニュータイトル
    'menu_slug'   => 'gnmap-settings',
    'capability'  => 'edit_posts',
    'parent_slug' => 'theme-general-settings', // 親メニューのスラッグ
  ));


}



function marker_size_change_tag( $name='chgmarker' ) {
  $tag = '';
  $tag .= '<div class="chgmarker">';
  $tag .= '<ul class="chgmarker__list">';
  $tag .= '<li class="chgmarker__ttl">地図アイコン</li>';
  $tag .= '<li class="chgmarker__list-item">';
  $tag .= '<input class="chgmarker__input" id="' . $name . '_ChgmarkerLarge" type="radio" name="' . $name . '" value="img_marker_large" checked="checked">';
  $tag .= '<label class="chgmarker__label" for="' . $name . '_ChgmarkerLarge">大</label>';
  $tag .= '</li>';
  $tag .= '<li class="chgmarker__list-item">';
  $tag .= '<input class="chgmarker__input" id="' . $name . '_ChgmarkerMiddle" type="radio" name="' . $name . '" value="img_marker_middle">';
  $tag .= '<label class="chgmarker__label" for="' . $name . '_ChgmarkerMiddle">中</label>';
  $tag .= '</li>';
  $tag .= '<li class="chgmarker-list-item">';
  $tag .= '<input class="chgmarker__input" id="' . $name . '_ChgmarkerSmall" type="radio" name="' . $name . '" value="img_marker_small">';
  $tag .= '<label class="chgmarker__label" for="' . $name . '_ChgmarkerSmall">小</label>';
  $tag .= '</li>';
  $tag .= '</ul>';
  $tag .= '</div>';
  return $tag;
}


/*
 * 緯度・経度の計算で日本測地系から世界測地系へ変換する
*/
function change_geodetic_system_from_jp_to_wd( $jlat, $jlng ) {
  $rdata = array();
  $jy = floatval($jlat) / 3600000;
  $jx = floatval($jlng) / 3600000;
  $rdata['lat'] = $jy - $jy * 0.00010695 + $jx * 0.000017464 + 0.0046017;
  $rdata['lng'] = $jx - $jy * 0.000046038 - $jx * 0.000083043 + 0.010040;
  return $rdata;
}


function slider_tags( $args ) {
  
  $title = isset($args['title']) ? $args['title'] : '';
  $image = isset($args['image']) ? $args['image'] : '';
  $text  = isset($args['text'])  ? $args['text']  : '';
  $link_map  = isset($args['link_map'])  ? $args['link_map']  : '';
  $link_main = isset($args['link_main']) ? $args['link_main'] : '';
  $id    = isset($args['id'])    ? $args['id']    : '';
  $link_text = isset($args['link_text']) ? $args['link_text'] : '';

  $tag  = '';
  $tag .= '<li>';
  $tag .= '<div class="layout3-slider-box">';
  $tag .= '<div class="layout3-thumb" style="background-image:url(' . $image . ')"></div>';
  $tag .= '<div class="layout3-hoverBox">';
  $tag .= '<h3>' . $title . '</h3>';
  $tag .= '<p>' . $text . '</p>';
  $tag .= '<div class="btn-2">';
  $tag .= '<a class="link-1"';
  $tag .= ' href="'. $link_map .'"';
  $tag .= ' id="' . $id . '">地図を見る</a>';
  $tag .= '</div>';
  $tag .= '<div class="btn-2 _red">';
  $tag .= '<a href="' . $link_main . '" target="_blank">' . $link_text .'</a>';
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '</div>';
  $tag .= '</li>';

  return $tag;
}

// マーカー画像
function get_marker_image( $post_id, $marker_size ) {
  global $osfw;
  if( $marker_size==='img_marker_large' ) {
    $set_marker_size = 'img_marker_large';
  } else if( $marker_size==='img_marker_middle' ) {
    $set_marker_size = 'img_marker_middle';
  } else if( $marker_size==='img_marker_small' ) {
    $set_marker_size = 'img_marker_small';
  } else {
    $set_marker_size = 'full';
  }
  $marker = $osfw->get_thumbnail( $post_id, $set_marker_size, get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
  return $marker;
}

function get_landmark_thumbnail( $post_id ) {
  $img_id = get_post_thumbnail_id( $post_id );
  if( $img_id!='' ) {
    $temp_img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
    if ($_SERVER['HTTPS']) {
      $img_url = preg_replace( "/^http:/", "https:", $temp_img[0] );
    } else {
      $img_url = $temp_img[0];
    }
  } else {
    $img_url   = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
  }
  return $img_url;
}

// ↑↑ ここまで追加記述してください ↑↑ //

// CSSスクリプトの読み込み
require_once 'functions/include-css.php';
// JSスクリプトを読み込み
require_once 'functions/include-js.php';