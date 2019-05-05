<?php
/*----------------------------------------------------------------------------------------------------*/
/* 管理画面をカスタマイズする
/*----------------------------------------------------------------------------------------------------*/

/**
 * バージョンアップ通知を管理者のみ表示させる
 */
add_action( 'admin_init', function(){
  if ( ! current_user_can( 'administrator' ) ) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
});

/**
 * ビジュアルエディタスタイルを適用する
 */
add_action( 'admin_init', function(){
  add_editor_style( 'css/admin/custom-editor-style.css' );
});

/**
 * 管理画面全体にスタイルを適用する
 */
add_action('admin_enqueue_scripts', function(){
  // ログインユーザー全体
  wp_enqueue_style('admin_css', get_stylesheet_directory_uri() . '/css/admin/admin.css');
  // 権限ごとのスタイルシート読み込み
  $current_user = wp_get_current_user();
  $user_arr = array('customer', 'editor', 'author', 'contributor', 'subscriber');
  foreach ($user_arr as $user) {
    $is_current_user = isset($current_user->caps[$user]) && $current_user->caps[$user] ? true : false;
    $file_path = '/css/admin/admin-'.$user.'.css';
    if($is_current_user && file_exists(get_stylesheet_directory() . $file_path)) {
      wp_enqueue_style('admin_'.$user.'_css', get_stylesheet_directory_uri() . $file_path);
    }
  }

});

/**
 * ビジュアルモードでSPANタグが消えないようにする
 */
add_filter( 'tiny_mce_before_init' , function ( $init_array ) {
  $init_array['valid_elements']          = '*[*]';
  $init_array['extended_valid_elements'] = '*[*]';
  return $init_array;
});