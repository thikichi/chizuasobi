<?php
global $osfw;
$address = get_post_meta( $post->ID, 'acf_landmark_address', true );
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
    <div class="box-1-map matchHeight">
      <!-- <img src="https://placehold.jp/750x750.png" alt=""> -->
      <?php
      // 投稿オブジェクトを単体で取得
      $post_single = get_posts( array( 'post_type'=>'landmark', 'include'=>$post->ID ) );
      $gmap = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
      $zoom = get_post_meta( $post->ID, 'acf_landmark_zoom', true );
      $zoom = $zoom!='' ? $zoom : 6;
      // 経度・緯度・ズーム率
      $location = array('lat' => $gmap['lat'], 'lng' => $gmap['lng'], 'zoom' => $zoom);
      // GoogleMapのフィールド、所在地のフィールド
      $field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
      // style
      $style = 'height:135px;width:135px';
      // 無料の地図アプリを呼び出す
      echo get_openLayers_map( 'mapAreaTab2_' . $post->ID , $location, '', $style );
      ?>
    </div>
    <div class="box-1-main matchHeight">
      <div class="box-1-text">
        <h3 class="subttl-1">
          <?php the_title(); ?> 
          <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
        </h3>
        <p class="mt-xs-5"><?php echo esc_html($address); ?></p>
        <p class="mt-xs-5"><?php echo $osfw->get_excerpt_filter( get_the_excerpt(), 50, ' [...記事の詳細へ]', get_the_permalink()); ?></p>
      </div>
    </div>
    <div class="box-1-btn matchHeight">
      <div class="box-1-btnTop">
        <?php
        $param = '&query=' . $gmap['lat'] . ',' . $gmap['lng'];
        $gmap_url .= $param;
        ?>
        <a href="<?php echo esc_url($gmap_url); ?>" target="_blank">
          <span class="link-color-1">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">大きな地図</span>
          </span>
        </a>
      </div>
      <div class="box-1-btnBottom">
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