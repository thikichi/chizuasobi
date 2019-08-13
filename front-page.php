<?php get_header(); ?>

<?php
$landmarks = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );



      
  
// array(1) {
//   [0]=>
//   object(WP_Post)#5699 (24) {
//     ["ID"]=>
//     int(32)
//     ["post_author"]=>
//     string(1) "0"
//     ["post_date"]=>
//     string(19) "2019-08-03 07:13:31"
//     ["post_date_gmt"]=>
//     string(19) "2019-08-02 22:13:31"
//     ["post_content"]=>
//     string(0) ""
//     ["post_title"]=>
//     string(15) "東京タワー"
//     ["post_excerpt"]=>
//     string(0) ""
//     ["post_status"]=>
//     string(7) "publish"
//     ["comment_status"]=>
//     string(6) "closed"
//     ["ping_status"]=>
//     string(6) "closed"
//     ["post_password"]=>
//     string(0) ""
//     ["post_name"]=>
//     string(45) "%e6%9d%b1%e4%ba%ac%e3%82%bf%e3%83%af%e3%83%bc"
//     ["to_ping"]=>
//     string(0) ""
//     ["pinged"]=>
//     string(0) ""
//     ["post_modified"]=>
//     string(19) "2019-08-03 07:44:14"
//     ["post_modified_gmt"]=>
//     string(19) "2019-08-02 22:44:14"
//     ["post_content_filtered"]=>
//     string(0) ""
//     ["post_parent"]=>
//     int(0)
//     ["guid"]=>
//     string(87) "http://localhost/public_html/chachamarunet.com/chizuasobi/?post_type=landmark&p=32"
//     ["menu_order"]=>
//     int(0)
//     ["post_type"]=>
//     string(8) "landmark"
//     ["post_mime_type"]=>
//     string(0) ""
//     ["comment_count"]=>
//     string(1) "0"
//     ["filter"]=>
//     string(3) "raw"
//   }
// }


?>
<a href="#" id="button-0">ここを押すと情報ウィンドウ開く0</a>
<a href="#" id="button-1">ここを押すと情報ウィンドウ開く1</a>

<div id="MapMain" class="gmap-main-wrapper">
  <div class="bg-green" style="height:300px">
    <div class="container"> 
      <h2 class="ttl-1 mt-xs-15 mb-xs-15"><span class="ttl-1-inner">Google Mapで検索</span></h2>
      <div id="mapArea" class="gmap-main bg-test mt-xs-5"></div>
<script>




(function(){
  "use strict";
  var mapData    = { pos: { lat: 35.681236, lng: 139.767125 }, zoom: 13 };
  var markerData = [
  <?php
  // 投稿ごとのマーカーと情報ウィンドウ作成
  $post_ids =array();
  foreach ($landmarks as $landmark): ?>
    <?php
    $post_ids[] = $landmark->ID;
    $map['Coordinate'] = get_post_meta( $landmark->ID, 'acf_landmark_gmap', true );
    $map['address']    = get_post_meta( $landmark->ID, 'acf_landmark_address', true );
    $img_id  = get_post_thumbnail_id( $landmark->ID );
    if( $img_id ) {
      $img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
      $img_url = esc_url($img[0]);
    } else {
      $img_url = 'http://placehold.jp/18/cccccc/ffffff/100x100.png?text=NO IMAGE';
    }
    ?>
    {
      pos: { lat: <?php echo esc_js( $map['Coordinate']['lat'] ); ?>, lng: <?php echo esc_js( $map['Coordinate']['lng'] ); ?> }, 
      title: "<?php echo esc_js( $landmark->post_title ); ?>", 
      icon: "", 
      post_id: <?php echo $landmark->ID; ?>,
      infoWindowContent: 
        "<div class='infwin cf' style='position:relative'>" + 
        "<a id='Gmap-<?php echo $landmark->ID; ?>' style='position:absolute;top:-150px'></a>" + 
        "<div class='infwin-thumb'><img class='img-responsive' src='<?php echo esc_url( $img_url ); ?>'></div>" + 
        "<div class='infwin-main'>" + 
        "<h3><?php echo esc_js( $landmark->post_title ); ?></h3>" + 
        "<p><?php echo esc_js( $map['address'] ); ?></p>" + 
        "</div>" + 
        "</div>"
    },
  <?php endforeach; ?>
  ];
  // 投稿からMapの情報ウィンドウ呼び出し
  var map, infoWindow;
  var markers = [];
  var infoWinCnts = [];
  var suffixies  = [<?php echo implode(',', $post_ids); ?>];
  jQuery(function($) {
    $.each(suffixies, function(index, post_id) {
      $("#HandleMap-" + post_id).bind("click",function(){
        infoWindow.setContent(infoWinCnts[post_id]);
        infoWindow.open(map, markers[post_id]);
        infoWindow.open(map,markers[post_id]);
      });
    });
  });
  // Google Map 本体
  map = new google.maps.Map(document.getElementById('mapArea'), {
      center: mapData.pos,
      zoom:   mapData.zoom
  });
  infoWindow = new google.maps.InfoWindow();
  for( var i=0; i < markerData.length; i++ ) {
    var post_id = markerData[i].post_id;
    (function(){
        var marker = new google.maps.Marker({
            position: markerData[i].pos,
            title:    markerData[i].title,
            icon:     markerData[i].icon,
            map: map
        });
        if( markerData[i].infoWindowContent ) {
            var infoWindowContent = markerData[i].infoWindowContent;
            marker.addListener('click', function(){
                infoWindow.setContent(infoWindowContent);
                infoWindow.open(map, marker);
            });
        }
        infoWinCnts[post_id] = markerData[i].infoWindowContent;
        markers[post_id] = marker;
    }());
  }
}());
</script>
    </div>
  </div>
</div>

<section class="mt-xs-50">
  <div class="container">
    <h2 class="ttl-2">
      <i class="fas fa-map-marker-alt"></i> 
      ランドマーク一覧
      <span class="ttl-2-small">検索条件 : 城 / 日本の城 / 史跡</span>
    </h2>





<?php
$args = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1
);
$the_query = new WP_Query( $args );
?>

<?php if ($the_query->have_posts()): ?>
  <ul class="row mt-xs-15">
    <?php while($the_query->have_posts()) : $the_query->the_post(); ?>

<?php
$field = array();
$field['Coordinate'] = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
$field['address']    = get_post_meta( $post->ID, 'acf_landmark_address', true );
?>

      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  <?php the_title(); ?> 
                  <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
                </h3>
                <p class="mt-xs-5"><?php echo esc_html($field['address']); ?></p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a id="HandleMap-<?php the_ID(); ?>" href="#Gmap-<?php the_ID(); ?>">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>

    <?php endwhile; ?>
  </ul>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>

    <ul class="row mt-xs-15">
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
      <li class="col-md-6 mt-xs-15">
        <div class="box-1 box-1-2col cf"> 
          <div class="box-1-inner cf">
            <div class="box-1-thumb matchHeight">
              <img src="https://placehold.jp/750x750.png" alt="">
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  大阪城 
                  <span class="subttl-1-mini">投稿日時 2018.10.14</span>
                </h3>
                <p class="mt-xs-5">大阪府大阪市中央区大阪城1-1</p>
                <ul class="taglist-1 cf mt-xs-10">
                  <li><a href="#">城・城址</a></li>
                  <li><a href="#">三大名城</a></li>
                  <li><a href="#">日本100名城</a></li>
                </ul>
              </div>
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> <span class="box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a href="#">
                  <span class="link-color-1">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> <span class="box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="box-1-bottom">
            <ul class="taglist-1 cf mt-xs-10">
              <li><a href="#">城・城址</a></li>
              <li><a href="#">三大名城</a></li>
              <li><a href="#">日本100名城</a></li>
            </ul>
          </div>
        </div><!-- .box-1 -->
      </li>
    </ul>
  </div>
</section>


<section class="mt-xs-50 bg-img-1 pb-xs-50 bt-s pt-xs-50">
  <div class="container">
    <h2 class="ttl-3">
      <span class="ttl-3-sub">今月の特集テーマ</span>
      <span class="ttl-3-main mml-char">『2018年NHK大河ドラマ「西郷どん」ゆかりの地を行く』</span>
    </h2>
    <div id="mapArea2" class="gmap-main mt-xs-15" style="height:500px;"></div>
    <p class="text-normal mt-xs-30">
      薩摩の貧しい下級藩士の家の長男として生まれた西郷隆盛。家のため、お金のために役人の元で働き始めます。しかし、情深い西郷は困った人のために身を削り自分の金や食べ物も与えてしまいます。そんな彼に家族たちも困り果てますが、本人はお構いなし。<br>
      そんな他人に優しい西郷に、藩主の島津斉彬が目を留めます。西郷自身も「民の幸せこそが国を富ませ強くする」という信念を持つ島津に惹かれます。島津から預けられた密命を受けて、東から西まで駆け回ります。だんだんと知名度を上げることとなり、重要人物と認識されるまでになります。 [...記事の詳細へ]
    </p>
    <ul class="row mt-xs-30">
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">1</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">2</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="col-md-4 matchHeight">
        <div class="box-2">
          <h3 class="box-2-subttl">
            <span class="box-2-subttl-num">3</span>
            <span class="box-2-subttl-main">西郷隆盛誕生地碑</span>
          </h3>
          <div class="box-2-main">
            <div class="box-2-main-inner">
              <div class="box-2-main-thumb">
                <img src="https://placehold.jp/100x100.png" alt="">
              </div>
              <div class="box-2-main-text">
                <p>
                西郷吉之助は、鹿児島城(鶴丸城)<br>
                下の下級武士が住む加治屋町にて生まれました。
                西郷隆盛の妹・西郷琴などの兄弟もここで生まれました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</section>

<?php get_template_part('parts/tab-content'); ?>

<?php get_footer(); ?>