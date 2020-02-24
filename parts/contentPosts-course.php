<?php
global $osfw;
?>

<?php
$args = array(
  'post_type' => 'course',
  'posts_per_page' => 5
);
$the_query = new WP_Query( $args );
?>
<?php if ($the_query->have_posts()): ?>
  <ul class="courselist__list">
    <?php while($the_query->have_posts()) : $the_query->the_post(); ?>


      <?php
      $course_time = $osfw->get_field_tag( $post->ID, 'acf_course_time', '-' );

      $rows = get_field('acf_course_recommend_post');
      $first_row = $rows[0];
      $last_row = end($rows);

      $fpost = get_post( $first_row->ID );
      $lpost = get_post( $last_row->ID );

      $first_point = $fpost->post_title;
      $last_point = $lpost->post_title;
      ?>
      <li class="courselist__item">
        <a href="<?php the_permalink(); ?>" class="courselist__item-link">
          ルートの詳細へ
        </a>
        <div class="courselist__box">
          <div class="courselist__box-top">
            <div class="courselist__box-topSub">
              <?php 
              $thumb = $osfw->get_thumbnail_by_post( $post->ID, 'img_square_w750', $alter_img_src = '' );
              if( $thumb ) {
                echo '<img src="' . esc_url($thumb['src']) . '">';
              } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-135.jpg">';
              }
              ?>
            </div>
            <div class="courselist__box-topMain">
              <div class="courselist__box-topMainLeft">
                <h3 class="courselist__box-ttl"><?php the_title(); ?></h3>
                <dl class="courselist__box-dl">
                  <dt>ルート</dt>
                  <dd>【出発】<?php echo $first_point; ?> …⇒ 【到着】<?php echo $last_point; ?></dd>
                  <dt>所要時間</dt>
                  <dd><?php echo $course_time; ?></dd>
                </dl>
                <a href="<?php the_permalink(); ?>" class="courselist__box-link">このルートの詳細を見る</a>
              </div>
              <div class="courselist__box-topMainRight">
                <h4 class="courselist__box-rootttl">【 ルートのご紹介 】</h4>
                <p class="courselist__box-read">
                  <?php the_excerpt(); ?>
                </p>
              </div>
            </div>
          </div>
          <div class="courselist__box-bottom">
            <ul class="courselist__box-bottomList">
              <?php 
              $i = 1;
              foreach ($rows as $row): 
                $row_post = get_post( $row->ID );
                ?>
                <li class="courselist__box-bopttomItem">
                  <p class="courselist__box-step">STEP.<?php echo $i; ?></p>
                  <div class="courselist__box-bopttomBox">
                    <div class="courselist__box-bopttomBoxSub">
                      <?php 
                      $thumb = $osfw->get_thumbnail_by_post( $row->ID, 'img_square_w300', $alter_img_src = '' );
                      if( $thumb ) {
                        echo '<img src="' . esc_url($thumb['src']) . '">';
                      } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/images/common/noimage-135.jpg">';
                      }
                      ?>
                    </div>
                    <div class="courselist__box-bopttomMain">
                      <h5 class="courselist__box-bopttomTtl">
                        <a href="<?php the_permalink( $row_post->ID ); ?>"><?php echo $row_post->post_title; ?></a>
                      </h5>
                      <p class="courselist__box-bopttomRead"><?php echo $osfw->get_excerpt_filter( strip_tags($row_post->post_content), 20, '...' ); ?></p>
                    </div>
                  </div>
                </li>
              <?php $i++; endforeach; ?>
            </ul>
          </div>
        </div><!-- courselist__box -->
      </li>


    <?php endwhile; ?>
  </ul>
<?php else: ?>
  <p>記事の投稿がありません。</p>
<?php endif; ?>
<?php wp_reset_query(); ?>