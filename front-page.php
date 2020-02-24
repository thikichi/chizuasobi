<?php get_header(); ?>

<?php
$landmarks = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
?>

<section id="MapSimpleSearchSec" class="gmap-all">
  <div class="container"> 
    <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">史跡を地図で検索</span></h2>
    <div id="MapSimpleSearch" class="gmap-all__map-area" style="position: relative; overflow: hidden"></div>
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
  <?php get_template_part('parts/feature'); ?>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
</section>

<section class="courselist mt-xs-50 mt-md-70">
  <div class="courselist__container">
    <div class="courselist__inner">
      <h2 class="title-1 mb-xs-15 mb-md-30">
        <span class="title-1__inner">
          <span class="title-1__main">
            おすすめコース巡りのコ～ナー
          </span>
        </span>
      </h2>
      <div class="courselist__read">
        <p class="courselist__read-inner">
         管理人が選んだおすすめの散策コースをご紹介します。<br>
          徒歩で手軽に巡り歩けるコースが中心です。
        </p>
      </div>
      <?php get_template_part( 'parts/contentPosts', 'course' ); ?>
    </div>
  </div>
</section>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>