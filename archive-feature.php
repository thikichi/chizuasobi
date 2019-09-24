<?php
/*
 * file name : feature
*/
?>
<?php get_header(); ?>
<?php if (have_posts()): ?>
  <?php /* ↓↓ 記事が存在したら下記を実行 ↓↓ */ ?>
  <?php while(have_posts()) : the_post(); ?>
    <?php /* ↓↓ 記事の件数だけ繰り返し処理 ↓↓ */ ?>

    <div><?php the_title(); // タイトルを表示 ?></div>
    <div><?php the_content(); // コンテンツを表示 ?></div>
    
    <?php /* ↑↑ 記事の件数だけ繰り返し処理 ↑↑ */ ?>
  <?php endwhile; ?>
  <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>
<?php else: ?>
<?php /* ↓↓ 記事が存在しない場合 ↓↓ */ ?>
  
  <p>まだ記事の投稿がありません。</p>
  
<?php /* ↑↑ 記事が存在しない場合 ↑↑ */ ?>
<?php endif; ?>
<?php get_footer(); ?>