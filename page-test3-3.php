<?php get_header(); ?>


<section class="block13">
  <div class="block13__container">
    <div class="block13__inner">
      <h2 class="title-1 mt-xs-30">
        <span class="title-1__inner">
          <span class="title-1__sub title-1__sub--l">
            おすすめ史跡めぐりコース
          </span>
          <span class="title-1__main">
            浅草・上野、御朱印めぐり
          </span>
        </span>
      </h2>
      <p class="block13__read mt-xs-50">
        <span class="block13__read-inner">
        浅草、上野周辺の神社をめぐり御朱印を集めよう！<br>
        ここではメジャーなルートをご紹介します。
        </span>
      </p>
      <ul class="block13__list mt-xs-50">
        <li class="block13__list-item matchHeight">
          <div class="block13__box">
            <span class="block13__box-step block13__box-step--origin">出発地点</span>
              <img src="https://placehold.jp/750x750.png" alt="">
            <h3 class="block13__box-ttl">サブタイトル</h3>
            <p class="block13__box-text">
              ここにテキストがはいります。ここにテキストがはいります。
            </p>
            <p class="block13__box-link">
              <a href="#" class="block13__box-linkmain">
                この経路を見る
              </a>
            </p>
          </div>
        </li>
        <li class="block13__list-item matchHeight">
          <div class="block13__box">
            <span class="block13__box-step">中間地点1</span>
              <img src="https://placehold.jp/750x750.png" alt="">
            <h3 class="block13__box-ttl">サブタイトル</h3>
            <p class="block13__box-text">
              ここにテキストがはいります。ここにテキストがはいります。
            </p>
            <p class="block13__box-link">
              <a href="#" class="block13__box-linkmain">
                この経路を見る
              </a>
            </p>
          </div>
        </li>
        <li class="block13__list-item matchHeight">
          <div class="block13__box">
            <span class="block13__box-step">中間地点2</span>
              <img src="https://placehold.jp/750x750.png" alt="">
            <h3 class="block13__box-ttl">サブタイトル</h3>
            <p class="block13__box-text">
              ここにテキストがはいります。ここにテキストがはいります。
            </p>
            <p class="block13__box-link">
              <a href="#" class="block13__box-linkmain">
                この経路を見る
              </a>
            </p>
          </div>
        </li>
        <li class="block13__list-item matchHeight">
          <div class="block13__box">
            <span class="block13__box-step block13__box-step--destin">到着地点</span>
              <img src="https://placehold.jp/750x750.png" alt="">
            <h3 class="block13__box-ttl">サブタイトル</h3>
            <p class="block13__box-text">
              ここにテキストがはいります。ここにテキストがはいります。
            </p>
            <p class="block13__box-link">
              <a href="#" class="block13__box-linkmain">
                この経路を見る
              </a>
            </p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</section>


<?php
$args = array(
  'post_type' => 'course',
  'numberposts' => 10
);
$post_course = get_posts($args);
$post_course_single = $post_course[1];
$recommend_post_ids = get_post_meta( $post_course_single->ID, 'acf_course_recommend_post', true );
$recommend_post_ttl = $post_course_single->post_title;
$waypoints = '';
$origin = $destination = array();
$previous_post_id = '';


$num=1;
foreach ($recommend_post_ids as $recommend_post_id) {
  $map_tag = '';
  // 前の投稿があれば取得
  if( $previous_post_id!='' ) {
    $map_tag .= '<div class="block1__map">' . "\n";
    $map_tag .= '<div id="map-' . $previous_post_id . '" class="block1__map-main"></div>' . "\n";
    $map_tag .= '<div id="panel-' . $previous_post_id . '" class="block1__panel"></div>' . "\n";
    $map_tag .= '</div>' . "\n";
    ?>

<?php
$post_origin = get_post( (int)$previous_post_id ); 
$post_destin = get_post( (int)$recommend_post_id ); 

$origin['address'] = get_post_meta( $post_origin->ID, 'acf_landmark_address', true );
$destin['address'] = get_post_meta( $post_destin->ID, 'acf_landmark_address', true );
?>

<section class="block1">
  <div class="container">
    <div class="bloc1__inner">
      <h3 class="block1__ttl">
        経路その<?php echo $num; ?>
        <span class="block1__ttl--subttl">『<?php echo $post_origin->post_title; ?>』 から 『<?php echo $post_destin->post_title; ?>』までの経路</span>
      </h3>
      <div class="block1__main">
        <div class="block1__spots">

          <div class="block1__spots-origin">
            <h4 class="block1__post-ttl">出発 : <span class="block1__post-ttl--strong">『<?php echo $post_origin->post_title; ?>』</span></h4>
            <div class="block1__spots-photo">
              <?php
              $img_1x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_1x', 'https://placehold.jp/640x480.png?text=No Image' );
              $img_2x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_2x', 'https://placehold.jp/300x225.png?text=No Image' );
              ?>
              <img src="<?php echo esc_url($img_1x['src']); ?>" srcset="<?php echo esc_url($img_1x['src']); ?> 1x, <?php echo esc_url($img_2x['src']); ?> 2x" class="block1__img">
            </div>
            <div class="block1__spots-text">
              <ul class="block1__spotlist">
                <li class="block1__spotlist-item"><?php echo esc_html($origin['address']); ?></li>
              </ul>
            </div>
          </div>
          <div class="block1__spots-destin">
            <h4 class="block1__post-ttl">出発 : <span class="block1__post-ttl--strong">『<?php echo $post_origin->post_title; ?>』</span></h4>
            <div class="block1__spots-photo">
              <?php
              $img_1x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_1x', 'https://placehold.jp/640x480.png?text=No Image' );
              $img_2x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_2x', 'https://placehold.jp/300x225.png?text=No Image' );
              ?>
              <img src="<?php echo esc_url($img_1x['src']); ?>" srcset="<?php echo esc_url($img_1x['src']); ?> 1x, <?php echo esc_url($img_2x['src']); ?> 2x" class="block1__img">
            </div>
            <div class="block1__spots-text">
              <ul class="block1__spotlist">
                <li class="block1__spotlist-item"><?php echo esc_html($origin['address']); ?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="block1__main-content">

<?php echo $map_tag; ?>

        </div>
      </div>
    </div>
  </div>
</section><!-- .block1 -->



    <?php
    $num++;
  }
  $previous_post_id = $recommend_post_id;
}
?>

























<?php wp_footer(); ?>

<script>
// https://vintage.ne.jp/blog/2016/01/780
function dispMapAndRoot( mapID, rootID, origin, destination ) {
    // ルート検索の条件
    console.log(origin);
    var request = {
      origin: new google.maps.LatLng(origin[0],origin[1]),
      destination: new google.maps.LatLng(destination[0],destination[1]),
      travelMode: google.maps.DirectionsTravelMode.WALKING,
    };

    // マップの生成
    var map = new google.maps.Map(document.getElementById(mapID), {
        center: new google.maps.LatLng(origin[0],origin[1]), // マップの中心
        zoom: 16 // ズームレベル
    });

    var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
    var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
        map: map, // 描画先の地図
        preserveViewport: true, // 描画後に中心点をずらさない
        suppressMarkers: false, // trueでマーカーを表示しない
        polylineOptions: {
            strokeColor: '#ff0000',
            strokeOpacity: 0.5,
            strokeWeight: 3
        }
    });
    // ルート検索
    d.route(request, function(result, status){
        // OKの場合ルート描画
        if (status == google.maps.DirectionsStatus.OK) {
            r.setDirections(result);
        }
    });
    r.setPanel(document.getElementById(rootID));
}
</script>


<script>
<?php
$previous_post_id='';
foreach ($recommend_post_ids as $recommend_post_id) {
  // 前の投稿があれば取得
  if( $previous_post_id!='' ) {
    $gmap_origin = get_post_meta( $previous_post_id, 'acf_landmark_gmap', true );
    $gmap_destination = get_post_meta( $recommend_post_id, 'acf_landmark_gmap', true );
    // 出発点
    $origin['mapID']   = 'map-' . $previous_post_id;
    $origin['panelID'] = 'panel-' . $previous_post_id;
    $origin['lat'] = $gmap_origin['lat'];
    $origin['lng'] = $gmap_origin['lng'];
    // 到着点
    $destination['lat'] = $gmap_destination['lat'];
    $destination['lng'] = $gmap_destination['lng'];
    // JS
    echo 'dispMapAndRoot( "'. $origin['mapID'] .'", "'. $origin['panelID'] .'", [' . $origin['lat'] . ',' . $origin['lng'] . '], [' . $destination['lat'] . ',' . $destination['lng'] . '] );' . "\n";
  }
  $previous_post_id = $recommend_post_id;
}
?>

// dispMapAndRoot( 'map-34', 'panel-34', [35.681382,139.766084], [35.658565,139.745532] );
// dispMapAndRoot( 'map-44', 'panel-44', [35.681382,139.766084], [35.658565,139.745532] );

</script>

<?php

// https://qiita.com/kngsym2018/items/15f19a88ea37c1cd3646


// $base_url = 'https://maps.googleapis.com/maps/api/directions/json?origin=Adelaide,SA&destination=Adelaide,SA&waypoints=optimize:true|Barossa+Valley,SA|Clare,SA|Connawarra,SA|McLaren+Vale,SA&key=AIzaSyBjYTWYNKXOkeVC6fofHCDHEJVhiTIVTIE';
// $tag = 'PHP';
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $base_url);
// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
// /*
// 一括で指定することもできる
// $option = [
//     CURLOPT_URL => $base_url.'/api/v2/tags/'.$tag.'/items',
//     CURLOPT_CUSTOMREQUEST => 'GET',
//     CURLOPT_SSL_VERIFYPEER => false,
// ];
// curl_setopt_array($curl, $option);
// */
// $response = curl_exec($curl);
// $result = json_decode($response, true);
// curl_close($curl);

// var_dump($result);
?>


<?php get_footer(); ?>