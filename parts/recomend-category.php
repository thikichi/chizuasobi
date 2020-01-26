<?php
global $osfw;
?>
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
              $cat_thumb_id    = $osfw->get_term_cfield($tax_slug, $tax->term_id, 'acf_landmark_cateogry_thumb');
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