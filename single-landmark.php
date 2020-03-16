<?php get_header(); ?>

<div class="container align-center mt-xs-30">
  <ul class="nav-pagelink">
    <li class="nav-pagelink__item">
      <a href="#Overview">史跡概要</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#mapRelationWrap">みどころMAP散歩</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Gallery">ギャラリー</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#SameCat">同じカテゴリーの史跡</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Shuhen">周辺の史跡</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#HotelList">周辺地域のホテルの一覧</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Quot">紹介サイトの一覧</a>
    </li>
  </ul>
</div>


<?php if (have_posts()): ?>
  <?php the_post(); ?>
  <section id="SingleMain" class="pb-xs-50">
    <div style="position: relative;">
      <div id="Overview" style="position:absolute;top:-100px"></div>
    </div>
    <div class="container">
      <h2 class="title-1 mt-xs-15 mb-xs-15">
        <!--  <i class="fas fa-map-marker-alt"></i>  -->
        <span class="title-1__inner">
          <?php
          $mainttl_sub = get_post_meta( $post->ID, 'afc_mainttl_sub', true );
          if( $mainttl_sub ): ?>
            <span class="title-1__sub">
              <?php echo esc_html($mainttl_sub); ?>
            </span>
          <?php endif; ?>
          <span class="title-1__main">
            <?php the_title(); ?>
          </span>
        </span>
      </h2>
      <div class="box4 mt-xs-30">
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
          <dt class="box4__highlight-ttl"><?php echo $place['title']; ?>【 <a href="javascript:mapRelationClick('mapRelation_<?php echo $i; ?>')">地図</a> 】</dt>
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
    </div>
  </section>
<?php endif; ?>



<section class="block4">
  <div style="position:relative">
    <div id="mapRelationWrap" style="position:absolute;top:-100px"></div>
  </div>
  <div class="container">
    <div class="block4__main">
      <h3 class="title-2 mb-xs-30">
        『<?php the_title(); ?>』の見どころMAP散歩
      </h3>
      <p class="block4__read mb-xs-15 align-center">「<?php the_title(); ?>」に直接・間接的に関連する施設・名所をご案内します。</p>
      <div class="block4__mappost">
        <div class="block4__mappost-map">
          <div id="mapRelation" class="block4__map"></div>

        </div>
        <div class="block4__mappost-post">
          <div class="block4__mapside">
            <h3 class="block4__mapside-ttl">
              関連史跡を選択
            </h3>
            <ul class="block4__mapside-list"><?php /*ajax出力 */ ?></ul>
          </div>
        </div>
      </div>
      <?php echo marker_size_change_tag(); ?>
      


    </div>
  </div>
</section>


<section class="block4">
  <div style="position:relative">
    <div id="Gallery" style="position:absolute;top:-130px"></div>
  </div>
  <div class="container">
    <div class="block4__main">
      <h3 class="title-2 mb-xs-30">
        史跡『<?php the_title(); ?>』の写真一覧
      </h3>
      <p class="block4__read mb-xs-15 align-center">史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
      各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。</p>
      <?php
      $gallery_id_arr = get_post_meta( $post->ID, 'acf_gallery', true );
      if( $gallery_id_arr ) {
        echo '<ul class="gallery mt-xs-30">';
        foreach ($gallery_id_arr as $gallery_id) {
          $img_1x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w300' );
          $img_2x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w750' );
          echo '<li class="gallery__item">';
          echo '<a href="' . esc_url($img_2x['src']) . '">';
          echo '<img src="' . esc_url($img_1x['src']) . '" srcset="' . esc_url($img_1x['src']) . ' 1x, ' . esc_url($img_2x['src']) . ' 2x" alt="' . esc_url($img_2x['alt']) . '">';
          echo '</a>';
          echo '</li>';
        }
        echo '</ul>';
      }
      ?>
    </div>
  </div>
</section>


<hr class="line1"></hr>


<section class="block5">
  <div style="position: relative;">
    <div id="SameCat" style="position:absolute;top:-110px"></div>
  </div>
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        メインのカテゴリーが『<?php the_title(); ?>』と同じ史跡の一覧
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>

        <div class="mt-xs-15">
          <div style="position:relative">
            <div id="mapSamecatWrap" style="position:absolute;top:-100px"></div>
          </div>
          <div id="mapSamecat" class="gmap-main"></div>
        </div>
        <div class="mt-xs-15">
          <?php
          $main_cat_id = get_post_meta( $post->ID, 'acf_landmark_main_category', true );
          $args = array(
            'post_type' => 'landmark',
            'posts_per_page' => 10
          );
          $temp_cat_ids = get_the_terms( $post->ID, 'landmark_cateogry' );
          if($main_cat_id) {
            $args = array_merge( $args, array('tax_query'=>array(array('taxonomy' => 'landmark_cateogry','field' => 'id','terms' => array( $main_cat_id )))));
          } else if($temp_cat_ids[0]->term_id) {
            $args = array_merge( $args, array('tax_query'=>array(array('taxonomy' => 'landmark_cateogry','field' => 'id','terms' => array( $temp_cat_ids[0]->term_id )))));
          }
          $the_query = new WP_Query( $args );
          ?>
          <?php if ($the_query->have_posts()): ?>
            <ul class="row mt-xs-15">
              <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                <?php // $mapid='mapSamecat'; // GoogleMapを読み込む要素を指定 ?>
                <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
              <?php endwhile; ?>
            </ul>
            <?php button('landmark'); ?>

          <?php else: ?>
            <p>記事の投稿がありません。</p>
          <?php endif; ?>
          <?php wp_reset_query(); ?>
        </div>
      </div>
    </div>
  </div>
</section>


<hr class="line1"></hr>


<section class="block5">
  <div style="position: relative;">
    <div id="Shuhen" style="position:absolute;top:-100px"></div>
  </div>
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        『<?php the_title(); ?>』周辺の史跡一覧
      </h2>
      <div class="block5__boxmain" style="position:relative">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
          
        </p>
        <div id="mapDistSearchLocation" style="position:absolute;top:-100px"></div>
        <?php
        /* 初期値 */
        $distance = 10;
        // 中心の投稿の地図情報

        $post_map_zoom   = get_post_meta( $post->ID, 'acf_landmark_zoom', true );
        $marker_data_arr = array();
        ?>
        <div id="mapDistSearch" class="mt-xs-15" style="width: 100%;height: 500px">
        </div>
        
        <?php
        $all_land_cats = get_terms( array( 'taxonomy'=>'landmark_cateogry', 'get'=>'all' ) );
        foreach ($all_land_cats as $all_land_cat): ?>
          <input class="marker-check" data-termid="<?php echo esc_attr($all_land_cat->term_id); ?>" type="checkbox" value="<?php echo esc_attr($all_land_cat->term_id); ?>" checked>
          <?php echo esc_html($all_land_cat->name); ?>
        <?php endforeach; ?>
        <select id="MarkerSelectDist">
          <option value="1000000" data-zoom="5.0">1000km以下</option>
          <option value="900000" data-zoom="5.0">900km以下</option>
          <option value="800000" data-zoom="6.0">800km以下</option>
          <option value="700000" data-zoom="6.0">700km以下</option>
          <option value="600000" data-zoom="6.0">600km以下</option>
          <option value="500000" data-zoom="6.0">500km以下</option>
          <option value="400000" data-zoom="7.0">400km以下</option>
          <option value="300000" data-zoom="7.0">300km以下</option>
          <option value="200000" data-zoom="8.0">200km以下</option>
          <option value="100000" data-zoom="9.0">100km以下</option>
          <option value="50000" data-zoom="10.0">50km以下</option>
          <option value="20000" data-zoom="11.0">20km以下</option>
          <option value="10000" data-zoom="12.0">10km以下</option>
          <option value="5000" data-zoom="13.0" selected>5km以下</option>
          <option value="2500" data-zoom="14.0">2.5km以下</option>
          <option value="1000" data-zoom="15.0">1.0km以下</option>
        </select>
        <p id="PostNum" class="fadeIn-1" style="display:none">記事件数: <span class="_allnum"></span> 件中 <span class="_getnum"></span>件表示</p>
        <div id="DispPost" data-mainpostid="<?php echo $post->ID; ?>" class="mt-xs-30 align-center">
          <ul class="row mt-xs-15 fadeIn-1"></ul>
          <p id="DispPostMore" style="display:none">さらに表示する</p>
        </div>

      </div>
    </div>
  </div>
</section>


<hr class="line1"></hr>


<section class="block5">
  <div style="position: relative;">
    <div id="HotelList" style="position:absolute;top:-80px"></div>
  </div>
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        『<?php the_title(); ?>』周辺地域のホテルの一覧
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            他に『日本の100名城』と同じテーマに属する記事を掲載しています。<br>
          下のマップアイコンを選択するか、スライダーからお好きな記事を選択してください。<br>
          スライダーを指定して指定の距離範囲内のランドマークを表示
          </span>
        </p>

        <?php
        $acf_landmark_gmap = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
        $lat = $acf_landmark_gmap['lat']; // 経度
        $lng = $acf_landmark_gmap['lng']; // 緯度
        $jx = ceil(($lng * 1.000106961 - $lat * 0.000017467 - 0.004602017) * 3600000);
        $jy = ceil(($lat * 1.000083049 + $lng * 0.000046047 - 0.010041046) * 3600000);
        $url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&x=" . $jx . "&y=" . $jy . "&range=50";
        // $url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&x=125754539&y=488255756&range=10&count=1";
        $xml = @simplexml_load_file($url);
        // mapID、投稿オブジェクト、MAP中心
        $style = 'width:100%;height:350px;margin-top:10px';
        the_google_map_disp_m('mapSingleHotel', $xml->Hotel, $post->ID, $style);
        ?>
        <ul class="layout3-slider mt-xs-20">
          <?php
          if( isset($xml->Hotel) ):
            foreach ($xml->Hotel as $hotel): ?>
            <li>
              <div class="layout3-slider-box">
                <div class="layout3-thumb" style="background-image:url(<?php echo $hotel->PictureURL; ?>)">
                </div>
                <div class="layout3-hoverBox">
                  <h3><?php echo $hotel->HotelName; ?></h3>
                  <p>
                    <?php echo $hotel->HotelCatchCopy; ?>http://localhost/chizuasobi
                  </p>
                  <div class="btn-2">
                    <a class="link-1" href="#mapSingleHotel" id="HandleMap-mapSingleHotel-<?php echo $hotel->HotelID; ?>">地図を見る</a>
                  </div>
                  <div class="btn-2 _red">
                    <a href="<?php echo $hotel->HotelDetailURL; ?>" target="_blank">ホテルの詳細へ</a>
                  </div>
                </div>
              </div><!-- .layout3-slider-box -->
            </li>
          <?php endforeach;
        endif; ?>
        </ul>
      </div>
    </div>
  </div>
</section>


<hr class="line1"></hr>

<section class="pt-xs-30">
  <div class="container">
    <?php /* 引用のリスト */ ?>
    <?php get_template_part( 'parts/items-quot' ); ?>
  </div>
</section>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>