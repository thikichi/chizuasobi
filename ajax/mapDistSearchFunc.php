<?php
function mapDistSearchFunc(){
    global $osfw;
    $returnObj = array();
    $dist  = $_POST['dist'];
    $mapid  = $_POST['mapid'];
    $query_post_type = $_POST['query_post_type'];
    $query_terms     = isset($_POST['query_terms']) ? $_POST['query_terms'] : '';
    $query_postid    = $_POST['query_postid'];
    $display_mode    = $_POST['display_mode']; // default: replace
    $disp_num   = $_POST['disp_num']; // 表示させたい記事件数
    $disped_num = $display_mode=='replace' ? 0 :  $_POST['disped_num']; // すでに表示されている件数

    // 現在の投稿
    $this_posts     = get_posts( array( 'post_type'=>$query_post_type, 'numberposts'=>-1 ) );
    $this_gmap = get_post_meta( $query_postid, 'acf_landmark_gmap', true );
    $thisdist = distance($this_gmap['lat'], $this_gmap['lng'], $this_gmap['lat'], $this_gmap['lng'], true);
    foreach ($this_posts as $this_post) {
      $terms = get_the_terms(get_the_ID(), 'landmark_cateogry');
      $term_list = '[';
      foreach ( $terms as $term ) {
        $term_list .= "'" . $term->term_id . "'";
        if ($term !== end($terms)) $term_list .= ',';
      }
      $term_list .= ']';
      $returnObj['markerDataAjax'][0]['id']   = $mapid . '_' . $this_post->ID;
      $returnObj['markerDataAjax'][0]['name'] = $this_post->post_title;
      $returnObj['markerDataAjax'][0]['lat']  = floatval($this_gmap['lat']);
      $returnObj['markerDataAjax'][0]['lng']  = floatval($this_gmap['lng']);
      $returnObj['markerDataAjax'][0]['cat']  = $term_list;
      $returnObj['markerDataAjax'][0]['dist'] = $thisdist;
      $returnObj['markerDataAjax'][0]['infoWindowContent'] = $this_post->post_title;
      // $returnObj['markerDataAjax'][0]['infoWindowContent'] = getInfowinContent( $this_post->ID, 'mapDistSearch', 'img_url', $this_post->post_title, 'address', 'link' );
    }

    // 対象となる投稿（距離による絞り込みなし）
    $selected_posts = array();
    if( $query_terms ) {
      $term_posts = get_posts( array( 
        'post_type' => $query_post_type,
        'post__not_in' => array(intval($query_postid)),
        'tax_query' => array( 
          array(
            'taxonomy' => 'landmark_cateogry', //タクソノミーを指定
            'field' => 'term_id', //ターム名をスラッグで指定する
            'terms' => $query_terms,
            'operator' => 'IN',
            'numberposts'=>-1,
          ),
        ),
      ));
      $i=1;
      foreach ($term_posts as $term_post) {
        $loop_gmap = get_post_meta( $term_post->ID, 'acf_landmark_gmap', true );
        $loop_address = get_post_meta( $term_post->ID, 'acf_landmark_address', true );
        $thisdist  =  distance($this_gmap['lat'], $this_gmap['lng'], $loop_gmap['lat'], $loop_gmap['lng'], true);
        $terms = get_the_terms($term_post->ID, 'landmark_cateogry');
        if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
          $term_list = '[';
          foreach ( $terms as $term ) {
            $term_list .= "'" . $term->term_id . "'";
            if ($term !== end($terms)) {
              $term_list .= ',';
            }
          }
          $term_list .= ']';
        }
        // thumbnail
        $temp_img = $osfw->get_thumbnail_by_post( $term_post->ID, 'img_square' );
        $post_map_img = $temp_img['src'] ? $temp_img['src'] : get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
        // InfoWindow
        $infoWin  = '';
        $infoWin .= "<div id='mapDistSearch_" . $term_post->ID . "' class='infwin cf' style='position:relative'>";
        $infoWin .= "<a id='" . $mapid . "_" . $term_post->ID . "' style='position:absolute;top:-150px'></a>";
        $infoWin .= "<div class='infwin-thumb'>";
        $infoWin .= "<img class='img-responsive' src='" . $post_map_img . "'></div>";
        $infoWin .= "<div class='infwin-main'>";
        $infoWin .= "<h3>" . $term_post->post_title . "</h3>";
        $infoWin .= "<p>" . $loop_address . "</p>";
        $infoWin .= "<p class='infwin-link'><a href='" . get_the_permalink() . "'>この記事を見る</a></p>";
        $infoWin .= "</div>";
        $infoWin .= "</div>";
        // マーカーオブジェクトをつくる
        $returnObj['markerDataAjax'][$i]['id']   = $term_post->ID;
        $returnObj['markerDataAjax'][$i]['name'] = $term_post->post_title;
        $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
        $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
        $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
        $returnObj['markerDataAjax'][$i]['dist'] = $thisdist;
        $returnObj['markerDataAjax'][$i]['infoWindowContent'] = $infoWin;
        if( $thisdist < $dist ) {
          $selected_posts[] = $term_post->ID;
        }
        $i++;
      }
    }
    // 対象となる投稿（距離により絞り込む）
    if( !empty($selected_posts) ) {
      $args = array(
        'post_type' => $query_post_type,
        'post__in'  => $selected_posts,
        'offset'    => $disped_num,
        'posts_per_page' => $disp_num,
      );
      $the_query = new WP_Query( $args );
      $get_num = $the_query->post_count;
      $returnObj['post_num_all']  = $all_num = intval($the_query->found_posts);
      $returnObj['post_num_get']  = $get_num + $disped_num;
      $returnObj['no_more_posts'] = $returnObj['post_num_get']>=$all_num ? true : false;
      // if( $display_mode==='replace' ) {
        $returnObj['tags'] = '';
      // } else if($the_query->have_posts()) {
      //   $returnObj['tags'] .= '';
      // }
      if ($the_query->have_posts()) {
        // $returnObj['markerDataAjax'] = [];
        $i=1;
        while($the_query->have_posts()) {
          $the_query->the_post();
          $cfield_gmap = get_post_meta( get_the_ID(), 'acf_landmark_gmap', true );
          $cfield_addr = get_post_meta( get_the_ID(), 'acf_landmark_address', true );
          // Theme URL
          $theme_url = get_stylesheet_directory_uri();
          // Permalink
          $permalink = get_the_permalink();
          // Post ID
          $post_id = get_the_ID();
          // Thumbnail
          $img_id = get_post_thumbnail_id( get_the_ID() );
          if( $img_id!='' ) {
            $temp_img = wp_get_attachment_image_src( $img_id , 'thumbnail' );
            $thumb = '<img src="' . $temp_img[0] . '" alt="">';
            $img_url = $temp_img[0];
          } else {
            $thumb = '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
            $img_url = get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg';
          }
          // Title
          $title = get_the_title();
          // Date time
          $date  = get_the_time('Y.m.d');
          // Taxonomy
          $taxtag = '';
          $tax = 'landmark_cateogry'; // タクソノミー名
          $terms = get_the_terms(get_the_ID(), $tax);
          if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
            $taxtag .= '<ul class="taglist-1 cf mt-xs-10">';
            foreach ( $terms as $term ) {
              $term_link = get_term_link( $term->term_id, $tax );
              $taxtag .= '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
            }
            $taxtag .= '</ul>';
          }



$returnObj['tags'] .= <<< EOM
<li class="col-md-6 mt-xs-15">
  <div class="box-1 box-1-2col cf"> 
    <div class="box-1-inner cf">
      <div class="box-1-thumb matchHeight">
        {$thumb}
      </div>
      <div class="box-1-main matchHeight">
        <div class="box-1-text">
          <h3 class="subttl-1">
            {$title}
            <span class="subttl-1-mini">投稿日時 {$date}</span>
          </h3>
          <p class="mt-xs-5">{$cfield_addr}</p>
          {$taxtag}
        </div>
      </div>
      <div class="box-1-btn matchHeight">
        <div class="box-1-btnTop">
          <a class="link-1" href="javascript:clickViewMap('{$post_id}')">
            <span class="link-color-1">
              <img class="_icon" src="{$theme_url}/images/common/icon-pin.svg"> 
              <span class="_linkText box-1-btnText">地図を見る</span>
            </span>
          </a>
        </div>
        <div class="box-1-btnBottom">
          <a class="link-1" href="{$permalink}">
            <span class="link-color-1">
              <img class="_icon" src="{$theme_url}/images/common/icon-book.svg"> 
              <span class="_linkText box-1-btnText">記事を読む</span>
            </span>
          </a>
        </div>
      </div>
    </div>
    <div class="box-1-bottom">
      {$taxtag}
    </div>
  </div>
</li>
EOM;
        $i++;
      }
    }
  } else {
    $returnObj['tags'] .= '<li>史跡の登録がありません。</li>';
  }



  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapDistSearchFunc', 'mapDistSearchFunc' );
add_action( 'wp_ajax_nopriv_mapDistSearchFunc', 'mapDistSearchFunc' );