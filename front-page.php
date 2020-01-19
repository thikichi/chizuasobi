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
              <?php
              $lcat_arr = get_terms( array('taxonomy'=>'landmark_cateogry','hide_empty'=>false) );
              if ( ! empty( $lcat_arr ) && !is_wp_error( $lcat_arr ) ){
                echo '<select data-setcategory="landmark_cateogry" name="landmark_cateogry" class="block3__form-select search-hook-select">';
                echo '<option value="">種類で探す</option>';
                foreach ( $lcat_arr as $term ) {
                  echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
            <div class="block3__search-box">
              <?php
              $lcat_arr = get_terms( array('taxonomy'=>'historical_person','hide_empty'=>false) );
              if ( ! empty( $lcat_arr ) && !is_wp_error( $lcat_arr ) ){
                echo '<select data-setcategory="historical_person" name="historical_person" class="block3__form-select search-hook-select">';
                echo '<option value="">人物で探す</option>';
                foreach ( $lcat_arr as $term ) {
                  echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
            <div class="block3__search-box">
              <select data-setfield="acf_landmark_level" name="acf_landmark_level" class="block3__form-select search-hook-select">
                <option value="">見どころレベル</option>
                <option value="5">5 : 星５つ [ ★★★★★ ] 以上</option>
                <option value="4">4 : 星４つ [ ★★★★ ] 以上</option>
                <option value="3">3 : 星３つ [ ★★★ ] 以上</option>
                <option value="2">2 : 星２つ [ ★★ ] 以上</option>
                <option value="1">1 : 星１つ [ ★ ] 以上</option>
              </select>
            </div>
          </div>
          <div class="block3__search-sub matchHeight">
            <div class="table">
              <div class="table-cell cf">
                <p class="block3__num">
                  件数
                  <span class="block3__num-main">
                    <span id="MapSimpleSearchNum" class="block3__num-main2" data-count="0">0</span>件
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
// $post_map_area = array(
//   'post_type' => 'landmark',
//   'posts_per_page' => -1,
// );

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


<section class="mt-xs-70 pb-xs-50">
  <div class="container">
    <h2 class="title-1 mb-xs-15">
      <span class="title-1__inner">
        <span class="title-1__main">
          史跡の一覧
        </span>
      </span>
    </h2>
    <ul class="row mt-xs-15" id="MapSimpleSearchPost"></ul>
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