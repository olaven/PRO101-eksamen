<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrap">
	<header class="header" role="banner">
	<?php
		if( has_nav_menu( 'head' ) ){
	?>
		<div class="g_nav_wrap">
			<button class="g_navi_button" type="button"><?php _e( 'Menu', 'moca' ); ?><i class="fa fa-bars" aria-hidden="true"></i></button>
			<nav class="g_navi" role="navigation">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'head',
						'container'      => false,
						'items_wrap' => '<ul>%3$s</ul>'
					)
				); ?>
			</nav>
		</div><!-- /.gnav_wrap -->
	<?php } ?>
	<?php
		$title_tag = 'h1';
		if( is_single() ){
			$title_tag = 'div';
		}
	?>
		<<?php echo $title_tag; ?> class="site_title"><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></<?php echo $title_tag; ?>>
		<p class="site_description"><?php bloginfo('description'); ?></p>
	</header><!-- /.header -->
</div><!-- /.wrap -->
