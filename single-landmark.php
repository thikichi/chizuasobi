<?php get_header(); ?>

<div class="container">
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
  <section id="SingleMain" class="pb-md-50 pb-xs-30">
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
      <?php get_template_part( 'parts/landmark-data' ); ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </section>
<?php endif; ?>


<?php
$relationplace = get_field('relationplace');
if( $relationplace ):
?>
<section class="block4">
  <div style="position:relative">
    <div id="mapRelationWrap" style="position:absolute;top:-100px"></div>
  </div>
  <div class="container">
    <div class="block4__main">
      <h3 class="title-2 mb-md-30 mb-xs-15">
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
              史跡を選択
            </h3>
            <ul id="mapRelationUL" class="block4__mapside-list"><?php /*ajax出力 */ ?></ul>
          </div>
        </div>
      </div>
      <?php echo marker_size_change_tag(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php
// 選択された「特集記事」の内容
$select_id = get_post_meta( $post->ID, 'acf_select_feature', true );
$feature_post = get_post($select_id);
if( $select_id ):
?>
  <?php /* mapSingleFeature */ ?>
  <section class="block4">
    <div style="position:relative">
      <div id="mapSingleFeatureWrap" style="position:absolute;top:-100px"></div>
    </div>
    <div class="container">
      <div class="block4__main">
        <h3 class="title-2 mb-md-30 mb-xs-15">
          関連記事『<?php echo $feature_post->post_title; ?>』
        </h3>
        <p class="block4__read mb-xs-15 align-center"><?php echo $feature_post->post_content; ?></p>
        <div class="block4__mappost">
          <div class="block4__mappost-map">
            <div id="mapSingleFeature" class="block4__map"></div>
          </div>
          <div class="block4__mappost-post">
            <div class="block4__mapside">
              <h3 class="block4__mapside-ttl">
                史跡を選択
              </h3>
              <ul id="mapSingleFeatureUL" class="block4__mapside-list"><?php /*ajax出力 */ ?></ul>
            </div>
          </div>
        </div>
        <?php echo marker_size_change_tag('chgmarkerMSF'); ?>
      </div>
    </div>
  </section>
<?php endif; ?>


<?php
$gallery_id_arr = get_post_meta( $post->ID, 'acf_gallery', true );
if( $gallery_id_arr ):
?>
<section class="block4">
  <div style="position:relative">
    <div id="Gallery" style="position:absolute;top:-130px"></div>
  </div>
  <div class="container">
    <div class="block4__main">
      <h3 class="title-2 mb-xs-30">
        史跡『<?php the_title(); ?>』の写真一覧
      </h3>
      <?php
      if( $gallery_id_arr ) {
        echo '<ul class="gallery mt-xs-30">';
        foreach ($gallery_id_arr as $gallery_id) {
          $img_1x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w300' );
          $img_2x = $osfw->get_thumbnail( $gallery_id, 'img_normal_w750' );
          echo '<li class="gallery__item">';
          echo '<a href="' . esc_url($img_2x['src']) . '">';
          echo '<img src="' . esc_url($img_1x['src']) . '" srcset="' . esc_url($img_1x['src']) . ' 1x, ' . esc_url($img_2x['src']) . ' 2x" alt="' . $img_1x['alt'] . '" title="' . $img_1x['excerpt'] . '">';
          echo '<p class="gallery__cap">' . $img_1x['title'] . '</p>';
          echo '</a>';
          echo '</li>';
        }
        echo '</ul>';
      }
      ?>
    </div>
  </div>
</section>
<?php endif; ?>


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
    <div id="mapHotelWrap" style="position:absolute;top:-80px"></div>
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
        <div id="mapHotel" class="gmap-main"><?php /* Ajax読み込み */ ?></div>
        <ul id="mapHotelUL" class="layout3-slider mt-xs-20"><?php /*ajax出力 */ ?></ul>
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