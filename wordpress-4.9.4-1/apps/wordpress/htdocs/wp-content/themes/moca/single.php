<?php get_header(); ?>
<div class="wrap">
  <main class="main">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post_thumb_wrap">
				<figure class="post_thumb">
					<?php if( has_post_thumbnail() ){
            the_post_thumbnail( 'large' );
          } else {
            echo '<div class="no_image"></div>';
          } ?>
				</figure>
        <div class="post_meta">
          <p class="post_posted"><time datetime="<?php the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time></p>
          <div class="post_cat_wrap">
            <p class="post_cats">
              <?php if( has_category() ){ ?>
                <i class="fa fa-folder-o" aria-hidden="true"></i><?php the_category(','); ?>
              <?php } ?>
              <?php if( has_tag() ){ ?>
                <i class="fa fa-tag" aria-hidden="true"></i><?php the_tags('', ','); ?>
              <?php } ?>
            </p>
          </div>
				</div><!-- /.post_meta -->
			</div><!-- /.post_thumb_wrap -->
      <div class="title_wrap">
        <?php the_title( '<h1 class="post_title">', '</h1>' ); ?>
      </div>
			<div class="post_content_area">
        <?php get_template_part( 'template-parts/module_sns_buttons' ) ?>
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
    <?php get_template_part( 'template-parts/module_sns_buttons' ) ?>
    <?php
      $prev = get_previous_post_link('%link');
      $next = get_next_post_link('%link');
      if( !empty( $prev || $next ) ){
    ?>
    <div class="pagelink">
		<?php
  		if( !empty( $prev ) ){
  			echo '<p class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i> '. $prev .'</p>';
  		}
  		if( !empty( $next )){
  			echo '<p class="next">'. $next .' <i class="fa fa-angle-right" aria-hidden="true"></i></p>';
  		}
		?>
		</div>
    <?php } ?>
		<div class="comment">
		<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>
		</div><!-- /.comment -->
 </main><!-- /.site_main -->
<?php get_sidebar(); ?>
</div><!-- /.wrap -->
<?php get_footer(); ?>
