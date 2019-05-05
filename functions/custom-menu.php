<?php
/*
 * step01.管理画面からサイドバーウィジェットが使えるようにします。
*/

if ( function_exists('register_nav_menu')) register_nav_menu('GLOBAL NAVIGATION', 'グローバルナビゲーション');

/*
 * step02.次に管理画面「外観」→「メニュー」よりナビゲーションを編集します。
*/

/*
 * step03.次にナビゲーションを表示したい箇所に以下のタグを貼り付けます。
 * 
 * <?php wp_nav_menu( array(
 *   'theme_location'=>'GLOBAL NAVIGATION', 
 *   'container'     =>'', 
 *   'menu_class'    =>'',
 *   'items_wrap'    =>'<ul id="main-nav">%3$s</ul>'));
 * ?>
*/

