<?php
/*-------------------------------------------*/
/*	Theme setup
/*-------------------------------------------*/
if ( ! function_exists( 'moca_theme_setup' ) ) :
function moca_theme_setup() {
	load_theme_textdomain( 'moca', get_template_directory() . '/languages');
	/*-------------------------------------------*/
	/*	Add default posts and comments RSS feed links to head.
	/*-------------------------------------------*/
	add_theme_support( 'automatic-feed-links' );
	/*-------------------------------------------*/
	/*	manage the document title & custom
	/*-------------------------------------------*/
	add_theme_support( 'title-tag' );
	/*-------------------------------------------*/
	/*	support for Post Thumbnails
	/*-------------------------------------------*/
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'moca_thumb_image', 350, 9999, false );
	add_image_size( 'moca_thumbnail_avatar', 100, 100, true );
	/*-------------------------------------------*/
	/*	Set the default content width.
	/*-------------------------------------------*/
	$GLOBALS['content_width'] = 800;
	/*-------------------------------------------*/
	/*	This theme uses wp_nav_menu() in two locations.
	/*-------------------------------------------*/
	register_nav_menus(
		array(
			'head'    => __( 'Head menu', 'moca' )
		)
	);
	/*-------------------------------------------*/
	/*	Switch default core markup for search form, comment form, and comments
	/*-------------------------------------------*/
	add_theme_support( 'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	/*-------------------------------------------*/
	/*	Add theme support for Custom Logo.
	/*-------------------------------------------*/
	add_theme_support( 'custom-logo',
		array(
			'width'       => 250,
			'height'      => 250,
			'flex-width'  => true,
		)
	);
	/*-------------------------------------------*/
	/*	Add theme support for selective refresh for widgets.
	/*-------------------------------------------*/
	add_theme_support( 'customize-selective-refresh-widgets' );
	/*-------------------------------------------*/
	/*	This theme styles the visual editor to resemble the theme style,
	/*-------------------------------------------*/
	add_editor_style( get_stylesheet_directory_uri() . '/assets/css/editor-style.css' );
	/*-------------------------------------------*/
	/*	Add custom background
	/*-------------------------------------------*/
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'default-repeat'         => '',
		'default-position-x'     => '',
		'default-attachment'     => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );

	/*-------------------------------------------*/
	/*	widget init
	/*-------------------------------------------*/
	function moca_widgets_init() {
		register_sidebar(
			array(
				'name' => esc_html__( 'Side area1', 'moca' ),
				'id' => 'side-widget-area1',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
		register_sidebar(
			array(
				'name' => esc_html__( 'Side area2', 'moca' ),
				'id' => 'side-widget-area2',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
		register_sidebar(
			array(
				'name' => esc_html__( 'Side area3', 'moca' ),
				'id' => 'side-widget-area3',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
		register_sidebar(
			array(
				'name' => esc_html__( 'Footer area1', 'moca' ),
				'id' => 'footer-widget-area1',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
		register_sidebar(
			array(
				'name' => esc_html__( 'Footer area2', 'moca' ),
				'id' => 'footer-widget-area2',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
		register_sidebar(
			array(
				'name' => esc_html__( 'Footer area3', 'moca' ),
				'id' => 'footer-widget-area3',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			)
		);
	}
	add_action( 'widgets_init', 'moca_widgets_init' );
	/*-------------------------------------------*/
	/*	Load css JS
	/*-------------------------------------------*/
	function moca_add_script() {

		// CSS =====================================
		wp_enqueue_style( 'moca_style', get_template_directory_uri() . '/assets/css/style.css', false );
		wp_enqueue_style( 'moca_font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', false );
		wp_enqueue_style( 'moca_notosans_fonts', '//fonts.googleapis.com/earlyaccess/notosansjapanese.css', false );
		wp_enqueue_style( 'moca_mada_fonts', '//fonts.googleapis.com/css?family=Mada', false );

		// JS =====================================
  	wp_enqueue_script( 'moca_common_js', get_template_directory_uri() . '/assets/js/common.js', array( 'jquery' ), '', false );
  }
	add_action('wp_enqueue_scripts','moca_add_script');
} // end moca_theme_setup

endif;
add_action( 'after_setup_theme', 'moca_theme_setup' );

/*-------------------------------------------*/
/*	Add a pingback url auto-discovery header for singularly identifiable articles.
/*-------------------------------------------*/
function moca_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'moca_pingback_header' );

/*-------------------------------------------*/
/*	Add a admin font
/*-------------------------------------------*/
function moca_load_admin_fonts( $hook ) {
	if ( 'post.php' !== $hook || 'post-new.php' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'moca_notosans_admin_font', '//fonts.googleapis.com/earlyaccess/notosansjapanese.css' );
}
add_action( 'admin_enqueue_scripts', 'moca_load_admin_fonts' );


/* ---------------------------------------------
	customize_register
--------------------------------------------- */
$moca_customize =  new moca_customize();

class moca_customize {

	public function __construct(){
		add_action( 'customize_register', array( $this, 'customize_register_moca_theme_setting' ) );
	}

	/* ---------------------------------------------
		moca theme setting
	--------------------------------------------- */
	public function customize_register_moca_theme_setting( $wp_customize ){
		$wp_customize->add_section( 'moca_section', array(
			'title' => 'moca theme setting',
			'priority' => 700,
		) );

		$add_setting_array = array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_callback' )
		);

		$add_setting_array_allowed_html = array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'sanitize_callback_allowed_html' )
		);

		/* ---------------------------------------------
			Link color
		--------------------------------------------- */
	  $wp_customize->add_setting( 'moca_options[link_color]', array(
				'default' => '',
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => array( $this, 'sanitize_callback' )
			)
		 );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'moca_options[link_color]',
			array(
				'label' => __( 'Link color', 'moca' ),
				'section'  => 'moca_section',
				'settings' => 'moca_options[link_color]',
				'description' => __( 'Please select link color.', 'moca' ),
			)
		));
	}

	/* ---------------------------------------------
		sanitize_callback
	--------------------------------------------- */
	public function sanitize_callback( $option ){
		$option = stripslashes( $option );
		return $option;
	}

	public function sanitize_callback_allowed_html( $option ){
		$allowed_html = array(
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'span' => array(),
		);
		wp_kses( $option, $allowed_html );
		return $option;
	}

} // moca_customize

/* -----------------------------------------------------------
	output HTML header
----------------------------------------------------------- */
// ヘッダーへスタイル書き出し
add_action('wp_head', 'moca_head_style');
function moca_head_style(){
	$moca_options = moca_options_load();
	$moca_link_color = $moca_options['link_color'];
	if( !empty( $moca_link_color ) ):
		$moca_link_color = preg_replace("/#/", "", $moca_link_color);

		$array_moca_link_color = [];
		$array_moca_link_color[] = hexdec( substr( $moca_link_color, 0, 2 ) );
		$array_moca_link_color[] = hexdec( substr( $moca_link_color, 2, 2) );
		$array_moca_link_color[] = hexdec( substr( $moca_link_color, 4, 2) );
	?>
		<style type="text/css" >
			.entry .sec_title a{
				<?php
					echo 'background : linear-gradient(transparent 90%, rgba('. $array_moca_link_color[0] .','. $array_moca_link_color[1] .','. $array_moca_link_color[2] .',0.4) 90%);'.PHP_EOL;
				?>
			}
			.entry .sec_title a:hover{
				<?php
					echo 'background : linear-gradient(transparent 80%, rgba('. $array_moca_link_color[0] .','. $array_moca_link_color[1] .','. $array_moca_link_color[2] .',0.4) 80%);'.PHP_EOL;
					echo 'text-decoration: none';
				?>
			}
			.pagelink p a:hover, .post_content a{
				<?php
					echo 'background : linear-gradient(transparent 70%, rgba('. $array_moca_link_color[0] .','. $array_moca_link_color[1] .','. $array_moca_link_color[2] .',0.4) 70%);'.PHP_EOL;
				?>
			}
		</style>
	<?php
	endif;
}
function moca_options_load(){
	$option = get_option( 'moca_options', moca_default_option() );
	if( !$option ){ $option = moca_default_option(); }
	return $option;
}
function moca_default_option(){
	return $option = array(
		'bg_color' => '#f27773'
	);
}
