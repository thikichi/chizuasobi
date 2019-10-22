<?php
global $osfw;
?>
<div class="box-1 cf mb-xs-15">
  <?php
  $args = array(
    'post_type' => 'news',
    'posts_per_page' => 10,
  );
  $the_query = new WP_Query( $args );
  if ($the_query->have_posts()): ?>
    <ul class="list-2">
      <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
        <li>
          <div class="list-2-box">
            <span class="_sub"><?php the_time('Y.m.d'); ?></span>
            <span class="_main">
              <?php
              $tax = 'newscategory'; // タクソノミー名
              $terms = get_the_terms($post->ID, $tax);
              if ( ! empty( $terms ) && !is_wp_error( $terms ) ) {
                echo '<ul class="taglist-1 cf mt-xs-10">';
                foreach ( $terms as $term ) {
                  $term_link = get_term_link( $term->term_id, $tax );
                  echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                }
                echo '</ul>';
              } else {
              }
              ?>
              <a href="<?php the_permalink(); ?>" class="hover-underline">
                <?php echo $osfw->get_excerpt_filter( get_the_title(), 30, ' … [続きを読む]', get_the_permalink() ); ?>
              </a>
              <span class="_small block">
                <?php echo $osfw->get_excerpt_filter( get_the_title(), 30, ' … ' ); ?>
              </span>
            </span>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p>記事の投稿がありません。</p>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
</div>