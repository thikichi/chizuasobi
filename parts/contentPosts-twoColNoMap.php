
<?php
global $osfw;
?>
<li class="block2__list-item">
  <div class="block2__box">
    <div class="block2__box-inner">
      <div class="block2__thumb matchHeight">
        <?php
        $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
        if( $img!='' ) {
          echo $osfw->the_image_tag( $img );
        } else {
          echo '<img class="block2__thumb-main" src="' . get_stylesheet_directory_uri() . '/images/common/noimage-500.svg' . '" alt="">';
        }
        ?>
      </div>
      <div class="block2__main matchHeight">
        <div class="block2-text">
          <h3 class="block2__ttk">
            <?php the_title(); ?> 
            <span class="block2__ttk--small">投稿日時 <?php the_time('Y.m.d'); ?></span>
          </h3>
          <p class="mt-xs-5">
            <?php echo $osfw->get_excerpt_filter( get_the_excerpt(), 50, '[...]' );
            ?>
          </p>
          <a href="<?php the_permalink(); ?>" class="block2__link"><span>記事を読む</span></a>
        </div>
      </div>
    </div>
  </div><!-- .block2 -->
</li>
