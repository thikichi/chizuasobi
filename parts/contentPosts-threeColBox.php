<?php
global $osfw;
global $i;
?>
<li class="col-md-4 matchHeight mb-xs-15">
  <div class="box-2">
    <?php if( $i > 5 ) { echo '<a class="_nextlink hover-nonUnderline" href="#"><span>さらに記事を見るには<br>こちらをクリック！</span></a>'; } ?>
    <h3 class="box-2-subttl">
      <span class="box-2-subttl-num"><?php echo $i; ?></span>
      <span class="box-2-subttl-main"><?php the_title(); ?> <a href="#mapAreaSp" id="HandleMap-mapAreaSp-<?php the_ID(); ?>" class="link-color-1 text-12">[地図を見る]</a></span>
    </h3>
    <div class="box-2-main">
      <div class="box-2-main-inner">
        <div class="box-2-main-thumb">
          <?php
          $img = $osfw->get_thumbnail_by_post( $post->ID, 'thumbnail' );
          if( $img!='' ) {
            echo $osfw->the_image_tag( $img );
          } else {
            echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-100.jpg" alt="">';
          }
          ?>
        </div>
        <div class="box-2-main-text">
          <p>
            <?php
            if( $i > 5 ) {
              echo $osfw->get_excerpt_filter( get_the_excerpt(), 30, '');
            } else {
              echo $osfw->get_excerpt_filter( get_the_excerpt(), 30, ' ...[続きを読む]', get_the_permalink() );
            }
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</li>