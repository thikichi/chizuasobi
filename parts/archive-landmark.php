<?php
global $osfw;
$qobj = $queried_object = get_queried_object();
// var_dump($qobj);
$taxonomy = $qobj->taxonomy;
$term_id  = $qobj->term_id;
$map_posts = get_posts( array( 
  'post_type'=>'landmark', 
  'posts_per_page'=>-1,
  'tax_query'      => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $term_id,
      )
    )
));
$markers = array();
// var_dump($map_posts);
$i=0;
foreach ($map_posts as $map_post) {
  $acf_landmark_gmap = get_post_meta( $map_post->ID, 'acf_landmark_gmap', true );
  $acf_landmark_address = get_post_meta( $map_post->ID, 'acf_landmark_address', true );
  $terms = get_the_terms($map_post->ID, 'landmark_cateogry');
  if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
    $term_list = '[';
    foreach ( $terms as $term ) {
      $term_list .= "'" . $term->term_id . "'";
      if ($term !== end($terms)) {
        $term_list .= ',';
      }
    }
    $term_list .= ']';
  }
  $map_id = 'ArchiveLandmarkMapMain';
  // thumbnail
  $temp_img = $osfw->get_thumbnail_by_post( $map_post->ID, 'img_square' );
  $post_map_img = $temp_img['src'] ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
  // InfoWindow
  $infoWin  = '';
  $infoWin .= "<div id='" . $map_id . "-" . $map_post->ID . "' class='infwin cf' style='position:relative'>";
  $infoWin .= "<a style='position:absolute;top:-150px'></a>";
  $infoWin .= "<div class='infwin-thumb'>";
  $infoWin .= "<img class='img-responsive' src='" . $post_map_img . "'></div>";
  $infoWin .= "<div class='infwin-main'>";
  $infoWin .= "<h3>" . $map_post->post_title . "</h3>";
  $infoWin .= "<p>" . $acf_landmark_address . "</p>";
  $infoWin .= "<p class='infwin-link'><a href='" . get_the_permalink() . "'>この記事を見る</a></p>";
  $infoWin .= "</div>";
  $infoWin .= "</div>";
  // create marker object
  $markers[$i]['id']   = $map_id . "_" . $map_post->ID;
  $markers[$i]['name'] = get_the_title();
  $markers[$i]['lat']  = floatval($acf_landmark_gmap['lat']);
  $markers[$i]['lng']  = floatval($acf_landmark_gmap['lng']);
  $markers[$i]['cat']  = $term_list;
  $markers[$i]['infoWindowContent'] = $infoWin;
  $i++;
}
?>

<div class="container">
  <h2 class="ttl-2">
    <i class="fas fa-map-marker-alt"></i> 
    カテゴリー『<?php echo $osfw->get_archive_title(); ?>』の記事一覧
  </h2>
</div>

<section id="ArchiveLandmarkMap" class="mb-xs-15 mt-xs-15">
  <div class="container">
    <div id="ArchiveLandmarkMapMain" class="gmap-all__map-area mt-xs-15" style="position: relative; overflow: hidden"></div>
  </div>
</section><!-- SearchFormMap -->

<section id="ArchiveLandmark" class="mb-xs-50 mb-md-70 mt-xs-15">
  <div class="container">
    <?php if(have_posts()): ?>
      <ul class="row">
        <?php // $markers = array(); // Marker Object ?>
        <?php $i=0; while(have_posts()) : the_post(); ?>
          <?php $mapid=$map_id; ?>
          <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
        <?php $i++; endwhile; ?>
      </ul>
      <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>
    <?php else: ?>
    <?php /* ↓↓ 記事が存在しない場合 ↓↓ */ ?>
      <p>まだ記事の投稿がありません。</p>
    <?php /* ↑↑ 記事が存在しない場合 ↑↑ */ ?>
    <?php endif; ?>
  </div>
</section>

<?php
// ob_start();
// var_dump( json_encode($markers) );
// $out = ob_get_contents();
// ob_end_clean();
// file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);
?>

<div class="align-center mt-xs-15 mb-xs-50 mb-md-70">
<?php
/*
* 投稿一覧系ページで各ページへのリンクを出力
* 例) << 前へ 1 2 3 次へ >>
*/
?>
<?php
the_posts_pagination(array(
  'mid_size' => 3,
  'prev_text' => '&lt;  前',
  'next_text' => '次 &gt;',
  'screen_reader_text' => ' ',
));
?>
</div>


<section class="block-6--bg-lightGray mt-xs-30">
  <div class="container">
    <div class="block-6__inner">
      <h3 class="block-6__ttl">
        他におすすめのジャンル一覧
      </h3>
      <div class="block-6__main">
        <ul class="row">
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
          <li class="block-6__item col-xl-2 col-lg-3 col-xs-6 mb-xs-15 matchHeight">
            <div class="box-7">
              <a href="<?php echo $term_link; ?>" class="box-7__link">
                <div class="list-7__thumb">
                  <?php
                  $cat_thumb_l = $osfw->get_thumbnail( $cat_thumb_id, 'img_square_500', 'https://placehold.jp/3d4070/ffffff/500x500.png' );
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
</section>