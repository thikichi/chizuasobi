<?php
global $osfw;
$gmap_url = 'https://www.google.com/maps/search/?api=1';
// https://www.google.com/maps/search/?api=1&query=35.6812362,139.7649361
?>
<section class="mt-xs-50">
  <div class="tab-switch">
    <nav>
      <div class="container">
        <ul class="tab-1 cf">
          <li class="tab-switch-nav _active">
            <a href="#">
              <span>
                注目の記事
              </span>
            </a>
          </li>
          <li class="tab-switch-nav">
            <a href="#">
              <span>
                特集一覧
              </span>
            </a>
          </li>
          <li class="tab-switch-nav">
            <a href="#">
              <span>
                新着情報
              </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="tabcontent-1">
      <div class="tabcontent-1-inner pb-xs-70">
        <div class="container">
          <div class="tabcontent-1-main pt-xs-30 pb-xs-30">
            <ul>
              <li class="tab-switch-content _active">
                <?php
                $args = array(
                  'post_type' => 'landmark',
                  'posts_per_page' => 5,
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'status',
                      'field' => 'slug',
                      'terms' => 'attention',
                    ),
                  ),
                );
                $the_query = new WP_Query( $args );
                ?>
                <?php if ($the_query->have_posts()): ?>
                  <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                    <?php
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
                  <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
              </li><!-- tab -->
              <li class="tab-switch-content">
                <?php
                $args = array(
                  'post_type' => 'feature',
                  'posts_per_page' => 5,
                );
                $the_query = new WP_Query( $args );
                if ($the_query->have_posts()): ?>
                  <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
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
                          foreach ($landmark_posts[0]['scf_feature_posts_post'] as $landmark_post_id) {
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
                              <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
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
                  <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
                <div class="btn-1">
                  <a href="<?php echo $osfw->get_archive_link('feature'); ?>">特集記事の一覧 <i class="fas fa-angle-double-right"></i></a>
                </div>
              </li><!-- tab -->
              <li class="tab-switch-content">
                <div class="box-1 cf mb-xs-15">
                  <?php
                  $args = array(
                    'post_type' => 'news',
                    'posts_per_page' => 10,
                  );
                  $the_query = new WP_Query( $args );
                  if ($the_query->have_posts()): ?>
                    <ul class="list-2">
                      <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                        <li>
                          <div class="list-2-box">
                            <span class="_sub"><?php the_time('Y.m.d'); ?></span>
                            <span class="_main">
                              <?php
                              $tax = 'newscategory'; // タクソノミー名
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
                              <a href="<?php the_permalink(); ?>" class="hover-underline">
                                <?php echo $osfw->get_excerpt_filter( get_the_title(), 30, ' … [続きを読む]', get_the_permalink() ); ?>
                              </a>
                              <span class="_small block">
                                <?php echo $osfw->get_excerpt_filter( get_the_title(), 30, ' … ' ); ?>
                              </span>
                            </span>
                          </div>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  <?php else: ?>
                    <p>記事の投稿がありません。</p>
                  <?php endif; ?>
                  <?php wp_reset_query(); ?>
                </div>
                <div class="btn-1">
                  <a href="<?php echo $osfw->get_archive_link('news'); ?>">新着記事の一覧 <i class="fas fa-angle-double-right"></i></a>
                </div>
              </li><!-- tab -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>