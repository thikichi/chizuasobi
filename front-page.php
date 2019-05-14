<?php get_header(); ?>


<div id="MapMain">
  <div class="bg-green" style="height:300px">
    <div class="container">
      <h2 class="ttl-1"><span class="ttl-1-inner">Google Mapで検索</span></h2>
      <div id="mapArea" class="gmap-main bg-test mt-xs-5">
        
      </div>
      <script type="text/javascript" >
      // ロードしたタイミングで実行
      window.onload = function () {
        initMap();
      };
      var map;
      var marker = [];
      var infoWindow = [];
      var markerData = [
        {
          name: 'TAM 東京',
          lat: 35.6954806,
          lng: 139.76325010000005,
          icon: 'tam.png'
        },
        {
          name: '小川町駅',
          lat: 35.6951212,
          lng: 139.76610649999998
        },
        {
          name: '淡路町駅',
          lat: 35.69496,
          lng: 139.76746000000003
        },
        {
          name: '御茶ノ水駅',
          lat: 35.6993529,
          lng: 139.76526949999993
        },
        {
          name: '神保町駅',
          lat: 35.695932,
          lng: 139.75762699999996
        },
        {
          name: '新御茶ノ水駅',
          lat: 35.696932,
          lng: 139.76543200000003
        }
      ];
      function initMap() {
        // 地図の作成
        var mapLatLng = new google.maps.LatLng({lat: markerData[0]['lat'], lng: markerData[0]['lng']}); // 緯度経度のデータ作成
        map = new google.maps.Map(document.getElementById('mapArea'), { // #mapAreaに地図を埋め込む
          center: mapLatLng, // 地図の中心を指定
          zoom: 15 // 地図のズームを指定
        });
        // マーカー毎の処理
        for (var i = 0; i < markerData.length; i++) {
          markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
          console.log(markerLatLng); 
          marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng, // マーカーを立てる位置を指定
            map: map // マーカーを立てる地図を指定
          });
       
          infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: '<div class="mapArea">' + markerData[i]['name'] + '</div>' // 吹き出しに表示する内容
          });
          markerEvent(i); // マーカーにクリックイベントを追加
        }
       
        marker[0].setOptions({// TAM 東京のマーカーのオプション設定
          icon: {
            url: markerData[0]['icon']// マーカーの画像を変更
          }
        });
      }
      // マーカーにクリックイベントを追加
      function markerEvent(i) {
        marker[i].addListener('click', function() { // マーカーをクリックしたとき
          infoWindow[i].open(map, marker[i]); // 吹き出しの表示
        });
      }
      </script>
    </div>

  </div>
</div>


<!-- post001 -->
<!--==================================================-->

<?php
$args = array(
  'post_type' => 'post',
  'posts_per_page' => 5, /* 表示件数を指定（-1なら全件） */
  'paged' => get_query_var('paged'),
  );
$the_query = new WP_Query( $args );
?>
<section class="post001 mb-50 mt-50">
  <div class="container-fluid">
    <div class="post001-inner">
      <h2 class="post001-heading">
        <img src="http://osweb.info/os-framework/component/wp-content/themes/os-component-manager-theme/components/main-component/post001/images/post001-icon-01.svg" height="35" alt="">
        ブログ（投稿）の一覧
      </h2>
      <p class="post001-more">
        <a href="<?php echo get_post_type_archive_link( 'post' ); ?>">一覧を見る</a>
      </p>
      <?php if ($the_query->have_posts()): ?>
        <ul class="post001-list">
          <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <p class="post001-date"><?php the_time('Y/m/d'); ?></p>
                <p class="post001-category">
                  <?php
                  /* カテゴリーの色取得 */
                  $default_color = '#FF0000'; /* デフォルトの色を指定 */
                  $terms = get_the_terms($post->ID, 'category');
                  ?>
                  <?php if($terms): foreach ($terms as $term): ?>
                    <span<?php os_get_category_color($term->term_id, $default_color); ?> class="post001-category-01">
                    <?php echo $term->name; ?></span>
                  <?php endforeach; endif; ?>
                </p>
                <p class="post001-title"><?php the_title(); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p>記事の投稿がありません。</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>


<!-- post001 -->
<!--==================================================-->

<?php
$args = array(
  'post_type' => 'news',
  'posts_per_page' => 5, /* 表示件数を指定（-1なら全件） */
  'paged' => get_query_var('paged'),
  );
$the_query = new WP_Query( $args );
?>
<section class="post001 mb-50">
  <div class="container-fluid">
    <div class="post001-inner">
      <h2 class="post001-heading">
        <img src="http://osweb.info/os-framework/component/wp-content/themes/os-component-manager-theme/components/main-component/post001/images/post001-icon-01.svg" height="35" alt="">
        新着情報
      </h2>
      <p class="post001-more">
        <a href="<?php echo get_post_type_archive_link( 'news' ); ?>">一覧を見る</a>
      </p>
      <?php if ($the_query->have_posts()): ?>
        <ul class="post001-list">
          <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <p class="post001-date"><?php the_time('Y/m/d'); ?></p>
                <p class="post001-category">
                  <?php
                  global $ofm_ptype;
                  $news_tax_slug = $ofm_ptype->get_ptype_news_cat();
                  /* カテゴリーの色取得 */
                  $default_color = '#FF0000'; /* デフォルトの色を指定 */
                  $terms = get_the_terms($post->ID, $news_tax_slug);
                  ?>
                  <?php if($terms): foreach ($terms as $term): ?>
                    <span<?php os_get_newscategory_color($term->term_id, $default_color); ?> class="post001-category-01">
                    <?php echo $term->name; ?></span>
                  <?php endforeach; endif; ?>
                </p>
                <p class="post001-title"><?php the_title(); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p>記事の投稿がありません。</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>