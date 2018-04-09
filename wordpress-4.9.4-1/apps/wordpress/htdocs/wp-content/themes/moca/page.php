<?php get_header(); ?>
<div class="wrap">
  <main class="main">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="title_wrap">
				<?php the_title( '<h1 class="post_title">', '</h1>' ); ?>
			</div>
			<div class="post_content_area">
				<div class="post_content">
					<?php the_content(); ?>
					<?php wp_link_pages( '<p class="link_pages">', '</p>', 'number', '', '', '%' ); ?>
				</div><!-- /.post_content -->
			</div><!-- /.post_content_area -->
		</article>
		<?php
      endwhile;
    else:
      _e( 'No articles found.', 'moca' );
      endif; // End the have_post
    ?>
 </main><!-- /.site_main -->
<?php get_sidebar(); ?>
</div><!-- /.wrap -->
<?php get_footer();
