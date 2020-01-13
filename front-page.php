<?php get_header(); ?>

<?php
$landmarks = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
?>

<section class="gmap-all">
  <div class="container"> 
    <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">史跡を地図で検索</span></h2>
    <div id="mapArea2" class="gmap-all__map-area" style="position: relative; overflow: hidden"></div>
  </div>
  <div class="block3">
    <div class="block3__container">
      <div class="block3__inner">
        <div class="block3__search">
          <div class="block3__search-main matchHeight">
            <div class="block3__search-box block3__search-box--first">
              <input type="text" name="freetext" class="block3__form-text" placeholder="検索ワードを指定">
            </div>
            <div class="block3__search-box">
              <select name="category" class="block3__form-select">
                <option value="">種類を選択</option>
                <option value="">選択１</option>
                <option value="">選択２</option>
              </select>
            </div>
            <div class="block3__search-box">
              <select name="category" class="block3__form-select">
                <option value="">種類を選択</option>
                <option value="">選択１</option>
                <option value="">選択２</option>
              </select>
            </div>
            <div class="block3__search-box">
              <select name="category" class="block3__form-select">
                <option value="">種類を選択</option>
                <option value="">選択１</option>
                <option value="">選択２</option>
              </select>
            </div>
          </div>
          <div class="block3__search-sub matchHeight">
            <div class="table">
              <div class="table-cell cf">
                <p class="block3__num">
                  件数
                  <span class="block3__num-main">
                    <span class="block3__num-main2">30</span>件
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="block3__search-link matchHeight">
            <div class="table">
              <div class="table-cell cf">
                <div class="link-1">
                  <a id="testlink" href="#">詳細検索</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<?php
$mapid = 'mapArea2';
$lat_init = 35.681236;
$lng_init = 139.767125;

// query args
$post_map_area = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
);

// // 特集テーマ
// global $post_map_sp;
// // 投稿件数だけ無限大に
// $post_map_sp['posts_per_page'] = -1;
?>

<script>
jQuery(function($) {
  $(function(){
    var markerMapArea = [];
    // var marker;
    /*
     * TOPページ
    */
    // 遅延読み込み部分
    var mapAreaDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( '<?php echo $mapid; ?>', mapLatLng, 10.0 );
      var disp_num = 2;
      var query_args = <?php echo json_encode($post_map_area); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'mapSimpleSearchFunc',
            'query_args' : query_args,
            'mapid'     : '<?php echo $mapid; ?>',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#<?php echo $mapid; ?>').myLazyLoadingObj({
      callback : mapAreaDone,
    });

    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });
  });
});
</script>


<section class="mt-xs-70 pb-xs-50">
  <div class="container">
    <h2 class="title-1 mb-xs-15">
      <span class="title-1__inner">
        <span class="title-1__main">
          史跡の一覧
        </span>
      </span>
    </h2>
    <?php
    $args = array(
      'post_type' => 'landmark',
      'posts_per_page' => -1
    );
    $the_query = new WP_Query( $args );
    ?>
    <?php if ($the_query->have_posts()): ?>
      <ul class="row mt-xs-15">
        <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
          <?php $mapid='mapArea'; // GoogleMapを読み込む要素を指定 ?>
          <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>記事の投稿がありません。</p>
    <?php endif; ?>
    <?php wp_reset_query(); ?>
  </div>
</section>
<section>
<?php
// global $post_map_sp;
$landmark_id_arr = array();
$get_feature_id  = get_theme_mod( 'top_special_select_1', false );
$get_feature_ttl = get_theme_mod( 'top_special_text_1', false );
if( $get_feature_id ) {
  $select_feature_post = get_posts( array('post_type'=>'feature', 'include'=>$get_feature_id,) );
  // var_dump($select_feature_post[0]);
  $map_center = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_center', true );
  $map_zoom   = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_zoom', true );
  // feature_posts
  $landmark_posts = SCF::get('scf_feature_posts', $select_feature_post[0]->ID);
  // var_dump($landmark_posts[0]['scf_feature_posts_post']);
  $landmark_id_arr = $landmark_posts[0]['scf_feature_posts_post'];
}
$post_map_sp = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
);
// 結合
$post_map_sp = !empty($landmark_id_arr) ? array_merge( $post_map_sp, array('post__in'=> $landmark_id_arr) ) : $post_map_sp;
// var_dump($post_map_sp);
$the_query = new WP_Query( $post_map_sp );
?>
<?php if ($the_query->have_posts() && $get_feature_id): ?>
  <?php $mapid='mapAreaSp'; // GoogleMapを読み込む要素を指定 ?>
  <?php get_template_part('parts/feature'); ?>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
</section>

<hr class="line1"></hr>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>