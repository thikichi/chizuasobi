<?php get_header(); ?>

<div class="container-fluid single-news">
  <div class="row">
    <div class="col-md-9 col-sm-8">
      <?php if (have_posts()): ?>
        <?php the_post(); ?>
        <?php /* ↓↓ 記事が存在したら下記を実行 ↓↓ */ ?>
        <h2 class="single-title mb-10"><?php the_title(); // タイトルを表示 ?></h2>
        <div class="single-meta mb-30">
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

        <?php /* アイキャッチ画像があれば出力する */ ?>
        <?php if(has_post_thumbnail()): ?>
          <div class="eyecatching mb-30">
            <?php the_post_thumbnail('large', array('class'=>'img-responsive center-block mb-xs-15')); ?>
          </div>
        <?php endif; ?>

        <div class="post-content mb-50"><?php the_content(); // コンテンツを表示 ?></div>
        <?php /* ↑↑ 記事が存在したら上記を実行 ↑↑ */ ?>

        <?php /* コメントフォーム　不要なら削除 */ ?>
        <div class="mb-10"><?php comments_template(); ?></div>

        <?php
        /*
         * 前の記事、次の記事へのリンク
         * prev next link for single-page
        */
        ?>
        <div class="single-arrow row mt-30">
          <div class="col-xs-4 col-xs-offset-2 single-arrow-prev">
            <?php previous_post_link('%link', '&lt;&lt; 前の記事へ'); ?>
          </div><!-- .col-xs-6 -->
          <div class="col-xs-4 single-arrow-next">
            <?php next_post_link('%link', '次の記事へ &gt;&gt;'); ?>
          </div><!-- .col-xs-6 -->
        </div><!-- .row -->

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