<?php get_header(); ?>

<?php
global $osfw;
?>

<div class="container-fluid single-news">
  <div class="row">
    <div class="col-md-9 col-sm-8">
      <?php get_template_part('parts/list'); ?>
    </div>
    <div class="col-md-3 col-sm-4 mt-xs-30 mt-sm-0">
      <div class="widget-rapper">
        <?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('sidebar-news'); /* 新着サイドバー */ ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>