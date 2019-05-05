<?php get_header(); ?>

<!-- title204 -->
<!--==================================================-->

<div class="title204 mb-xs-30">
  <div class="container-fluid">
    <h2 class="title204-text">
      <span>送信完了</span>
    </h2>
  </div>
</div>

<section class="mt-50 mb-50">
  <div class="container container-960">
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <p class="mb-xs-30">
          お問い合わせを送信いたしました。<br>
          <span class="space-1em"></span>
          ご入力いただいたメールアドレスに、確認用メールを送信いたしましたので、ご確認をお願いいたします。<br>
          <span class="space-1em"></span>
          24時間経過してもメールが届かない場合は、メールアドレスに誤りがある可能性がございますので、大変お手数ですが、再度フォームからお問い合わせくださいますようお願いいたします。
        </p>
        <?php if (have_posts()): the_post(); ?>
          <?php the_content(); ?>
        <?php endif; ?>
      </div>
    </div><!-- .row -->
    <div class="align-center mt-xs-20 mt-sm-40">
      <a href="<?php echo home_url('/'); ?>" class="form113-button form113-submit">トップページへ戻る</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>