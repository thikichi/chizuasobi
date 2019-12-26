<?php global $osfw; ?>
<section class="block5 block5--nobg">
  <div class="block5__inner">
    <h2 class="block5-ttl">
      <?php echo $osfw->get_title(); ?>
    </h2>
    <div class="block5__boxmain">
      <?php if(have_posts()): ?>
        <ul class="block2__list mt-xs-30">
          <?php $i=0; while(have_posts()) : the_post(); ?>
            <?php get_template_part( 'parts/contentPosts', 'twoColNoMap' ); ?>
          <?php $i++; endwhile; ?>
        </ul>
        <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>
      <?php else: ?>
      <?php /* ↓↓ 記事が存在しない場合 ↓↓ */ ?>
        <p>まだ記事の投稿がありません。</p>
      <?php /* ↑↑ 記事が存在しない場合 ↑↑ */ ?>
      <?php endif; ?>
    </div>
  </div>
</section>