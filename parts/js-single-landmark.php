<?php
$post_map_center = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$lat_init = $post_map_center['lat'];
$lng_init = $post_map_center['lng'];

// get terms of this post.
$terms = get_the_terms($post->ID, 'landmark_cateogry');
$term_id_arr = array();
if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
  foreach ( $terms as $term ) { $term_id_arr[] = $term->term_id; }
}
// query args
$post_args_same_cat = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
  // 'offset' => $offset,
  'tax_query' => array( 
    array(
      'taxonomy' => 'landmark_cateogry', //タクソノミーを指定
      'field' => 'term_id', //ターム名をスラッグで指定する
      'terms' => $term_id_arr,
      'operator' => 'IN',
    ),
  ),
);
?>

<script>
jQuery(function($) {
  $(function(){
    var markerMapArea = [];

    /*
     * 同じカテゴリー
    */
    // 遅延読み込み部分
    var mapCatsDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapCats', mapLatLng, 10.0 );
      var disp_num = 2;
      var query_args = <?php echo json_encode($post_args_same_cat); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'get_wp_posts_map',
            'query_args' : query_args,
            'map_id'     : 'mapCats',
            'disp_num'   : disp_num, // 記事○件ずつ表示
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapCats').myLazyLoadingObj({
      callback : mapCatsDone,
    });

    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });

    /*
     * 付近の史跡一覧
    */
    var map;
    var marker = [];
    var mapLatLng;
    var circleObj;
    var currentDist = 5000;
    // var currentDist = 700000;
    var query_terms = [3,2,6];
    var query_postid = $('#DispPost').data('mainpostid');
    var query_post_type = 'landmark';
    var infoWindow = [];
    var markerData = [];
    var centerMap = {'lat': <?php echo $lat_init; ?>, 'lng': <?php echo $lng_init; ?>};

    // ajax main
    function doAjaxPosts( dist, query_post_type, query_terms, query_postid, display_mode='replace' ) {
      if( display_mode=='replace' ) {
        $('#DispPost > ul').html('<img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif">');
      } else {
        $('#DispPost > ul').append('<img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif">');
      }
      $('#PostNum').css('display','none');
      var disped_num = $('#DispPost > ul > li').length;
      console.log($('#DispPost > ul > li').length);
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
              'action' : 'view_mes',
              'dist'   : dist,
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
            dispMarker(map, jsonData['markerDataAjax'], marker, currentDist, 0, infoWindow);
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
      var temp_query_terms = [];
      $('.marker-check').each(function(index,el) {
        if ( $(this).prop('checked') ) {
          temp_query_terms.push($(this).val());
        }
      });
      query_terms = temp_query_terms;
      deleteMakers(markerData, 1, marker);
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
    });

    // セレクトボックス選択
    $('#MarkerSelectDist').change(function() {
      //選択したvalue値を変数に格納
      var temp_query_terms = [];
      $('.marker-check').each(function(index,el) {
        if ( $(this).prop('checked') ) {
          temp_query_terms.push($(this).val());
        }
      });
      query_terms = temp_query_terms;
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
      doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
    }
    $('#mapDistSearch').myLazyLoadingObj({
      callback : mylazyloadDone,
    });



    $('.layout3-slider').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      prevArrow: '<a href="javascript:void(0)" class="slide-arrow prev-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="55.892,105.002 5.892,55.002 55.892,5.002"/></svg></span></a>',
      nextArrow: '<a href="javascript:void(0)" class="slide-arrow next-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="3.892,5.002 53.892,55.002 3.892,105.002 "/></svg></span></a>',
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 4,
            centerMode: false,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 3,
            centerMode: true,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 2,
            centerMode: true,
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
            centerMode: true,
          }
        }
      ],
    });



  });
});
</script>