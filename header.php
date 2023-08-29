<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
  </head>
  <body>
    <div id="wrap">
      <header class="fade-in">
        <div>
          <h1><a href="<?php echo home_url(); ?>" class="ci">KenWorks77</a></h1>
          <p>Fly Low - Go Fast - Turn Left</p>
        </div>
        <p id="head_img"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/cropped-travel.jpg" width="930" height="242"></a></p>
      </header>
      <nav id="head-navi" class="fade-in">
        <ul>
          <li><a href="<?php echo home_url(); ?>"<?php if (is_home() || is_front_page()) {echo ' class="current"';} ?>>Home</a></li>
          <?php
            // カスタム投稿へのリンクを表示
            $args = array(
              'public' => true,
              '_builtin' => false // カスタム投稿以外を表示させない
            );
            $post_types = get_post_types($args,'names','and');
            // 現在表示中のリンクをactiveにする
            function currentSign ($name) {
              $permalink = urldecode(get_permalink());
              if (strstr($permalink, $name)) {
                echo ' class="current"';
              }
            }
            foreach ($post_types as $post_type) :
              $object = get_post_type_object($post_type); ?>
          <li><a href="<?php echo home_url($object->name); ?>"<?php currentSign($object->name); ?>><?php echo $object->label; ?></a></li>
          <?php
            endforeach; ?>
          <li><a href="<?php echo home_url('about'); ?>"<?php currentSign('about'); ?>>About Us</a></li>
        </ul>
      </nav>
