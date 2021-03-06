<?php
$relationplace = get_field('relationplace');
// var_dump($relationplace);
$zoom = get_post_meta( $post->ID, 'relationplace_zoom', true );
?>

<script>
var mapRelationMarker = [];
jQuery(function($) {
  $(function(){
    var markerSize ='img_marker_large';
    
    // 遅延読み込み部分
    var mapRelationDone = function() {
      var markerData = [];
      var place_arr = <?php echo json_encode($relationplace); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'    : 'mapRelationFunc',
            'place_arr' : place_arr,
            'mapid'     : 'mapRelation',
            'marker_size' : markerSize,
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];

            var last_lat = markerData[markerData.length - 1]['lat'];
            var last_lng = markerData[markerData.length - 1]['lng'];
            var mapLatLng = getCenerLatLng( last_lat, last_lng );
            var map = initMap( 'mapRelation', mapLatLng, <?php echo $zoom; ?> );
            mapRelationMarker = dispMarker2( map, markerData );

            $('#mapRelationUL').html(jsonData['tags']);
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
    $('#mapRelationHook').myLazyLoadingObj({
      callback : mapRelationDone,
    });
    // mapRelationDone();

    $('input[name="chgmarker"]').change(function() {
      markerSize = $("input[name='chgmarker']:checked").val();
      mapRelationDone();
    });

  });
});
function mapRelationClick( linkid ) {
  google.maps.event.trigger(mapRelationMarker[linkid], "click");
  document.getElementById('mapRelationWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>