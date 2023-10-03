<?php get_header(); ?>
<div id="c-archive-title">
  <?php if(have_posts()): ?>
    <h1 id="c-archive-h1" class="fade-in"><?php echo get_post_type_object(get_post_type())->label ?></h1>
  <?php endif; ?>
  <div class="search-result fade-in">
  <?php if(have_posts()): ?>
    <p>- Search results : <span><?php the_search_query(); ?></span></p>
  <?php else: ?>
    <p class="no-results">No results : <span><?php the_search_query(); ?></span></p>
  <?php endif; ?>
</div>
</div>
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
<?php get_footer(); ?>
