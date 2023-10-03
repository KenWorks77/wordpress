<?php get_header(); ?>
<div>
  <?php
    // カスタム投稿 : 最新の投稿を表示
    // 各カスタム投稿の最新投稿時間を配列にまとめる（$postTypeTime）
    $postTypeTime = array();
    $args = array(
      'public' => true,
      '_builtin' => false // カスタム投稿以外を表示させない
    );
    $post_types = get_post_types($args,'names','and');
    foreach ($post_types as $post_type) :
      $object = get_post_type_object($post_type);
      $postTypeArgs = array(
        'post_type' => $object->name,
        'posts_per_page' => 1,
      );
      $customTimeQuery = new WP_Query($postTypeArgs);
      if ($customTimeQuery->have_posts()) :
        $customTimeQuery->the_post();
        $post_name = get_post_type();
        $post_date = get_the_date('YmdHi');
        // 配列$postTypeTimeに代入
        $postTypeTime[$post_name] = $post_date;
        // ループのリセット
        wp_reset_postdata();
      endif;
    endforeach;
    // 最新の投稿時間があるカスタム投稿を特定
    $maxValue = max($postTypeTime);
    $maxKeys = array_keys($postTypeTime, $maxValue);
    // 特定した最新のカスタム投稿を表示
    $args = array(
      'post_type' => $maxKeys[0],
      'posts_per_page' => 1,
    );
    $custom_query = new WP_Query($args);
    if ($custom_query->have_posts()) :
      $custom_query->the_post();
      // アイキャッチ画像指定が無ければ投稿内最初の画像を表示
      if (has_post_thumbnail()) :
        $image_url = get_the_post_thumbnail_url();
      else :
        $image_url = get_first_image_url();
      endif; ?>
        <p id="home-notice" class="fade-in">The latest post - <?php echo get_post_type_object(get_post_type())->label; ?> <span class="new-text">NEW!</span></p>
        <div id="home-latest">
          <p class="fade-in"><a href="<?php echo esc_url(get_permalink()); ?>"><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"></a></p>
          <h1 class="fade-in"><a href="<?php echo esc_url(get_permalink()); ?>" class="title"><?php echo esc_attr(get_the_title()); ?></a></h1>
          <p class="fade-in"><?php echo get_the_excerpt(); ?> <a href="<?php echo esc_url(get_permalink()); ?>">Continue reading →</a></p>
        </div>
  <?php
      // ループのリセット
      wp_reset_postdata();
    endif; ?>
</div>
<div>
  <div id="home-div">
    <?php
      // 各カスタム投稿を表示
      // print_r($post_types);
      foreach ($post_types as $post_type) :
        $customPostArgs = array(
          'post_type' => $post_type,
          'posts_per_page' => 1,
        );
        $customPostQuery = new WP_Query($customPostArgs);
        if ($customPostQuery->have_posts()) :
          $customPostQuery->the_post();
          // アイキャッチ画像指定が無ければ投稿内最初の画像を表示
          if (has_post_thumbnail()) :
            $image_url = get_the_post_thumbnail_url();
          else :
            $image_url = get_first_image_url();
          endif;
          $post_type_object = get_post_type_object($post_type); ?>
          <div class="fade-in">
            <h1 class="home-h1"><?php echo $post_type_object->label; ?></h1>
            <p class="adjust-img"><a href="<?php echo esc_url(home_url($post_type_object->name)); ?>"><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"></a></p>
            <p><a href="<?php echo esc_url(home_url($post_type_object->name)); ?>"><?php echo $post_type_object->label; ?> index page →</a></p>
          </div>
    <?php
          // ループのリセット
          wp_reset_postdata();
        endif;
      endforeach; ?>
  </div>
</div>
<?php get_footer(); ?>
