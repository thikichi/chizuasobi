jQuery(function($) {

  /* コンポーネント以外の自作スクリプトはこの中へ記述します */
  /*============================================================*/

  // TAB切り替わりの部分
  $('.tab-switch').children('li').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    $(this).addClass('_active');
    $(this).siblings('li').removeClass('_active');
  });

});

/* コンポーネント付随のスクリプトはこの下へ記述します */
/*============================================================*/

