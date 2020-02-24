<?php get_header(); ?>

<section class="courselist mt-xs-30 mt-md-50">
  <div class="courselist__container">
    <div class="courselist__inner">
      <h2 class="title-1 mb-xs-15 mb-md-30">
        <span class="title-1__inner">
          <span class="title-1__main">
            おすすめコース巡りのコ～ナー
          </span>
        </span>
      </h2>
      <div class="courselist__read">
        <p class="courselist__read-inner">
         管理人が選んだおすすめの散策コースをご紹介します。<br>
          徒歩で手軽に巡り歩けるコースが中心です。
        </p>
      </div>
      <?php get_template_part( 'parts/contentPosts', 'course' ); ?>
    </div>
  </div>
</section>

<?php get_template_part( 'parts/recomend', 'category' ); ?>

<?php get_footer(); ?>