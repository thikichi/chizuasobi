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
   * @return string タームのタグを返す
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
}

// ユーティリティークラスのオブジェクトを作成
$utility_class = new utilityClass();