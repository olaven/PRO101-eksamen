<?php
/**
 * Featured Content
 *
 * @package Arctic Black
 */

if ( get_theme_mod( 'enable_slider' ) == false ) {
	if ( is_customize_preview() ) {
		echo '<div id="featured-content" class="featured-content not-visible"></div>';
	}
	return;
}

$arctic_black_featured = new WP_Query( array(
	'cat'     			=> absint( get_theme_mod( 'slider_cat', 1 ) ),
	'posts_per_page' 	=> absint( get_theme_mod( 'slides_num', 5 ) ),
	'orderby'        	=> esc_attr( get_theme_mod( 'slider_orderby', 'date' ) ),
	'order'          	=> esc_attr( get_theme_mod( 'slider_order', 'DESC' ) ),
	'post__not_in' 		=> get_option( 'sticky_posts' ),
	'no_found_rows'  	=> true,
) );

if ( $arctic_black_featured->have_posts() ) : ?>

	<div id="featured-content" class="featured-content">

		<?php while ( $arctic_black_featured->have_posts() ) : $arctic_black_featured->the_post(); ?>

		<?php

		$featured_image 	= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'arctic-large' ) ;
		$background_image 	= ( !empty( $featured_image[0] ) ) ? 'style="background-image:url(' . esc_url( $featured_image[0] ) . ');"' : '' ;
		?>

		<article id="featured-post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="featured-image" <?php echo $background_image;?>></div>
			<div class="slider-content">

				<header class="entry-header">

					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				</header>

			</div>

		</article>

		<?php endwhile; ?>

	</div><!-- #featured-content -->

<?php endif; wp_reset_postdata();?>
