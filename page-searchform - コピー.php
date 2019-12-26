<?php get_header(); ?>

<?php
// 投稿タイプを指定
$csearch->set_post_type('landmark');
// 投稿タイプを指定
$csearch->set_is_freeword_tax_field( true );
// タクソノミーのグルーピングした項目の関係
$csearch->set_tax_query_relation_gloup( array('GLOUP1' => 'OR') ); 
// タクソノミー同士の関係
echo $csearch->set_query_relation( 'taxonomy', 'AND' );
// 記事件数
$csearch->set_posts_per_page(10);
?>

<section id="SearchForm" class="searchform1 mb-xs-15">
  <div class="container">
    <form class="searchform1__inner" action="<?php echo $csearch->get_action_url('/searchform/'); ?>" method="GET">
      <?php $csearch->setup_form(); ?>
      <h2 class="searchform1__title">
        史跡・絞り込み検索
      </h2>
      <div class="searchform1__main">
        <div class="searchform1__row cf">
          <div class="searchform1__col--label">
            都道府県
          </div>
          <div class="searchform1__col--main">
            <?php
            // タクソノミー「都道府県」をチェックボックスで出力する
            $args = array(
              'taxonomy'    => '_prefecture',
              'operator'    => 'IN',
              'is_counter'  => false,
              'is_label_front' => false,
              'srch_label'  => '都道府県',
              'vertical'    => false,
              'is_counter' => true,
              'class'       => 'searchform1__checkbox',
              'id'          => 'SearchFormPrefecture',
            );
            echo $csearch->form_checkbox_tax_tags( $args );
            ?>
          </div>
        </div><!-- .searchform1__row -->

        <div class="searchform1__row">
          <div class="searchform1__col--label">
            史跡の種類
          </div>
          <div class="searchform1__col--main">
            <?php
            $args = array(
              'taxonomy'    => 'landmark_cateogry',
              'operator'    => 'IN',
              'is_counter'  => false,
              'is_label_front' => false,
              'srch_label'  => '史跡の種類',
              'vertical'    => false,
              'is_counter' => true,
              'class'       => 'searchform1__checkbox',
              'id'          => 'SearchFormPrefecture',
              'gloup'      => 'GLOUP1',
            );
            echo $csearch->form_checkbox_tax_tags( $args );
            ?>
          </div>
        </div><!-- .searchform1__row -->

        <div class="searchform1__row">
          <div class="searchform1__col--label">
            記事カテゴリー
          </div>
          <div class="searchform1__col--main">
            <?php
            $args = array(
              'taxonomy'    => 'status',
              'operator'    => 'IN',
              'is_counter'  => false,
              'is_label_front' => false,
              'srch_label'  => '記事カテゴリー',
              'vertical'    => false,
              'is_counter' => true,
              'class'       => 'searchform1__checkbox',
              'id'          => 'SearchFormPostCategory',
              'gloup'      => 'GLOUP1',
            );
            echo $csearch->form_checkbox_tax_tags( $args );
            ?>
          </div>
        </div><!-- .searchform1__row -->

        <div class="searchform1__row">
          <div class="searchform1__col--label">
            見どころレベル
          </div>
          <div class="searchform1__col--main">
            <?php
            /* セレクトボックス出力 （ カスタムフィールド「所在地」 ） */
            $args = array(
              'srch_label' => '見どころレベル',
              'key' => 'acf_landmark_level',
              'class' => 'searchform1__selectbox',
              'id'    => 'SearchFormLevel',
              'values' => array(
                '5' => '★★★★★',
                '4' => '★★★★',
                '3' => '★★★',
                '2' => '★★',
                '1' => '★',
              ),
              'compare' => 'LIKE',
              'type' => 'CHAR',
              'is_counter' => true, // ※ フィールドの値と完全に一致している必要があります
            );
            echo $csearch->form_selectbox_customfield_tags( $args );
            ?>
          </div>
        </div><!-- .searchform1__row -->
        <div class="align-center mt-xs-15">
          <?php $csearch->form_input_reset( 'リセット', '/searchform/', '', 'button__1--reset' ); ?>
          <input type="submit" class="button__1--submit" value="送信">
        </div>
      </div>
    </form>
  </div>
</section>


<section id="SearchFormMap" class="mb-xs-15">
  <div class="container">
    <div class="searchform-map">
      <?php /* 検索実行 */ ?>
      <?php $the_query = $csearch->set_search_query(); ?>
      <?php /* 検索結果の件数と検索対象ワードを表示 */ ?>
      <?php $search_count = $csearch->get_search_count(); ?>
      <p class="mb-xs-5">検索件数 ： 全 <?php echo $search_count['all_num']; ?> 件中 <?php echo $search_count['get_num']; ?> を表示</p>
      <p class="mb-xs-15">選択ワード： <?php echo $csearch->get_search_query(); ?> </p>
      <div id="mapSearch" class="gmap-all__map-area mt-xs-15" style="position: relative; overflow: hidden"></div>
  </div>
</section><!-- SearchFormMap -->


<section id="SearchFormResult" class="mb-xs-50 mb-md-70">
  <div class="container">
    <div class="searchform-result">
      <?php if ( $the_query && $the_query->have_posts() ) : ?>
        <ul class="row mt-xs-15">
          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <!-- ここから記事の出力 -->
            <?php $mapid='mapSearch'; // GoogleMapを読み込む要素を指定 ?>
            <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
          <!-- ここまで記事の出力 -->
          <?php endwhile; ?>
        </ul>
        <?php /* ページネーション */ ?>
        <?php $csearch->get_search_pagenation(); ?>
      <?php endif; ?>
      <?php /* リセット */ ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<?php
$post_map_area = $csearch->get_subquery_args();
$lat_init = 35.681236;
$lng_init = 139.767125;
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
    var mapSearchDone = function() {
      var markerData = [];
      var mapLatLng = getCenerLatLng( <?php echo $lat_init; ?>, <?php echo $lng_init; ?> );
      var map = initMap( 'mapSearch', mapLatLng, 10.0 );
      var query_args = <?php echo json_encode($post_map_area); ?>;
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
            'action'     : 'get_wp_posts_map',
            'query_args' : query_args,
            'map_id'     : 'mapSearch',
          },
          success: function( response ){
            jsonData = JSON.parse( response );
            markerData = jsonData['markerDataAjax'];
            markerMapArea = dispMarker2( map, markerData );
          }
      });
    }
    $('#mapSearch').myLazyLoadingObj({
      callback : mapSearchDone,
    });
    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });
  });
});
</script>


<?php get_footer(); ?>