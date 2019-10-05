<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no,address=no,email=no">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <link href="<?php bloginfo('rss2_url'); ?>" rel="alternate" type="application/rss+xml" title="RSSフィード">
  <?php if(is_admin_bar_showing()): ?>
    <style type="text/css">
      /* ログイン時に管理バーが表示されている時に読み込ませたいスタイルを定義 */
    </style>
  <?php endif; ?>
  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php wp_head(); ?>
<script>
jQuery(function($) {
  $(function(){
    
    $.fn.myLazyLoadingObj = function(options) {
      var callback  = options.callback;
      var thisOffset = this.offset().top;
      var cnt_mapdist = 0;
      $(window).scroll(function(){
        if( $(window).scrollTop() + $(window).height() > thisOffset && cnt_mapdist < 1 ){
          callback();
          cnt_mapdist++;
        }
      });
      return this;
    }
  });
});

function getInfowinContent( post_id, map_id, img_url, post_title, address, link ) {
  var tag = '';
  tag += "<div id='infoWin-" + post_id + "' class='infwin cf' style='position:relative'>";
  tag += "<a id='AAAAA" + map_id + "-" + post_id + "' style='position:absolute;top:-150px'></a>";
  tag += "<div class='infwin-thumb'>";
  tag += "<img class='img-responsive' src='" + img_url + "'></div>";
  tag += "<div class='infwin-main'>";
  tag += "<h3>" + post_title + "</h3>";
  tag += "<p>" + address + "</p>";
  tag += "<p class='infwin-link'><a href='" + link + "'>この記事を見る</a></p>";
  tag += "</div>";
  tag += "</div>";
  return tag;
}
</script>


</head>

<body <?php body_class(); ?>>

<div class="header-naviFolding">
  <div class="header-naviFolding-close">
    <?php get_template_part( 'parts/hamburger' ) ?>
  </div>
  <div class="header-naviFolding-inner">
    <ul class="header-naviFolding-main">
      <li>
        <a class="toggleSlide-nextElem" href="<?php echo home_url('/'); ?>">TOPページ</a>
      </li>
      <li>
        <a class="toggleSlide-nextElem has-icon-plus-after" href="#">メニュー</a>
        <ul>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
        </ul>
      </li>
      <li>
        <a class="toggleSlide-nextElem has-icon-plus-after" href="#">メニュー</a>
        <ul>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
        </ul>
      </li>
      <li>
        <a class="toggleSlide-nextElem has-icon-plus-after" href="#">メニュー</a>
        <ul>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
        </ul>
      </li>
      <li>
        <a class="toggleSlide-nextElem has-icon-plus-after" href="#">メニュー</a>
        <ul>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
          <li><a href="#">サブメニュー</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>


  <?php /* この下にヘッダーセットを記述 */ ?>

  <header id="Header" class="header">
    <div class="container">
      <div class="header-inner">
        <div class="header-logo">
          <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/header-logo.svg" alt="地図遊び">
          </a>
        </div>
        <div class="header-main">
          <span class="table">
            <span class="table-cell __left">
              <h1 class="fontSet5">GoogleMapで遊ぶ<br class="visible-xs">ランドマーク紹介サイト</h1>
            </span>
          </span>
        </div>
      </div>
    </div>
  </header> 

  <?php if( is_front_page() ): ?>
    <?php get_template_part( 'parts/mainvisual' ); ?>
  <?php else: ?>
    <?php get_template_part( 'parts/subvisual' ); ?>
  <?php endif; ?>

  <?php /* メインビジュアル ＆ サブビジュアル ＆ パンくずリスト */ ?>

  <?php if(is_front_page()): /* TOPページ */ ?>

    <main class="frame-main">

      <?php /* メインビジュアルはできればここに記述 */ ?>

  <?php else: /* 下層ページ */ ?>

    <main class="frame-main">
      <article class="frame-article">



        <!-- breadcrumbs168 -->
        <!--==================================================-->

        <div class="breadcrumbs168 mt-xs-20 mb-xs-30">
          <div class="container-fluid">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
              <?php if(function_exists('bcn_display')){bcn_display();} ?>
            </div>
          </div>
        </div>

  <?php endif; ?>



  <?php /* 条件分岐テンプレ（以下の条件分岐のどれか1つのみが適用されます） */ ?>

  <?php /* TOPページ */ ?>
  <?php if(is_front_page()): ?>

  <?php /* 特定の固定ページ ※ slug : 固定ページのスラッグ名を指定 */ ?>
  <?php elseif(is_page('slug')): ?>

  <?php /* 上記以外の固定ページ */ ?>
  <?php elseif(is_page()): ?>

  <?php /* 新着情報（アーカイブ ＆ 詳細） */ ?>
  <?php elseif(is_post_type_archive('news') || is_singular('news') || is_tax('newscategory')): ?>

  <?php /* 特定のカスタム投稿のアーカイブ　※ slug: カスタム投稿のスラッグ名を指定 */ ?>
  <?php elseif(is_post_type_archive('slug')): ?>

  <?php /* 特定のカスタム投稿の詳細　※ slug: カスタム投稿のスラッグ名を指定 */ ?>
  <?php elseif(is_singular('slug')): ?>

  <?php /* 特定のカスタム分類アーカイブ　※ slug: カスタム分類のスラッグ名を指定 */ ?>
  <?php elseif(is_tax('slug')): ?>

  <?php /* 「投稿」（ブログ）のアーカイブ */ ?>
  <?php elseif(is_archive() || is_single() || is_home()): ?>

  <?php /* 404ページ */ ?>
  <?php elseif(is_404()): ?>

  <?php /* その他 */ ?>
  <?php else: ?>

  <?php endif; ?>
