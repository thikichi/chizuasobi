jQuery(function($) {

  /* コンポーネント以外の自作スクリプトはこの中へ記述します */
  /*============================================================*/

  // TAB切り替わりの部分
  $('.tab-switch').children('.tab-switch-nav').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    $(this).addClass('_active');
    $(this).siblings('.tab-switch-nav').removeClass('_active');
    // content switch
    // var thisIndex = $(this).index();
    // $('.tab-switch-content').eq(thisIndex);
  });

});

/* コンポーネント付随のスクリプトはこの下へ記述します */
/*============================================================*/

