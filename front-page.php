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

<?php
$field = array();
$field['Coordinate'] = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$field['address']    = get_post_meta( $post->ID, 'acf_landmark_address', true );
?>

      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <?php
              $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
              if( $img!='' ) {
                echo $osfw->the_image_tag( $img );
              } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
              }
              ?>
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  <?php the_title(); ?> 
                  <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
                </h3>
                <p class="mt-xs-5"><?php echo esc_html($field['address']); ?></p>
                <?php
                $tax = 'landmark_cateogry'; // タクソノミー名
                // $terms = get_terms( array('taxonomy'=>$tax,'get'=>'all' ) );
                $terms = get_the_terms($post->ID, $tax);
                if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
                  echo '<ul class="taglist-1 cf mt-xs-10">';
                  foreach ( $terms as $term ) {
                    $term_link = get_term_link( $term->term_id, $tax );
                    echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                  }
                  echo '</ul>';
                } else {
                }
                ?>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a class="link-1" id="HandleMap-mapArea-<?php the_ID(); ?>" href="#mapArea">
                  <span class="link-color-1">
                    <img class="_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> 
                    <span class="_linkText box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a class="link-1" href="<?php the_permalink(); ?>">
                  <span class="link-color-1">
                    <img class="_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> 
                    <span class="_linkText box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <?php
            $tax = 'landmark_cateogry'; // タクソノミー名
            // $terms = get_terms( array('taxonomy'=>$tax,'get'=>'all' ) );
            $terms = get_the_terms($post->ID, $tax);
            if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
              echo '<ul class="taglist-1 cf mt-xs-10">';
              foreach ( $terms as $term ) {
                $term_link = get_term_link( $term->term_id, $tax );
                echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
              }
              echo '</ul>';
            } else {
            }
            ?>
          </div>
        </div><!-- .box-1 -->
      </li>
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
$select_feature_post_id = 89; // 選択した特集記事
$select_feature_post = get_posts( array('post_type'=>'feature', 'include'=>$select_feature_post_id,) );
$map_center = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_center', true );
$map_zoom   = get_post_meta( $select_feature_post[0]->ID, 'acf_feature_map_zoom', true );
// feature_posts
$landmark_posts = SCF::get('scf_ feature_posts', $select_feature_post[0]->ID);
// var_dump($landmark_posts[0]['scf_ feature_posts_post']);
$landmark_id_arr = array();
foreach ($landmark_posts[0]['scf_ feature_posts_post'] as $landmark_post_id) {
  $landmark_id_arr[] = $landmark_post_id;
}
$args = array(
  'post_type' => 'landmark',
  'posts_per_page' => 3,
  'include'=> $landmark_id_arr,
);
$the_query = new WP_Query( $args );
?>
<?php if ($the_query->have_posts()): ?>


<section class="mt-xs-50 bg-img-1 pb-xs-50 bt-s pt-xs-50">
  <div class="container">
    <h2 class="ttl-3">
      <span class="ttl-3-sub">今月の特集テーマ</span>
      <span class="ttl-3-main mml-char"><?php the_title(); ?></span>
    </h2>
    <div class="text-normal mt-xs-30">
      <?php the_content(); ?>
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
    <ul class="row mt-xs-30">
      <?php $i=1; while($the_query->have_posts()) : $the_query->the_post(); ?>
        <li class="col-md-4 matchHeight">
          <div class="box-2">
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
                    <?php echo $osfw->get_excerpt_filter( get_the_excerpt(), 30, ' ...[続きを読む]', get_the_permalink() ); ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </li>
      <?php $i++; endwhile; ?>
    </ul>
  </div>
  <div class="btn-1">
    <a href="<?php echo $osfw->get_archive_link('landmark'); ?>">記事の一覧 <i class="fas fa-angle-double-right"></i></a>
  </div>
</section>

<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>



<?php get_template_part('parts/tab-content'); ?>




<?php get_footer(); ?>