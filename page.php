<?php get_header(); ?>
<?php
  if (have_posts()):
    while (have_posts()): ?>
    <h1 class="c-single-h1 fade-in"><?php the_title(); ?></h1>
    <?php the_post(); ?>
    <p><?php the_content(); ?></p>
<?php
    endwhile;
  endif; ?>
<!--page.phpを使用しています。-->
<?php get_footer(); ?>
