<?php get_header(); ?>
<?php
  if (have_posts()):
    while (have_posts()): ?>
    <div id="c-single-tle"><h1 class="c-single-h1 fade-in"><?php the_title(); ?></h1></div>
    <?php the_post(); ?>
    <p><?php the_content(); ?></p>
<?php
    endwhile;
  endif; ?>
<!--page.phpを使用しています。-->
<?php get_footer(); ?>
