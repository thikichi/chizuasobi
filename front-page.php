<?php get_header(); ?>

<?php
$landmarks = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
?>

<div class="gmap-all">
  <div class="container"> 
    <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">Google Mapで検索</span></h2>
    <div id="mapArea" class="gmap-all__map-area" style="position: relative; overflow: hidden"></div>
  </div>
</div>

<section class="mt-xs-15">
  <div class="container">
    <h2 class="title-1 mt-xs-15 mb-xs-15">
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


<?php
$landmark_id_arr = array();
$get_feature_id  = get_theme_mod( 'top_special_select_1', false );
$get_feature_ttl = get_theme_mod( 'top_special_text_1', false );

if( $get_feature_id ) {
  $select_feature_post = get_posts( array('post_type'=>'feature', 'include'=>$get_feature_id,) );
  $map_center = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_center', true );
  $map_zoom   = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_zoom', true );
  // feature_posts
  $landmark_posts = SCF::get('scf_feature_posts', $select_feature_post[0]->ID);
  // var_dump($landmark_posts[0]['scf_feature_posts_post']);
  foreach ($landmark_posts[0]['scf_feature_posts_post'] as $landmark_post_id) {
    $landmark_id_arr[] = $landmark_post_id;
  }
}
$post_map_sp = array(
  'post_type' => 'landmark',
  'posts_per_page' => 6,
);
// 結合
$post_map_sp = !empty($landmark_id_arr) ? array_merge( $post_map_sp, array('include'=> $landmark_id_arr) ) : $post_map_sp;
$the_query = new WP_Query( $post_map_sp );
?>
<?php if ($the_query->have_posts() && $get_feature_id): ?>
  <section class="block5 mt-xs-30 bgColor-lightGray">
    <div class="container">
      <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
        <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
          <?php echo $get_feature_ttl; ?><br>
          『 <?php echo $select_feature_post[0]->post_title; ?> 』
        </h3>
        <div class="inner-normal">
          <div class="text-normal">
            <?php echo nl2br($select_feature_post[0]->post_content); ?>
          </div>
          <div class="mt-xs-15">
            <div id="mapAreaSp" style="width:100%;height:350px"></div>
          </div>
          <ul class="list-1 row mt-xs-30">
            <?php $i=1; while($the_query->have_posts()) : $the_query->the_post(); ?>
              <?php get_template_part( 'parts/contentPosts','threeColBox' ); ?>
            <?php $i++; endwhile; ?>
          </ul>
          <div class="btn-1">
            <a href="<?php echo $osfw->get_archive_link('feature'); ?>">その他の特集記事の一覧 <i class="fas fa-angle-double-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>