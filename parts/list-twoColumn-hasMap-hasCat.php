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
  $mapid = 'ArchiveLandmarkMapMain';
  // thumbnail
  $temp_img = $osfw->get_thumbnail_by_post( $map_post->ID, 'img_square' );
  $post_map_img = isset($temp_img['src']) ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';


    // get main category of the landmark_cateogry post.
    $main_cat_id = '';
    $loop_catmain_id = get_post_meta( $map_post->ID, 'acf_landmark_cateogry_main', true );
    // get all taxonomy term list of 'landmark_cateogry' and set main category id
    $get_terms = get_the_terms($map_post->ID, 'landmark_cateogry');
    if( $get_terms!='' && $loop_catmain_id!='' ) {
      foreach ($get_terms as $key => $get_term) {
        if( $get_term->term_id===(int)$loop_catmain_id ) {
          $main_cat_id = $get_term->term_id;
        }
      }
    } else {
      $main_cat_id = $get_terms[0]->term_id;
    }
    // set icon from taxonomy term ID.
    $cat_icon_id = $osfw->get_term_cfield('landmark_cateogry', $main_cat_id, 'acf_landmark_cateogry_icon');
    $cat_icon = $cat_icon_id!='' ? $osfw->get_thumbnail( $cat_icon_id, 'full' ) : '';



  // InfoWindow
  // $infoWin  = '';
  // $infoWin .= "<div id='" . $mapid . "-" . $map_post->ID . "' class='infwin cf' style='position:relative'>";
  // $infoWin .= "<a style='position:absolute;top:-150px'></a>";
  // $infoWin .= "<div class='infwin-thumb'>";
  // $infoWin .= "<img class='img-responsive' src='" . $post_map_img . "'></div>";
  // $infoWin .= "<div class='infwin-main'>";
  // $infoWin .= "<h3>" . $map_post->post_title . "</h3>";
  // $infoWin .= "<p>" . $acf_landmark_address . "</p>";
  // $infoWin .= "<p class='infwin-link'><a href='" . get_the_permalink() . "'>この記事を見る</a></p>";
  // $infoWin .= "</div>";
  // $infoWin .= "</div>";
  // create marker object
  $markers[$i]['id']   = $mapid . "_" . $map_post->ID;
  $markers[$i]['name'] = get_the_title();
  $markers[$i]['lat']  = floatval($acf_landmark_gmap['lat']);
  $markers[$i]['lng']  = floatval($acf_landmark_gmap['lng']);
  $markers[$i]['cat']  = $term_list;
  // $markers[$i]['infoWindowContent'] = $infoWin;
  $markers[$i]['cat_icon'] = isset($cat_icon['src']) ? $cat_icon['src'] : '';
  $markers[$i]['infoWindowContent'] = gmap_infowindow( $map_post->ID, $mapid . "_" . $map_post->ID );
  // $markers[$i]['tags'] .= get_tag_postlist( $map_post->ID, 'landmark_cateogry', $acf_landmark_address );

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

        <?php get_template_part('parts/pagenation-numlist'); ?>

      </div>
    </div>
  </div>
</section>