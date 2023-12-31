<div id="c-archive-title">
  <h1 id="c-archive-h1" class="fade-in"><?php echo esc_html(get_post_type_object(get_post_type())->label); ?></h1>
  <?php // タクソノミ表示
    $current_object = get_queried_object(); // 現在リクエストされているクエリの情報オブジェクトを取得
    $custom_post_ids = get_posts(array(
      'post_type' => $current_object->name,
      'numberposts' => -1, // すべての投稿を取得
      'fields' => 'ids', // 投稿IDのみ取得
    ));
    // term一覧を表示
    $terms = get_terms(array(
      'taxonomy' => $current_object->taxonomy,
      'object_ids' => $custom_post_ids, // カスタム投稿に関連付けられた投稿IDを指定
      'hide_empty' => false, // 空のtermも表示する
    ));
    if (!empty($terms)) :
      $name = get_post_type_object(get_post_type())->name;
      echo '<select id="selectbox" class="fade-in">';
      echo '<option value="' . esc_url(home_url($name)) . '">- index▼</option>';
      foreach ($terms as $term) :
        $taxonomy_strpos = strpos($term->taxonomy, $current_object->taxonomy);
        if ($taxonomy_strpos !== false) :
          $term_link = get_term_link($term); ?>
          <option value="<?php echo esc_attr($term_link); ?>"<?php if ($term->slug === $current_object->slug) {echo ' selected';} ?>>- <?php echo esc_html($term->name); ?>▼</option>
  <?php 
        endif;
      endforeach;
      echo '</select>';
    endif;
  ?>
</div>
