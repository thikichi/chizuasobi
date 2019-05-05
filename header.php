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
</head>

<body <?php body_class(); ?>>

  <?php /* この下にヘッダーセットを記述 */ ?>

  <header id="Header" class="header header-h">
    <div class="container">
      <div class="header-inner cf">
        <div class="header-logo">
          <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/header-logo.svg" alt="地図遊び">
        </div>
        <div class="header-main">
          <div class="header-h pl-xs-10 pl-sm-15 pl-md-30">
            <div class="d-t h-100p">
              <div class="d-tc h-100p va-m">
                <h1 class="fontSet5">GoogleMapで遊ぶランドマーク紹介サイト</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="header-navi">
          <div class="header-h">
            <div class="d-t h-100p">
              <div class="d-tc h-100p va-m">
                <div class="spnavi-hamburger">
                  <div class="hamburger hamburger-spin">
                    <div class="hamburger-box">
                      <div class="hamburger-inner"></div>
                    </div>
                  </div>
                  <div class="spnavi-hamburger-text font-noto-serif-jp">
                    menu
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header> 
  <div id="MainVisual" class="mainvisual mb-xs-100" style="background-color: gray">
    <div class="mainvisual-inner">
      <ul class="slider-for">
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-3.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-4.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-5.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-1.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-2.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-3.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-4.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-5.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-1.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-2.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-3.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-4.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-5.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-1.jpg"></li>
        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-2.jpg"></li>
      </ul>
      <div class="slider-nav-wrapper">
        <ul class="slider-nav">
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-3-mini.jpg">
            </a>
            <span class="slider-nav-text">東京駅</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-4-mini.jpg">
            </a>
            <span class="slider-nav-text">日光東照宮</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-5-mini.jpg">
            </a>
            <span class="slider-nav-text">レインボー<br>ブリッジ</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-1-mini.jpg">
            </a>
            <span class="slider-nav-text">東京タワー</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-2-mini.jpg">
            </a>
            <span class="slider-nav-text">姫路城</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-3-mini.jpg">
            </a>
            <span class="slider-nav-text">東京駅</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-4-mini.jpg">
            </a>
            <span class="slider-nav-text">日光東照宮</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-5-mini.jpg">
            </a>
            <span class="slider-nav-text">レインボー<br>ブリッジ</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-1-mini.jpg">
            </a>
            <span class="slider-nav-text">東京タワー</span>
          </li>
          <li class="slider-nav-img">
            <a href="#">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/mv-2-mini.jpg">
            </a>
            <span class="slider-nav-text">姫路城</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  jQuery(function($) {
    $(document).ready(function(){
      $('.slider-for').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.slider-nav'
      });
      $('.slider-nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        centerMode: true,
        focusOnSelect: true,
        asNavFor: '.slider-for'
      });
    });
  });
  </script>

  <?php /* メインビジュアル ＆ サブビジュアル ＆ パンくずリスト */ ?>

  <?php if(is_front_page()): /* TOPページ */ ?>

    <main class="frame-main">

      <?php /* メインビジュアルはできればここに記述 */ ?>

  <?php else: /* 下層ページ */ ?>

    <main class="frame-main">
      <article class="frame-article">

        <?php /* サブビジュアル<img>を出力 */ ?>
        <?php // if(function_exists('os_disp_subvisual')) os_disp_subvisual(); ?>

        <?php /* サブビジュアルURLを出力 */ ?>
        <?php // if(function_exists('os_disp_sv_url')) os_disp_sv_url(); ?>

        <?php /* サブビジュアルテキストを出力 */ ?>
        <?php // if(function_exists('os_disp_sv_bgtxt')) os_disp_sv_bgtxt(); ?>


        <!-- subvisual224 -->
        <!--==================================================-->
        <?php /* サブビジュアル 管理画面「フレーム設定」の「サブビジュアル(背景画像)」にて画像を指定します */ ?>
        <div class="subvisual224" style="background-image: url(<?php if(function_exists('os_disp_sv_url')) os_disp_sv_url(); ?>)">
          <?php if(function_exists('os_disp_sv_bgtxt')) os_disp_sv_bgtxt(); ?>
        </div>


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
