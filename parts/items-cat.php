<?php
$cat_field_arr = array(
  array( 'key' => 'acf_castle_category', 'label' => '種類', 'type' => 'text' ),
  array( 'key' => 'acf_castle_anothername', 'label' => '城の別名', 'type' => 'text' ),
  array( 'key' => 'acf_castle_chikujyosha', 'label' => '築城者', 'type' => 'text' ),
  array( 'key' => 'acf_castle_age', 'label' => '城の年代', 'type' => 'text' ),
  array( 'key' => 'acf_castle_jyoshu', 'label' => 'おもな城主', 'type' => 'text' ),
);
?>
<ul class="list1">
  <?php
  foreach ($cat_field_arr as $cat_field) {
    # code...
    if($cat_field['type']==='text') {
      $fvalue = get_post_meta( $post->ID, $cat_field['key'], true );
      if($fvalue!='') {
        echo '<li>';
        echo '<dl class="dlList1">';
        echo '<dt class="dlList1__item--label">' . $cat_field['label'] . '</dt>';
        echo '<dd class="dlList1__item--value">' . $fvalue . '</dd>';
        echo '</dl>';
        echo '</li>';
      }
    }
  }
  ?>
</ul>