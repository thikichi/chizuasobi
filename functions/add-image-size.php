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
  add_image_size('img_square_w750', 750, 750 ,true);
  add_image_size('img_square_w300', 300, 300 ,true);
  add_image_size('img_square_w100', 100, 100 ,true);

  add_image_size('img_golden_w750', 750, 464 ,true);
  add_image_size('img_golden_w300', 300, 185 ,true);
  add_image_size('img_golden_w100', 100, 60 ,true);

  add_image_size('img_silver_w750', 750, 530 ,true);
  add_image_size('img_silver_w300', 300, 210 ,true);
  add_image_size('img_silver_w100', 100, 70 ,true);

  add_image_size('img_normal_w750', 750, 560 ,true);
  add_image_size('img_normal_w300', 300, 227 ,true);
  add_image_size('img_normal_w100', 100, 75 ,true);

  add_image_size('img_marker', 75, 75 ,true);

  // img_marker_large
  add_image_size('img_marker_large', 85, 104 ,true);
  add_image_size('img_marker_middle', 60, 73 ,true);
  add_image_size('img_marker_small', 45, 55 ,true);
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

