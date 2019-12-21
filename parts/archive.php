<?php
global $osfw;
?>

<section id="ArchiveLandmark" class="block2 mb-xs-50 mb-md-70 mt-xs-15">
  <div class="block2__container">
    <h2 class="title-1 mt-xs-15 mb-xs-15">
      <span class="title-1__inner">
        <span class="title-1__main">
          <?php echo $osfw->get_archive_title(); ?>
        </span>
      </span>
    </h2>
    <?php if(have_posts()): ?>
      <ul class="block2__list mt-xs-30">
        <?php // $markers = array(); // Marker Object ?>
        <?php $i=0; while(have_posts()) : the_post(); ?>
          <li class="block2__list-item">
            <div class="block2__box">
              <div class="block2__box-inner">
                <div class="block2__thumb matchHeight">
                  <?php
                  $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
                  if( $img!='' ) {
                    echo $osfw->the_image_tag( $img );
                  } else {
                    echo '<img class="block2__thumb-main" src="' . get_stylesheet_directory_uri() . '/images/common/noimage-500.svg' . '" alt="">';
                  }
                  ?>
                </div>
                <div class="block2__main matchHeight">
                  <div class="block2-text">
                    <h3 class="subttl-1">
                      <?php the_title(); ?> 
                      <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
                    </h3>
                    <p class="mt-xs-5">
                      <?php echo $osfw->get_excerpt_filter( get_the_excerpt(), 56, '[...]' );
                      ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="block2__link"><span>記事を読む</span></a>
                  </div>
                </div>
              </div>
            </div><!-- .block2 -->
          </li>
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