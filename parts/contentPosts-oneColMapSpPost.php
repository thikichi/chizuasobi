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
    <div class="box-1-map matchHeight">
      <?php
      // この投稿にひもづく史跡の一覧を取得
      $landmark_id_arr = array();
      // feature_posts
      $landmark_posts = SCF::get('scf_feature_posts', $post->ID);
      // var_dump($landmark_posts[0]['scf_feature_posts_post']);
      foreach ((array)$landmark_posts[0]['scf_feature_posts_post'] as $landmark_post_id) {
        $landmark_id_arr[] = $landmark_post_id;
      }
      // 投稿オブジェクトを単体で取得
      $post_single = get_posts( array(
        'post_type'=>'landmark',
        'include'=>$landmark_id_arr,
      ) );
      $gmap = get_post_meta( $post->ID, 'acf_feature_map_center', true );
      $zoom = get_post_meta( $post->ID, 'acf_feature_map_zoom', true );
      $zoom = $zoom!='' ? $zoom : 6;
      // 経度・緯度・ズーム率
      $location = array('lat' => $gmap['lat'], 'lng' => $gmap['lng'], 'zoom' => $zoom);
      // GoogleMapのフィールド、所在地のフィールド
      $field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
      // style
      $style = 'height:135px;width:135px';
      // 無料の地図アプリを呼び出す
      echo get_openLayers_map( 'mapAreaTab_' . $post->ID , $location, '', $style );
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