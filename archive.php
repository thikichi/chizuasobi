<?php get_header(); ?>
<div class="container-fluid single-news">
  <div class="row">
    <div class="col-md-9 col-sm-8">

      <!-- title204 -->
      <!--==================================================-->

      <div class="row title204 mb-30">
        <div class="container-fluid">
          <h2 class="title204-text">
            <?php /* functions/utility.php にて編集可 */ ?>
            <span><?php echo $utility_class->get_archive_title(); ?></span>
          </h2>
        </div>
      </div>

      <?php if (have_posts()): ?>
        <?php while(have_posts()) : the_post(); ?>
          <?php /* ↓↓ 記事が存在したら下記を実行 ↓↓ */ ?>

          <?php /* タイトルを出力 */ ?>
          <h2 class="single-title mb-10">
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>
          <div class="single-meta mb-20">
            <?php /* 投稿日を出力 */ ?>
            <time datetime="<?php the_time('Y-m-d'); ?>" class="single-time">投稿日： <?php the_time('Y.m.d'); // 投稿日時を表示 ?></time>

            <?php $cat_terms = get_the_terms( $post->ID, 'category' ); ?>
            <?php if($cat_terms): ?>
              <span class="ml-30">カテゴリー：
                <?php
                /* カテゴリーの色取得 */
                $default_color = '#FF0000'; /* デフォルトの色を指定 */
                $terms = get_the_terms($post->ID, 'category');
                ?>
                <?php if($terms): foreach ($terms as $term):
                  $link = get_term_link( $term->term_id, 'category' );
                  ?>
                  <a href="<?php echo esc_url($link); ?>"<?php os_get_category_color($term->term_id, $default_color); ?> class="single-terms">
                    <?php echo $term->name; ?>
                  </a>
                <?php endforeach; endif; ?>
              </span>
            <?php endif; ?>

            <?php $tag_terms = get_the_terms( $post->ID, 'post_tag' ); ?>
            <?php if($tag_terms): ?>
              <span class="ml-30">タグ：
                <?php foreach ($tag_terms as $term): ?>
                  <?php $term_link = get_term_link( $term->slug, 'post_tag' ); ?>
                  <a href="<?php echo esc_url($term_link); ?>" class="single-terms"><?php echo $term->name; ?></a>
                <?php endforeach; ?>
              </span>
            <?php endif; ?>
          
          </div>
          <div class="row mb-30">
            <?php /* アイキャッチ画像が設定されていた場合 */ ?>
            <?php if(has_post_thumbnail()): ?>
                <div class="col-sm-2 col-xs-12 matchHeight">
                  <?php /* アイキャッチ画像を出力 */ ?>
                  <?php the_post_thumbnail('thumbnail', array('class'=>'img-responsive center-block mb-xs-15')); ?>
                </div>
                <div class="col-sm-10 col-xs-12 matchHeight pt-sm-15">
                  <?php /* 記事の概要を出力 */ ?>
                  <?php the_excerpt(); ?>
                </div>
            <?php /* アイキャッチ画像がない場合 */ ?>
            <?php else: ?>
                <div class="col-xs-12 post-content">
                  <?php /* 記事の概要を出力 */ ?>
                  <?php /* 文字数などは functions/text.php にて定義可 */ ?>
                  <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
          </div>

          <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>
        <?php endwhile; ?>

        <div class="pagenation">
          <?php
          /*
          * 投稿一覧系ページで各ページへのリンクを出力
          * 例) << 前へ 1 2 3 次へ >>
          */
          ?>
          <?php
          /* どうしてもうまくいかない場合は下記をコメントアウトをはずしてみる */
          // $GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
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

      <?php else: ?>
        <?php /* ↓↓ 記事が存在しない場合 ↓↓ */ ?>
        <p>まだ記事の投稿がありません。</p>
        <?php /* ↑↑ 記事が存在しない場合 ↑↑ */ ?>
      <?php endif; ?>
    </div>
    <div class="col-md-3 col-sm-4 mt-xs-30 mt-sm-0">
      <div class="widget-rapper">
        <?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('sidebar-post'); /* 新着サイドバー */ ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>