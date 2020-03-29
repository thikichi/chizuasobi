
<?php
global $osfw;
$slider_arr = get_field('acf_option_slider','option');
$slider_for = $slider_nav = '';
foreach ($slider_arr as $key => $slider) {
  // main slider
  $link   = $slider['slider']['link']['url'];
  $target = $slider['slider']['link']['target'] ? ' target="_blank"' : '';
  if( $osfw->is_mobile() ) {
    // $slider_img['square_w750'] = $osfw->get_thumbnail( $slider['slider']['image'], 'img_golden_w750' );
    $slider_img['square_w750'] = $osfw->get_thumbnail( $slider['slider']['image'], 'img_golden_w750' );
  } else {
    $slider_img['square_w750'] = $osfw->get_thumbnail( $slider['slider']['image'], 'img_square_w750' );
  }
  $slider_for .= '<li>';
  $slider_for .= $link!='' ? '<a href="' . $link . '"' . $target . '>' : '';
  $slider_for .= '<img src="' . $slider_img['square_w750']['src'] . '">';
  $slider_for .= $link!='' ? '</a>' : '';
  $slider_for .= '</li>';
  // sub slider
  $slider_img['normal_w300'] = $osfw->get_thumbnail( $slider['slider']['image'], 'img_normal_w300' );
  $title   = $slider['slider']['title'];
  $slider_nav .= '<li class="slider-nav-img">';
  $slider_nav .= '<a href="#">';
  $slider_nav .= '<img src="' . $slider_img['normal_w300']['src'] . '">';
  $slider_nav .= '</a>';
  $slider_nav .= '<span class="slider-nav-text">' . $title . '</span>';
  $slider_nav .= '</li>';
}
?>

<div id="MainVisual" class="mainvisual" style="background-color: gray">
  <div class="mainvisual-inner">
    <ul class="slider-for">
      <?php echo $slider_for; ?>
    </ul>
    <div class="slider-nav-wrapper">
      <ul class="slider-nav">
        <?php echo $slider_nav; ?>
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
        // {
        //   breakpoint: 767,
        //   settings: {
        //     slidesToShow: 3,
        //     centerMode: true,
        //   }
        // },
        {
          breakpoint: 767,
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
            slidesToShow: 5,
            centerMode: true,
          }
        },
        // {
        //   breakpoint: 575,
        //   settings: {
        //     slidesToShow: 3,
        //     centerMode: true,
        //   }
        // },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        }
      ],
      asNavFor: '.slider-for'
    });
  });
});
</script>