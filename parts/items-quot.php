<?php if(have_rows('acf_related_sites')): ?>
  <div class="mt-xs-15">
    <h3 class="title-2">
      他に『<?php the_title(); ?>』を紹介しているサイトの一覧
    </h3>
    
    <ul class="list2 mt-xs-15">
      <?php while(have_rows('acf_related_sites')): the_row(); ?>
        <li class="list2-item">
          <h4 class="text-18"><?php the_sub_field('title'); ?></h4>
          <?php if( get_sub_field('url') ): ?>
            <q class="quote1-link" cite="<?php the_sub_field('url'); ?>">
              <a class="link-color-1" href="<?php the_sub_field('url'); ?>" target="_blank">
                <?php the_sub_field('url'); ?> <i class="fas fa-external-link-alt"></i>
              </a>
            </q>
          <?php endif; ?>
          <?php if( get_sub_field('explain') ): ?>
            <p class="mt-xs-10"><?php the_sub_field('explain'); ?></p>
          <?php endif; ?>

          <?php if( get_sub_field('quot') ): ?>
            <blockquote class="quote1-main" cite="http://www.example.com/kusamakura.html">
              <?php the_sub_field('quot'); ?>
            </blockquote>
          <?php endif; ?>
          <?php if( $site_name ): ?>
            <p class="quote1-ttl">
              引用元『<?php the_sub_field('title'); ?>』より抜粋
            </p>
          <?php endif; ?>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
<?php endif; ?>