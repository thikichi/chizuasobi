jQuery(function($) {

  /* コンポーネント以外の自作スクリプトはこの中へ記述します */
  /*============================================================*/

  $('.toggleSlide-nextElem').on('click', function(event) {
    // event.preventDefault();
    $(this).toggleClass('__avtive');
    $(this).siblings('ul').slideToggle('fast');
  });


  // TAB切り替わりの部分
  $('.tab-switch').each(function(index, el) {
    var thisTab = $(this);
    thisTab.find('.tab-switch-nav').on('click', function(event) {
      event.preventDefault();
      /* Act on the event */
      $(this).addClass('_active');
      $(this).siblings('.tab-switch-nav').removeClass('_active');
      // content switch
      thisTab.find('.tab-switch-content').removeClass('_active');
      var thisIndex = $(this).index();
      thisTab.find('.tab-switch-content').eq(thisIndex).addClass('_active');
    });
  });

  // pc sp 要素移動
  $(window).on('load resize', function() {
    var winWidth = $(window).width();
    if (winWidth < 768) {
      $('.spmoveto').each(function(index, el) {
        var moveToObj = $(this).data('spmoveto');
        $('#' + moveToObj).append( $(this).children() );
      });
    } else {
      $('.pcmoveto').each(function(index, el) {
        var moveToObj = $(this).data('pcmoveto');
        $('#' + moveToObj).append( $(this).children() );
      });
    }
  });
});

/* コンポーネント付随のスクリプトはこの下へ記述します */
/*============================================================*/




