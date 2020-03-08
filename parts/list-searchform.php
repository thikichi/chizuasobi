<?php
global $mapid;
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

        <form class="sform" action="<?php echo $osfw->get_page_link( 'searchform' ); ?>" method="GET">
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
              <?php $csearch->form_input_reset( 'リセット', '/searchform/', '', 'button__1--reset' ); ?>
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

              <div style="position:relative">
                <div id="mapSearchformWrap" style="position:absolute;top:-100px"></div>
                <div id="mapSearchform" class="gmap-all__map-area"></div>
              </div>

            </div>
          </div>
        </section><!-- SFormMap -->


        <section class="sform__result">
          <?php if ( $the_query && $the_query->have_posts() ) : ?>
            <ul class="row mt-xs-15">
              <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <!-- ここから記事の出力 -->
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
      </div>
    </div>
  </div>
</section>

<?php get_template_part( 'parts/recomend-category' ); ?>