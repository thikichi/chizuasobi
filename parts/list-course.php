<?php
global $markers;
global $osfw;
global $mapid;
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

        <?php if(have_posts()): ?>
          <ul class="block2__list mt-xs-30">
            <?php // $markers = array(); // Marker Object ?>
            <?php $i=0; while(have_posts()) : the_post(); ?>
              <?php get_template_part( 'parts/contentPosts', 'twoColNoMap' ); ?>
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