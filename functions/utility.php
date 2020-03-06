<?php
/*----------------------------------------------------------------------------------------------------*/
/* ユーティリティー
/*----------------------------------------------------------------------------------------------------*/

// ベースとなるクラスを読み込む
include_once get_template_directory() . '/functions/os-framework-manager/class/os-fm-base.php';

/*
* ユーティリティークラス
*/
class utilityClass extends OsFmBase {

  function __construct() {
    // 親クラスのコンストラックタを呼ぶ
    parent::__construct();

  }

  /**
   * アーカイブタイトルを表示する（投稿一覧も対象）
   *
   */
  public function get_archive_title() {
    $title_name = '';
    if(is_category()) {
      $title_name = single_cat_title('', false);
    } else if(is_tag()) {
      $title_name = single_tag_title('', false);
    } else if(is_tax()) {
      $title_name = single_term_title( '' , false );
    } elseif(is_year() || is_month() || is_date()) {
      $title_name = get_the_archive_title();
    } elseif(is_archive()) {
      $title_name = post_type_archive_title('',false);
    } elseif(is_home()) {
      $title_name = get_the_title();
    }
    return $title_name;
  }

  /**
   * アーカイブおよびシングルページのタイトルを表示する
   *
   */
  public function get_title() {
    $title_name = '';
    if(is_single()) {
      $title_name = get_the_title();
    } else {
      $title_name = $this->get_archive_title();
    }
    return $title_name;
  }

  /**
   * カスタムフィールドの値をタグと共に返す
   */
  public function get_field_tag( $post_id, $field_name, $alt='', $start_tag='', $end_tag='', $nl2br=false, $escape=true, $escape_param=array() ) {
    $temp_cfield = get_post_meta( $post_id, $field_name, true );
    $cfield = $temp_cfield!='' ? $temp_cfield : $alt;
    $cfield = $cfield!='' ? $start_tag . $cfield . $end_tag : '';
    if( $nl2br ) {
      $cfield = nl2br( $cfield );
    }
    if( $escape ) {
      if( !empty($escape_param) ) {
        $cfield = $this->wp_kses( $cfield, $escape_param );
      } else {
        $cfield = $this->wp_kses( $cfield );
      }
    }
    return $cfield;
  }

  /*
   * 入力内容をサニタイズして出力する
   * @param string $text target text
   * @param array  $allowed_html allowed tags
   * @return string Filtered string of HTML
  */
  public function wp_kses( $text, $allowed_html=array() ) {
    $allowed = !empty($allowed_html) ? $allowed_html : wp_kses_allowed_html( 'post' );
    return wp_kses($text, $allowed);
  }

  /*
   * 投稿にひもづけられたアイキャッチ画像の情報を取得
   * @param number $post_id 投稿ID
   * @param string $size サムネイルのサイズ
   * @param string  $alter_img_src 代替するテキスト
   * @return array 画像情報が格納された配列
  */
  public function get_thumbnail_by_post( $post_id, $size='medium', $alter_img_src = '' ) {
    $thumb_id = get_post_thumbnail_id( $post_id );
    return $this->get_thumbnail( $thumb_id, $size, $alter_img_src );
  }

  /*
   * アイキャッチ画像の情報をそのIDから取得
   * @param number $post_id 投稿ID
   * @param string $size サムネイルのサイズ
   * @param string  $alter_img_src 代替するテキスト
   * @return array 画像情報が格納された配列
  */
  public function get_thumbnail( $thumb_id, $size='medium', $alter_img_src = '' ) {
    if( $thumb_id ) {
      $eyecatch_img = wp_get_attachment_image_src( $thumb_id , $size );
      $rdata['src'] = $eyecatch_img[0];
      $rdata['width']  = $eyecatch_img[1];
      $rdata['height'] = $eyecatch_img[2];
      $rdata['alt']    = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
      $rdata['title']  = get_post( $thumb_id )->post_title;
      $rdata['excerpt']= get_post( $thumb_id )->post_excerpt;
      $rdata['content']= get_post( $thumb_id )->post_content;
    } else if( $alter_img_src!='' ) {
      $rdata['src'] = $alter_img_src;
      $rdata['alt'] = '';
    } else {
      $rdata = '';
    }
    return $rdata;
  }

  /*
   * イメージタグを組み立てて表示する
   * @param array $param 投稿ID
   * @param boolean $is_width  幅を設定するかを指定
   * @param boolean $is_height 高さを設定するかを指定
   * @return array IMGタグ
  */
  public function the_image_tag( $param, $is_width=false, $is_height=false ) {
    $tag = '';
    $src = isset($param['src']) && $param['src']!='' ? $param['src'] : '';
    $alt = isset($param['alt']) && $param['alt']!='' ? $param['alt'] : '';
    $id = isset($param['id']) && $param['id']!='' ? $param['id'] : '';
    $class = isset($param['class']) && $param['class']!='' ? $param['class'] : '';
    $width = $is_width && isset($param['width']) ? $param['width'] : '';
    $height= $is_height && isset($param['height']) ? $param['height'] : '';
    if( $src ) {
      $tag .= '<img';
      if($src!='') $tag .= ' src="'. esc_url($src)  .'"';
      if($alt!='') $tag .= ' alt="'. $alt  .'"';
      if($id!='')  $tag .= ' id="'. $id  .'"';
      if($width!='') $tag .= ' width="'. $width  .'"';
      if($height!='') $tag .= ' height="'. $height  .'"';
      $tag .= '>';
    } else {
      echo '';
    }
    echo $tag;
  }

  /*
   * カスタムフィールドでキーが重複している場合の値を取得
   * Smart Custom Fieldなどのプラグインで使うと便利
  */
  public function get_post_meta_group( $post_id, $key ) {
    $cfields = get_post_meta( $post_id, $key, false );
    if( count($cfields) <= 1 && $cfields[0]=='' ) {
      $rdata = '';
    } else {
      $rdata = $cfields;
    }
    return $rdata;
  }

  /*
   * 固定ページのスラッグを指定してそのパーマリンクを取得する
  */
  public function get_page_link( $slug ) {
    //固定ページのスラッグからページを取得
    $page = get_page_by_path( $slug );
    //ページIDからURLを取得
    $page_url = get_permalink( $page->ID );
    if( $page_url ) {
      $tag = esc_url($page_url);
    } else {
      $tag = '#';
    }
    return $tag;
  }

  /*
   * タクソノミーとタームを指定してそのパーマリンクを取得する
  */
  public function get_term_link( $slug, $tax='category' ) {
    $term_link = get_term_link($slug, $tax);
    if( !is_wp_error($term_link) ) {
      $tag = esc_url($term_link);
    } else {
      $tag = '#';
    }
    return $tag;
  }

  /*
   * 投稿タイプを指定してそのアーカイブのパーマリンクを取得する
  */
  public function get_archive_link( $post_type ) {
    return get_post_type_archive_link( $post_type );
  }

  /**
   * AFC タームに設定のフィールドを取得する
   */
  public function get_term_cfield($tax_slug, $term_id, $field_name) {
    $rdata = get_field( $field_name, $tax_slug . '_' . $term_id);
    return $rdata;
  }

  /**
   * 指定のタームにひもづく投稿のカスタムフィールドを取得
   */
  public function get_post_cfield_by_term( $post_type, $taxonomy, $term_slug, $cfield, $num=-1, $start_tag='', $end_tag='', $alt='' ) {
    $ad_cats = get_term_by('slug', $term_slug, $taxonomy);
    $ad_post = get_posts(
      array(
        'post_type' => $post_type,
        'showposts' => $num,
        'tax_query' => array(
          array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term_slug
          )
        )
      )
    );
    if( !empty($ad_post) ) {
      $ad_post_id = $ad_post[0]->ID;
      // $rdata = get_post_meta( $ad_post_id, $cfield, true );
      $rdata = $this->get_field_tag( $ad_post_id, $cfield, $alt, $start_tag, $end_tag, false, false);
    } else {
      $rdata = '';
    }
    return $rdata;
  }

  /**
  * mobileだけ出力を分ける
  */
  public function is_mobile() {
    $useragents = array(
        'iPhone',          // iPhone
        'iPod',            // iPod touch
        '^(?=.*Android)(?=.*Mobile)', // 1.5+ Android
        'dream',           // Pre 1.5 Android
        'CUPCAKE',         // 1.5+ Android
        'blackberry9500',  // Storm
        'blackberry9530',  // Storm
        'blackberry9520',  // Storm v2
        'blackberry9550',  // Storm v2
        'blackberry9800',  // Torch
        'webOS',           // Palm Pre Experimental
        'incognito',       // Other iPhone browser
        'webmate'          // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
  }

  /**
  * 文字を丸める関数
  */
  public function get_excerpt_filter( $text, $num=50, $more_text='...続きを読む', $link='', $target='', $charset='UTF-8' ) {
    if( $link!='' ) {
      $target = $target!='' ? ' target="' . $target . '"' : '';
      $more_text = '<a href="' . esc_url($link) . '"' . $target . '>' . $more_text . '</a>';
    }
    $str_disp = mb_substr( $text, 0, $num );
    if( mb_strlen( $str_disp, 'UTF-8' ) >= $num ) {
      return $str_disp . $more_text;
    } else {
      return $str_disp;
    }
  }
}

// ユーティリティークラスのオブジェクトを作成
$osfw = new utilityClass();