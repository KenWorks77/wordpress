<?php
  if (have_posts()):
    while (have_posts()): ?>
    <h1 class="c-single-h1 fade-in"><?php the_title(); ?></h1>
    <?php the_post(); ?>
    <?php the_content(); ?>
<?php
    endwhile;
  endif; ?>
<nav id="bottom-navi" class="fade-in">
  <ul>
    <li><?php previous_post_link(); ?></li>
    <li><a href="<?php echo home_url(get_post_type_object(get_post_type())->name); ?>"><?php echo get_post_type_object(get_post_type())->label; ?>-index</a></li>
    <li><?php next_post_link(); ?></li>
  </ul>
</nav>

<?php
  // Swiperスライダー
  // 親カテゴリーのslugを取得
  $parentSlug = get_post($post->post_parent)->post_type; ?>
<h2 class="swiper-h2 fade-in">Other <?php echo get_post_type_object(get_post_type())->label; ?> posts</h2>
<div class="swiper fade-in">
  <div class="swiper-wrapper">
    <?php
      $args = array(
        'post_type' => $parentSlug,
        'posts_per_page' => -1, // 表示する投稿の数（-1はすべての投稿を表示）
      );
      $custom_query = new WP_Query($args);
      $slug = $post->post_name;
      if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) :
          $custom_query->the_post();
          // アイキャッチ画像を表示
          if (has_post_thumbnail()) :
            $thumbnail_url = get_the_post_thumbnail_url();
            // スライダーに現在表示中のslugを含めない
            if (!strstr(get_permalink(), $slug)) :?>
              <div class="swiper-slide">
                <div>
                  <p class="adjust-img"><a href="<?php echo esc_url(get_permalink()); ?>"><img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"></a></p>
                  <h3><a href="<?php esc_url(get_permalink()); ?>" class="title"><?php echo esc_attr(get_the_title()); ?></a></h3>
                </div>
              </div>
    <?php
            endif;
          endif;
        endwhile;
        wp_reset_postdata(); // ループのリセット
      else :
        // 該当する投稿がない場合
        print_r('no custom posts');
      endif; ?>
  </div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
  <div class="swiper-pagination"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/swiper-setting.js"></script>
