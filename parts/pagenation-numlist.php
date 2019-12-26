<div class="align-center mt-xs-30">
<?php
/*
* 投稿一覧系ページで各ページへのリンクを出力
* 例) << 前へ 1 2 3 次へ >>
*/
?>
<?php
the_posts_pagination(array(
  'mid_size' => 3,
  'prev_text' => '&lt;  前',
  'next_text' => '次 &gt;',
  'screen_reader_text' => ' ',
));
?>
</div>