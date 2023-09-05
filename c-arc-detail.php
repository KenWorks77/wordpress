<div id="c-archive-title">
  <h1 id="c-archive-h1" class="fade-in"><?php echo get_post_type_object(get_post_type())->label ?></h1>
  <?php // タクソノミ表示
    $taxonomy = get_queried_object(); // 現在リクエストされているクエリの情報オブジェクト（タクソノミーオブジェクト）を取得
    $custom_post_ids = get_posts(array(
      'post_type' => $taxonomy->name,
      'numberposts' => -1, // すべての投稿を取得
      'fields' => 'ids', // 投稿IDのみ取得
    ));
    // term一覧を表示
    $terms = get_terms(array(
      'taxonomy' => $taxonomy->taxonomy,
      'object_ids' => $custom_post_ids, // カスタム投稿に関連付けられた投稿IDを指定
      'hide_empty' => false, // 空のtermも表示する
    ));
    if (!empty($terms)) :
      echo '<select id="selectbox" class="fade-in">';
      echo '<option value="">Filter ' . get_post_type_object(get_post_type())->label . '▼</option>';
      foreach ($terms as $term) :
        $archive_strpos = strpos($term->taxonomy, $taxonomy->name); // archive-***.php向け
        $taxonomy_strpos = strpos($term->taxonomy, $taxonomy->taxonomy); // taxonomy.php向け
        if ($archive_strpos !== false || $taxonomy_strpos !== false) :
          $term_link = get_term_link($term); ?>
          <option value="<?php echo esc_url($term_link)?>"<?php if ($term->slug === $taxonomy->slug) {echo ' selected';} ?>><?php echo $term->name ?></option>
  <?php 
        endif;
      endforeach;
      echo '</select>';
    endif;
  ?>
</div>
<div id="c-archive-div">
  <?php
    if (have_posts()):
      while (have_posts()) : ?>
      <div class="fade-in">
        <?php the_post();
          if (has_post_thumbnail()) :
            echo '<p class="adjust-img"><a href="' . esc_url(get_the_permalink()) . '"><img src="' . esc_url(get_the_post_thumbnail_url()) . '" alt="' . esc_attr(get_the_title()) . '"></a></p>';
          else :
            echo '<p>※アイキャッチ画像を指定してください。</p>';
          endif; ?>
        <h2><a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a></h2>
        <p><?php echo get_the_excerpt(); ?> <a href="<?php echo esc_url(get_the_permalink()); ?>">Continue reading →</a></>
      </div>
  <?php
      endwhile;
    endif; ?>
  <div id="pagination" class="fade-in">
    <?php the_posts_pagination(
      array(
        'mid_size'      => 2,
        'prev_next'     => true,
        'prev_text'     => __( '« Prev', 'textdomain' ),
        'next_text'     => __( 'Next »', 'textdomain' ),
        'type'          => 'list',
        'screen_reader_text' => 'Pagination',
      )
    ); ?>
  </div>
</div>
