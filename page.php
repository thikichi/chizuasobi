<?php get_header(); ?>

<section class="mt-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <?php /* WordPressの投稿内容を出力するタグ */ ?>
        <?php if (have_posts()): the_post(); ?>
          <?php the_title(); ?>
          <?php the_content(); ?>
        <?php else: ?>
          <p>まだ記事の投稿がありません。</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>