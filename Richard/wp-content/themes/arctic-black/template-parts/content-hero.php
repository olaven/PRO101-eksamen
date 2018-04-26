<?php
/**
 * The template part for displaying Hero section
 *
 * @package Arctic Black
 */

$term_id = ( is_archive() ) ? get_queried_object()->term_id : '';
$image_id = get_term_meta( $term_id, 'image', true );
$has_post_thumbnail = ( is_singular() && has_post_thumbnail( get_the_id() ) || is_archive() ) ? ' has-post-thumbnail' : '';

?>

<div id="section-hero" class="section-hero<?php echo esc_attr( $has_post_thumbnail );?>">

<?php if( is_home() ) : ?>
	<?php arctic_black_do_slider_content();?>
<?php endif;?>

<?php if( is_singular() || is_archive() ) :?>
	<div class="hero-image"></div>

	<?php if ( is_archive() ) : ?>
	<header class="archive-header">
		<?php the_archive_title( '<h1 class="archive-title">', '</h1>' );?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' );?>
	</header><!-- .archive-header -->
	<?php endif;?>

	<?php if ( !empty( $has_post_thumbnail ) ) : ?>
		<div class="scroll-to-content">
			<a href="#content"><?php echo arctic_black_get_svg( array( 'icon' => 'chevron-down' ) );?></span></a>
		</div>
	<?php endif;?>

<?php endif;?>

</div><!-- .section-hero -->
