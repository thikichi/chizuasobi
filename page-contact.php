<?php get_header(); ?>

<!-- title204 -->
<!--==================================================-->

<div class="title204 mb-xs-30">
  <div class="container-fluid">
    <h2 class="title204-text">
      <span>入力フォーム</span>
    </h2>
  </div>
</div>

<section class="form113 mt-50 mb-50">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p class="mt-xs-20 mt-ms-40">
          ○○薬局へのお問い合わせは、下記メールフォームよりお願いいたします。<br class="visible-xl visible-lg visible-md">
          お問い合わせ内容の確認後、担当者よりご連絡いたします。<br class="visible-xl visible-lg visible-md">
          お急ぎの場合は、お電話にてお問い合わせください。 
        </p>
        <p class="mt-xs-10 mb-xs-20">
          <span class="form113-required"></span> は必須項目です。
        </p>
        <div class="content0021-form">
          <?php if (have_posts()): the_post(); ?>
            <?php the_content(); ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section><!-- .section -->

<?php get_footer(); ?>