<?php
/*
 * ヘッダー
 * header.php を読み込みます
*/
get_header(); ?>

<div class="container"> 
  <div class="row">
    <main class="col-md-8">
      <section class="mb-50"> 
        <h2><?php the_title(); ?></h2>
        <article>

        <?php
        /*
         * 管理画面よりの投稿を反映
        */
        ?>
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

        </article>
      </section><!-- .top-concept -->
    </main>
    <aside class="col-md-4">

      <?php
      /*
       * サイドバー
       * sidebar.php を読み込みます
      */
      get_sidebar(); ?>

    </aside>
  </div><!--.row-->
</div><!-- .container -->

<?php
/*
 * フッター
 * footer.php を読み込みます
*/
get_footer(); ?>