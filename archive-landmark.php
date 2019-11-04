<?php
/*
 * file name : landmark
*/
?>
<?php get_header(); ?>

<section id="ArchiveLandmark">
  <div class="container">
    <?php if (have_posts()): ?>
      <?php while(have_posts()) : the_post(); ?>

        <?php $mapid='ArchiveLandmarkMap'; // GoogleMapを読み込む要素を指定 ?>
        <?php get_template_part( 'parts/contentPosts','twoCol' ); ?>

      <?php endwhile; ?>
      <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>
    <?php else: ?>
    <?php /* ↓↓ 記事が存在しない場合 ↓↓ */ ?>
      
      <p>まだ記事の投稿がありません。</p>
      
    <?php /* ↑↑ 記事が存在しない場合 ↑↑ */ ?>
    <?php endif; ?>
  </div>
</section>


<?php get_footer(); ?>