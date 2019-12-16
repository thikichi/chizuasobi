<?php get_header(); ?>

<?php
$recommend_post_ids = get_post_meta( $post->ID, 'acf_course_recommend_post', true );
$recommend_post_ttl = $post_course_single->post_title;
$waypoints = '';
$origin = $destination = array();
$previous_post_id = '';

$def_ratio = 5; // 標準のli要素の分割数
$cur_radio = count($recommend_post_ids);
$ul_width_all = (100 / $def_ratio);
$ul_width_radio = ($ul_width_all * $cur_radio) / 100;




$args = array(
  'post_type' => 'landmark',
  'post__in'  => $recommend_post_ids,
  'order' => 'ASC',
  'posts_per_page' => -1
);
$the_query = new WP_Query( $args );
?>

<style>
@media screen and (min-width:1200px) { 
.block13__list-wrapper { width: calc(100% * <?php echo $ul_width_radio; ?>); }
}
</style>

<?php
$previous2_post_id =='';
?>


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
      <p class="block13__read mt-xs-30 mt-md-50">
        <span class="block13__read-inner">
        浅草、上野周辺の神社をめぐり御朱印を集めよう！<br>
        ここではメジャーなルートをご紹介します。
        </span>
      </p>
      <div class="block13__list-wrapper">
        <?php if ($the_query->have_posts()): ?>
          <ul class="block13__list mt-xs-30 mt-md-50">
          <?php $num=1; while($the_query->have_posts()) : $the_query->the_post(); ?>
            <li class="block13__list-item matchHeight">
              <div class="block13__box">
                  <?php
                  if( $num === 1 ) {
                    echo '<span class="block13__box-step block13__box-step--origin">';
                    echo '出発地点';
                    echo '</span>';
                    $href = '#postID_' . $post->ID;
                  } else if( $num === count($recommend_post_ids) ) {
                    echo '<span class="block13__box-step block13__box-step--destin">';
                    echo '到着地点';
                    echo '</span>';
                    $href = '#postID_' . $previous2_post_id;
                  } else {
                    echo '<span class="block13__box-step block13__box-step">';
                    echo '中間地点';
                    echo '</span>';
                    $href = '#postID_' . $post->ID;
                  }
                  ?>
                </span>
                <?php
                $img_1x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_1x', 'https://placehold.jp/640x480.png?text=No Image' );
                $img_2x = $osfw->get_thumbnail_by_post( $post_origin->ID, 'img_3_4_2x', 'https://placehold.jp/300x225.png?text=No Image' );
                ?>
                <img src="<?php echo esc_url($img_1x['src']); ?>" srcset="<?php echo esc_url($img_1x['src']); ?> 1x, <?php echo esc_url($img_2x['src']); ?> 2x" class="block1__img">
                <h3 class="block13__box-ttl"><?php the_title(); ?></h3>
                <p class="block13__box-text">
                  <?php
                  echo $osfw->get_excerpt_filter( get_the_excerpt(), 50, '[..]' );
                  ?>
                </p>
                <p class="block13__box-link">
                  <a href="<?php echo $href; ?>" class="block13__box-linkmain">
                    この経路を見る
                  </a>
                </p>
              </div>
            </li>
            <?php
            $previous2_post_id = $post->ID;
            ?>
          <?php $num++; endwhile; ?>
        </ul>
        <?php endif; ?>
        <?php wp_reset_query(); ?>
      </div>
    </div>
  </div>
</section>


<div class="bg-lightGray pb-xs-50 pb-md-70 pb-lg-100">
<?php
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
  <div style="position: relative">
    <div id="postID_<?php echo $post_origin->ID; ?>" style="position:absolute;top:-125px"></div>
  </div>
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
            <h4 class="block1__post-ttl">到着 : <span class="block1__post-ttl--strong">『<?php echo $post_destin->post_title; ?>』</span></h4>
            <div class="block1__spots-photo">
              <?php
              $img_1x = $osfw->get_thumbnail_by_post( $post_destin->ID, 'img_3_4_1x', 'https://placehold.jp/640x480.png?text=No Image' );
              $img_2x = $osfw->get_thumbnail_by_post( $post_destin->ID, 'img_3_4_2x', 'https://placehold.jp/300x225.png?text=No Image' );
              ?>
              <img src="<?php echo esc_url($img_1x['src']); ?>" srcset="<?php echo esc_url($img_1x['src']); ?> 1x, <?php echo esc_url($img_2x['src']); ?> 2x" class="block1__img">
            </div>
            <div class="block1__spots-text">
              <ul class="block1__spotlist">
                <li class="block1__spotlist-item"><?php echo esc_html($destin['address']); ?></li>
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
<div>

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
</script>

<?php get_footer(); ?>