<script>
jQuery(function($) {
  $(function(){
    $('.layout3-slider').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      prevArrow: '<a href="javascript:void(0)" class="slide-arrow prev-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="55.892,105.002 5.892,55.002 55.892,5.002"/></svg></span></a>',
      nextArrow: '<a href="javascript:void(0)" class="slide-arrow next-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="3.892,5.002 53.892,55.002 3.892,105.002 "/></svg></span></a>',
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 4,
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
            slidesToShow: 2,
            centerMode: true,
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
            centerMode: true,
          }
        }
      ],
    });
  });
});
</script>