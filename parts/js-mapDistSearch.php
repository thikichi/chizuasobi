<?php
$post_map_center = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$lat_init = $post_map_center['lat'];
$lng_init = $post_map_center['lng'];
?>
<script>
var mapDistInfoWins = [];

jQuery(function($) {
  $(function(){
    /*
     * 付近の史跡一覧
    */
    var markerMapArea = [];
    var map;
    var marker = [];
    var mapLatLng;
    var circleObj;
    var currentDist = 5000;
    // var currentDist = 700000;
    var query_terms = [];
    var query_postid = $('#DispPost').data('mainpostid');
    var query_post_type = 'landmark';
    var infoWindow = [];
    var markerData = [];
    var centerMap = {'lat': <?php echo $lat_init; ?>, 'lng': <?php echo $lng_init; ?>};

    function get_checked_values( targetElem ) {
      var temp_query_terms = [];
      $(targetElem).each(function(index,el) {
        if ( $(this).prop('checked') ) {
          temp_query_terms.push($(this).val());
        }
      });
      return temp_query_terms;
    }

    // ajax main
    function doAjaxPosts( dist, query_post_type, query_terms, query_postid, display_mode='replace' ) {
      if( display_mode=='replace' ) {
        $('#DispPost > ul').html('<img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif">');
      } else {
        $('#DispPost > ul').append('<img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif">');
      }
      $('#PostNum').css('display','none');
      var disped_num = $('#DispPost > ul > li').length;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
              'action' : 'view_mes',
              'dist'   : dist,
              'mapid'  : 'mapDistSearch',
              'query_post_type' : query_post_type,
              'query_terms'     : query_terms,
              'query_postid' : query_postid,
              'disp_num' : 2, // 記事2件ずつ表示
              'display_mode' : display_mode, // 表示のさせ方 replace 入れ替え additional
              'disped_num' : disped_num,
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            var tag = '';
            markerData = jsonData['markerDataAjax'];

            deleteMakers(markerData, 1, marker);
            // dispMarker(map, jsonData['markerDataAjax'], marker, currentDist, 0, infoWindow);
            markerMapArea = dispMarker2( map, markerData );
            mapDistInfoWins = markerMapArea;

            $('#PostNum > ._allnum').html(jsonData['post_num_all']);
            $('#PostNum > ._getnum').html(jsonData['post_num_get']);
            if( display_mode=='replace' ) {
              $('#DispPost > ul').html(jsonData['tags']);
              $('#DispPost ._loader').remove();
            } else if(display_mode=='additional') {
              $('#DispPost > ul').append(jsonData['tags']);
              $('#DispPost ._loader').remove();
            }
            if( jsonData['no_more_posts'] ) {
              $('#DispPostMore').css('display','none');
            } else {
              $('#DispPostMore').css('display','block');
            }
            $('#PostNum').css('display','block');
            $('.matchHeight').matchHeight();
          }
      });
    }
    $('.marker-check').click(function() {
      var termid = $(this).data('termid');
      query_terms = get_checked_values('.marker-check');
      deleteMakers(markerData, 1, marker);
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
    });

    // セレクトボックス選択
    $('#MarkerSelectDist').change(function() {
      //選択したvalue値を変数に格納
      query_terms = get_checked_values('.marker-check');
      currentDist = $(this).val();
      var zoom = $(this).find('option:selected').data('zoom');
      // hiddenMakersAll();
      changeZoom(zoom, map);
      dalatePaintCircleMap( circleObj );
      circleObj = paintCircleMap( map, mapLatLng, currentDist );
      deleteMakers(markerData, 1, marker);
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
    });

    // さらに表示する
    $('#DispPostMore').on('click', function(event) {
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid, 'additional' );
    });

    // 遅延読み込み部分
    var mylazyloadDone = function() {
      mapLatLng = getCenerLatLng( centerMap['lat'], centerMap['lng'] );
      map = initMapDist( 'mapDistSearch', mapLatLng, centerMap, 13.0 );
      circleObj = paintCircleMap( map, mapLatLng, currentDist );
      query_terms = get_checked_values('.marker-check');
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
    }
    $('#mapDistSearch').myLazyLoadingObj({
      callback : mylazyloadDone,
    });
  });
});
function clickViewMap( linkid ) {
  google.maps.event.trigger(mapDistInfoWins[linkid], "click");
  document.getElementById('mapDistSearchLocation').scrollIntoView({behavior: 'smooth'});
}
</script>