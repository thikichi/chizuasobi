<?php
function mapDistSearchFunc(){
    global $osfw;
    $returnObj = array();
    $dist  = $_POST['dist'];
    $mapid  = $_POST['mapid'];
    $post_id = $_POST['post_id'];
    $query_post_type = $_POST['query_post_type'];
    $query_terms     = isset($_POST['query_terms']) ? $_POST['query_terms'] : '';
    $query_postid    = $_POST['query_postid'];
    $display_mode    = $_POST['display_mode']; // default: replace
    $disp_num   = $_POST['disp_num']; // 表示させたい記事件数
    $disped_num = $display_mode=='replace' ? 0 :  $_POST['disped_num']; // すでに表示されている件数

    // 現在の投稿
    $main_post = get_post( $post_id );
    $post_map_center = get_post_meta( $post_id, 'acf_landmark_gmap', true );
    $lat_init = $post_map_center['lat'];
    $lng_init = $post_map_center['lng'];
    $terms = get_the_terms($post_id, 'landmark_cateogry');
    $term_list = '[';
    foreach ( $terms as $term ) {
      $term_list .= "'" . $term->term_id . "'";
      if ($term !== end($terms)) $term_list .= ',';
    }
    $term_list .= ']';
    // marker image
    $marker_id = get_post_meta( $post_id, 'acf_landmark_gmap_marker', true );
    $marker = $osfw->get_thumbnail( $marker_id, 'img_marker_large', get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
    // ajax object
    $returnObj['markerDataAjax'][0]['id']   = $mapid . '_' . $post_id;
    $returnObj['markerDataAjax'][0]['name'] = $this_post->post_title;
    $returnObj['markerDataAjax'][0]['lat']  = floatval($lat_init);
    $returnObj['markerDataAjax'][0]['lng']  = floatval($lng_init);
    $returnObj['markerDataAjax'][0]['cat']  = $term_list;
    $returnObj['markerDataAjax'][0]['dist'] = $thisdist;
    $returnObj['markerDataAjax'][0]['cat_icon'] = $marker['src'];
    $returnObj['markerDataAjax'][0]['infoWindowContent'] = gmap_infowindow( $post_id, $mapid . "_" . $post_id );


    // 現在の投稿
    // $this_posts     = get_posts( array( 'post_type'=>$query_post_type, 'numberposts'=>-1 ) );
    // $this_gmap = get_post_meta( $query_postid, 'acf_landmark_gmap', true );
    // $thisdist = distance($this_gmap['lat'], $this_gmap['lng'], $this_gmap['lat'], $this_gmap['lng'], true);
    // foreach ($this_posts as $this_post) {
    // }

    $this_gmap = get_post_meta( $query_postid, 'acf_landmark_gmap', true );
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
        // 距離内にある投稿かどうかを判別する
        if( $thisdist < $dist ) {
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
          // get main category of the landmark_cateogry post.
          $main_cat_id = '';
          $loop_catmain_id = get_post_meta( $term_post->ID, 'acf_landmark_cateogry_main', true );
          // get all taxonomy term list of 'landmark_cateogry' and set main category id
          $get_terms = get_the_terms($term_post->ID, 'landmark_cateogry');
          if( $get_terms!='' && $loop_catmain_id!='' ) {
            foreach ($get_terms as $key => $get_term) {
              if( $get_term->term_id===(int)$loop_catmain_id ) {
                $main_cat_id = $get_term->term_id;
              }
            }
          } else {
            $main_cat_id = $get_terms[0]->term_id;
          }
          // set icon from taxonomy term ID.
          $cat_icon_id = $osfw->get_term_cfield('landmark_cateogry', $main_cat_id, 'acf_landmark_cateogry_icon');
          $cat_icon = $cat_icon_id!='' ? $osfw->get_thumbnail( $cat_icon_id, 'full' ) : '';
          // marker image
          $marker_id = get_post_meta( $term_post->ID, 'acf_landmark_gmap_marker', true );
          $marker = $osfw->get_thumbnail( $marker_id, 'img_marker_large', get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
          // マーカーオブジェクトをつくる
          $returnObj['markerDataAjax'][$i]['id']   = $term_post->ID;
          $returnObj['markerDataAjax'][$i]['name'] = $term_post->post_title;
          $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
          $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
          $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
          $returnObj['markerDataAjax'][$i]['dist'] = $thisdist;
          $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker['src'];
          $returnObj['markerDataAjax'][$i]['infoWindowContent'] = gmap_infowindow( $term_post->ID, $mapid . "_" . $term_post->ID );
          // 距離内の記事一覧をIDで取得
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
          // get post list
          $returnObj['tags'] .= get_tag_postlist( get_the_ID(), 'landmark_cateogry', $cfield_addr );
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