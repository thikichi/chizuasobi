<?php
global $osfw;
?>
<div class="box-1 box-1-3col cf mb-xs-15">
  <div class="box-1-inner cf">
    <div class="box-1-thumb matchHeight">
      <?php
      $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
      if( $img!='' ) {
        echo $osfw->the_image_tag( $img );
      } else {
        echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-135.jpg" alt="">';
      }
      ?>
    </div>
    <div class="box-1-main matchHeight">
      <div class="box-1-text">
        <h3 class="subttl-1">
          <?php the_title(); ?> 
          <p class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></p>
        </h3>
        <p class="mt-xs-5"><?php echo $osfw->get_excerpt_filter( get_the_excerpt(), 50, ' [...記事の詳細へ]', get_the_permalink()); ?></p>
        <?php
        $tax = 'feature_cateogry'; // タクソノミー名
        $terms = get_the_terms($post->ID, $tax);
        if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
          echo '<ul class="taglist-1 cf mt-xs-10">';
          foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->term_id, $tax );
            echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
          }
          echo '</ul>';
        }
        ?>
      </div>
    </div>
    <div class="box-1-btn matchHeight">
      <div class="box-1-btnBottom" style="height:100%">
        <a class="link-1" id="HandleMap-<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
          <span class="link-color-1">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
          </span>
        </a>
      </div>
    </div>
  </div>
  <div class="box-1-bottom">
    <?php
    $tax = 'landmark_cateogry'; // タクソノミー名
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