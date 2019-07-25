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










// ↑↑ ここまで追加記述してください ↑↑ //

// CSSスクリプトの読み込み
require_once 'functions/include-css.php';
// JSスクリプトを読み込み
require_once 'functions/include-js.php';