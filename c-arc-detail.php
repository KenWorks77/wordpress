<div id="c-archive-div">
  <?php
    if (have_posts()):
      while (have_posts()) : ?>
      <div class="fade-in">
        <?php the_post();
          // アイキャッチ画像指定が無ければ投稿内最初の画像を表示
          if (has_post_thumbnail()) :
            $image_url = get_the_post_thumbnail_url();
          else :
            $image_url = get_first_image_url();
          endif;
          echo '<p class="adjust-img"><a href="' . esc_url(get_the_permalink()) . '"><img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '"></a></p>'; ?>
        <h2><a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html(get_the_excerpt()); ?> <a href="<?php the_permalink(); ?>">Continue reading →</a></p>
        <p><button class="add-favorite" data-slug="<?php echo esc_attr($post->post_name); ?>" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>" data-img="<?php echo esc_attr($image_url); ?>">Add to favorites</button></p>
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

<!-- カスタム投稿ページ内検索 -->
<div class="search-form">
  <form action="<?php echo esc_url(home_url()); ?>" method="get" class="fade-in">
    <input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="Search <?php echo esc_attr(get_post_type_object(get_post_type())->label); ?>">
    <input type="hidden" name="post_type" value="<?php echo esc_attr(get_post_type_object(get_post_type())->name); ?>">
    <button type="submit">Search</button>
  </form>
</div>
