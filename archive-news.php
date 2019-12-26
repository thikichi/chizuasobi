<?php get_header(); ?>

<?php
global $osfw;
?>

<div class="container-fluid single-news">
  <div class="row">
    <div class="col-md-9 col-sm-8">
      
      <section class="block5 block5--nobg">
        <div class="block5__inner">
          <h2 class="block5-ttl block5-ttl--gray">
            <?php echo $osfw->get_archive_title(); ?>
          </h2>
          <div class="block5__boxmain">
            <p class="block5__lead">
              <span class="block5__lead-inner">
                新着情報の過去の記事一覧となります。
              </span>
            </p>

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
      </section>

    </div>
    <div class="col-md-3 col-sm-4 mt-xs-30 mt-sm-0">
      <div class="widget-rapper">
        <?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('sidebar-news'); /* 新着サイドバー */ ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>