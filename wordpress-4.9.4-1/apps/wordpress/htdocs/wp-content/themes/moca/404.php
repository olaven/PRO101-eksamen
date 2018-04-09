<?php get_header(); ?>
<div class="wrap">
  <main class="main">
  <div class="entry_wrap">
		<p class="not_found_txt">
      <?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'moca' ); ?>
    </p>
		<?php get_search_form(); ?>
  </div>
 </main><!-- /.site_main -->
<?php get_sidebar(); ?>
</div><!-- /.wrap -->
<?php get_footer(); ?>
