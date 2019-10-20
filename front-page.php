<?php get_header(); ?>

<?php
$landmarks = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
?>

<div id="MapMain" class="gmap-main-wrapper">
  <div class="bg-green" style="height:300px">
    <div class="container"> 
      <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">Google Mapで検索</span></h2>

<?php
// 経度・緯度・ズーム率
$map_center = array(35.681236,139.767125,13);
// GoogleMapのフィールド、所在地のフィールド
$field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
// mapID、投稿オブジェクト、MAP中心
the_google_map_disp('mapArea', $landmarks, $map_center, $field_params);
?>

    </div>
  </div>
</div>

<section class="mt-xs-50">
  <div class="container">
    <h2 class="ttl-2">
      <i class="fas fa-map-marker-alt"></i> 
      史跡の一覧
      <!-- <span class="ttl-2-small">検索条件 : 城 / 日本の城 / 史跡</span> -->
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
      <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
    <?php endwhile; ?>
  </ul>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
  </div>
  <div class="btn-1">
    <a href="<?php echo $osfw->get_archive_link('landmark'); ?>">記事の一覧 <i class="fas fa-angle-double-right"></i></a>
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
$args = array(
  'post_type' => 'landmark',
  'posts_per_page' => 6,
);
// 結合
$args = !empty($landmark_id_arr) ? array_merge( $args, array('include'=> $landmark_id_arr) ) : $args;
$the_query = new WP_Query( $args );
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
      <?php
      // 経度・緯度・ズーム率
      $map_center2 = array($map_center['lat'], $map_center['lng'], $map_zoom);
      // GoogleMapのフィールド、所在地のフィールド
      $field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
      // mapID、投稿オブジェクト、MAP中心
      $map_posts = get_posts( $args );
      the_google_map_disp('mapAreaSp', $map_posts, $map_center2, $field_params);
      ?>
    </div>
    <ul class="list-1 row mt-xs-30">
      <?php $i=1; while($the_query->have_posts()) : $the_query->the_post(); ?>
        <li class="col-md-4 matchHeight mb-xs-15">
          <div class="box-2">
            <?php if( $i > 5 ) { echo '<a class="_nextlink hover-nonUnderline" href="#"><span>さらに記事を見るには<br>こちらをクリック！</span></a>'; } ?>
            <h3 class="box-2-subttl">
              <span class="box-2-subttl-num"><?php echo $i; ?></span>
              <span class="box-2-subttl-main"><?php the_title(); ?> <a href="#mapAreaSp" id="HandleMap-mapAreaSp-<?php the_ID(); ?>" class="link-color-1 text-12">[地図を見る]</a></span>
            </h3>
            <div class="box-2-main">
              <div class="box-2-main-inner">
                <div class="box-2-main-thumb">
                  <?php
                  $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
                  if( $img!='' ) {
                    echo $osfw->the_image_tag( $img );
                  } else {
                    echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
                  }
                  ?>
                </div>
                <div class="box-2-main-text">
                  <p>
                    <?php
                    if( $i > 5 ) {
                      echo $osfw->get_excerpt_filter( get_the_excerpt(), 30, '');
                    } else {
                      echo $osfw->get_excerpt_filter( get_the_excerpt(), 30, ' ...[続きを読む]', get_the_permalink() );
                    }
                    ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </li>
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