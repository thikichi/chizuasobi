<?php
/*
Script Name:  OS Subquery search
Description:  This is search system for wordpress.
Version:      1.0.0
Author:       t.hikichi
License:      GPL license
*/

/*
* 複合検索クラス
*/
class ComplexSearch {

  private $search_values;
  private $search_values_field;
  private $search_values_field_gloup;
  private $logical_value;
  private $post_type;
  private $search_values_text;
  private $search_values_text2;
  private $search_values_gloup;
  private $tax_query_relation;
  private $tax_query_relation_gloup;
  private $search_query;
  private $is_freeword_tax_field = true;
  private $the_query = false;
  private $get_subquery_args;
  private $default_param;
  private $posts_per_page;
  private $order_param;
  private $cfield_keys;
  private $tax_keys;
  private $no_search_mode = '1';
  private $hidden_search_done;

  function __construct() {
    $this->search_values = array();
    $this->search_values_field = array();
    $this->search_values_field_gloup = array();
    $this->search_values_text  = array();
    $this->search_values_text2  = array();
    $this->logical_value = array();
    $this->tax_query_relation = 'AND';
    $this->tax_query_relation_gloup = array();
    $this->meta_query_relation = 'AND';
    $this->meta_query_relation_gloup = array();
    $this->posts_per_page = '';
    $this->post_type = 'post';
    $this->search_values_gloup = array();
    $this->default_param = array();
    $this->order_param = array( 'order' => '__ORDER__', 'orderby' => '__ORDERBY__', 'meta_key' => '__METAKEY__');
    $this->hidden_search_done = array('name' => 'os_subquery_search_done', 'value' => '1');
    // カスタムフィールドのキー
    $this->cfield_keys = array(
      'class'      => '',
      'id'         => '',
      'key'        => '',
      'values'     => array(),
      'compare'    => 'LIKE',
      'type'       => 'CHAR',
      'srch_label' => '',
      'vertical'   => false,
      'is_label_front' => false,
      'gloup'      => '',
      'is_counter' => false,
      '_key'       => '',
      '_compare'   => array(),
      '_type'      => 'CHAR',
      '_srch_label'=> '',
    );
    // タクソノミーのキー
    $this->tax_keys = array(
      'taxonomy'    => '',
      'operator'    => 'IN',
      'is_counter'  => false,
      'is_label_front' => false,
      'gloup'       => '',
      'srch_label'  => '',
      'vertical'    => false,
      'class'       => '',
      'id'          => '',
      '_taxonomy'   => '',
      '_operator'   => 'IN',
      '_srch_label' => '',
    );
  }

  /**
   * セッターとしてフリーワード検索にカスタムフィールドやカスタムタクソノミーを含めるか指定
   */
  public function set_is_freeword_tax_field( $boolean ) {
    $this->is_freeword_tax_field = $boolean ? true : false;
  }

  /**
   * セッターとして論理値を設定する。
   */
  public function set_logical_value($name, $value) {
    $this->logical_value[$name] = $value;
  }

  /**
   * セッターとして投稿タイプを設定する。
   */
  public function set_post_type($post_type=array('post')) {
    $this->post_type = $post_type;
  }

  /**
   * セッターとしてタクソノミーの絞込み条件を追加
   */
  public function set_tax_query_relation($value) {
    $this->tax_query_relation = $value;
  }

  /**
   * セッターとしてタクソノミーグループ内の絞込み条件を追加
   */
  public function set_tax_query_relation_gloup( $args ) {
    foreach ($args as $gloup_name => $relation_value) {
      $this->tax_query_relation_gloup[$gloup_name] = $relation_value;
    }
  }

  /**
   * セッターとして（カスタムフィールドの）絞込み条件を追加
   */
  public function set_meta_query_relation($value) {
    $this->meta_query_relation = $value;
  }

  /**
   * セッターとして（カスタムフィールドの）絞込み条件を追加
   */
  public function set_meta_query_relation_gloup( $args ) {
    foreach ($args as $gloup_name => $relation_value) {
      $this->meta_query_relation_gloup[$gloup_name] = $relation_value;
    }
  }

  /**
   * セッターとして表示する記事件数をセット
   */
  public function set_posts_per_page($value) {
    $this->posts_per_page = $value;
  }

  /**
   * セッターとしてデフォルトの初期パラメータを指定する（上級）
   */
  public function set_default_param($value) {
    $this->default_param = $value;
  }

  /**
   * 検索が実行されなかった時のデフォルトの挙動
   */
  public function set_no_search_result($mode=1) {
    switch ($mode) {
      case 1:
        # 指定の投稿を全件表示
      $this->no_search_mode = '1';
        break;
      case 2:
        # 投稿を表示しない
      $this->no_search_mode = '2';
        break;
      default:
        # 指定の投稿を全件表示
      $this->no_search_mode = '1';
        break;
    }
  }

  /**
   * 検索フォームに必要なセッティング項目を追加する（隠しフィールドなど）
   */
  public function setup_form() {
    echo '<input type="hidden" name="' . $this->hidden_search_done['name'] . '" value="' . $this->hidden_search_done['value'] . '">';
  }

  /**
   * 並び替えを指定するフォームを出力
   */
  // $args = array(
  //   'type'   => 'select',
  //   'values' => array(
  //     array('label' => '価格の安い順', 'orderby' => 'meta_value', 'meta_key' => 'test_key', 'order' => 'DESC'),
  //     array('label' => '価格の高い順', 'orderby' => 'meta_value', 'meta_key' => 'test_key', 'order' => 'ASC'),
  //     array('label' => 'おすすめ昇順',  'orderby' => 'cf_rmd',     'meta_key' => 'test_key', 'order' => 'ASC'),
  //   ),
  // );
  // echo $csearch->form_set_order_tags( $args );

  public function form_set_order_tags( $args = array() ) {
    $type = isset($args['type']) ? $args['type'] : 'select';
    $single_mode = isset($args['single_mode']) ? $args['single_mode'] : false;
    $values = isset($args['values']) ? $args['values'] : array();
    $name   = 'select_order_value';
    $getval         = isset($_GET[$name]) ? $_GET[$name] : array();
    $vertical       = isset($args['vertical']) ? $args['vertical'] : false;
    $is_counter     = isset($args['is_counter']) ? $args['is_counter'] : false;
    $is_label_front = isset($args['is_label_front']) && $args['is_label_front']===true ? true : false;
    $class          = isset($args['class']) ? $args['class'] : '';
    $id             = isset($args['id'])    ? $args['id']    : '';
    $tag = '';
    $temp_qstring = isset($_SERVER['QUERY_STRING']) ? '&' . $_SERVER['QUERY_STRING'] : '&';
    $qstring = $temp_qstring;
    switch ( $type ) {
      case 'select':
        // selectboxの場合
        $opt_values = array();
        $i=0;
        if( is_array($values) ) {
          foreach ($values as $option) {
            $value = '';
            foreach ($this->order_param as $key => $ptn) {
              $value .= isset($option[$key]) ? $ptn . $option[$key] . $ptn : '';
            }
            if( $single_mode ) {
              $qstring = 'is-os-search-form=1' . $qstring;
              foreach ($this->order_param as $key => $ptn) {
                $qstring = preg_replace('/' . $ptn . '.+' . $ptn . '/', '', $qstring);
              }
              $opt_values[$i]['value'] = '?' . $qstring . '&' . $name . '=' . $value;
            } else {
              $opt_values[$i]['value'] = $value;
            }
            
            $opt_values[$i]['label'] = $option['label'];
            $i++;
          }
        }
        if( !empty($getval) ) {
          $getval = '?' . $qstring . '&' . $name . '=' . $getval;
        }
        $selectval = isset($_GET[$name]) ? $_GET[$name] : '';
        $tag .= $this->get_tags_selectbox( $name, $opt_values, $selectval, $is_counter, $class, $id, $single_mode );

        break;
      case 'redio':
        // redioボタン
        foreach ($values as $option) {
          $value = '';
          foreach ($this->order_param as $key => $ptn) {
            $value .= isset($option[$key]) ? $ptn . $option[$key] . $ptn : '';
          }
          $checked = $value==$getval ? ' checked' : '';
          // Checkbox出力
          $tag .= $this->get_tags_radio(
            $name,
            $value,
            $checked,
            $option['label'],
            $vertical,
            $is_label_front,
            $class,
            $id
          );
        }
        $tag .= "\n";
        break;
      default:
        break;
    }
    return $tag;
  }

  /**
   * チェックボックスを出力する（直接に配列をわたす場合）
   */
  public function form_checkbox_customfield_tags( $args=array() ) {

    foreach ($this->cfield_keys as $ckey => $cvalue) {
      ${$ckey} = isset($args[$ckey]) ? $args[$ckey] : $cvalue;
    }
    static $i = 0;
    $name = 'cfield_checkbox_' . $i;
    $arr_selected_values = isset($_GET[$name]) ? $_GET[$name] : array();
    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field_gloup[$gloup]['check'][$i][$ckey] = ${$ckey};
      }
      $this->search_values_field_gloup[$gloup]['check'][$i]['name']    = $name;
    } else {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field['check'][$i][$ckey] = ${$ckey};
      }
      $this->search_values_field['check'][$i]['name']    = $name;
    }
    $i++;

    $arr_selected_values = isset($_GET[$name]) ? $_GET[$name] : array();
    $tag = '';
    foreach ($values as $value_key => $value_value) {
      $checked = in_array($value_key, $arr_selected_values) ? ' checked' : '';
      $count   = $this->get_custom_field_count( $this->post_type, $key, $value_value );
      $counter = $is_counter ? '(' . $count . ')' : '';
      // Checkbox出力
      $tag .= $this->get_tags_checkbox(
        $name,
        $value_key,
        $checked,
        $value_value . $counter,
        $vertical,
        $is_label_front,
        $class,
        $id
      );
    }
    $tag .= "\n";
    return $tag;
  }

  /**
   * カスタムフィールドでラジオボタンを出力する
   */
  public function form_radio_customfield_tags( $args=array() ) {

    foreach ($this->cfield_keys as $ckey => $cvalue) {
      ${$ckey} = isset($args[$ckey]) ? $args[$ckey] : $cvalue;
    }
    static $i = 0;
    $name = 'cfield_radio_' . $i;
    $selected_values = isset($_GET[$name]) ? $_GET[$name] : array();

    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field_gloup[$gloup]['radio'][$i][$ckey] = ${$cvalue};
      }
      $this->search_values_field_gloup[$gloup]['radio'][$i]['name'] = $name;
    } else {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field['radio'][$i][$ckey] = ${$ckey};
      }
      $this->search_values_field['radio'][$i]['name']    = $name;
    }
    $i++;
    $tag = '';
    foreach ($values as $value => $label) {
      $checked = $value==$selected_values ? ' checked' : '';
      $count   = $this->get_custom_field_count( $this->post_type, $key, $label );
      $counter = $is_counter ? '(' . $count . ')' : '';
      // Checkbox出力
      $tag .= $this->get_tags_radio(
        $name,
        $value,
        $checked,
        $label . $counter,
        $vertical,
        $is_label_front,
        $class,
        $id
      );
    }
    $tag .= "\n";
    return $tag;
  }

  /**
   * カスタムフィールドでセレクトボックスを出力する
   */
  public function form_selectbox_customfield_tags( $args=array() ) {
    foreach ($this->cfield_keys as $ckey => $cvalue) {
      ${$ckey} = isset($args[$ckey]) ? $args[$ckey] : $cvalue;
    }
    static $i = 0;
    $name = 'cfield_select_' . $i;
    $selected_value = isset($_GET[$name]) ? $_GET[$name] : '';
    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field_gloup[$gloup]['select'][$i][$ckey] = ${$ckey};
      }
      $this->search_values_field_gloup[$gloup]['select'][$i]['name']    = $name;
    } else {
      foreach ($this->cfield_keys as $ckey => $cvalue) {
        $this->search_values_field['select'][$i][$ckey] = ${$ckey};
      }
      $this->search_values_field['select'][$i]['name']    = $name;
    }
    $i++;
    $opt_values = array();
    if( is_array($values) ) {
      foreach ($values as $value_value => $value_label) {
        $opt_values[$i]['value'] = $value_value;
        $opt_values[$i]['label'] = $value_label;
        $opt_values[$i]['count'] = $this->get_custom_field_count( $this->post_type, $key, $value_value );
        $i++;
      }
    }
    $tag = $this->get_tags_selectbox( $name, $opt_values, $selected_value, $is_counter, $class, $id );
    $tag .= "\n";
    return $tag;
  }

  /**
   * チェックボックスを出力する
   */
  public function form_checkbox_tax_tags( $args = array() ) {
    static $i = 0;
    foreach ($this->tax_keys as $tkey => $tvalue) {
      ${$tkey} = isset($args[$tkey]) ? $args[$tkey] : $tvalue;
    }
    $is_label_front = isset($args['is_label_front']) && $args['is_label_front']===true ? true : false;
    $name = 'checkbox' . $i;

    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values_gloup[$gloup]['checkbox'][$i][$tkey] = ${$tkey};
      }
      $this->search_values_gloup[$gloup]['checkbox'][$i]['name']     = $name;
    } else {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values['checkbox'][$i][$tkey] = ${$tkey};
      }
      $this->search_values['checkbox'][$i]['name']     = $name;
    }
    $i++;

    $arr_selected_values = isset($_GET[$name]) ? $_GET[$name] : array();
    $tag = '';
    $get_terms = get_terms(array('taxonomy'=>$taxonomy, 'get'=>'all'));
    foreach ($get_terms as $get_term) {
      $counter = $is_counter ? '(' . $get_term->count . ')' : '';
      $checked = in_array($get_term->term_id, $arr_selected_values) ? ' checked' : '';
      // Checkbox出力
      $tag .= $this->get_tags_checkbox(
        $name,
        $get_term->term_id,
        $checked,
        $get_term->name . $counter,
        $vertical,
        $is_label_front,
        $class,
        $id
      );
    }
    $tag .= '<input type="hidden" name="operator_' . $name . '" value="' . $operator . '">';
    $tag .= "\n";
    return $tag;
  }

  /**
   * ラジオボタンを出力する
   */
  public function form_radio_tax_tags( $args = array() ) {
    foreach ($this->tax_keys as $tkey => $tvalue) {
      ${$tkey} = isset($args[$tkey]) ? $args[$tkey] : $tvalue;
    }
    static $i = 0;
    $name = 'radio' . $i;
    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values_gloup[$gloup]['radio'][$i][$tkey] = ${$tkey};
      }
      $this->search_values_gloup[$gloup]['radio'][$i]['name']     = $name;
    } else {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values['radio'][$i][$tkey] = ${$tkey};
      }
      $this->search_values['radio'][$i]['name']     = $name;
    }
    $i++;
    $tag = '';
    $selected_value = isset($_GET[$name]) ? $_GET[$name] : array();
    $get_terms = get_terms(array('taxonomy'=>$taxonomy, 'get'=>'all'));
    foreach ($get_terms as $get_term) {
      $checked = $get_term->term_id==$selected_value ? ' checked' : '';
      $counter = $is_counter ? '(' . $get_term->count . ')' : '';
      // Checkbox出力
      $tag .= $this->get_tags_radio(
        $name,
        $get_term->term_id,
        $checked,
        $get_term->name . $counter,
        $vertical,
        $is_label_front,
        $class,
        $id
      );
    }
    $tag .= '<input type="hidden" name="operator_' . $name . '" value="' . $operator . '">';
    $tag .= "\n";
    return $tag;
  }

  /**
   * セレクトボックスを出力する
   */
  public function form_selectbox_tax_tags( $args ) {
    foreach ($this->tax_keys as $tkey => $tvalue) {
      ${$tkey} = isset($args[$tkey]) ? $args[$tkey] : $tvalue;
    }
    static $i = 0;
    $name = 'select' . $i;
    // グループが指定されているかを判定
    if( $gloup!='' ) {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values_gloup[$gloup]['select'][$i][$tkey] = ${$tkey};
      }
      $this->search_values_gloup[$gloup]['select'][$i]['name']     = $name;
    } else {
      foreach ($this->tax_keys as $tkey => $tvalue) {
        $this->search_values['select'][$i][$tkey] = ${$tkey};
      }
      $this->search_values['select'][$i]['name']     = $name;
    }
    $i++;
    $selected_value = isset($_GET[$name]) ? $_GET[$name] : '';
    $get_terms = get_terms(array('taxonomy'=>$taxonomy, 'get'=>'all'));
    $values = array();
    $i=0;
    foreach ($get_terms as $get_term) {
      $values[$i]['value'] = $get_term->term_id;
      $values[$i]['label'] = $get_term->name;
      $values[$i]['count'] = $get_term->count;
      $i++;
    }
    $tag = $this->get_tags_selectbox( $name, $values, $selected_value, $is_counter, $class, $id );
    return $tag;
  }

  /**
   * チェックボックスのタグを生成する
   */
  private function get_tags_checkbox( $name, $value, $checked, $text, $vertical, $is_label_front='', $class='', $id='' ) {
    $class = $class!='' ? ' class="' . $class . '"' : '';
    $id    = $id!='' ? ' id="' . $id . '"' : '';
    $tag  = '';
    $tag .= '<label>';
    if($is_label_front) $tag .= $text;
    $tag .= '<input ';
    $tag .= 'type="checkbox" ';
    $tag .= 'name="' . $name . '[]" ';
    $tag .= 'value="' . $value . '"';
    $tag .= $checked;
    $tag .= $class . $id;
    $tag .= '>';
    if(!$is_label_front) $tag .= $text;
    if($vertical) $tag .= '<br>';
    $tag .= "\n";
    $tag .= '</label>';
    return $tag;
  }

  /**
   * ラジオボタンのタグを生成する
   */
  private function get_tags_radio( $name, $value, $checked, $text, $vertical, $is_label_front, $class='', $id='' ) {
    $class = $class!='' ? ' class="' . $class . '"' : '';
    $id    = $id!='' ? ' id="' . $id . '"' : '';
    $tag  = '';
    $tag .= '<label>';
    if($is_label_front) $tag .= $text;
    $tag .= '<input ';
    $tag .= 'type="radio" ';
    $tag .= 'name="' . $name . '" ';
    $tag .= 'value="' . $value . '"';
    $tag .= $checked;
    $tag .= $class . $id;
    $tag .= '>';
    if(!$is_label_front) $tag .= $text;
    if($vertical) $tag .= '<br>';
    $tag .= "\n";
    $tag .= '</label>';
    return $tag;
  }

  /**
   * セレクトボックスのタグを生成する
   */
  private function get_tags_selectbox( $name, $opt_values, $selected_value, $is_counter=false, $class='', $id='', $single_mode=false ) {
    $class = $class!='' ? ' class="' . $class . '"' : '';
    $id    = $id!='' ? ' id="' . $id . '"' : '';
    $single_mode = $single_mode ? ' onchange="location.href=value;"' : '';
    $tag  = '';
    $tag .= '<select name="' . $name . '"' . $class . $id . $single_mode . '>';
    $tag .= '<option value="">- 選択してください -</option>' . "\n";
    foreach ($opt_values as $opt_value) {
      $cnt = $is_counter ? '(' . $opt_value['count'] . ')' : '';
      $selected = $opt_value['value']==$selected_value ? ' selected' : '';
      $tag .= '<option value="' . $opt_value['value'] . '"' . $selected . '>';
      $tag .= $opt_value['label'];
      if($cnt) $tag .= $cnt;
      $tag .= '</option>' . "\n";
    }
    $tag .= '</select>';
    $tag .= "\n";
    return $tag;
  }

  /**
   * カスタムフィールドによる記事数取得
   */
  private function get_custom_field_count( $post_type = 'post', $post_meta_key = null ,$post_meta_value = null ) {
    $args = array(
      'post_type'  => $post_type,
      'meta_key'   => $post_meta_key,
      'meta_value' => $post_meta_value,
      'posts_per_page' => -1
    );
    $meta_posts = get_posts($args);
    $count_post = 0;
    foreach ($meta_posts as $post) {
      $count_post++;
    }
    return $count_post;
  }

  /**
   * フリーテキスト検索のタグを生成する
   */
  public function form_textfield_tags( $args=array() ) {
    $srch_label = isset($args['srch_label']) ? $args['srch_label'] : ''; // 検索結果のワード
    $supports   = isset($args['supports'])   ? $args['supports'] : array('content'); // サポートする属性
    $exact      = isset($args['exact'])      ? true : false; // 投稿の全体から正確なキーワードで検索するか
    $sentence   = isset($args['sentence'])   ? true : false; //語句(フレーズ検索)で検索するか
    $is_cfield  = isset($args['is_cfield'])  ? true : false; // カスタムフィールドも対象にいれるか
    $size       = isset($args['size']) && is_numeric($args['size']) ? $args['size'] : false;
    $maxlength  = isset($args['maxlength']) && is_numeric($args['maxlength']) ? $args['maxlength'] : false;
    $taxonomies = isset($args['taxonomies']) ? $args['taxonomies'] : false;
    $class      = isset($args['class']) ? ' class="'.$args['class'].'"' : '';
    $id         = isset($args['id']) ? ' id="'.$args['id'].'"' : '';
    // カスタムフィールドのスラッグ
    $custom_fields = isset($args['custom_fields']) && is_array($args['custom_fields']) ? $args['custom_fields'] : array();

    static $i = 0;
    $name      = 'cfield_text' . $i;
    $i++;
    $get_value = isset($_GET[$name]) ? $_GET[$name] : '';

    $tag = '';
    $tag .= '<input ';
    $tag .= 'type="text" ';
    $tag .= 'name="' . esc_attr($name) . '" ';
    $tag .= 'value="' . esc_attr($get_value) . '" ';
    if($size) $tag .= 'size="' . $size . '"';
    if($maxlength) $tag .= 'maxlength="'. $maxlength .'" ';
    $tag .= $class . $id;
    $tag .= '>';
    $tag .= "<br>";
    $tag .= "\n";
    $this->search_values_text2[$i]['supports']   = $supports;
    $this->search_values_text2[$i]['name']       = $name;
    $this->search_values_text2[$i]['value']      = $get_value;
    $this->search_values_text2[$i]['exact']      = $exact;
    $this->search_values_text2[$i]['sentence']   = $sentence;
    $this->search_values_text2[$i]['srch_label'] = $srch_label;
    $this->search_values_text2[$i]['custom_fields'] = $custom_fields;
    $this->search_values_text2[$i]['taxonomies'] = $taxonomies;
    return $tag;
  }

  /**
   * テキストフィールドを実装する。
   */
  public function form_text_field_tags($customfields=array(), $size=false, $maxlength=false) {

    static $cf_text_cnt = 0;
    $name      = 'cfield_text' . $cf_text_cnt;
    $get_value = '';
    // カスタムフィールドが対象の場合
    if(!empty($customfields)) {
      foreach ($customfields as $customfield) {
        $get_value = isset($_GET[$name]) ? $_GET[$name] : '';
        $this->search_values_field['cfield_' . $customfield['key']][$cf_text_cnt]['name']    = $name;
        $this->search_values_field['cfield_' . $customfield['key']][$cf_text_cnt]['key']     = $customfield['key'];
        $this->search_values_field['cfield_' . $customfield['key']][$cf_text_cnt]['compare'] = $customfield['compare'];
        $this->search_values_field['cfield_' . $customfield['key']][$cf_text_cnt]['type']    = $customfield['type'];
      }
    }
    $cf_text_cnt++;

    $tag = '';
    $tag .= '<input ';
    $tag .= 'type="text" ';
    $tag .= 'name="' . esc_attr($name) . '" ';
    $tag .= 'value="' . esc_attr($get_value) . '" ';
    if($size) $tag .= 'size="' . $size . '"';
    if($maxlength) $tag .= 'maxlength="'. $maxlength .'" ';
    $tag .= '>';
    $tag .= "<br>";
    $tag .= "\n";
    return $tag;
  }

  /**
   * 絞り込み検索を実行
   */
  public function set_search_query() {

    $arr_terms = array();
    $tax_query = array();

    /*
     * タクソノミーによる条件絞込み
    */
    $tax_query = array();
    foreach ($this->search_values as $input_type => $input_values) {
      foreach ($input_values as $input_value) {
        if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
          $get_tax_ids = $_GET[$input_value['name']];
          // 個別の値ごとにパラメータを変更できるようにする
          $key_arr = array('taxonomy','operator','srch_label');
          foreach ($key_arr as $tkey) {
            if( !empty($input_value['_' . $tkey]) ) {
              foreach ((array)$input_value['_' . $tkey] as $tkey2 => $tvalue2) {
                if( $get_tax_ids == $tkey2 ) {
                  $input_value[$tkey] = $tvalue2;
                }
              }
            }
          }
          // クエリーを組み立てる
          $tax_query[] = array(
            'name'     => $input_value['name'],
            'taxonomy' => $input_value['taxonomy'],
            'field'    => 'term_id',
            'terms'    => $get_tax_ids,
            'operator' => $input_value['operator'],
            'srch_label' => $input_value['srch_label'],
          );
        }
      }
    }

    /*
     * グループタクソノミーを組み立てる
    */
    if( !empty( $this->search_values_gloup ) ) {
      $gloup_custom_fields = array();
      foreach ($this->search_values_gloup as $gloup_name => $gloup_value_arr) {
        $tax_gloup = array();
        $temp_flg = false;
        foreach ($gloup_value_arr as $input_type => $input_values) {
          foreach ($input_values as $input_value) {
            if(isset($_GET[$input_value['name']]) && !empty($_GET[$input_value['name']])) {
              $temp_flg = true;
              $get_tax_ids = $_GET[$input_value['name']];
              // 個別の値ごとにパラメータを変更できるようにする
              $key_arr = array('taxonomy','operator','srch_label');
              foreach ($key_arr as $tkey) {
                if( !empty($input_value['_' . $tkey]) ) {
                  foreach ((array)$input_value['_' . $tkey] as $tkey2 => $tvalue2) {
                    if( $get_tax_ids == $tkey2 ) {
                      $input_value[$tkey] = $tvalue2;
                    }
                  }
                }
              }
              // クエリーを組み立てる
              $tax_gloup[] = array(
                'name'     => $input_value['name'],
                'taxonomy' => $input_value['taxonomy'],
                'field'    => 'term_id',
                'terms'    => $get_tax_ids,
                'operator' => $input_value['operator'],
                'srch_label' => $input_value['srch_label'],
              );
            }
          }
          if($input_values === end($gloup_value_arr) && $temp_flg) {
            $relation = isset($this->set_tax_query_relation_gloup[$gloup_name]) ? $this->set_tax_query_relation_gloup[$gloup_name] : 'AND';
            $tax_gloup = array_merge($tax_gloup, array('relation' => $relation));
            $tax_query[] = $tax_gloup;
          }
        }
      }
    }

    /*
     * タクソノミー全体の絞り込み条件を追加
    */
    if( !empty($tax_query) ) $tax_query = array_merge($tax_query, array('relation' => $this->tax_query_relation));

    $arr_fields = array();
    $meta_query = array();

    /*
     * フリーワード検索　ワード
    */
    foreach ($this->search_values_text2 as $search_form) {
      if( in_array("content", $search_form['supports']) && $search_form['value']!='' ) {
        $text_srh = array();
        $text_srh['word'] = '';
        $text_srh['word']    .= $search_form['value'];
        $text_srh['exact']    = $search_form['exact'];
        $text_srh['sentence'] = $search_form['sentence'];
      }
    }

    /*
     * フリーワード検索　カスタムフィールド
    */
    $temp_arr = array();
    foreach ($this->search_values_text2 as $search_form) {
      if( in_array("custom_field", $search_form['supports']) && $search_form['value']!='' ) {
        foreach ($search_form['custom_fields'] as $key) {
          $temp_arr[] = array(
            'name'      => $search_form['name'],
            'key'       => $key,
            'value'     => $search_form['value'],
            'compare'   => 'LIKE',
            'srch_label'=> $search_form['srch_label']
          );
        }
      }
    }
    if( !empty($temp_arr) ) $meta_query = array_merge($meta_query, $temp_arr);

    /*
     * フリーワード検索　カスタム分類
    */
    foreach ($this->search_values_text2 as $search_form) {
      if( in_array("taxonomy", $search_form['supports']) && $search_form['value']!='' ) {
        $term_ids = array();
        foreach ($search_form['taxonomies'] as $taxonomy) {
          $taxies = get_terms( array( 'taxonomy'=>$taxonomy, 'get'=>'all' ) );
          foreach ($taxies as $term) {
            if( strpos( $search_form['value'], $term->name ) !== false){
              $term_ids[] = $term->term_id;
            }
          }
          // クエリーを組み立てる
          $tax_query[] = array(
            'name'     => $search_form['name'],
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => $term_ids,
            'operator' => 'IN',
            'srch_label' => $search_form['srch_label'],
          );
        }
      }
    }

    /*
     * カスタムフィールドによる条件絞込み
    */
    foreach ($this->search_values_field as $input_type => $input_values) {
      foreach ($input_values as $input_value) {
        // radio要素のname属性の値があるか
        if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
          $get_search_word = $_GET[$input_value['name']];
          if( is_array($get_search_word) && ( $input_value['compare']=='IN' || $input_value['compare']=='NOT IN' ) ) {
            $search_word = $get_search_word;
          } else if( is_array($get_search_word) ) {
            $search_word = implode(' ', $get_search_word);
          } else {
            $search_word = $get_search_word;
          }
          // 個別の値ごとにパラメータを変更できるようにする
          $key_arr = array('key','compare','type','srch_label');
          foreach ($key_arr as $ckey) {
            if( !empty($input_value['_' . $ckey] && is_array($input_value['_' . $ckey])) ) {
              foreach ($input_value['_' . $ckey] as $ckey2 => $cvalue2) {
                if( $search_word == $ckey2 ) {
                  $input_value[$ckey] = $cvalue2;
                }
              }
            }
          }
          // クエリーを組み立てる
          $meta_query[] = array(
            'name'    => $input_value['name'],
            'key'     => $input_value['key'],
            'value'   => $search_word,
            'compare' => $input_value['compare'],
            'type'    => $input_value['type'],
            'srch_label' => $input_value['srch_label'],
          );
        }
      }
    }

    /*
     * グループカスタムフィールドを組み立てる
    */
    if( !empty( $this->search_values_field_gloup ) ) {
      $gloup_custom_fields = array();
      
      foreach ($this->search_values_field_gloup as $gloup_name => $gloup_value_arr) {
        $meta_query_gloup = array();
        $temp_flg = false;
        foreach ($gloup_value_arr as $input_type => $input_values) {
          foreach ($input_values as $input_value) {
            if(isset($_GET[$input_value['name']]) && !empty($_GET[$input_value['name']])) {
              $temp_flg = true;
              $get_search_word = $_GET[$input_value['name']];
              if( is_array($get_search_word) && ( $input_value['compare']=='IN' || $input_value['compare']=='NOT IN' ) ) {
                $search_word = $get_search_word;
              } else if( is_array($get_search_word) ) {
                $search_word = implode(' ', $get_search_word);
              } else {
                $search_word = $get_search_word;
              }
              // 個別の値ごとにパラメータを変更できるようにする
              $key_arr = array('key','compare','type','srch_label');
              foreach ($key_arr as $ckey) {
                if( !empty($input_value['_' . $ckey]) ) {
                  foreach ($input_value['_' . $ckey] as $ckey2 => $cvalue2) {
                    if( $search_word == $ckey2 ) {
                      $input_value[$ckey] = $cvalue2;
                    }
                  }
                }
              }
              // クエリーを組み立てる
              $meta_query_gloup[] = array(
                'name'    => $input_value['name'],
                'key'     => $input_value['key'],
                'value'   => $search_word,
                'compare' => $input_value['compare'],
                'type'    => $input_value['type'],
                'srch_label' => $input_value['srch_label'],
              );
            }
          }
          if($input_values === end($gloup_value_arr) && $temp_flg) {
            $meta_query_relation = isset($this->meta_query_relation_gloup[$gloup_name]) ? $this->meta_query_relation_gloup[$gloup_name] : 'AND';
            $meta_query_gloup = array_merge($meta_query_gloup, array('relation' => $meta_query_relation));
            $meta_query[] = $meta_query_gloup;
          }
        }
      }
    }

    // タクソノミー組み立て
    $tax_query = !empty($tax_query) ? array_merge($tax_query, array('relation' => $this->tax_query_relation)) : $tax_query;
    // カスタムフィールド組み立て
    $meta_query = !empty($meta_query) ? array_merge($meta_query, array('relation' => $this->meta_query_relation)) : $meta_query;
    
    // フリーワード検索にタクソノミーやカスタムフール度を含めるか指定
    if(!empty($text_srh['word'])) $this->freeword_tax_field();
    
    // WP_Queryの引数を宣言
    $args  = array();
    // クエリーを組み立てる
    $paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
    if(!empty($this->post_type))      $args = array_merge($args, array('post_type' => $this->post_type));
                                      $args = array_merge($args, array('paged' => $paged));
    if(!empty($text_srh['word']))     $args = array_merge($args, array('s' => $text_srh['word']));
    if(!empty($text_srh['exact']))    $args = array_merge($args, array('exact' => $text_srh['exact']));
    if(!empty($text_srh['sentence'])) $args = array_merge($args, array('sentence' => $text_srh['sentence']));
    if(!empty($s))                    $args = array_merge($args, $s[0]);
    if(!empty($post__in))             $args = array_merge($args, $post__in[0]);
    if(!empty($tax_query))            $args = array_merge($args, array('tax_query'  => $tax_query));
    if(!empty($meta_query))           $args = array_merge($args, array('meta_query' => $meta_query));
    if(!empty($this->posts_per_page)) $args = array_merge($args, array('posts_per_page' => $this->posts_per_page));
    if(!empty($this->default_param))  $args = array_merge($args, $this->default_param);
    // 並び順指定
    if( isset($_GET['select_order_value']) && $_GET['select_order_value']!='' ) {
      $order_arr = array();
      foreach ($this->order_param as $key => $ptn) {
        preg_match('/' . $ptn . '(.+)' . $ptn . '/', $_GET['select_order_value'], $match);
        $order_arr[$key] = $match[1];
      }
      $args = array_merge($args, $order_arr);
    }
    // 配列から特定のキー値を削除する
    $args = $this->remove_key_array( $args, 'name' );
    $args = $this->remove_key_array( $args, 'srch_label' );
    // チェック用の変数
    $this->get_subquery_args = $args;
    // クエリーを実行
    // $this->no_search_mode
    // 検索が実行された場合
    if( isset($_GET[$this->hidden_search_done['name']]) && $_GET[$this->hidden_search_done['name']]==='1' && !empty($args) ) {
      $the_query = new WP_Query( $args );
    } else {
      if( $this->no_search_mode==='1' ) {
        $the_query = new WP_Query( $args );
      } else if( $this->no_search_mode==='2' ) {
        $the_query = false;
      }
    }
    $this->the_query = $the_query;
    return $the_query;
  }

  private function remove_key_array( $args, $keyname ) {
    if( is_array($args) ) {
      foreach ($args as $key1 => $value1) {
        if( $key1===$keyname ) {
          unset($args[$key1]);
        }
        if( is_array($value1) ) {
          foreach ($value1 as $key2 => $value2) {
            if( $key2===$keyname ) {
              unset($args[$key1][$key2]);
            }
            if( is_array($value2) ) {
              foreach ($value2 as $key3 => $value3) {
                if( $key3===$keyname ) {
                  unset($args[$key1][$key2][$key3]);
                }
                if( is_array($value3) ) {
                  foreach ($value3 as $key4 => $value4) {
                    if( $key4===$keyname ) {
                      unset($args[$key1][$key2][$key3][$key4]);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    return $args;
  }

  /*
   * 検索ワード表示
  */
  public function get_search_query() {
    $html = '';

    // カスタムフィールド
    foreach ($this->search_values_field as $input_type => $input_values) {
      foreach ($input_values as $input_value) {
        // radio要素のname属性の値があるか
        if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
          // 検索対象ごとに検索結果のタイトルを変える
          if( isset($input_value['_srch_label']) && is_array($input_value['_srch_label']) ) {
            foreach ($input_value['_srch_label'] as $chng_key => $chng_val) {
              $input_value['srch_label'] = $chng_key===$_GET[$input_value['name']] ? $chng_val : $input_value['srch_label'];
            }
          }
          $label  = isset($input_value['srch_label']) ? $input_value['srch_label'] : '未設定';
          $values = is_array($_GET[$input_value['name']]) ? implode(',', $_GET[$input_value['name']]) : $_GET[$input_value['name']];
          if( $html!='' ) $html .= ' / ';
          $html .= $label . ' : ' . $values;
        }
      }
    }

    // グループカスタムフィールド
    foreach ($this->search_values_field_gloup as $gloup => $gloup_value) {
      foreach ($gloup_value as $input_type => $input_values) {
        foreach ($input_values as $input_value) {
          // radio要素のname属性の値があるか
          if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
            // 検索対象ごとに検索結果のタイトルを変える
            if( isset($input_value['_srch_label']) && is_array($input_value['_srch_label']) ) {
              foreach ($input_value['_srch_label'] as $chng_key => $chng_val) {
                $input_value['srch_label'] = $chng_key===$_GET[$input_value['name']] ? $chng_val : $input_value['srch_label'];
              }
            }
            $label  = isset($input_value['srch_label']) ? $input_value['srch_label'] : '未設定';
            $values = is_array($_GET[$input_value['name']]) ? implode(',', $_GET[$input_value['name']]) : $_GET[$input_value['name']];
            if( $html!='' ) $html .= ' / ';
            $html .= $label . ' : ' . $values;
          }
        }
      }
    }

    // タクソノミー
    foreach ($this->search_values as $input_type => $input_values) {
      foreach ($input_values as $input_value) {
        // radio要素のname属性の値があるか
        if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
          // 検索対象ごとに検索結果のタイトルを変える
          if( isset($input_value['_srch_label']) && is_array($input_value['_srch_label']) ) {
            foreach ($input_value['_srch_label'] as $chng_key => $chng_val) {
              if( !is_array($_GET[$input_value['name']]) ) {
                $input_value['srch_label'] = $chng_key==$_GET[$input_value['name']] ? $chng_val : $input_value['srch_label'];
              }
            }
          }
          $label  = isset($input_value['srch_label']) ? $input_value['srch_label'] : '未設定';
          $term_ids = $_GET[$input_value['name']];
          $term_name = '';
          foreach ((array)$term_ids as $term_id) {
            $term_info  = get_term_by( 'id', $term_id, $input_value['taxonomy'] );
            if( $term_name!='' ) $term_name .= ',';
            $term_name .= $term_info->name;
          }
          if( $html!='' ) $html .= ' / ';
          $html .= $label . ' : ' . $term_name;
        }
      }
    }

    // グループタクソノミー
    foreach ($this->search_values_gloup as $gloup => $gloup_value) {
      foreach ($gloup_value as $input_type => $input_values) {
        foreach ($input_values as $input_value) {
          // radio要素のname属性の値があるか
          if(isset($_GET[$input_value['name']]) && $_GET[$input_value['name']]!='') {
            // 検索対象ごとに検索結果のタイトルを変える
            if( isset($input_value['_srch_label']) && is_array($input_value['_srch_label']) ) {
              foreach ($input_value['_srch_label'] as $chng_key => $chng_val) {
                if( !is_array($_GET[$input_value['name']]) ) {
                  $input_value['srch_label'] = $chng_key===$_GET[$input_value['name']] ? $chng_val : $input_value['srch_label'];
                }
              }
            }
            $label  = isset($input_value['srch_label']) ? $input_value['srch_label'] : '未設定';
            $term_ids = $_GET[$input_value['name']];
            $term_name = '';
            foreach ((array)$term_ids as $term_id) {
              $term_info  = get_term_by( 'id', $term_id, $input_value['taxonomy'] );
              if( $term_name!='' ) $term_name .= ',';
              $term_name .= $term_info->name;
            }
            if( $html!='' ) $html .= ' / ';
            $html .= $label . ' : ' . $term_name;
          }
        }
      }
    }
    // フリーワード検索
    foreach ($this->search_values_text2 as $fw_form) {
      if( $fw_form['value']!='' ) {
        $label = isset($fw_form['srch_label']) ? $fw_form['srch_label'] : '未設定';
        if( $html!='' ) $html .= ' / ';
        $html .= $label . ' : ' . $fw_form['value'];
      }
    }
    $html = $html!='' ? $html : '検索キーワードの指定がありません。';
    return $html;
  }

  /**
   * 検索件数を取得する
   */
  public function get_search_count() {
    if( $this->the_query ) {
      $all_num = $this->the_query->found_posts;
      $get_num = $this->the_query->post_count;
      $rdata['all_num'] = $all_num;
      $rdata['get_num'] = $get_num;
    } else {
      $rdata['all_num'] = '';
      $rdata['get_num'] = '';
    }
    return $rdata;
  }

  /**
   * さらに見るボタンの実装（別ページに結果セットをもったまま繊維させるボタン）
   */
  public function get_another_link_sresult( $link_type='link', $label='See More...', $pass='', $class="" ) {
    $query_string = $_SERVER['QUERY_STRING']!='' ? $_SERVER['QUERY_STRING'] : '';
    $class = $class!='' ? ' class="' . $class . '"' : '';
    $rdata = '';
    if( $this->the_query ) {
      $all_num = $this->the_query->found_posts;
      $get_num = $this->the_query->post_count;
      if( intval($all_num) !== intval($get_num) ) {
        switch ($link_type) {
          case 'link':
            $rdata = '<a' . $class . ' href="' . home_url($pass) . '?' . $query_string . '">' . $label . '</a>';
            break;
          case 'button':
            $rdata = '<button' . $class . ' onclick="location.href=\'' . home_url($pass) . '?' . $query_string . '\'">' . $label . '</button>';
            break;
          case 'input':
            $rdata = '<input' . $class . ' type="button" onclick="location.href=\'' . home_url($pass) . '?' . $query_string . '\'" value="' . $label . '">';
            break;
          default:
            break;
        }
      }
    }
    return $rdata;
  }

  /**
   * ページネーションを実装
   */
  public function get_search_pagenation() {
    global $paged;
    global $wp_rewrite;
    $paginate_base = get_pagenum_link(1);
    if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
      $paginate_format = '';
      $paginate_base = add_query_arg('paged','%#%');
    }else{
      $paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
      user_trailingslashit('page/%#%/','paged');
      $paginate_base .= '%_%';
    }
    echo paginate_links(array(
      'base' => $paginate_base,
      'format' => $paginate_format,
      'total' => $this->the_query->max_num_pages,
      'mid_size' => 1,
      'current' => ($paged ? $paged : 1),
      'prev_text' => '< 前へ',
      'next_text' => '次へ >',
    ));
  }

  /**
   * サイト内検索の範囲に、カテゴリー名、タグ名、を含める
   */
  private function freeword_tax_field() {
    if( $this->is_freeword_tax_field ) {
      add_filter('posts_search', 'custom_search', 10, 2);
      function custom_search($search, $wp_query) {
        global $wpdb;
        //サーチページ以外だったら終了
        if (!$wp_query->is_search)
            return $search;
        if (!isset($wp_query->query_vars))
            return $search;
        // タグ名・カテゴリ名も検索対象に
        $search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
        if (count($search_words) > 0) {
            $search = '';
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $search_word = $wpdb->_escape("%{$word}%");
                    $search .= " AND (
                     {$wpdb->posts}.post_title LIKE '{$search_word}'
                     OR {$wpdb->posts}.post_content LIKE '{$search_word}'
                     OR {$wpdb->posts}.ID IN (
                       SELECT distinct post_id
                       FROM {$wpdb->postmeta}
                       WHERE meta_value LIKE '{$search_word}'
                       )
                     OR {$wpdb->posts}.ID IN (
                       SELECT distinct r.object_id
                       FROM {$wpdb->term_relationships} AS r
                       INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
                       INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                       WHERE t.name LIKE '{$search_word}'
                     OR t.slug LIKE '{$search_word}'
                     OR tt.description LIKE '{$search_word}'
                     )
                 ) ";
                }
            }
        }
        return $search;
      }
    }
  }

  /**
   * formの送信先を指定する
   */
  public function get_action_url( $path='/' ) {
    return home_url($path);
  }

  // 指定したタクソノミーについて隠しフィールドを自動生成し、カスタムフィールドとして検索できるようにする
  // 特定のタクソノミーと特定のカスタムフィールドでOR検索したい時に使う特別オプション
  public function use_taxonomy_as_customfield( $taxonomies=array() ) {
  }

  /**
   * 検索クエリーをチェックする
   */
  public function disp_subquery_args() {
    var_dump( $this->get_subquery_args );
  }

  /**
   * 検索クエリーを取得する
   */
  public function get_subquery_args() {
    return $this->get_subquery_args;
  }

  /**
   * 検索条件を絞り込むセレクトボックス
   */
  public function select_query_relation( $type='select', $target='taxonomy', $opvl=array( 'AND'=>'絞込む', 'OR'=>'含む' ) ) {
    if( $target=='custom_field' ) {
      $key = 'meta_query_relation';
    } else if( $target=='taxonomy' ) {
      $key = 'tax_query_relation';
    } else {
      $key = '';
    }
    // GET取得
    $sval = isset( $_GET[$key] ) ? $_GET[$key] : '';
    // 検索条件をセット
    if( $sval!='' && $key!='' ) $this->{$key} = $sval;
    // タグを吐き出す
    $tag  = '';
    switch ($type) {
      // セレクトボックス
      case 'select':
        $tag .= '<select name="' . $key . '">';
        foreach ($opvl as $key2 => $label) {
          $selected = $sval===$key2 ? ' selected' : '';
          $tag .= '<option value="' . $key2 . '"' . $selected . '>' . $label . '</option>';
        }
        $tag .= '</select>';
        break;
      // ラジオボタン
      case 'radio':
        foreach ($opvl as $key2 => $label) {
          $checked = $sval===$key2 ? ' checked' : '';
          $tag .= '<label>';
          $tag .= '<input type="radio" name="' . $key . '" value="' . $key2 . '"' . $checked . '>';
          $tag .= $label;
          $tag .= '</label>';
        }
        break;

      default:
        # code...
        break;
    }
    return $tag;
  }

  /**
   * 検索条件を絞り込む隠しフィールド
   */
  public function set_query_relation( $target='taxonomy', $opvl='AND' ) {
    if( $target=='custom_field' ) {
      $key = 'meta_query_relation';
    } else if( $target=='taxonomy' ) {
      $key = 'tax_query_relation';
    } else {
      $key = '';
    }
    // GET取得
    $sval = isset( $_GET[$key] ) ? $_GET[$key] : '';
    // 検索条件をセット
    if( $sval!='' && $key!='' ) $this->{$key} = $sval;
    $tag  = '<input type="hidden" name="' . $key . '" value="' . $opvl . '">';
    return $tag;
  }

  /**
   * リセットボタン
   */
  public function form_input_reset( $label='', $redirect_url='', $form_id = '', $class='' ) {
    $redirect_url = home_url( $redirect_url );
    $class = $class!='' ? ' class="' . $class . '"' : '';
    echo '<input' . $class . ' id="osSubqueryReset" type="button" value="' . $label . '" onClick="location.href=\'' . $redirect_url . '\';">';
    add_action('wp_footer', 'os_subquery_reset_js');
  }
}
// ユーティリティークラスのオブジェクトを作成
$csearch = new ComplexSearch();