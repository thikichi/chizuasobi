<?php
global $markers;
global $osfw;
global $mapid;

if( is_post_type_archive('landmark') ) {
  $map_posts = get_posts( array( 
    'post_type'=>'landmark', 
    'posts_per_page'=>-1,
  ));
} else {
  $qobj = $queried_object = get_queried_object();
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
}

$markers = array();
// var_dump($map_posts);
$i=0;
foreach ($map_posts as $map_post) {
  $acf_landmark_gmap = get_post_meta( $map_post->ID, 'acf_landmark_gmap', true );
  $acf_landmark_address = get_post_meta( $map_post->ID, 'acf_landmark_address', true );
  $terms = get_the_terms($map_post->ID, 'landmark_cateogry');
  // var_dump($terms);
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
  $post_map_img = isset($temp_img['src']) ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
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

<section class="block5">
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        <?php echo $osfw->get_archive_title(); ?>
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>

        <div id="ArchiveLandmarkMap" class="mb-xs-15 mt-xs-15">
          <div id="ArchiveLandmarkMapMain" class="gmap-all__map-area mt-xs-15" style="position: relative; overflow: hidden"></div>
        </div><!-- SearchFormMap -->

        <?php if(have_posts()): ?>
          <ul class="mt-xs-30 row">
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

        <div class="align-center">
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