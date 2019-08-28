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


$heredocs .= <<< EOM
{
  pos: { lat: {$gmap['lat']}, lng: {$gmap['lng']} }, 
  title: "{$landmark->post_title}", 
  icon: "", 
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
      $("#HandleMap-" + post_id).bind("click",function(){
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




// ↑↑ ここまで追加記述してください ↑↑ //

// CSSスクリプトの読み込み
require_once 'functions/include-css.php';
// JSスクリプトを読み込み
require_once 'functions/include-js.php';