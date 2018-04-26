<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Arctic Black
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if( arctic_black_is_sticky() ) : ?>
			<span class="sticky-label"><?php echo arctic_black_get_svg( array( 'icon' => 'star' ) );?></span>
		<?php endif;?>
		<?php if ( has_post_thumbnail() ) :?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'post-thumbnail' );?>
			</div>
		<?php endif;?>
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>
	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
