<?php
/*
 * file name : feature
*/
?>
<?php get_header(); ?>

<?php
// global $post_map_sp;
$landmark_id_arr = array();
// $get_feature_id  = get_theme_mod( 'top_special_select_1', false );
$get_feature_ttl = get_theme_mod( 'top_special_text_1', false );
$map_center = get_post_meta( $post->ID, 'acf_feature_map_center', true );
$map_zoom   = get_post_meta( $post->ID, 'acf_feature_map_zoom', true );
// feature_posts
$landmark_posts = SCF::get('scf_feature_posts', $post->ID);
$landmark_id_arr = $landmark_posts[0]['scf_feature_posts_post'];

$post_map_sp = array(
  'post_type' => 'landmark',
  'posts_per_page' => -1,
);
// 結合
$post_map_sp = !empty($landmark_id_arr) ? array_merge( $post_map_sp, array('post__in'=> $landmark_id_arr) ) : $post_map_sp;
// var_dump($post_map_sp);
$the_query = new WP_Query( $post_map_sp );
?>
<?php if ($the_query->have_posts()): ?>
  <?php get_template_part('parts/feature'); ?>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>