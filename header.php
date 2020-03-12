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
</script>


</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v6.0"></script>
<?php
global $osfw;
?>
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
        <a class="toggleSlide-nextElem has-icon-plus-after" href="#">史跡の一覧</a>
        <ul>
          <li><a href="<?php echo $osfw->get_archive_link('landmark'); ?>">史跡の一覧</a></li>
          <li><a href="<?php echo $osfw->get_archive_link('feature'); ?>">特集</a></li>
          <li><a href="<?php echo $osfw->get_archive_link('course'); ?>">おすすめ史跡巡りコース</a></li>
        </ul>
      </li>
      <li>
        <a class="toggleSlide-nextElem" href="<?php echo $osfw->get_page_link('searchform'); ?>">史跡検索</a>
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
              <h1 class="fontSet5">歴史を地図で巡る<br class="visible-xs">史跡紹介サイト</h1>
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

<?php if( !(is_home() || is_front_page() )): ?>
  <div class="breadcrumb">
    <div class="breadcrumb__container">
      <div class="breadcrumb__inner">
        <?php
        if ( function_exists( 'bcn_display' ) ) {
        bcn_display();
        }
        ?>
      </div>
    </div>
  </div>
<?php endif; ?>


  <?php endif; ?>