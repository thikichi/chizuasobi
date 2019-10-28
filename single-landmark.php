<?php get_header(); ?>

<?php if (have_posts()): ?>
  <?php the_post(); ?>
  <section id="SingleMain">
    <div class="container">
      <h2 class="ttl-2">
        <i class="fas fa-map-marker-alt"></i> 
        <?php the_title(); ?>
      </h2>
      <div class="box4 mt-xs-30">
        <div class="box4-thumb">
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
          // mapID、投稿オブジェクト、MAP中心
          the_google_map_disp('mapSingleMain', $single_post, $map_center, $field_params, $style);
          ?>
        </div>
        <div class="box4-main">
          <div class="box4-main-inner">
            <div class="box4-list">
              <?php
              $tax = 'landmark_cateogry'; // タクソノミー名
              // $terms = get_terms( array('taxonomy'=>$tax,'get'=>'all' ) );
              $terms = get_the_terms($post->ID, $tax);
              if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
                echo '<ul class="taglist-2">';
                foreach ( $terms as $term ) {
                  $term_link = get_term_link( $term->term_id, $tax );
                  echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                }
                echo '</ul>';
              } else {
              }
              ?>
              <ul class="list1">
                <?php
                if ( is_object_in_term($post->ID, 'landmark_cateogry','castle') ) {
                  $field_arr = array(
                    array( 'name' => 'acf_landmark_address', 'label' => '所在地', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_category', 'label' => '種類', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_anothername', 'label' => '別名', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_age', 'label' => '年代', 'type'=>'text' ),
                    // 城　
                    array( 'name' => 'acf_castle_anothername', 'label' => '城の別名', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_category', 'label' => '城の種類', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_chikujyosha', 'label' => '築城者', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_age', 'label' => '城の年代', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_jyoshu', 'label' => 'おもな城主', 'type'=>'text' ),
                  );
                  foreach ($field_arr as $field) {
                    # code...
                    if($field['type']==='text') {
                      $fvalue = get_post_meta( $post->ID, $field['name'], true );
                      if($fvalue!='') {
                        echo '<li>';
                        echo '<dl class="dlList1">';
                        echo '<dt class="dlList1__item--label">' . $field['label'] . '</dt>';
                        echo '<dd class="dlList1__item--value">' . $fvalue . '</dd>';
                        echo '</dl>';
                        echo '</li>';
                      }
                    }
                  }
                }
                ?>
              </ul>
              <div class="box4-text mt-xs-30">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>


<section class="block5 mt-xs-30 bgColor-lightGray">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
      <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
        史跡「<?php the_title(); ?>」の写真一覧
      </h3>
      <div class="inner-normal">
        <ul class="gallery1">
          <?php
          $photo_arr = SCF::get('scf_landmark_gallery');
          foreach ($photo_arr as $photo) {
            # code...
            $img_250 = $osfw->get_thumbnail( $photo['scf_landmark_gallery_img'], 'img_square_250', 'https://placehold.jp/3d4070/ffffff/750x750.png' );
            $img_500 = $osfw->get_thumbnail( $photo['scf_landmark_gallery_img'], 'img_square_500', 'https://placehold.jp/3d4070/ffffff/750x750.png' );
            echo '<li class="gallery1__item">';
            echo '<a class="gallery1__item-link" href="' . $img_500['src'] . '">';
            echo '<img class="gallery1__item-image" src="' . $img_250['src'] . '" 
             srcset="' . $img_250['src'] . ' 1x, 
             ' . $img_500['src'] . ' 2x"
             alt="">';
            echo '<span class="gallery1__item-icon _icon"><i class="fas fa-search"></i></span>';
            echo '</a>';
            echo '</li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</section>



<section class="block5">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50 border-solid">
      <div class="block5-ttl inner-narrow underline-solid align-center">
        <h3 class="font-noto-serif-jp text-24 ">
          『<?php the_title(); ?>』と同じカテゴリーの史跡一覧
        </h3>
        <div class="align-center">
          <p class="mt-xs-5 mb-xs-5">関連カテゴリー</p>
          <?php echo $term_ttl; ?>
        </div>
      </div>
      <div class="inner-normal">
      <div class="mt-xs-15">
        <div id="mapCats" class="gmap-main"></div>
      </div>
      <div class="tab-switch tab-2 mt-xs-30">
      <?php
      if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
        echo '<ul class="tab-2-list">';
        foreach ( $terms as $term ) {
          $term_link = get_term_link( $term->term_id, $tax );
          $class_val = $term===reset($terms) ? 'tab-switch-nav _active' : 'tab-switch-nav';
          echo '<li class="' . $class_val . '"><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
        }
        echo '</ul>';
      }
      ?>
      <?php
      if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
        echo '<ul>';
        foreach ( $terms as $term ) {
          $term_link = get_term_link( $term->term_id, $tax );
          $class_val = $term===reset($terms) ? 'tab-switch-content _active' : 'tab-switch-content';
          echo '<li class="' . $class_val . '">';
          ?>
          <p class="mt-xs-30">カテゴリーが「城・城址」である投稿の一覧です。</p>
          <?php
          $args = array(
            'post_type' => 'landmark',
            'posts_per_page' => 5,
            'tax_query' => array(
              array(
                'taxonomy' => 'landmark_cateogry',
                'field' => 'id',
                'terms' => array( $term->term_id )
              ),
            ),
          );
          $the_query = new WP_Query( $args );
          if ($the_query->have_posts()): ?>
            <ul class="row mt-xs-15">
              <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                <?php $mapid='mapCats'; // GoogleMapを読み込む要素を指定 ?>
                <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p>記事の投稿がありません。</p>
          <?php endif; ?>
          <?php wp_reset_query(); ?>
        <?php }} ?>
      </div>
    </div>
  </div>
</section>









<?php
$related_sites = SCF::get('related_sites');
if( $related_sites[0]['scf_landmark_relatedsites_siteurl']!='' ): ?>
  <section class="block5 bgColor-lightGray">
    <div class="container">
      <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
        <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
          他に『<?php the_title(); ?>』を紹介しているサイトの一覧
        </h3>
        <ul class="list2 mt-xs-15">
          <?php foreach ($related_sites as $related_site): ?>
            <?php
            $site_title = esc_html( $related_site['scf_landmark_relatedsites_sitetitle'] );
            $site_url   = esc_url( $related_site['scf_landmark_relatedsites_siteurl'] );
            $quot       = esc_html( $related_site['scf_landmark_relatedsites_quotations'] );
            $explain    = esc_html( $related_site['scf_landmark_relatedsites_explain'] );
            // サイト名
            if( !empty($related_site['scf_landmark_relatedsites_website']) ) {
              $post_id = $related_site['scf_landmark_relatedsites_website'][0];
              $site = get_posts( array( 'post_type'=>'website', 'include'=>$post_id ) );
              $site_name = $site[0]->post_title;
            } else {
              $site_name = $site_title;
            }
            ?>
            <li class="list2-item">
              <h4 class="text-18"><?php echo $site_title; ?></h4>
              <?php if( $site_url ): ?>
                <q class="quote1-link" cite="<?php echo $site_url; ?>">
                  <a class="link-color-1" href="<?php echo $site_url; ?>" target="_blank">
                    <?php echo $site_url; ?> <i class="fas fa-external-link-alt"></i>
                  </a>
                </q>
              <?php endif; ?>
              <?php if( $explain ): ?>
                <p class="mt-xs-10"><?php echo $explain; ?></p>
              <?php endif; ?>

              <?php if( $quot ): ?>
                <blockquote class="quote1-main" cite="http://www.example.com/kusamakura.html">
                  <?php echo esc_textarea($quot); ?>
                </blockquote>
              <?php endif; ?>
              <?php if( $site_name ): ?>
                <p class="quote1-ttl">
                  引用元『<?php echo $site_name; ?>』より抜粋
                </p>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>
<?php endif; ?>





<section class="block5 mt-xs-30 bgColor-lightGray">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
      <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
        『<?php the_title(); ?>』周辺の史跡一覧
      </h3>
      <div class="inner-normal">
        <p class="text-16">
          周辺に存在する史跡一覧です。
        </p>
        <?php
        /* 初期値 */
        $distance = 10;
        // 中心の投稿の地図情報

        $post_map_zoom   = get_post_meta( $post->ID, 'acf_landmark_zoom', true );
        $marker_data_arr = array();
        ?>

        <div id="mapDistSearch" style="width: 100%;height: 500px"></div>
        
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
          <ul class="row mt-xs-15 fadeIn-1">
          </ul>
          <p id="DispPostMore" style="display:none">さらに表示する</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="block5 mt-xs-30 bgColor-lightGray">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
      <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
        『<?php the_title(); ?>』周辺地域のホテル・旅館の一覧
      </h3>
      <div class="inner-normal">
        <p class="text-16">他に『日本の100名城』と同じテーマに属する記事を掲載しています。<br>
          下のマップアイコンを選択するか、スライダーからお好きな記事を選択してください。<br>
          スライダーを指定して指定の距離範囲内のランドマークを表示
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
          <?php foreach ($xml->Hotel as $hotel): ?>
            <li>
              <div class="layout3-slider-box">
                <div class="layout3-thumb" style="background-image:url(<?php echo $hotel->PictureURL; ?>)">
                </div>
                <div class="layout3-hoverBox">
                  <h3><?php echo $hotel->HotelName; ?></h3>
                  <p>
                    <?php echo $hotel->HotelCatchCopy; ?>
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
          <?php endforeach; ?>
        </ul>
      </div>

    </div>
  </div>
</section>

<div class="mt-xs-15">
  <?php get_template_part('parts/tab-content'); ?>
</div>

<?php get_footer(); ?>