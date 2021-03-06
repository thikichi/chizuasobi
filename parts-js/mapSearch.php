<?php
$gmap_ajax_search = get_field('acf_option_gmap_ajax_search','option');
if( $gmap_ajax_search ) {
  $zoom = (int)$gmap_ajax_search['zoom'];
} else {
  $zoom = 10;
}
?>

<script>
  var mapSearchMarker = [];
  var selectTaxVal = {};
  var selectFieldVal = {};
  var inputTextVal = {};
  jQuery(function($) {
  $(function(){

    // var marker;
    /*
     * TOPページ
    */
    // 遅延読み込み部分
    var mapSearchDone = function() {
      var markerData = [];
      var markerSize ='img_marker_large';
      var disp_num = 5;
      var query_args = {
        "post_type":"landmark",
        "posts_per_page": disp_num
      };
      $('#mapSearchBtn').remove();
      // ローダー読み込み
      $('#mapSearchPost').html('<div class="align-center mt-30"><img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif"></div>');
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapSearchFunc',
            'marker_size': markerSize,
            'query_args' : query_args,
            'disp_num'   : disp_num,
            'selectTaxVal' : selectTaxVal,
            'selectFieldVal' : selectFieldVal,
            'inputTextVal' : inputTextVal,
            'mapid'     : 'mapSearch',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            var last_lat = markerData[markerData.length - 1]['lat'];
            var last_lng = markerData[markerData.length - 1]['lng'];
            var mapLatLng = getCenerLatLng( last_lat, last_lng );
            var map = initMap( 'mapSearch', mapLatLng, <?php echo $zoom; ?> );
            mapSearchMarker = dispMarker2( map, markerData );

            // 記事の出力
            if( jsonData['tags']!='' ) {
              $('#mapSearchPost').html( jsonData['tags'] );
            } else {
              $('#mapSearchPost').html( '<p class="align-center mt-50 mb-50">お探しの投稿はありませんでした。</p>' );
            }
            
            $('.matchHeight').matchHeight();
            // 表示件数カウント
            $('#mapSearchNum').html(0);
            $('#mapSearchNum').attr('data-count', jsonData['found_posts']);
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
            $('#mapSearchPost').after(jsonData['tags_btn']);
          }
      });
    }
    $('#mapSearch').myLazyLoadingObj({
      callback : mapSearchDone,
    });

    $('input[name="chgmarker"]').change(function() {
      markerSize = $("input[name='chgmarker']:checked").val();
      mapSearchDone();
    });

    // 検索フォームが選択された場合
    $('.search-hook-select').change(function() {
      setFormValues();
      mapSearchDone();
    });

    // フリーワード
    $('.block3__form-text').on('input',function(e){
      setFormValues();
      mapSearchDone();
    });

    // mapSearchDone();

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
        selectFieldVal = { fieldname: setfield , value: val , type: 'NUMERIC' , compare: '>=' };
        // selectFieldVal[setfield]['type'] = 'NUMERIC';
        // selectFieldVal[setfield]['compare'] = '>=';
      });
      // フリーワード検索
      inputTextVal = $('input[name="freetext"]').val();
    }

  });
});
function mapSearchClick( linkid ) {
  google.maps.event.trigger(mapSearchMarker[linkid], "click");
  document.getElementById('mapSearchSec').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>