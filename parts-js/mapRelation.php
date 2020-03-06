<?php
$relationplace = get_field('relationplace');
// var_dump($relationplace);

$acf_landmark_gmap = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$relationplace_zoom = get_post_meta( $post->ID, 'relationplace_zoom', true );

$lat_init = $acf_landmark_gmap['lat'];
$lng_init = $acf_landmark_gmap['lng'];

?>

<script>
var markerMapArea = [];
jQuery(function($) {
  $(function(){
    
    // 遅延読み込み部分
    var mapAreaDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapRelation', mapLatLng, <?php echo $relationplace_zoom; ?> );
      var place_arr = <?php echo json_encode($relationplace); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'    : 'mapRelationFunc',
            'place_arr' : place_arr,
            'mapid'     : 'mapRelation',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
            console.log(jsonData['tags']);
            $('.block4__mapside-list').append(jsonData['tags']);
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
    mapAreaDone();
    // $('[data-mapid]').on('click', function(event) {
    //   var map_post_id = $(this).data('mapid');
    //   google.maps.event.trigger(markerMapArea[map_post_id], "click");
    // });
  });
});
function clickViewMap( linkid ) {
  google.maps.event.trigger(markerMapArea[linkid], "click");
  document.getElementById('mapRelationWrap').scrollIntoView({behavior: 'smooth', block: 'start'});
}
</script>