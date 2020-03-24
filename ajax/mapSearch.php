<?php
/*
 * Google Map Ajax
*/
function mapSearchFunc(){
  global $osfw;
  $returnObj = array();
  $mapid     = $_POST['mapid'];
  $marker_size = $_POST['marker_size'];
  $disp_num  = $_POST['disp_num']; // 表示させたい記事件数
  $query_args = $_POST['query_args'];
  $disp_num   = $_POST['disp_num'];
  $select_tax_val = $_POST['selectTaxVal'];
  $select_field_val = $_POST['selectFieldVal'];
  $input_text_val = $_POST['inputTextVal'];
  
  $returnObj['tags'] = '';

ob_start();
var_dump( $select_field_val );
$out = ob_get_contents();
ob_end_clean();
file_put_contents(dirname(__FILE__) . '/test.txt', $out, FILE_APPEND);


  // タクソノミー絞り込み
  $tax_query = array( 'relation' => 'AND' );
  if( isset($select_tax_val) ) {
    foreach ($select_tax_val as $tax_slug => $tax_term_id) {
      if( $tax_term_id!='' ) {
        $temp_arr[] = array('taxonomy'=>$tax_slug, 'field' => 'id', 'terms' => array( (int)$tax_term_id ) );
      }
    }
    $tax_query = array_merge( $tax_query, $temp_arr );
  }
  unset($temp_arr);

  // カスタムフィールド絞り込み
  $meta_query = array( 'relation' => 'AND' );
  if( isset($select_field_val) ) {
    if( $select_field_val['value']!='' && $select_field_val['type'] === 'NUMERIC' ) {
      $temp_arr[] = array(
        'key'   => $select_field_val['fieldname'], 
        'value' => $select_field_val['value'],
        'type'  => $select_field_val['type'],
        'compare' => $select_field_val['compare']
      );
    } else if( $select_field_val['value']!='' ) {
      $temp_arr[] = array(
        'key'   => $select_field_val['fieldname'], 
        'value' => $select_field_val['value']
      );
    } else {}
    if( isset($temp_arr) ) $meta_query = array_merge( $meta_query, $temp_arr );
  }
  unset($temp_arr);

  // 検索ワードを指定
  if( isset($input_text_val) ) {
    $search_word = $input_text_val;
  }
  
  // 絞り込み条件を結合
  $query_args = isset($tax_query) ?  array_merge( $query_args, array( 'tax_query'=>$tax_query ) ) : $query_args;
  $query_args = isset($meta_query) ? array_merge( $query_args, array( 'meta_query'=>$meta_query ) ) : $query_args;
  $query_args = isset($search_word) ? array_merge( $query_args, array( 's'=>$search_word ) ) : $query_args;

  $the_query = new WP_Query( $query_args );

  
  $returnObj['found_posts'] = $the_query->found_posts;
  $returnObj['post_count']  = $the_query->post_count;
  if( $the_query->found_posts > $disp_num ) {
    $returnObj['tags_btn'] = '
      <div id="mapSearchBtn" class="btn-1">
      <a href="' . $osfw->get_archive_link('landmark') . '">過去の特集記事の一覧 
      <i class="fas fa-angle-double-right"></i>
      </a>
      </div>
    ';
  } else {
    $returnObj['tags_btn'] = '';
  }



  if ($the_query->have_posts()) {
    $i=0;
    while($the_query->have_posts()) {
      $the_query->the_post();
      $loop_gmap = get_post_meta( get_the_ID(), 'acf_landmark_gmap', true );
      $loop_address = get_post_meta( get_the_ID(), 'acf_landmark_address', true );


      // get main category of the landmark_cateogry post.
      $main_cat_id = '';
      $loop_catmain_id = get_post_meta( get_the_ID(), 'acf_landmark_cateogry_main', true );
      // get all taxonomy term list of 'landmark_cateogry' and set main category id
      $get_terms = get_the_terms(get_the_ID(), 'landmark_cateogry');
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
      // // marker image
      // $loop_marker_id = get_post_meta( get_the_ID(), 'acf_landmark_gmap_marker', true );
      // if( $loop_marker_id ) {
      //   $temp_marker = $osfw->get_thumbnail( $loop_marker_id, 'full' );
      //   $marker = $temp_marker['src'];
      // } else {
      //   $marker = get_stylesheet_directory_uri() . '/images/common/icon-marker-noimage.png';
      // }
      // marker image
      $marker_id = get_post_meta( get_the_ID(), 'acf_landmark_gmap_marker', true );
      if( $marker_size==='img_marker_large' ) {
        $set_marker_size = 'img_marker_large';
      } else if( $marker_size==='img_marker_middle' ) {
        $set_marker_size = 'img_marker_middle';
      } else if( $marker_size==='img_marker_small' ) {
        $set_marker_size = 'img_marker_small';
      } else {
        $set_marker_size = 'full';
      }
      $temp_marker = $osfw->get_thumbnail( $marker_id, $set_marker_size, get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg' );
      $marker = $temp_marker['src'];
      // create marker
      $returnObj['markerDataAjax'][$i]['id']   = get_the_ID();
      $returnObj['markerDataAjax'][$i]['name'] = get_the_title();
      $returnObj['markerDataAjax'][$i]['lat']  = floatval($loop_gmap['lat']);
      $returnObj['markerDataAjax'][$i]['lng']  = floatval($loop_gmap['lng']);
      $returnObj['markerDataAjax'][$i]['cat']  = $term_list;
      $returnObj['markerDataAjax'][$i]['cat_icon'] = $marker;
      $returnObj['markerDataAjax'][$i]['infoWindowContent'] = gmap_infowindow( get_the_ID(), $mapid . "_" . get_the_ID() );
      $returnObj['tags'] .= get_tag_postlist( get_the_ID(), 'landmark_cateogry', $loop_address, 'mapSearchClick' );
      
      $i++;
    }
  }
  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_mapSearchFunc', 'mapSearchFunc' );
add_action( 'wp_ajax_nopriv_mapSearchFunc', 'mapSearchFunc' );

