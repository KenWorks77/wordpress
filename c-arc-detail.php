<h1 id="c-archive-h1" class="fade-in"><?php echo get_post_type_object(get_post_type())->label ?></h1>
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
</div>
