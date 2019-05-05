<?php get_header(); ?>


<!-- post001 -->
<!--==================================================-->

<?php
$args = array(
  'post_type' => 'post',
  'posts_per_page' => 5, /* 表示件数を指定（-1なら全件） */
  'paged' => get_query_var('paged'),
  );
$the_query = new WP_Query( $args );
?>
<section class="post001 mb-50 mt-50">
  <div class="container-fluid">
    <div class="post001-inner">
      <h2 class="post001-heading">
        <img src="http://osweb.info/os-framework/component/wp-content/themes/os-component-manager-theme/components/main-component/post001/images/post001-icon-01.svg" height="35" alt="">
        ブログ（投稿）の一覧
      </h2>
      <p class="post001-more">
        <a href="<?php echo get_post_type_archive_link( 'post' ); ?>">一覧を見る</a>
      </p>
      <?php if ($the_query->have_posts()): ?>
        <ul class="post001-list">
          <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <p class="post001-date"><?php the_time('Y/m/d'); ?></p>
                <p class="post001-category">
                  <?php
                  /* カテゴリーの色取得 */
                  $default_color = '#FF0000'; /* デフォルトの色を指定 */
                  $terms = get_the_terms($post->ID, 'category');
                  ?>
                  <?php if($terms): foreach ($terms as $term): ?>
                    <span<?php os_get_category_color($term->term_id, $default_color); ?> class="post001-category-01">
                    <?php echo $term->name; ?></span>
                  <?php endforeach; endif; ?>
                </p>
                <p class="post001-title"><?php the_title(); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p>記事の投稿がありません。</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>


<!-- post001 -->
<!--==================================================-->

<?php
$args = array(
  'post_type' => 'news',
  'posts_per_page' => 5, /* 表示件数を指定（-1なら全件） */
  'paged' => get_query_var('paged'),
  );
$the_query = new WP_Query( $args );
?>
<section class="post001 mb-50">
  <div class="container-fluid">
    <div class="post001-inner">
      <h2 class="post001-heading">
        <img src="http://osweb.info/os-framework/component/wp-content/themes/os-component-manager-theme/components/main-component/post001/images/post001-icon-01.svg" height="35" alt="">
        新着情報
      </h2>
      <p class="post001-more">
        <a href="<?php echo get_post_type_archive_link( 'news' ); ?>">一覧を見る</a>
      </p>
      <?php if ($the_query->have_posts()): ?>
        <ul class="post001-list">
          <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <p class="post001-date"><?php the_time('Y/m/d'); ?></p>
                <p class="post001-category">
                  <?php
                  global $ofm_ptype;
                  $news_tax_slug = $ofm_ptype->get_ptype_news_cat();
                  /* カテゴリーの色取得 */
                  $default_color = '#FF0000'; /* デフォルトの色を指定 */
                  $terms = get_the_terms($post->ID, $news_tax_slug);
                  ?>
                  <?php if($terms): foreach ($terms as $term): ?>
                    <span<?php os_get_newscategory_color($term->term_id, $default_color); ?> class="post001-category-01">
                    <?php echo $term->name; ?></span>
                  <?php endforeach; endif; ?>
                </p>
                <p class="post001-title"><?php the_title(); ?></p>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p>記事の投稿がありません。</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>