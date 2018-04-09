<?php get_header(); ?>
<div class="wrap">
  <main class="main" role="main">
  <div class="entry_wrap">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/module_entry_item' );
      endwhile;
    else:
      echo '<p>'. __( 'No articles found.', 'moca' ) . '<p>';
      endif; // End the have_post
    ?>
  </div>
 <?php get_template_part( 'template-parts/module_pagination' ); ?>
 </main><!-- /.site_main -->
<?php get_sidebar(); ?>
</div><!-- /.wrap -->
<?php get_footer(); ?>
