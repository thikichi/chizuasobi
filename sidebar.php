<aside class="frame-left col-lg-3 col-lg-pull-9">

  <!-- ここにコンポーネントを入れ込みます -->



  <?php
  /* ダイナミックサイドバー */
  /* 使用する場合は functions.php の該当箇所のコメントアウトを外してください */
  ?>
  <?php if(function_exists('dynamic_sidebar')): ?>
    <ul class="frame-dynamicSidebar">
      <?php dynamic_sidebar(); ?>
    </ul>
  <?php endif; ?>

</aside>
