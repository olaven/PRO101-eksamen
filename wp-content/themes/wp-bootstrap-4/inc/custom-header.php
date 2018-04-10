<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package WP_Bootstrap_4
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses wp_bootstrap_4_header_style()
 */
function wp_bootstrap_4_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'wp_bootstrap_4_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/assets/images/default-cover-img.jpeg',
		'default-text-color'     => 'ffffff',
		'width'                  => 1440,
		'height'                 => 500,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'wp_bootstrap_4_header_style',
	) ) );

	register_default_headers( array(
		'desk' => array(
			'url'           => '%s/assets/images/default-cover-img.jpeg',
			'thumbnail_url' => '%s/assets/images/default-cover-img.jpeg',
			'description'   => __( 'Desk', 'wp-bootstrap-4' )
		),
	) );
}
add_action( 'after_setup_theme', 'wp_bootstrap_4_custom_header_setup' );

if ( ! function_exists( 'wp_bootstrap_4_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see wp_bootstrap_4_custom_header_setup().
	 */
	function wp_bootstrap_4_header_style() {

		if ( get_header_image() ) : ?>
			<style type="text/css">
				.wb-bp-front-page .wp-bs-4-jumbotron {
					background-image: url(<?php echo esc_url( get_header_image() ); ?>);
				}
				.wp-bp-jumbo-overlay {
					background: rgba(33,37,41, 0.7);
				}
			</style>
		<?php
		endif;

		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.navbar-dark .navbar-brand,
			.navbar-dark .navbar-nav .nav-link,
			.navbar-dark .navbar-nav .nav-link:hover, .navbar-dark .navbar-nav .nav-link:focus,
			.navbar-dark .navbar-brand:hover, .navbar-dark .navbar-brand:focus,
			.navbar-dark .navbar-nav .show > .nav-link, .navbar-dark .navbar-nav .active > .nav-link, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .nav-link.active,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
