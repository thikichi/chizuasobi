<?php
/*
 * オリジナルのカスタムフィールドを実装
 * 
 * 通常は「Advanced Custom Fields」のようなプラグインでカスタムフィールドを設置してください。
 * プラグインとか使わず設定する場合は以下を利用します。
 * 
 * Custom Metaboxes and Fields for WordPress ライブラリを利用しています。
 * https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress
 * 
 * 詳しい使い方は下記URLを参照してください。
 * http://www.webopixel.net/wordpress/896.html
 * https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-wordpress/wiki
 * 
*/

add_filter( 'cmb_meta_boxes_child', function($meta_boxes, $prefix) {

  // 固定ページ
  $meta_boxes['cpost_page'] = array(
    'id'         => 'cpost_page_id',
    'title'      => 'カスタムフィールドのタイトル',
    'pages'      => array('page'),
    'context'    => 'normal',
    'priority'   => 'high',
    'show_names' => true,
    'fields'     => array(
      array(
        'name' => 'カスタムフィールド名： ',
        'desc' => 'カスタムフィールドの説明',
        'id'   => $prefix . 'cpost_page_hoge',
        'type' => 'title'
      ),
    )
  );

  // 投稿
  $meta_boxes['cpost_post'] = array(
    'id'         => 'cpost_post_id',
    'title'      => 'カスタムフィールドのタイトル',
    'pages'      => array('post'),
    'context'    => 'normal',
    'priority'   => 'high',
    'show_names' => true,
    'fields'     => array(
      array(
        'name' => 'カスタムフィールド名： ',
        'desc' => 'カスタムフィールドの説明',
        'id'   => $prefix . 'cpost_post_hoge',
        'type' => 'text'
      ),
    )
  );

  // グループでリピートするカスタムフィールド
  $meta_boxes['cpost_group_repeat_page'] = array(
      'id'         => 'cpost_group_repeat_page_id',
      'title'      => '追加したカスタムフィールド',
      'pages'      => array('page'),
      'context'    => 'normal',
      'priority'   => 'high',
      'show_names' => true,
      'fields'     => array(
        array(
          'id'          => $prefix . 'repeat_group',
          'type'        => 'group',
          'options'     => array(
            'add_button'    => 'グループの追加',
            'remove_button' => 'グループの削除',
            'sortable'      => true, // beta
          ),
          'fields'     => array(
            array(
              'name' => 'テストテキスト',
              'desc' => 'ここに説明文が入ります。',
              'id'   => $prefix . 'test_text',
              'type' => 'text',
            ),
            array(
              'name' => 'ファイル',
              'desc' => 'ファイルをリンクする場合はここで選択してください。',
              'id' => $prefix . 'add_file',
              'type' => 'file',
              'save_id' => false,
              'allow' => array( 'url', 'attachment' )
            ),
          )
        )
      )
  );

  return $meta_boxes;
}, 10, 2);
