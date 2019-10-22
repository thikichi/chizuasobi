<?php
global $osfw;
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
          <a class="link-1" data-mapid="<?php the_ID(); ?>" href="#mapArea">
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
  </div><!-- .box-1 -->
</li>
