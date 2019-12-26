<?php
global $osfw;
global $i;
global $post_map_sp;
global $get_feature_ttl;
global $select_feature_post;
global $the_query;
?>

<section class="block5">
  <div class="block5__container">
    <div class="block5__inner">
      <h2 class="block5-ttl">
        <?php echo $get_feature_ttl; ?><br>
        『 
        <?php 
        if( is_archive() ) {
          echo $select_feature_post[0]->post_title;
        } else if(is_single()) {
          the_title();
        }
        ?> 
        』
      </h2>
      <div class="block5__boxmain">
        <p class="block5__lead">
          <?php
          echo nl2br($select_feature_post[0]->post_content);
          ?>
        </p>
        <div class="mt-xs-15">
          <div id="mapAreaSp" style="width:100%;height:350px"></div>
        </div>
        <ul class="list-1 row mt-xs-30">
          <?php $i=1; while($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php get_template_part( 'parts/contentPosts','threeColBox' ); ?>
          <?php $i++; endwhile; ?>
        </ul>
        <?php if( is_front_page() ): ?>
          <div class="btn-1">
            <a href="<?php echo $osfw->get_archive_link('feature'); ?>">過去の特集記事の一覧 <i class="fas fa-angle-double-right"></i></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>