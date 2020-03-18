<?php
global $osfw;
?>
<div class="box4 mt-xs-30">
  <div style="position:relative">
    <div id="Landmark_<?php echo $post->ID; ?>" style="position:absolute;top:-200px"></div>
  </div>
  <div class="box4-thumb">
    <div class="box4-thumb__photo">
      <?php
      $img = $osfw->get_thumbnail_by_post( $post->ID, 'img_square' );
      if( $img!='' ) {
        echo $osfw->the_image_tag( $img );
      } else {
        echo '<img loading="lazy" src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
      }
      $map_center = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
      $map_zoom   = get_post_meta( $post->ID, 'acf_landmark_zoom', true );
      $single_post = get_posts( array( 'post_type'=>'landmark', 'include'=>$post->ID ) );
      // 経度・緯度・ズーム率
      $map_center = array($map_center['lat'], $map_center['lng'], $map_zoom);
      // GoogleMapのフィールド、所在地のフィールド
      $field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
      $style = 'width:100%;height:270px;margin-top:10px';
      ?>
    </div>
    <div class="box4-thumb__map mt-xs-10">
      <?php
      $gmap_iframe = get_post_meta( $post->ID, 'acf_googlemap_iframe', true );
      if( $gmap_iframe!='' ) {
        echo $gmap_iframe;
      } 
      ?>
    </div>
  </div>
  <div class="box4-main">
    <div class="box4-main-inner">
      <div class="mb-xs-15"><?php echo do_shortcode('[addtoany]'); ?></div>
      <div class="box4-list">
        <?php
        $tax = 'landmark_cateogry'; // タクソノミー名
        $terms = get_the_terms($post->ID, $tax);
        if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
          echo '<ul class="taglist-1 cf">';
          foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->term_id, $tax );
            echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
          }
          echo '</ul>';
        }
        ?>
        <?php
        $tax = 'landmark_tag'; // タクソノミー名
        $terms = get_the_terms($post->ID, $tax);
        if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
          echo '<ul class="taglist-1 taglist-1--red cf mt-xs-5">';
          foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->term_id, $tax );
            echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
          }
          echo '</ul>';
        }
        ?>
        <?php /* カテゴリーのリスト */ ?>
        <?php get_template_part( 'parts/items-cat' ); ?>

        <?php
        $castle_feetext = get_field('acf_castle_feetext');
        ?>
        <div class="box4-content mt-xs-30">
          
          <?php if( $castle_feetext['overview'] ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">概要</h3>
              <p class="box4-content__textarea">
                <?php echo nl2br($castle_feetext['overview']); ?>
              </p>
            </div>
          <?php endif; ?>

          <?php
          $relationplace = get_field('relationplace');
          if ( isset($relationplace) && $relationplace!='' ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">見どころ</h3>
              <?php $i=0; ?>
              <div class="box4__highlight-wrapper">
                <?php $i=0; foreach ($relationplace as $place):
                  // photo
                  if( $place['photo']!='' ) {
                    $temp_img = wp_get_attachment_image_src( $place['photo'] , 'img_square_w100' );
                    $img_url = $temp_img[0];
                  } else {
                    $img_url   = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
                  }
                  ?>
                  <dl class="box4__highlight" style="position:relative">
                    <a id="mapRelationArticle_<?php echo $i; ?>" style="position:absolute;top:-100px"></a>
                    <dt class="box4__highlight-ttl"><?php echo $place['title']; ?>
                    <?php if( is_singular('landmark') ): ?>
                      【 <a href="javascript:mapRelationClick('mapRelation_<?php echo $i; ?>')">地図</a> 】
                    <?php endif; ?>
                    </dt>
                    <dd class="box4__highlight-main">
                      <div class="box4__highlight-photo">
                        <img src="<?php echo esc_url($img_url); ?>">
                      </div>
                      <div class="box4__highlight-text">
                        <p class="box4__highlight-textarea">
                         <?php echo nl2br($place['textarea']); ?>
                        </p>
                        <?php if( $place['quote'] ):
                          foreach ($place['quote'] as $quote): ?>
                            <blockquote class="infwin__blockquote" cite="<?php echo esc_url($quote['url']); ?>">
                            <p class="infwin__blockquote-text">
                              <?php echo $osfw->get_excerpt_filter( $quote['textarea'], 100, '...続きを読む', $quote['url'], '_blank' ); ?>
                            </p>
                            <cite class="infwin__blockquote-cite">
                              <?php
                              $tag  = '';
                              $tag .= $quote['site_name'];
                              if($quote['page_title']) $tag .= '『' . $quote['page_title'] . '』';
                              echo $tag;
                              ?>
                            </cite>
                            </blockquote>
                          <?php endforeach;
                        endif; ?>
                      </div>
                    </dd>
                  </dl>
                <?php $i++; endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if( $castle_feetext['history'] ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">歴史</h3>
              <p class="box4-content__textarea">
                <?php echo nl2br($castle_feetext['history']); ?>
              </p>
            </div>
          <?php endif; ?>

          <?php if( $castle_feetext['access'] ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">交通情報</h3>
              <p class="box4-content__textarea">
                <?php echo nl2br($castle_feetext['access']); ?>
              </p>
            </div>
          <?php endif; ?>

          <?php if( $castle_feetext['other'] ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">その他</h3>
              <p class="box4-content__textarea">
                <?php echo nl2br($castle_feetext['other']); ?>
              </p>
            </div>
          <?php endif; ?>

          <?php
          $nenpyo_arr = get_field('acf_nenpyo');
          if ( isset($nenpyo_arr) && $nenpyo_arr!='' ): ?>
            <div class="box4-content__sec">
              <h3 class="box4-content__subttl">歴史年表</h3>
              <ul class="box4-content__list">
                <?php foreach ($nenpyo_arr as $nenpyo): ?>
                  <li class="box4-content__item">
                    <span class="box4-content__item-text box4-content__item-text--left">
                      <?php echo esc_html($nenpyo['seireki']); ?>
                    </span>
                    <span class="box4-content__item-text box4-content__item-text--center">
                      （<?php echo esc_html($nenpyo['wareki']); ?>）
                    </span>
                    <span class="box4-content__item-text box4-content__item-text--right">
                      <?php echo esc_html($nenpyo['dekigoto']); ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
        <div class="box4-text mt-xs-30 mb-xs-15">
          <?php the_content(); ?>
        </div>
        <div class="fb-comments" data-href="http://localhost/chizuasobi/" data-width="100%" data-numposts="5"></div>
      </div>
    </div>
  </div>
</div>