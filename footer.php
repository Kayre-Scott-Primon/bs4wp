<div class="w-100 bg-secondary border-top border-dark mt-5">
      <div class="container">
        <div class="row">
          <div class="col py-5 text-center text-white">
            <h5><?php echo get_theme_mod('footer_title', 'Titlulo footer');?></h5>
            <p class="mb-0"><?php echo get_theme_mod('footer_text', 'Subtitulo footer');?></p>
          </div>
        </div>
      </div>
    </div>

    <?php wp_footer(); ?>

    <script src="<?php bloginfo('template_url');?>/js/jquery.js"></script>
    <script src="<?php bloginfo('template_url');?>/js/bootstrap.js"></script>
    <script src="<?php bloginfo('template_url');?>/js/popper.js"></script>
  </body>
</html>
