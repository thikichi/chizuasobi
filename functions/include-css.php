<?php
/*----------------------------------------------------------------------------------------------------*/
/* サイトに読み込むCSSファイルを指定 */
/*----------------------------------------------------------------------------------------------------*/

/*
 * スタイルを追加する方法
 * 
 * 基本的にはWordPressで用意された下記のfunctionを使って実装
 * wp_enqueue_style( $handle, $src, $deps, $ver, $media ); 
 * 
 * $handle
 * （文字列） （必須） スタイルシートのハンドルとして使われる名称
 * CSSファイル名を書いておけば大丈夫です。
 * 
 * $src
 * （オプション） スタイルシートのURL
 * 
 * $deps
 * （オプション） このスタイルシートが依存する他のスタイルシートのハンドル配列
 * 分からなければ省略
 * 
 * $ver
 * （オプション） スタイルシートのバージョン番号を指定する文字列 (存在する場合) 
 * 分からなければ省略
 * 
 * $media
 * （オプション） スタイルシートが定義されているメディアを指定する文字列。例: 'all'、'screen'、'handheld'、'print'。
 * 分からなければ省略
*/


function wp_enqueue_scripts_css() {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　全ページ共通 ↓↓↓ */
  /*---------------------------------------------------------------*/

  /*
   * fontello
  */
  wp_enqueue_style(
    'fontello',
    get_stylesheet_directory_uri() . '/fonts/fontello-custom/css/fontello.css'
  );

  /*
   * font-awesome
  */
  // ver 5.0.13
  wp_enqueue_style(
    'font-awesome',
    get_stylesheet_directory_uri() . '/fonts/font-awesome-5.0.13/css/fontawesome-all.min.css'
  );

  /*
   * slick-theme
  */
  wp_enqueue_style(
    'slick-theme',
    get_stylesheet_directory_uri() . '/vendor/slick/slick-theme.css'
  );

  /*
   * slick
  */
  wp_enqueue_style(
    'slick',
    get_stylesheet_directory_uri() . '/vendor/slick/slick.css'
  );

  /*
   * module-extension.css
  */
  wp_enqueue_style(
    'module-extension',
    get_stylesheet_directory_uri() . '/css/module-extension.css',
    array('reset.css')
  );

  /*
   * main-frame.css
  */
  wp_enqueue_style(
    'main-frame',
    get_stylesheet_directory_uri() . '/css/main-frame.css',
    array('reset.css','bootstrap-custom.css','module.css')
  );

  /*
   * common.css
  */
  wp_enqueue_style(
    'os-common',
    get_stylesheet_directory_uri() . '/css/common.css',
    array('reset.css','bootstrap-custom.css','module.css')
  );


  if(is_front_page()) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　トップページ ↓↓↓ */
  /*---------------------------------------------------------------*/

  /*
   * index.css
  */
  wp_enqueue_style(
    'os-index',
    get_stylesheet_directory_uri() . '/css/index.css'
  );

  } else if(is_page('slug')) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　特定の固定ページ ↓↓↓ */
  /*---------------------------------------------------------------*/



  } else if(is_page()) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　固定ページ ↓↓↓ */
  /*---------------------------------------------------------------*/



  } elseif((is_singular('news') || is_tax('newscategory'))) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　新着情報 ↓↓↓ */
  /*---------------------------------------------------------------*/
  /*
   * news.css （新着情報）
  */
  wp_enqueue_style(
    'os-blog',
    get_stylesheet_directory_uri() . '/css/blog.css'
  );


  } elseif((is_single() || is_archive() || is_home())) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　ブログ（投稿） ↓↓↓ */
  /*---------------------------------------------------------------*/

  /*
   * news.css （新着情報）
  */
  wp_enqueue_style(
    'os-blog',
    get_stylesheet_directory_uri() . '/css/blog.css'
  );


  } elseif(is_search()) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　検索結果ページ ↓↓↓ */
  /*---------------------------------------------------------------*/

  /*
   * search.css （新着情報）
  */
  wp_enqueue_style(
    'search.css',
    get_stylesheet_directory_uri() . '/css/search.css'
  );


  } elseif(is_404()) {
  /*---------------------------------------------------------------*/
  /* ↓↓↓　404 NOT FOUND ↓↓↓ */
  /*---------------------------------------------------------------*/

  /*
   * news.css （新着情報）
  */
  wp_enqueue_style(
    '404',
    get_stylesheet_directory_uri() . '/css/404.css'
  );

  } else {}

  /*
   * style.css
  */
  wp_enqueue_style(
    'os-style',
    get_stylesheet_directory_uri() . '/style.css'
  );

}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_css' );