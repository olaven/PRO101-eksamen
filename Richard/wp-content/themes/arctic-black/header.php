<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arctic Black
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php if( has_nav_menu( 'menu-1' ) ) :?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'arctic-black' ); ?></a>
	<?php endif;?>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'arctic-black' ); ?></a>

	<?php if( is_active_sidebar( 'sidebar-2' ) ) :?>
		<a class="skip-link screen-reader-text" href="#tertiary"><?php esc_html_e( 'Skip to footer', 'arctic-black' ); ?></a>
	<?php endif;?>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrap">
			<div class="site-branding">
				<?php
				arctic_black_custom_logo();
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<?php if ( has_nav_menu( 'menu-1' ) ) :?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' 	=> 'menu-1',
						'menu_id' 			=> 'primary-menu',
						'container_class'	=> 'menu-wrap',
						'depth'				=> 1
					) );
				?>
				<button id="sidebar-toggle" class="sidebar-toggle" aria-controls="secondary" aria-expanded="false">
					<span class="sidebar-toggle-icon"></span>
				</button>
			</nav><!-- #site-navigation -->
			<?php endif;?>

		</div><!-- .wrap -->
	</header><!-- #masthead -->

	<?php get_template_part( 'template-parts/content', 'hero' ); ?>

	<div id="content" class="site-content">
