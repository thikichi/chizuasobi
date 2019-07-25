jQuery(function($) {

  /* コンポーネント以外の自作スクリプトはこの中へ記述します */
  /*============================================================*/


  /* ハンバーガー */
  $('.spnavi-hamburger, .spnavi-overlay').on('click', function() {
    $('html').toggleClass('spnavi-opened');
    $('.header-naviFolding').toggleClass('__avtive');
  });






  /* MW WP Form */
  /*--------------------------------------------------*/
  var inputTypes = ['text','password','checkbox','radio','file','hidden','submit','reset','button','image','tel','number'];
  $.each(inputTypes, function(index, val) {
    $( '.change-input-type-' + val ).each(function(index, el) {
      $(this).attr('type',val);
    });
  });






  /* Custom Post Type Widgetsのアーカイブリンクのバグ修正 */
  /*--------------------------------------------------*/
  var findSidebarAnchor = $('.widget_archive').find('a');
  if($(findSidebarAnchor).length){
    jQuery.each(findSidebarAnchor, function() {
      var thisHref    = $(this).attr('href');
      var thisUrlArr  = thisHref.split('/');
      var newsSlug    = thisUrlArr[thisUrlArr.length-4];
      var replaceHref = thisHref;
      if(thisUrlArr[thisUrlArr.length-5]===newsSlug) {
        replaceHref =  thisHref.replace(newsSlug + '/' + newsSlug , newsSlug);
      }
      $(this).attr('href', replaceHref);
    });
  }



  /* アーカイブリストで件数表示がある時も崩れないように */
  var widgetListClass = ['widget_archive','widget_categories'];
  jQuery.each(widgetListClass, function(index,val) {
    var findSidebarLi = $('.' + val).find('li');
    if(findSidebarLi.length){
      jQuery.each(findSidebarLi, function() {
        var thisList       = $(this);
        var thisAnchor     = thisList.find('a');
        var thisAnchorHref = thisAnchor.attr('href');
        var thisListText   = $(this).text();
        // li要素を空にする
        thisList.html('');
        // a要素の内容をセット
        thisAnchor.text(thisListText);
        // li要素のaタグをセット
        thisList.html(thisAnchor);
      });
    }
  });

  /* ドロップダウン形式のアーカイブリストでも崩れないように */
  var findSidebarOption = $('select[name=archive-dropdown]').find('option');
  if($(findSidebarOption).length){
    jQuery.each(findSidebarOption, function() {
      var thisHref    = $(this).attr('value');
      var thisUrlArr  = thisHref.split('/');
      var newsSlug    = thisUrlArr[thisUrlArr.length-4];
      var replaceHref = thisHref;
      if(thisUrlArr[thisUrlArr.length-5]===newsSlug) {
        replaceHref =  thisHref.replace(newsSlug + '/' + newsSlug , newsSlug);
      }
      $(this).attr('value', replaceHref);
    });
  }

  /* 投稿日を表示する設定のときに表示崩れするのを防止 */
  var widgetList = $('.widget_recent_entries > ul > li');
  if(widgetList.length){
    jQuery.each(widgetList, function() {
      var widgetListDate = $(this).find('.post-date').html();
      if(widgetListDate) {
        var widgetListAnchor = $(this).children('a');
        var widgetListAnchorText = widgetListAnchor.text();
        widgetListAnchor.html('<span class="post-data">' + widgetListDate + '</span>' + '<br>' + widgetListAnchorText);
        $(this).html(widgetListAnchor);
      }
    });
  }



});

/* コンポーネント付随のスクリプトはこの下へ記述します */
/*============================================================*/





/* pagetop170 */
/*--------------------------------------------------*/

(function($) {

  var $pagetop170 = $('.pagetop170');

  $(window).on('load scroll', function() {

    var scrT = $(this).scrollTop();

    if (scrT <= 200) {
      $pagetop170.stop().fadeOut();
    } else if (200 < scrT) {
      $pagetop170.stop().fadeIn();
    }

  });

  $pagetop170.on('click', function() {
    $(htmlorbody).animate({
      scrollTop: 0
    }, {
      duration: 500,
      easing: 'easeOutQuart'
    });
  });

})(jQuery);
