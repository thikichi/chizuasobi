<?php
/*
 * Bodyにページごとのスラッグをクラスとして付与する
*/
add_filter('body_class', function($classes = '') {
  if (is_page()) {
   $page = get_page(get_the_ID());

  $decode_slug = urldecode($page->post_name);
  // 日本語が含まれるものを除外する
  $en_slug = '';
  if(strlen($decode_slug) == mb_strlen($decode_slug,'utf8')) {
    $en_slug = $decode_slug;
  }
  if($en_slug!='') $classes[] = 'body-class-page-' . $page->post_name;
  }
  return $classes;
});