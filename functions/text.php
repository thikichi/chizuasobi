<?php
/*----------------------------------------------------------------------------------------------------*/
/* テキストの処理に関する関数 */
/*----------------------------------------------------------------------------------------------------*/

/*
 * 記事抜粋の終端に表示される、[...]を変更する
*/
add_filter('excerpt_more', function(){
  global $post;
  return ' ・・・<a class="moretag" href="'. get_permalink($post->ID) . '">[記事の詳細へ]</a>';
});

/*
 * 抜粋の長さ（文字数）を変更
*/
add_filter('excerpt_mblength', function($length){
  return 100;
});

/*
 * タイトルの長さ（文字数）を変更し、終端に任意のテキストを表示する
*/
// add_filter('the_title', function($title, $id) {
//   return mb_strimwidth($title, 0, 40, "...","UTF-8");
// }, 10, 2);