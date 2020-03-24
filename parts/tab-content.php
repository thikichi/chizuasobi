<?php
global $osfw;
$gmap_url = 'https://www.google.com/maps/search/?api=1';
// https://www.google.com/maps/search/?api=1&query=35.6812362,139.7649361
?>
<section class="bg-lightGray2 pt-xs-30">
  <div class="tab-switch">
    <nav>
      <div class="container">
        <ul class="tab-1 cf">
          <li class="tab-switch-nav _active">
            <a href="javascript:void(0)">
              <span>
                注目の記事
              </span>
            </a>
          </li>
          <li class="tab-switch-nav">
            <a href="javascript:void(0)">
              <span>
                特集一覧
              </span>
            </a>
          </li>
          <li class="tab-switch-nav">
            <a href="javascript:void(0)">
              <span>
                新着情報
              </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="tabcontent-1">
      <div class="tabcontent-1-inner pb-xs-70">
        <div class="container">
          <div class="tabcontent-1-main pt-xs-30 pb-xs-30">
            <ul>
              <li class="tab-switch-content _active">
                <?php
                $args = array(
                  'post_type' => 'landmark',
                  'posts_per_page' => 5,
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'status',
                      'field' => 'slug',
                      'terms' => 'attention',
                    ),
                  ),
                );
                $the_query = new WP_Query( $args );
                ?>
                <?php if ($the_query->have_posts()): ?>
                  <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                    <?php get_template_part( 'parts/contentPosts-oneColMapPost' ) ?>
                  <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
              </li><!-- tab -->
              <li class="tab-switch-content">
                <?php
                $args = array(
                  'post_type' => 'feature',
                  'posts_per_page' => 5,
                );
                $the_query = new WP_Query( $args );
                if ($the_query->have_posts()): ?>
                  <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                    <?php get_template_part( 'parts/contentPosts-oneColMapSpPost' ) ?>
                  <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
                <div class="btn-1">
                  <a href="<?php echo $osfw->get_archive_link('feature'); ?>">特集記事の一覧 <i class="fas fa-angle-double-right"></i></a>
                </div>
              </li><!-- tab -->
              <li class="tab-switch-content">
                <?php get_template_part( 'parts/contentPosts-oneColNews' ) ?>
                <div class="btn-1">
                  <a href="<?php echo $osfw->get_archive_link('news'); ?>">新着記事の一覧 <i class="fas fa-angle-double-right"></i></a>
                </div>
              </li><!-- tab -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>