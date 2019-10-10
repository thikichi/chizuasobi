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









<section class="block5 mt-xs-30 bgColor-lightGray">
  <div class="container">
    <div class="bgColor-white mt-xs-30 mt-md-50 mb-xs-30 mb-md-50">
      <h3 class="block5-ttl font-noto-serif-jp text-24 inner-normal underline-solid align-center">
        史跡「<?php the_title(); ?>」の写真一覧
      </h3>
      <div class="inner-normal">
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
  </div>
</section>







<?php
$tax = 'landmark_cateogry';
$terms = get_the_terms($post->ID, $tax);
$term_ttl = '';
$term_arr = array();
$term_ttl .= '<ul class="taglist-3 __iBlock">';
foreach ($terms as $term) {
  $term_arr[] = $term->term_id;
  $term_ttl .= '<li>';
  $term_ttl .= '<a href="#">';
  $term_ttl .= $term->name;
  $term_ttl .= '</a> ';
  $term_ttl .= '</li>';
}
$term_ttl .= '</ul>';
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
              <?php
              $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
              if( $img!='' ) {
                echo $osfw->the_image_tag( $img );
              } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
              }
              ?>
            </div>
            <div class="box-1-main matchHeight">
              <div class="box-1-text">
                <h3 class="subttl-1">
                  <?php the_title(); ?> 
                  <span class="subttl-1-mini">投稿日時 <?php the_time('Y.m.d'); ?></span>
                </h3>
                <p class="mt-xs-5"><?php echo esc_html($field['address']); ?></p>
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
            </div>
            <div class="box-1-btn matchHeight">
              <div class="box-1-btnTop">
                <a class="link-1" id="HandleMap-mapCats-<?php the_ID(); ?>" href="#mapCats">
                  <span class="link-color-1">
                    <img class="_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-pin.svg"> 
                    <span class="_linkText box-1-btnText">地図を見る</span>
                  </span>
                </a>
              </div>
              <div class="box-1-btnBottom">
                <a class="link-1" href="<?php the_permalink(); ?>">
                  <span class="link-color-1">
                    <img class="_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-book.svg"> 
                    <span class="_linkText box-1-btnText">記事を読む</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div><!-- .box-1 -->
      </li>
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
        $post_map_center = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
        $post_map_zoom   = get_post_meta( $post->ID, 'acf_landmark_zoom', true );
        $lat_init = $post_map_center['lat'];
        $lng_init = $post_map_center['lng'];
        // 全ての史跡を取得
        $landmark_posts  = get_posts( array( 'post_type'=>'landmark', 'numberposts'=>-1 ) );
        $marker_data_arr = array();
        $i=0;
        foreach ($landmark_posts as $landmark_post) {
            $map_center = get_post_meta( $landmark_post->ID, 'acf_landmark_gmap', true );
            $map_zoom   = get_post_meta( $landmark_post->ID, 'acf_landmark_zoom', true );
            $map_address = get_post_meta( $landmark_post->ID, 'acf_landmark_address', true );
            $land_cat   = get_the_terms( $landmark_post->ID, 'landmark_cateogry' );
            $dist = distance($lat_init, $lng_init, $map_center['lat'], $map_center['lng'], true);


            $img = $osfw->get_thumbnail_by_post( $landmark_post->ID, 'img_square' );
            $img_url = $img ? $img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
            


            // get markerData
            $marker_data_arr[$i]['id']   = $landmark_post->ID;
            $marker_data_arr[$i]['name'] = $landmark_post->post_title;
            $marker_data_arr[$i]['lat']  = $map_center['lat'];
            $marker_data_arr[$i]['lng']  = $map_center['lng'];
            $marker_data_arr[$i]['cat']  = $land_cat[0]->term_id;
            $marker_data_arr[$i]['address'] = $map_address;
            $marker_data_arr[$i]['link'] = get_the_permalink($landmark_post->ID);
            $marker_data_arr[$i]['img_url'] = $img_url;
            $marker_data_arr[$i]['dist'] = floor($dist);
            $i++;
        }
        ?>

        <div id="mapDistSearch" style="width: 100%;height: 500px">
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

        <div id="DispPost" data-mainpostid="<?php echo $post->ID; ?>" class="mt-xs-30 align-center">
        </div>

        <script>
        jQuery(function($) {
          $(function(){
            var map;
            var marker = [];
            var mapLatLng;
            var circleObj;
            var currentDist = 5000;
            var query_terms = []; // termID list
            var query_postid = $('#DispPost').data('mainpostid');
            var query_post_type = 'landmark';
            var infoWindow = [];
            var markerData = [ // マーカーを立てる場所名・緯度・経度
            <?php foreach ($marker_data_arr as $marker_data): ?>
             {
                id:   <?php echo esc_js($marker_data['id']); ?>,
                name: '<?php echo esc_js($marker_data['name']); ?>',
                lat:  <?php echo esc_js($marker_data['lat']); ?>,
                lng:  <?php echo esc_js($marker_data['lng']); ?>,
                cat:  <?php echo esc_js($marker_data['cat']); ?>,
                dist: <?php echo esc_js($marker_data['dist']); ?>,
                infoWindowContent: getInfowinContent(
                  <?php echo esc_js($marker_data['id']); ?>, 
                  'mapDistSearch', 
                  '<?php echo esc_js($marker_data['img_url']); ?>',
                  '<?php echo esc_js($marker_data['name']); ?>',
                  '<?php echo esc_js($marker_data['address']); ?>',
                  '<?php echo esc_js($marker_data['link']); ?>',
                ),
             },
            <?php endforeach; ?>
            ];
            function initMapDist() {
             // 地図の作成
                mapLatLng = new google.maps.LatLng({lat: <?php echo $lat_init; ?>, lng: <?php echo $lng_init; ?>}); // 緯度経度のデータ作成
                map = new google.maps.Map(document.getElementById('mapDistSearch'), { // #sampleに地図を埋め込む
                center: mapLatLng, // 地図の中心を指定
                zoom: 13 // 地図のズームを指定
               });
               paintCircleMap();
               // カテゴリーのチェッック状態に応じてマーカーをつける
              $('.marker-check').each(function(index,el) {
                if ( $(this).prop('checked') ) {
                  // console.log( $(this).data('termid') );
                  query_terms.push($(this).val());
                  dispMarker($(this).data('termid'));
                }
              });
              // Ajax post
              doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
            }























            // ajax main
            function doAjaxPosts( dist, query_post_type, query_terms, query_postid ) {
              $('#DispPost').html('<img class="_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/images/common/icon-loader.gif">');
              $.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  data: {
                      'action' : 'view_mes',
                      'dist'   : dist,
                      'query_post_type' : query_post_type,
                      'query_terms'     : query_terms,
                      'query_postid' : query_postid,
                  },
                  success: function( response ){
                    jsonData = JSON.parse( response );
                    var tag = '';
                    // $.each( jsonData['post'], function( i, val ){
                    //     tag += '<p>' + 'タイトル: ' +  val['post_title'] + '</p>';
                    //     tag += '<p>' + 'パーマリンク: ' +  val['permalink'] + '</p>';
                    // });
                    $('#DispPost').html(jsonData['tags']);
                    $('.matchHeight').matchHeight();
                  }
              });
            }

            // マーカーにクリックイベントを追加
            function markerEvent(i) {
                marker[i].addListener('click', function() { // マーカーをクリックしたとき
                  infoWindow[i].open(map, marker[i]); // 吹き出しの表示
              });
            }

            // マーカー毎の処理
            function dispMarker(catNum) {
              for (var i = 0; i < markerData.length; i++) {
                  if( markerData[i]['cat']===catNum ) {
                    markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']});
                    marker[i] = new google.maps.Marker({ // マーカーの追加
                     position: markerLatLng, // マーカーを立てる位置を指定
                     animation: google.maps.Animation.DROP,
                        map: map // マーカーを立てる地図を指定
                   });
                   infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
                       content: markerData[i]['infoWindowContent'] // 吹き出しに表示する内容
                   });
                   markerEvent(i); // マーカーにクリックイベントを追加
                 } 
              }
              hiddenMakersAll();
            }

            //マーカーを削除する
            function deleteMakers(catNum) {
              for (var i = 0; i < markerData.length; i++) {
                if( markerData[i]['cat']===catNum) {
                  marker[i].setMap(null);
                }
              }
            }

            // マーカーを隠す
            function hiddenMakersAll() {
              $.each(marker, function(index, val) {
                if(marker[index]) {
                  if( markerData[index]['dist'] < currentDist) {
                    marker[index].setVisible(true);
                  } else {
                    marker[index].setVisible(false);
                  }
                }
              });
            }

            // ズームレベルを変更する
            function changeZoom( zoom=map.getZoom() ) {
              map.setZoom( parseInt(zoom) );
            }

            // 半径の表示円を描画
            function paintCircleMap() {
              circleObj = new google.maps.Circle({
                center: mapLatLng,       // 中心点(google.maps.LatLng)
                fillColor: '#ff0000',   // 塗りつぶし色
                fillOpacity: 0.1,       // 塗りつぶし透過度（0: 透明 ⇔ 1:不透明）
                map: map,             // 表示させる地図（google.maps.Map）
                radius: parseInt(currentDist),          // 半径（ｍ）
                strokeColor: '#ff0000', // 外周色 
                strokeOpacity: 0.5,       // 外周透過度（0: 透明 ⇔ 1:不透明）
                strokeWeight: 1         // 外周太さ（ピクセル）
              });
            }
            // 半径の表示円を削除
            function dalatePaintCircleMap() {
              circleObj.setMap(null);
            }




            $('.marker-check').click(function() {
              var termid = $(this).data('termid');
              if ( $(this).prop('checked') ) {
                dispMarker(termid);
              } else {
                deleteMakers(termid);
              }
              query_terms = [];
              $('.marker-check').each(function(index,el) {
                if ( $(this).prop('checked') ) {
                  query_terms.push($(this).val());
                }
              });
              doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
            });
            // セレクトボックス選択
            $('#MarkerSelectDist').change(function() {
              //選択したvalue値を変数に格納
              var val = $(this).val();
              currentDist = val;
              // var zoom = $(this).data('zoom');
              var zoom = $(this).find('option:selected').data('zoom');
              hiddenMakersAll();
              changeZoom(zoom);
              dalatePaintCircleMap();
              paintCircleMap();
              // Ajax post
              doAjaxPosts( currentDist, query_post_type, query_terms, query_postid );
            });

            // 遅延読み込み部分
            var mylazyloadDone = function() {
              initMapDist();
              // $('.marker-check').trigger('click');
            }
            $('#mapDistSearch').myLazyLoadingObj({
              callback : mylazyloadDone,
            });
          });
        });
        </script>
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
        <script type="text/javascript">
        jQuery(function($) {
          $(document).ready(function(){
            $('.layout3-slider').slick({
              slidesToShow: 5,
              slidesToScroll: 1,
              prevArrow: '<a href="javascript:void(0)" class="slide-arrow prev-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="55.892,105.002 5.892,55.002 55.892,5.002"/></svg></span></a>',
              nextArrow: '<a href="javascript:void(0)" class="slide-arrow next-arrow"><span class="_inner"><svg class="icon-svg-arrow" version="1.1" id="レイヤー_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="27.5px" viewBox="0 0 60 110" enable-background="new 0 0 60 110" xml:space="preserve"><polyline fill="none" stroke-width="5" stroke-miterlimit="10" points="3.892,5.002 53.892,55.002 3.892,105.002 "/></svg></span></a>',
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
                },
                {
                  breakpoint: 400,
                  settings: {
                    slidesToShow: 1,
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
  </div>
</section>


<div class="mt-xs-15">
<?php get_template_part('parts/tab-content'); ?>
</div>







<?php get_footer(); ?>