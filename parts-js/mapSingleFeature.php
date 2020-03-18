<?php
// 選択された「特集記事」の内容
if( is_singular('landmark') ) {
  $select_id = get_post_meta( $post->ID, 'acf_select_feature', true );
  $zoom = get_post_meta( $post->ID, 'relationplace_zoom', true );
  $page_in_link = '0';
} else if( is_singular('feature') ) {
  $select_id = $post->ID;
  $zoom = '14';
  $page_in_link = '1';
} else {
  $page_in_link = '1';
}
?>

<?php if( $select_id ): ?>
  <script>
  var mapSingleFeatureMarker = [];
  jQuery(function($) {
    $(function(){
      var markerSize ='img_marker_large';
      
      // 遅延読み込み部分
      var mapSingleFeatureDone = function() {
        var markerData = [];
        var select_id = <?php echo json_encode($select_id); ?>;
        var page_in_link = <?php echo json_encode($page_in_link); ?>;
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
              'action'  : 'mapSingleFeatureFunc',
              'select_id' : select_id,
              'mapid'   : 'mapSingleFeature',
              'marker_size' : markerSize,
              'page_in_link' : page_in_link,
            },
            success: function( response ){
              jsonData = JSON.parse( response );
              markerData = jsonData['markerDataAjax'];
              var last_lat = markerData[markerData.length - 1]['lat'];
              var last_lng = markerData[markerData.length - 1]['lng'];
              var mapLatLng = getCenerLatLng( last_lat, last_lng );
              var map = initMap( 'mapSingleFeature', mapLatLng, <?php echo $zoom; ?> );
              mapSingleFeatureMarker = dispMarker2( map, markerData );
              $('#mapSingleFeatureUL').html(jsonData['tags']);
              // スムーズスクロール
              $(function(){
                // #で始まるa要素をクリックした場合に処理
                $('a[href^=#]').click(function(){
                  // 移動先を0px調整する。0を30にすると30px下にずらすことができる。
                  var adjust = 0;
                  // スクロールの速度（ミリ秒）
                  var speed = 400;
                  // アンカーの値取得 リンク先（href）を取得して、hrefという変数に代入
                  var href= $(this).attr("href");
                  // 移動先を取得 リンク先(href）のidがある要素を探して、targetに代入
                  var target = $(href == "#" || href == "" ? 'html' : href);
                  // 移動先を調整 idの要素の位置をoffset()で取得して、positionに代入
                  var position = target.offset().top + adjust;
                  // スムーススクロール linear（等速） or swing（変速）
                  $('body,html').animate({scrollTop:position}, speed, 'swing');
                  return false;
                });
              });
            }
        });
      }
      $('#mapSingleFeature').myLazyLoadingObj({
        callback : mapSingleFeatureDone,
      });

      $('input[name="chgmarkerMSF"]').change(function() {
        markerSize = $("input[name='chgmarkerMSF']:checked").val();
        mapSingleFeatureDone();
      });

    });
  });
  function mapSingleFeatureClick( linkid ) {
    google.maps.event.trigger(mapSingleFeatureMarker[linkid], "click");
    document.getElementById('mapSingleFeatureWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
  }
  </script>
<?php endif; ?>