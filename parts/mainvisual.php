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
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            centerMode: false,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 1,
            centerMode: true,
          }
        }
      ],
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      centerMode: true,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 2,
            centerMode: true,
          }
        }
      ],
      asNavFor: '.slider-for'
    });
  });
});
</script>