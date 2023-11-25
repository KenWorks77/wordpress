<?php
function add_custom_class_to_content($content) {
  // 追加するクラス'fade-in'
  $class_fade_in = 'fade-in';
  // <figure>（画像）にクラスを追加
  $content = str_replace('<figure class="wp-block-image', '<figure class="wp-block-image ' . esc_attr($class_fade_in) , $content);
  // <figure>（動画）にクラスを追加
  $content = str_replace('<figure class="wp-block-embed', '<figure class="wp-block-embed ' . esc_attr($class_fade_in) , $content);
  // <p>（テキスト）にクラスを追加
  $content = str_replace('<p', '<p class="' . esc_attr($class_fade_in) . '"', $content);
  return $content;
}
add_filter('the_content', 'add_custom_class_to_content');

// form validation
function validation_rule($validation, $data, $Data) {
  $validation->set_rule('name', 'noempty', array('message' => 'Enter your name.'));
  $validation->set_rule('mail', 'noempty', array('message' => 'Enter your valid email address.'));
  $validation->set_rule('phone', 'tel', array('message' => 'Enter your valid phone number.'));
  $validation->set_rule('detail', 'noempty', array('message' => 'Enter your valid message.'));
  return $validation;
}
add_filter('mwform_validation_mw-wp-form-19', 'validation_rule', 10, 3);

// add title tag for each page
add_theme_support( 'title-tag' );

// get the first image in the post
function get_first_image_url() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  if(empty($first_img)){
    $first_img = 'no image画像のパスをここに指定すること';
  }
  return $first_img;
}

  // access count
  function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
      $count = 0;
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
    }else{
      $count++;
      update_post_meta($postID, $count_key, $count);
    }
  }

	// display access count on edit page
  function manage_posts_columns($columns) {
    $columns['post_views_count'] = 'アクセス数';
    return $columns;
  }
  function add_column($column_name, $post_id) {
    if ($column_name == 'post_views_count') {
        $stitle = get_post_meta($post_id, 'post_views_count', true);
    }
    if (isset($stitle) && $stitle) {
      echo attribute_escape($stitle);
    }
    else {
      echo __('None');
    }
  }
  add_filter( 'manage_posts_columns', 'manage_posts_columns' );
  add_action( 'manage_posts_custom_column', 'add_column', 10, 2 );

  // Custom Post Type UIを使用しなかった場合以下を記述（固定ページの登録も必要） 
  // function add_custom_post_type() {
    // $args = array(
    // 'label' => 'Swiper編集',
    // 'hierarchical' => false,
    // 'public' => true,
    // 'menu_position' => 5,
    // 'has_archive' => true,
    // 'show_in_rest' => true,
    // 'rewrite' => array('with_front' => false),
    // 'supports' => array(
    //   'title',
    //   'editor',
    //   'thumbnail'
    // )
    // );
    // register_post_type('swiper', $args);
  // }
  // add_action('after_setup_theme', 'add_custom_post_type');
?>
