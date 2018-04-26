<?php
/**
 * Arctic Theme Customizer
 *
 * @package Arctic Black
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function arctic_black_customize_preview_js() {

	wp_enqueue_script( 'arctic_black_customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview', 'customize-selective-refresh' ), '20151215', true );

	$css_selector = arctic_black_css_color_selector();
	$output = array(
		'primary_color_background' 			=> $css_selector['primary_color_background'],
		'primary_color_border' 				=> $css_selector['primary_color_border'],
		'primary_color_text' 				=> $css_selector['primary_color_text'],
		'secondary_color_background' 		=> $css_selector['secondary_color_background'],
		'secondary_color_text' 				=> $css_selector['secondary_color_text'],
	);
	wp_localize_script( 'arctic_black_customizer', 'ArcticBlackCustomizerl10n', $output );

}
add_action( 'customize_preview_init', 'arctic_black_customize_preview_js' );

/**
 * Additional customizer control scripts.
 */
function arctic_black_customizer_control() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'arctic-black-customizer-control', get_parent_theme_file_uri( "/assets/css/customizer-control$suffix.css" ), array(), time(), 'all' );

	wp_enqueue_script( 'arctic-black-customizer-control', get_parent_theme_file_uri( "/assets/js/customizer-control$suffix.js" ), array(), time(), true );

}
add_action( 'customize_controls_enqueue_scripts', 'arctic_black_customizer_control', 15 );

/**
 * [arctic_black_setting_default description]
 * @return [type] [description]
 */
function arctic_black_setting_default(){
	$settings = array(
		'primary_color'		=> '#EC407A',
		'secondary_color'	=> '#F06292',
		'enable_slider'		=> false,
		'slider_cat'		=> '1',
		'slider_num'		=> 5,
		'slider_orderby'	=> 'date',
		'slider_order'		=> 'DESC',
		'post_date'			=> true,
		'post_author'		=> true,
		'post_cat'			=> true,
		'post_tag'			=> true,
		'author_display'	=> true,
		'posts_navigation'	=> 'posts_navigation',
		'theme_designer'	=> true,
		'footer_image'		=> get_template_directory_uri() . '/assets/images/footer-image.jpg',
	);

	return apply_filters( 'arctic_black_setting_default', $settings );
}

/**
 * [arctic_black_css_color_selector description]
 * @return [type] [description]
 */
function arctic_black_css_color_selector(){

	$arctic_black_css_color_selector = array(
		'primary_color_background'	=> '
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			a.post-edit-link,
			.comment-body > .reply a,
			.posts-navigation .nav-previous a:hover,
			.posts-navigation .nav-previous a:focus,
			.posts-navigation .nav-next a:hover,
			.posts-navigation .nav-next a:focus,
			.sidebar-toggled .sidebar-toggle:hover span:before,
			.sidebar-toggled .sidebar-toggle:hover span:after,
			.sidebar-toggled .sidebar-toggle:focus span:before,
			.sidebar-toggled .sidebar-toggle:focus span:after,
			.page-numbers:hover:not(.current),
			.page-numbers:focus:not(.current),
			.widget_tag_cloud a:hover,
			.widget_tag_cloud a:focus
		',
		'primary_color_border'	=> '
			.widget_tag_cloud a:hover,
			.widget_tag_cloud a:focus
		',
		'primary_color_text'	=> '
			a,
			.sticky-label,
			.widget_nav_menu a:hover,
			.widget_nav_menu a:focus,
			.widget_nav_menu li.current_page_item > a,
			.widget_nav_menu li.current-menu-item > a,
			.social-links ul a:hover,
			.social-links ul a:focus
		',
		'secondary_color_background'	=> '
			button:hover,
			button:active,
			button:focus,
			input[type="button"]:hover,
			input[type="button"]:active,
			input[type="button"]:focus,
			input[type="reset"]:hover,
			input[type="reset"]:active,
			input[type="reset"]:focus,
			input[type="submit"]:hover,
			input[type="submit"]:active,
			input[type="submit"]:focus,
			a.post-edit-link:hover,
			a.post-edit-link:focus,
			.comment-body > .reply a:hover,
			.comment-body > .reply a:active,
			.comment-body > .reply a:focus
		',
		'secondary_color_text'	=> '
			a:hover,
			a:focus,
			.featured-content .entry-title a:hover,
			.featured-content .entry-title a:focus,
			.home .site-main .entry-title a:hover,
			.home .site-main .entry-title a:focus,
			.archive .site-main .entry-title a:hover,
			.archive .site-main .entry-title a:focus,
			.entry-meta a:hover,
			.entry-meta a:focus,
			.cat-links a:hover,
			.cat-links a:focus,
			.tags-links a:hover,
			.tags-links a:focus,
			.comments-link a:hover,
			.comments-link a:focus,
			.comment-navigation a:hover,
			.comment-navigation a:focus,
			.post-navigation a:hover,
			.post-navigation a:focus,
			.comment-meta a:hover,
			.comment-meta a:focus,
			.author-title a:hover,
			.author-title a:focus,
			.site-footer a:hover,
			.site-footer a:focus
		',
	);

	return apply_filters( 'arctic_black_css_color_selector', $arctic_black_css_color_selector );
}

/**
 * Load Customizer Setting.
 */
require get_template_directory() . '/inc/customizer/sanitization-callbacks.php';
require get_template_directory() . '/inc/customizer/settings.php';
require get_template_directory() . '/inc/customizer/output.php';
