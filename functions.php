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
  $specials = get_terms( array( 'taxonomy'=>'special', 'get'=>'all' ) );
  foreach ($specials as $term) {
    $choices[$term->term_id] = $term->name;
  }

  // セレクト
  $wp_customize->add_setting('top_special_select_1', array(
    'default' => null,
  ));
  $wp_customize->add_control( 'top_special_select_1', array(
    'section'  => 'top_special',
    'settings' => 'top_special_select_1',
    'label'    => '選択対象の特集',
    'description' => '選択対象となるカテゴリーを選択',
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

$heredocs .= <<< EOM
{
  pos: { lat: {$gmap['lat']}, lng: {$gmap['lng']} }, 
  title: "{$landmark->post_title}", 
  icon: "{$icon_img}", 
  post_id: {$landmark->ID},
  infoWindowContent: 
    "<div class='infwin cf' style='position:relative'>" + 
    "<a id='Gmap-{$landmark->ID}' style='position:absolute;top:-150px'></a>" + 
    "<div class='infwin-thumb'>" + 
    "<img class='img-responsive' src='{$img_url}'></div>" + 
    "<div class='infwin-main'>" + 
    "<h3>{$landmark->post_title}</h3>" + 
    "<p>{$address}</p>" + 
    "<p class='infwin-link'><a href='#'>この記事を見る</a></p>" + 
    "</div>" + 
    "</div>"
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
  var thisOffset_{$map_id};
  var counter_{$map_id}=0;
  $(window).on('load',function(){
    thisOffset_{$map_id} = $('#{$map_id}').offset().top;
  });
  $(window).scroll(function(){
    if( $(window).scrollTop() + $(window).height() > thisOffset_{$map_id} && counter_{$map_id} < 1 ){
      mygooglemap_{$map_id}();
      counter_{$map_id}++;
    }
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
  $post_map_img = $temp_img['src'] ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';

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
  infoWindowContent: 
    "<div class='infwin cf' style='position:relative'>" + 
    "<a id='Gmap-{$post_id}' style='position:absolute;top:-150px'></a>" + 
    "<div class='infwin-thumb'>" + 
    "<img class='img-responsive' src='{$post_map_img}'></div>" + 
    "<div class='infwin-main'>" + 
    "<h3>{$post_title}</h3>" + 
    "<p>{$post_map_address}</p>" + 
    "<p class='infwin-link'><a href='{$post_map_link}'>この記事を見る</a></p>" + 
    "</div>" + 
    "</div>"
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


$jy = $hotel->X / 3600000;
$jx = $hotel->Y / 3600000;
$lng = $jy - $jy * 0.00010695 + $jx * 0.000017464 + 0.0046017;
$lat = $jx - $jy * 0.000046038 - $jx * 0.000083043 + 0.010040;

$icon_hotel = get_stylesheet_directory_uri() . '/images/common/icon-hotel.png';

$heredocs .= <<< EOM
{
  pos: { lat: {$lat}, lng: {$lng} }, 
  title: "{$hotel->HotelName}", 
  icon: "{$icon_hotel}", 
  post_id: {$hotel->HotelID},
  infoWindowContent: 
    "<div class='infwin cf' style='position:relative'>" + 
    "<a id='Gmap-{$hotel->HotelID}' style='position:absolute;top:-150px'></a>" + 
    "<div class='infwin-thumb'>" + 
    "<img class='img-responsive' src='{$hotel->PictureURL}'></div>" + 
    "<div class='infwin-main'>" + 
    "<h3>{$hotel->HotelName}</h3>" + 
    "<p>{$hotel->HotelAddress}</p>" + 
    "<p class='infwin-link'><a href='{$hotel->HotelDetailURL}'>この宿泊施設を見る</a></p>" + 
    "</div>" + 
    "</div>"
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
  var thisOffset_{$map_id};
  var counter_{$map_id}=0;
  $(window).on('load',function(){
    thisOffset_{$map_id} = $('#{$map_id}').offset().top;
  });
  $(window).scroll(function(){
    if( $(window).scrollTop() + $(window).height() > thisOffset_{$map_id} && counter_{$map_id} < 1 ){
      mygooglemap_{$map_id}();
      counter_{$map_id}++;
    }
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
    console.log(map.getProjectionObject().getCode());
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




// ↑↑ ここまで追加記述してください ↑↑ //

// CSSスクリプトの読み込み
require_once 'functions/include-css.php';
// JSスクリプトを読み込み
require_once 'functions/include-js.php';