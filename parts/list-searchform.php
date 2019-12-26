<?php
global $csearch;
global $osfw;
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

<section class="block5">
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        史跡・絞り込み検索
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>

        <form class="sform" action="<?php echo $osfw->get_page_link( 'sform' ); ?>" method="GET">
          <?php $csearch->setup_form(); ?>
          <div class="sform__main">
            <div class="sform__row cf">
              <div class="sform__col-label">
                都道府県
              </div>
              <div class="sform__col-main">
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
                  'class'       => 'sform__checkbox',
                  'id'          => 'SFormPrefecture',
                );
                echo $csearch->form_checkbox_tax_tags( $args );
                ?>
              </div>
            </div><!-- .sform__row -->

            <div class="sform__row">
              <div class="sform__col-label">
                史跡の種類
              </div>
              <div class="sform__col-main">
                <?php
                $args = array(
                  'taxonomy'    => 'landmark_cateogry',
                  'operator'    => 'IN',
                  'is_counter'  => false,
                  'is_label_front' => false,
                  'srch_label'  => '史跡の種類',
                  'vertical'    => false,
                  'is_counter' => true,
                  'class'       => 'sform__checkbox',
                  'id'          => 'SFormPrefecture',
                  'gloup'      => 'GLOUP1',
                );
                echo $csearch->form_checkbox_tax_tags( $args );
                ?>
              </div>
            </div><!-- .sform__row -->

            <div class="sform__row">
              <div class="sform__col-label">
                記事カテゴリー
              </div>
              <div class="sform__col-main">
                <?php
                $args = array(
                  'taxonomy'    => 'status',
                  'operator'    => 'IN',
                  'is_counter'  => false,
                  'is_label_front' => false,
                  'srch_label'  => '記事カテゴリー',
                  'vertical'    => false,
                  'is_counter' => true,
                  'class'       => 'sform__checkbox',
                  'id'          => 'SFormPostCategory',
                  'gloup'      => 'GLOUP1',
                );
                echo $csearch->form_checkbox_tax_tags( $args );
                ?>
              </div>
            </div><!-- .sform__row -->

            <div class="sform__row">
              <div class="sform__col-label">
                見どころレベル
              </div>
              <div class="sform__col-main">
                <?php
                /* セレクトボックス出力 （ カスタムフィールド「所在地」 ） */
                $args = array(
                  'srch_label' => '見どころレベル',
                  'key' => 'acf_landmark_level',
                  'class' => 'sform__selectbox',
                  'id'    => 'SFormLevel',
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
            </div><!-- .sform__row -->
            <div class="align-center mt-xs-15">
              <?php $csearch->form_input_reset( 'リセット', '/sform/', '', 'button__1--reset' ); ?>
              <input type="submit" class="button__1--submit" value="送信">
            </div>
          </div>
        </form>

        <section id="SFormMap" class="mb-xs-15">
          <div class="sform-map">

            <?php /* 検索実行 */ ?>
            <?php $the_query = $csearch->set_search_query(); ?>
            <?php /* 検索結果の件数と検索対象ワードを表示 */ ?>
            <div class="sform__sword">
              <?php $search_count = $csearch->get_search_count(); ?>
              <p class="mb-xs-5">検索件数 ： 全 <?php echo $search_count['all_num']; ?> 件中 <?php echo $search_count['get_num']; ?> を表示</p>
              <p class="mb-xs-15">選択ワード： <?php echo $csearch->get_search_query(); ?> </p>
              <div id="mapSearch" class="gmap-all__map-area mt-xs-15" style="position: relative; overflow: hidden;width:100%"></div>
            </div>
          </div>
        </section><!-- SFormMap -->


        <section class="sform__result">
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


      </div>
    </div>
  </div>
</section>


<section class="block7">
  <div class="block7__container">
    <div class="block7__inner">
      <h2 class="block7-ttl">
        他におすすめのカテゴリー
      </h2>
      <div class="block7__boxmain">
        <div class="block7__lead">
          他にもおすすめのカテゴリーがあります。
        </div>

        <div class="block-7__main">
          <ul class="block-7__list">
            <?php
            $tax_slug = 'landmark_cateogry';
            $tax_arr = get_terms( array( 'taxonomy'=>$tax_slug, 'exclude'=>$term_id ) );
            // var_dump($tax_arr);
            foreach ($tax_arr as $key => $tax):
              $tax_description = term_description( $tax->term_id, $tax_slug );
              $tax_description = $osfw->get_excerpt_filter( $tax_description, 30, $more_text=' [...]');
              $cat_thumb_id    = $osfw->get_term_cfield($tax_slug, $tax->term_id, 'acf_landmark_cateogry_image');
              $term_link = get_term_link( $tax->term_id, $tax_slug );
              // var_dump($cat_thumb_id);
              ?>
              <li class="block-7__item">
                <div class="block-7__box">
                  <a href="<?php echo $term_link; ?>" class="box-7__link">
                    <div class="list-7__thumb">
                      <?php
                      $cat_thumb_l = $osfw->get_thumbnail( $cat_thumb_id, 'img_square_500', 'https://placehold.jp/3d4070/ffffff/1500x1500.png' );
                      $cat_thumb_s = $osfw->get_thumbnail( $cat_thumb_id, 'img_square_250', 'https://placehold.jp/3d4070/ffffff/250x250.png' );
                      echo '<img src="' . $cat_thumb_s['src'] . '" srcset="' . $cat_thumb_s['src'] . ' 1x, ' . $cat_thumb_l['src'] . ' 2x" alt="' . $cat_thumb['alt'] . '">';
                      ?>
                    </div>
                    <div class="list-7__main">
                      <h3 class="list-7__title-main"><?php echo $tax->name; ?></h3>
                      <p class="list-7__excerpt"><?php echo $tax_description; ?></p>
                    </div>
                  </a>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div>
    </div>
  </div>
</section>