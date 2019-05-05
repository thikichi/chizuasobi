<?php
/*----------------------------------------------------------------------------------------------------*/
/* アイキャッチ ・ ギャラリー画像の定義 */
/*----------------------------------------------------------------------------------------------------*/

/*
 * step01.独自サイズの画像を定義する
*/

/**
 * 新しく独自仕様の画像サイズを定義する
 *
 * @param string  $name   画像サイズの名前
 * @param int     $width  幅ピクセル数
 * @param int     $height 高さピクセル数
 * @param boolean $crop   画像の切り抜きを行うか否か
 * 例）
 * add_image_size( $name, $width, $height, $crop );
 */

add_action( 'after_setup_theme', function(){
  // 1000px × 1000px 比較的大きな画像
  // add_image_size('img_square', 1000, 1000 ,true);
  // 黄金比の近似値 ※ 世界的な美の基準  1000×618
  add_image_size('img_golden_ratio', 1000, 620 ,true);
  // 白銀比の近似値 ※ 日本人になじみ深い 1000×707
  // add_image_size('img_sailver_ratio', 1000, 700 ,true);
  // 独自定義のサムネイル画像を定義できます。
  // add_image_size('画像サイズの名前','幅ピクセル数','高さピクセル数','true or false');
});


/*
 * step02.設定した大きさで画像を出力する。
*/

/*
 * アイキャッチ画像で「白銀比」の画像を出力するときは以下のように指定する。
 * <?php the_post_thumbnail('img_sailver_ratio'); ?>
 * 
 * ギャラリーのショートコードに大きさを指定することもできます（name属性を追加）。
 * [gallery size="img_sailver_ratio"]
 * 
 * 上記の例で""となっているところを下記のようにすると「メディア設定」で指定した値がセットされます。
 * "thumbnail", "medium", "large", "full"
 * 
 * また独自に定義した値を指定する事も可能です。
 * 
*/

