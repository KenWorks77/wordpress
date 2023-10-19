    <div id="bottom-area">
      <p id="scroll-top" class="fade-in"><a href="javascript:;">↑ Scroll to Top</a></p>
      <?php if( !(is_home() || is_front_page() )): ?>
        <div class="breadcrumb-area fade-in">
          <?php
            if ( function_exists('bcn_display') ) {
              bcn_display();
            }
          ?>
        </div>
      <?php endif; ?>
    </div>
    <footer class="fade-in">
      <h1><a href="<?php echo esc_url(home_url()); ?>" class="ci">KenWorks77</a></h1>
      <?php
        if (have_posts()):
          $slug = $post->post_name;
          if($slug != 'contact') : ?>
          <p>&nbsp;-&nbsp;<a href="<?php echo esc_url(home_url('contact')); ?>">Contact Us</a></p>
      <?php
          endif;
        endif; ?>
    </footer>
  </div>
  <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/smoothscroll.js"></script>
  <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/common.js"></script>
  <!-- slug: <?php $slug = $post->post_name; echo esc_html(urldecode($slug)); ?> -->
  <!-- permalink: <?php $permalink = get_permalink(); echo esc_html(urldecode($permalink)); ?> -->
  <?php wp_footer(); ?>
</body>
</html>
