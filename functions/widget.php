<?php
/*
 * step 01.管理画面からサイドバーウィジェットが使えるようにする
*/
if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'name' => 'サイドバー（新着情報）',
    'id' => 'sidebar-news',
    'before_widget' => "<div class='sidebar sidebar-news'>",
    'before_widget' => '<div id="%1$s" class="widget widget-news %2$s">',
    'after_widget'  => "</div>",
    'before_title'  => "<h2 class='widget-title widget-title-news'>",
    'after_title'   => '</h2>'
  ));
}

if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'name' => 'サイドバー（ブログ）',
    'id' => 'sidebar-post',
    'before_widget' => "<div class='sidebar sidebar-post'>",
    'before_widget' => '<div id="%1$s" class="widget widget-post %2$s">',
    'after_widget'  => "</div>",
    'before_title'  => "<h2 class='widget-title widget-title-post'>",
    'after_title'   => '</h2>'
  ));
}

if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'name' => 'サイドバー（固定ページ）',
    'id' => 'sidebar-page',
    'before_widget' => "<div class='sidebar sidebar-page'>",
    'before_widget' => '<div id="%1$s" class="widget widget-page %2$s">',
    'after_widget'  => "</div>",
    'before_title'  => "<h2 class='widget-title widget-title-page'>",
    'after_title'   => '</h2>'
  ));
}

/*
 * step 02.管理画面「外観」→「ウィジェット」よりナビゲーションを編集します。
*/

/*
 * step 03.ウィジェットの設定を反映したい箇所に以下のタグを埋め込んでください。
 * 
 * <?php if(function_exists('dynamic_sidebar')) dynamic_sidebar(); ?>
*/
