<?php get_header(); ?>

<?php if (have_posts()): ?>
  <?php the_post(); ?>
  <section id="SingleMain">
    <div class="container">
      <h2 class="ttl-2 font-noto-serif-jp">
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
            echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
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
                    array( 'name' => 'acf_castle_category', 'label' => '種類', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_anothername', 'label' => '別名', 'type'=>'text' ),
                    array( 'name' => 'acf_castle_age', 'label' => '年代', 'type'=>'text' ),
                  );
                  foreach ($field_arr as $field) {
                    # code...
                    if($field['type']==='text') {
                      $fvalue = get_post_meta( $post->ID, $field['name'], true );
                      if($fvalue!='') {
                        echo '<li>';
                        echo '<dl class="dlList1">';
                        echo '<dt>' . $field['label'] . '</dt>';
                        echo '<dd>' . $fvalue . '</dd>';
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


<section class="block5 mt-xs-30 bgColor-lightGray ">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
      <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
        他に『<?php the_title(); ?>』を紹介しているサイトの一覧
      </h3>
      <ul class="list2 mt-xs-15">
        <li class="list2-item">
          <h4 class="text-18">サイト名</h4>
          <q class="quote1-link" cite="https://www.osakacastle.net/">
            <a class="link-color-1" href="https://www.osakacastle.net/" target="_blank">
              https://www.osakacastle.net/
            </a>
          </q>
          <p class="mt-xs-10">ここにサイトの説明がはいります。</p>
          <blockquote class="quote1-main" cite="http://www.example.com/kusamakura.html">
          特別展　「幕末・維新の人とことば」の詳細が決まりました
          平成30年10月6日（土）～11月25日（日）
          昨年と今年は、徳川慶喜による大政奉還の表明、王政復古の大号令による新政府発足、新政府軍と旧幕府軍による内戦「戊辰戦争」の勃発という、明治維新の一連の大変革からちょうど150年にあたります。そこで本展では、この激動の時代に活躍した人物を取り上げ、残された書や手紙などを手がかりに、彼らの人間像に迫りたいと思います。
          </blockquote>
          <p class="quote1-ttl">
            引用元『大阪城天守閣』より抜粋
          </p>
        </li>
        <li class="list2-item">
          <h4 class="text-18">サイト名</h4>
          <q class="quote1-link" cite="https://www.osakacastle.net/">
            <a class="link-color-1" href="https://www.osakacastle.net/" target="_blank">
              https://www.osakacastle.net/
            </a>
          </q>
          <p class="mt-xs-10">ここにサイトの説明がはいります。</p>
          <blockquote class="quote1-main" cite="http://www.example.com/kusamakura.html">
          特別展　「幕末・維新の人とことば」の詳細が決まりました
          平成30年10月6日（土）～11月25日（日）
          昨年と今年は、徳川慶喜による大政奉還の表明、王政復古の大号令による新政府発足、新政府軍と旧幕府軍による内戦「戊辰戦争」の勃発という、明治維新の一連の大変革からちょうど150年にあたります。そこで本展では、この激動の時代に活躍した人物を取り上げ、残された書や手紙などを手がかりに、彼らの人間像に迫りたいと思います。
          </blockquote>
          <p class="quote1-ttl">
            引用元『大阪城天守閣』より抜粋
          </p>
        </li>
        <li class="list2-item">
          <h4 class="text-18">サイト名</h4>
          <q class="quote1-link" cite="https://www.osakacastle.net/">
            <a class="link-color-1" href="https://www.osakacastle.net/" target="_blank">
              https://www.osakacastle.net/
            </a>
          </q>
          <p class="mt-xs-10">ここにサイトの説明がはいります。</p>
          <blockquote class="quote1-main" cite="http://www.example.com/kusamakura.html">
          特別展　「幕末・維新の人とことば」の詳細が決まりました
          平成30年10月6日（土）～11月25日（日）
          昨年と今年は、徳川慶喜による大政奉還の表明、王政復古の大号令による新政府発足、新政府軍と旧幕府軍による内戦「戊辰戦争」の勃発という、明治維新の一連の大変革からちょうど150年にあたります。そこで本展では、この激動の時代に活躍した人物を取り上げ、残された書や手紙などを手がかりに、彼らの人間像に迫りたいと思います。
          </blockquote>
          <p class="quote1-ttl">
            引用元『大阪城天守閣』より抜粋
          </p>
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="mt-xs-50">
  <div class="container">
    <div class="inner">
      <h2 class="ttl-4">
        <span>カテゴリーが同じである投稿の一覧</span>
      </h2>
      <?php
      $tax = 'landmark_cateogry';
      $terms = get_the_terms($post->ID, $tax);
      $term_ttl = '';
      $term_arr = array();
      foreach ($terms as $term) {
        $term_arr[] = $term->term_id;
        $term_ttl  .= $term->name . ' / ';
      }
      // var_dump($term_arr);
      $relative_posts = get_posts( array( 
        'post_type'=>'landmark', 
        'tax_query' => array( 
          array(
            'taxonomy' => 'landmark_cateogry', //タクソノミーを指定
            'field' => 'term_id', //ターム名をスラッグで指定する
            'terms' => $term_arr,
          ),
        ),
       ));
      ?>
      <p class="mt-xs-15">
        関連カテゴリー：<?php echo $term_ttl; ?>
      </p>
      <div class="mt-xs-15">
      <?php
      // 経度・緯度・ズーム率
      $map_center_cat = array(35.681236,139.767125,7);
      // GoogleMapのフィールド、所在地のフィールド
      $field_params = array( 'gmap' => 'acf_landmark_gmap', 'address' => 'acf_landmark_address');
      // mapID、投稿オブジェクト、MAP中心
      the_google_map_disp('mapCats', $relative_posts, $map_center_cat, $field_params);
      ?>
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
          ?>
          <?php if ($the_query->have_posts()): ?>
            <div class="box3 mt-xs-30">
              <span class="pcmoveto" data-pcmoveto="pcmoveto-1" id="spmoveto-1">
                <!-- SP時に内容が移動  -->
              </span>
              <div class="box3-sub">
                <?php
                $img = $osfw->get_thumbnail_by_post( $post->ID, 'img_square' );
                if( $img!='' ) {
                  echo $osfw->the_image_tag( $img );
                } else {
                  echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-750.jpg" alt="">';
                }
                ?>
                <a href="#">
                  [ <img class="_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg">  地図を見る ]
                </a>
              </div>
              <div class="box3-main">
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
                <div class="quote1 mt-xs-5">
                  <h3 class="box3-ttl ttl1"><?php the_title(); ?></h3>
                  <p class="mt-xs-15">
                    <?php echo $osfw->get_excerpt_filter( get_the_content(), 200, ' ...[続きを読む]', get_the_permalink() ); ?>
                  </p>
                </div>
              </div>
            </div>
          <?php else: ?>
            <p>記事の投稿がありません。</p>
          <?php endif; ?>
          <?php wp_reset_query(); ?>
          <?php
          echo '</li>';
        }
        echo '</ul>';
      }
      ?>
    </div>
  </div>
</section>

<section class="mt-xs-50">
  <div class="container-1170">
    <h2 class="ttl-4">
      <span>ギャラリー</span>
    </h2>
    <div class="mt-xs-30">
      <ul class="gallery1">
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
        <li>
          <a href="#">
            <img src="https://placehold.jp/3d4070/ffffff/750x750.png" alt="">
            <span class="_icon"><i class="fas fa-search"></i></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</section>


<?php
$acf_landmark_gmap = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
var_dump($acf_landmark_gmap);

// $url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&s_area=162612&count=1&xml_ptn=2";

$lat = $acf_landmark_gmap['lat']; // 経度
$lng = $acf_landmark_gmap['lng']; // 緯度
$jx = ceil(($lng * 1.000106961 - $lat * 0.000017467 - 0.004602017) * 3600000);
$jy = ceil(($lat * 1.000083049 + $lng * 0.000046047 - 0.010041046) * 3600000);


$url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&x=" . $jx . "&y=" . $jy . "&range=50";
// $url = "http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=leo16d0c4beac1&x=125754539&y=488255756&range=10&count=1";

$xml = @simplexml_load_file($url);
  // var_dump($url);
  // foreach ($xml->Hotel as $hotel) { 
  # code...
  // echo '<table border="2">';
  // echo '<tr>';
  // echo '<th>ホテルID</th>';
  // echo '<td>' . $hotel->HotelID . '</td>';
  // echo '</tr>';
  // echo '<tr>';
  // echo '<th>ホテル名</th>';
  // echo '<td>' .  $hotel->HotelName . '</td>';
  // echo '</tr>';
  // echo '<tr>';
  // echo '<th>郵便番号</th>';
  // echo '<td>' . $hotel->PostCode . '</td>';
  // echo '</tr>';
  // echo '</table>';
  // }
?>


<section id="Special" class="mt-xs-50 layout2 bg-lightGray" style="padding-bottom:120px">
  <div class="container-1170">
    <div class="layout2-inner">
      <h2 class="ttl-5 font-noto-serif-jp text-24 align-center">
        <span>
          周辺地域のお宿一覧
        </span>
      </h2>
      <p class="text-16 mt-xs-30">他に『日本の100名城』と同じテーマに属する記事を掲載しています。<br>
        下のマップアイコンを選択するか、スライダーからお好きな記事を選択してください。<br>
        スライダーを指定して指定の距離範囲内のランドマークを表示
      </p>
      <div class="layout3-map mt-xs-30">


<?php
// mapID、投稿オブジェクト、MAP中心
$style = 'width:100%;height:350px;margin-top:10px';
the_google_map_disp_m('mapSingleHotel', $xml->Hotel, $post->ID, $style);
?>

      </div>
      <ul class="layout3-slider mt-xs-20">
        <?php foreach ($xml->Hotel as $hotel): ?>
          <li>
            <div class="layout3-slider-box">
              <div style="background-image:url(<?php echo $hotel->PictureURL; ?>);background-repeat:no-repeat;background-size:cover;width:100%;height:230px">
              </div>
              <div class="layout3-hoverBox">
                <h3><?php echo $hotel->HotelName; ?></h3>
                <p>
                  <?php echo $hotel->HotelCatchCopy; ?>
                </p>
                <div class="btn-2">
                  <a class="link-1" href="#Gmap-<?php echo $hotel->HotelID; ?>" id="HandleMap-mapSingleHotel-<?php echo $hotel->HotelID; ?>">地図を見る</a>
                </div>
                <div class="btn-2 _red">
                  <a href="<?php echo $hotel->HotelDetailURL; ?>" target="_blank">ホテルの詳細へ</a>
                </div>
              </div>
            </div><!-- .layout3-slider-box -->
          </li>
        <?php endforeach; ?>
      </ul>
      <script type="text/javascript">
      jQuery(function($) {
        $(document).ready(function(){
          $('.layout3-slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            prevArrow: '<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/arrow-left.svg" class="slide-arrow prev-arrow">',
            nextArrow: '<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/arrow-right.svg" class="slide-arrow next-arrow">',
            responsive: [
              {
                breakpoint: 991,
                settings: {
                  slidesToShow: 4,
                  centerMode: false,
                }
              },
              {
                breakpoint: 767,
                settings: {
                  slidesToShow: 3,
                  centerMode: true,
                }
              },
              {
                breakpoint: 575,
                settings: {
                  slidesToShow: 2,
                  centerMode: true,
                }
              }
            ],
          });
        });
      });
      </script>
    </div>
  </div>
</section>


<div style="margin-top: -100px;">
<?php get_template_part('parts/tab-content'); ?>
</div>







<?php get_footer(); ?>