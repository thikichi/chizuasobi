<?php
/*----------------------------------------------------------------------------------------------------*/
/* 各種プラグインのカスタマイズ
/*----------------------------------------------------------------------------------------------------*/

/*
 * All in one seo pack プラグイン
/*----------------------------------------------------------------------------------------------------*/

/**
 * All in one seo pack
 * アーカイブ系に title などを指定出力する方法
 */
// add_filter('aioseop_title', function($title){
//   if(is_post_type_archive('news')){
//     $title = 'ここに新着情報のタイトルがはいります';
//   }
//   return $title;
// });

/**
 * All in one seo pack
 * アーカイブ系に desctiption を指定出力する方法
 */
// add_filter('aioseop_description', function($description){
//   global $post;
//   if(is_post_type_archive('news')){
//     $description = "ここに新着情報のディスクリプションがはいります";
//   }
//   return $description;
// });

/**
 * All in one seo pack
 * アーカイブ系に keywork を指定出力する方法
 */
// add_filter('aioseop_keywords', function($keywords){
//   if(is_post_type_archive('news')){
//     $keywords = "ここに新着情報のキーワードがはいります";
//     $keywords = trim($keywords,",");
//   }
//   return $keywords;
// });


/*
 * MW WP Form プラグイン
/*----------------------------------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', function(){

  /* お問い合わせページの場合 */
  if(is_page('contact')) {
    
    /* MW WP Form プラグイン 郵便番号を出力 */
    wp_enqueue_script(
      'ajaxzip3.js', 
      get_stylesheet_directory_uri() . '/vendor/ajaxzip3/ajaxzip3.js', 
      array('jquery'), 
      false, 
      true
    );

    /* MW WP Form プラグイン URLパラメータの値の受け渡し　例） http://example.com/contact/?param=○○○ */
    // $mwform_formkey_key = 22;             // お問い合わせフォームのキーを指定
    // $name_attribute     = 'お問い合わせ種別'; // name属性を指定
    // $get_param          = 'param'; 　　　　　　 // GETの値（URLのパラメータ）を指定
    // add_filter( 'mwform_value_mw-wp-form-' . $mwform_formkey_key, function($value, $name) {
    //   global $name_attribute;
    //   global $get_param;
    //   if ($name === $name_attribute && !empty($_GET[$get_param]) && !is_array($_GET[$get_param])) {
    //     $rdata = $_GET[$get_param];
    //     return $rdata;
    //   }
    //   return $value;
    // }, 10, 2 );

   }
});

/**
 * MW WP Form プラグイン
 * 管理者アカウント以外は管理画面からメニューを消す
 */
add_action('admin_menu', function(){
  if (!current_user_can('level_10')) {
    remove_menu_page('edit.php?post_type=mw-wp-form');
  }
});


/*
 * Breadcrumb NavXT プラグイン
/*----------------------------------------------------------------------------------------------------*/

/**
 * パンくずリスト「Breadcrumb NavXT」プラグインで404ページに「ブログ（投稿）」が表示されるバグを回避
 */
if ( function_exists('bcn_display') ) {
  add_action('bcn_after_fill', function($trail){
    if ( is_404() ) {
      unset($trail->trail[1]);
      array_keys($trail->trail);
    }
  });
}

/*
 * Advanced Custom Fieldプラグイン
/*----------------------------------------------------------------------------------------------------*/

/**
 * Advanced Custom Fieldプラグインを利用する場合
 * acfでgoogle mapでエラーがでるのでそれを修正
 */
add_filter('acf/fields/google_map/api', function () {
    return array(
        'libraries' => 'places',
        'key'        => 'AIzaSyBjYTWYNKXOkeVC6fofHCDHEJVhiTIVTIE', // Googleで発行したキーを用意する
        'client'     => ''
    );
});