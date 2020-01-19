<?php
$mapid = 'mapArea2';
$lat_init = 35.681236;
$lng_init = 139.767125;
?>

<script>
jQuery(function($) {
  $(function(){
    var markerMapArea = [];
    var selectTaxVal = {};
    var selectFieldVal = {};
    var inputTextVal = {};
    // var marker;
    /*
     * TOPページ
    */
    // 遅延読み込み部分
    var mapAreaDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( '<?php echo $mapid; ?>', mapLatLng, 10.0 );
      var disp_num = 5;
      var query_args = {
        "post_type":"landmark",
        "posts_per_page": disp_num
      };
      $('#MapSimpleSearchBtn').remove();
      // ローダー読み込み
      $('#MapSimpleSearchPost').html('<div class="align-center mt-30"><img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif"></div>');
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapSimpleSearchFunc',
            'query_args' : query_args,
            'disp_num'   : disp_num,
            'selectTaxVal' : selectTaxVal,
            'selectFieldVal' : selectFieldVal,
            'inputTextVal' : inputTextVal,
            'mapid'     : '<?php echo $mapid; ?>',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            console.log(jsonData);
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
            // 記事の出力
            $('#MapSimpleSearchPost').html( jsonData['tags'] );
            $('.matchHeight').matchHeight();
            // 表示件数カウント
            $('#MapSimpleSearchNum').html(0);
            $('#MapSimpleSearchNum').attr('data-count', jsonData['found_posts']);
            var countElm = $('[data-count]'),
            countSpeed = 20;
            countElm.each(function(){
              var self = $(this),
              countMax = self.attr('data-count'),
              thisCount = self.text(),
              countTimer;
              function timer(){
                countTimer = setInterval(function(){
                  var countNext = thisCount++;
                  self.text(countNext);
                  if(countNext == countMax){
                    clearInterval(countTimer);
                  }
                },countSpeed);
              }
              timer();
            });
            // さらに見るボタンを追加
            console.log(jsonData['tags_btn']);
            $('#MapSimpleSearchPost').after(jsonData['tags_btn']);
          }
      });
    }
    $('#<?php echo $mapid; ?>').myLazyLoadingObj({
      callback : mapAreaDone,
    });

    // 検索フォームが選択された場合
    $('.search-hook-select').change(function() {
      setFormValues();
      mapAreaDone();
    });

    // フリーワード
    $('.block3__form-text').blur(function() {
      setFormValues();
      mapAreaDone();
    });

    // すべてのフォームの値を取得する
    function setFormValues() {
      // カテゴリーを選択したとき
      $('[data-setcategory]').each(function(index, el) {
        var setcategory = $(this).data('setcategory');
        var val = $(this).val();
        selectTaxVal[setcategory] = val;
      });
      // カスタムフィールドを選択したとき
      $('[data-setfield]').each(function(index, el) {
        var setfield = $(this).data('setfield');
        var val = $(this).val();
        selectFieldVal[setfield] = val;
      });
      // フリーワード検索
      inputTextVal = $('input[name="freetext"]').val();
    }


    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });
  });
});
</script>