<?php get_header(); ?>

<div class="container align-center mt-xs-30">
  <ul class="nav-pagelink">
    <li class="nav-pagelink__item">
      <a href="#Siseki">史跡紹介</a>
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
      <a href="#HotelList">周辺地域の祝初施設一覧</a>
    </li>
  </ul>
</div>


<?php if (have_posts()): ?>
  <?php the_post(); ?>
  <section id="SingleMain" class="pb-xs-50">
    <div style="position: relative;">
      <div id="Siseki" style="position:absolute;top:-50px"></div>
    </div>
    <div class="container">
      <h2 class="title-1 mt-xs-15 mb-xs-15">
        <!--  <i class="fas fa-map-marker-alt"></i>  -->
        <span class="title-1__inner">
          <span class="title-1__sub">
            Edo Castle
          </span>
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
            <div class="box4-list">
              <?php /* カテゴリーのリスト */ ?>
              <?php get_template_part( 'parts/items-cat' ); ?>
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


<hr class="line1"></hr>



<section class="block5">
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        史跡「<?php the_title(); ?>」の写真一覧
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>
        <?php
        $gallery_id_arr = get_post_meta( $post->ID, 'acf_gallery', true );
        if( $gallery_id_arr ) {
          echo '<ul class="gallery mt-xs-30">';
          foreach ($gallery_id_arr as $gallery_id) {
            $img_1x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w300' );
            $img_2x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w750' );
            echo '<li class="gallery__item">';
            echo '<img src="' . esc_url($img_1x['src']) . '" srcset="' . esc_url($img_1x['src']) . ' 1x, ' . esc_url($img_2x['src']) . ' 2x" alt="' . esc_url($img_2x['alt']) . '">';
            echo '</li>';
          }
          echo '</ul>';
        }
        ?>
      </div>
    </div>
  </div>
</section>

<hr class="line1"></hr>

<section class="block5">
  <div style="position: relative;">
    <div id="SameCat" style="position:absolute;top:-50px"></div>
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
          <div id="mapCats" class="gmap-main"></div>
        </div>
        <div class="mt-xs-15">

    <?php
    $main_cat_id = get_post_meta( $post->ID, 'acf_landmark_main_category', true );
    $args = array(
      'post_type' => 'landmark',
      'posts_per_page' => -1
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
          <?php $mapid='mapCats'; // GoogleMapを読み込む要素を指定 ?>
          <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>
        <?php endwhile; ?>
      </ul>
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


<?php
$related_sites = SCF::get('related_sites');
if( $related_sites[0]['scf_landmark_relatedsites_siteurl']!='' ): ?>
  <section class="block5 bgColor-lightGray">
    <div style="position: relative;">
      <div id="Shuhen" style="position:absolute;top:-50px"></div>
    </div>
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






<section class="block5">
  <div style="position: relative;">
    <div id="Shuhen" style="position:absolute;top:-50px"></div>
  </div>
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        『<?php the_title(); ?>』周辺の史跡一覧
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            史跡記事の過去のアーカイブです。史跡記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>

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


<hr class="line1"></hr>


<section class="block5">
  <div style="position: relative;">
    <div id="HotelList" style="position:absolute;top:-50px"></div>
  </div>
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        『<?php the_title(); ?>』周辺地域のホテル・旅館の一覧
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
          if( isset($xml->Hotel) && is_array($xml->Hotel) ):
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


<div class="pt-xs-50">
  <?php get_template_part('parts/tab-content'); ?>
</div>

<?php get_footer(); ?>