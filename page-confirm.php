<?php get_header(); ?>

<!-- title204 -->
<!--==================================================-->

<div class="title204 mb-xs-30">
  <div class="container-fluid">
    <h2 class="title204-text">
      <span>内容確認</span>
    </h2>
  </div>
</div>

<section class="mt-50 mb-50">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p class="mb-xs-30">
          以下の内容でお間違いないでしょうか？<br>
          <span class="space-1em"></span>
          お間違いないようであれば「送信」ボタンを押してください。
        </p>
        <?php if (have_posts()): the_post(); ?>
          <?php the_content(); ?>
        <?php endif; ?>
      </div>
    </div><!-- .row -->
  </div>
</section>

<?php get_footer(); ?>