<?php
global $osfw;
?>


<section class="block5">
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        <?php echo $osfw->get_archive_title(); ?>
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <span class="block5__lead-inner">
            特修記事の過去のアーカイブです。特修記事ではテーマに関連する様々な歴史的名所をご案内します。<br>
            各名所についての細かい内容についても知ることが出来ますのでぜひご覧ください。
          </span>
        </p>
        <?php if(have_posts()): ?>
          <ul class="block2__list mt-xs-30">
            <?php // $markers = array(); // Marker Object ?>
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

        <div class="align-center">
        <?php
        /*
        * 投稿一覧系ページで各ページへのリンクを出力
        * 例) << 前へ 1 2 3 次へ >>
        */
        ?>
        <?php
        the_posts_pagination(array(
          'mid_size' => 3,
          'prev_text' => '&lt;  前',
          'next_text' => '次 &gt;',
          'screen_reader_text' => ' ',
        ));
        ?>
        </div>
      </div>
    </div>
  </div>
</section>

