<?php
/*
 * file name : feature
*/
?>
<?php get_header(); ?>

<div class="container align-center mt-xs-30">
  <ul class="nav-pagelink">
    <li class="nav-pagelink__item">
      <a href="#mapSingleFeatureWrap">史跡MAP</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#mapRelationWrap">みどころMAP散歩</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Gallery">ギャラリー</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#SameCat">同じカテゴリーの史跡</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Shuhen">周辺の史跡</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#HotelList">周辺地域のホテルの一覧</a>
    </li>
    <li class="nav-pagelink__item">
      <a href="#Quot">紹介サイトの一覧</a>
    </li>
  </ul>
</div>


<section class="block4">
  <div style="position:relative">
    <div id="mapSingleFeatureWrap" style="position:absolute;top:-100px"></div>
  </div>
  <div class="container">
    <div class="block4__main">
      <h2 class="title-1 mt-xs-15 mb-xs-15">
        <span class="title-1__inner">
          <span class="title-1__sub">
            Featured Articles
          </span>
          <span class="title-1__main">
            <?php the_title(); ?>
          </span>
        </span>
      </h2>
      <?php if (have_posts()): ?>
        <?php while(have_posts()) : the_post(); ?>
          <p class="block4__read mb-xs-15 align-center"><?php the_content(); ?></p>
          <div class="block4__mappost">
            <div class="block4__mappost-map">
              <div id="mapSingleFeature" class="block4__map"></div>
            </div>
            <div class="block4__mappost-post">
              <div class="block4__mapside">
                <h3 class="block4__mapside-ttl">
                  史跡を選択
                </h3>
                <ul id="mapSingleFeatureUL" class="block4__mapside-list"><?php /*ajax出力 */ ?></ul>
              </div>
            </div>
          </div>
          <?php echo marker_size_change_tag('chgmarkerMSF'); ?>
        <?php endwhile; ?>
      <?php else: ?>
        <p>記事の投稿がありません。</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php 
$select_posts = get_post_meta( $post->ID, 'acf_feature_posts', true );
?>

<?php if( !empty($select_posts) ): ?>
  <section class="pb-xs-50">
    <div class="container">
      <?php foreach ($select_posts as $select_post): ?>
        <?php
        $args = array(
        'post_type' => 'landmark',
        'p' => $select_post,
        'paged' => get_query_var('paged'),
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            
            <h3 class="title-1 mt-xs-15 mb-xs-15">
              <span class="title-1__inner">
                <?php
                $mainttl_sub = get_post_meta( $post->ID, 'afc_mainttl_sub', true );
                if( $mainttl_sub ): ?>
                  <span class="title-1__sub">
                    <?php echo esc_html($mainttl_sub); ?>
                  </span>
                <?php endif; ?>
                <span class="title-1__main">
                  <?php the_title(); ?>
                </span>
              </span>
            </h3>
            <?php get_template_part( 'parts/landmark-data' ); ?>
            <?php wp_reset_postdata(); ?>

          <?php endwhile; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>