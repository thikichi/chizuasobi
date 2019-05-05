<?php if(comments_open()): ?>
  <div class="comments">
    <?php if(have_comments()): ?>
      <ol class="comments-list">
        <?php wp_list_comments(); ?>
      </ol>
    <?php endif; ?>
    <?php comment_form(); ?>
  </div>
<?php endif; ?>