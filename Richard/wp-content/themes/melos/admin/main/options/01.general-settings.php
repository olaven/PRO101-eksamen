<?php
/**
 * General settings functions.
 *
 * @package ThinkUpThemes
 */

/* ----------------------------------------------------------------------------------
	Logo Settings
---------------------------------------------------------------------------------- */

function thinkup_custom_logo() {
global $thinkup_general_logoswitch;
global $thinkup_general_logolink;
global $thinkup_general_sitetitle;
global $thinkup_general_sitedescription;

	if ( $thinkup_general_logoswitch == "option1" ) {
		if ( ! empty( $thinkup_general_logolink ) ) {
			echo '<img src="' . esc_url( $thinkup_general_logolink ) . '" alt="' . esc_attr__( 'Logo', 'melos' ) . '">';
		} 
	} else if ( $thinkup_general_logoswitch == "option2" or empty( $thinkup_general_logoswitch ) ) {
		if ( empty( $thinkup_general_sitetitle ) ) {
			echo '<h1 rel="home" class="site-title" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' . get_bloginfo( 'name' ) . '</h1>';
		} else {
			echo '<h1 rel="home" class="site-title" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' . esc_html( $thinkup_general_sitetitle ) . '</h1>';
		}
		if ( ! empty( $thinkup_general_sitedescription ) ) {
			echo '<h2 class="site-description">' . esc_html( $thinkup_general_sitedescription ) . '</h2>';
		}
	}
}

// Output retina js script if retina logo is set
function thinkup_input_logoretina() {
global $thinkup_general_logoswitch;
global $thinkup_general_logolinkretina;

	if ( $thinkup_general_logoswitch == "option1" ) {
		if ( ! empty( $thinkup_general_logolinkretina ) ) {
			wp_enqueue_script( 'retina' );
		} 
	}
}	
add_action( 'wp_enqueue_scripts', 'thinkup_input_logoretina', 11 );


/* ----------------------------------------------------------------------------------
	Custom Favicon
---------------------------------------------------------------------------------- */

function thinkup_custom_favicon() {
global $thinkup_general_faviconlink;

	if ( ! empty( $thinkup_general_faviconlink ) ) {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . esc_url( $thinkup_general_faviconlink ) . '" />';
	}	
}
add_action('wp_head', 'thinkup_custom_favicon');


/* ----------------------------------------------------------------------------------
	Page Layout
---------------------------------------------------------------------------------- */

/* Add Custom Sidebar css */
function thinkup_sidebar_css($classes) {
global $thinkup_homepage_layout;
global $thinkup_general_layout;
global $thinkup_blog_layout;
global $thinkup_post_layout;
global $thinkup_portfolio_layout;
global $thinkup_project_layout;
global $thinkup_woocommerce_layout;
global $thinkup_woocommerce_layoutproduct;

global $post;

// Set variables to avoid php non-object notice error
$_thinkup_meta_layout = NULL;

// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_layout = get_post_meta( $post->ID, '_thinkup_meta_layout', true );
}

	$class_sidebar = NULL;

	if ( is_front_page() ) {
		if ( $thinkup_homepage_layout == "option1" or empty( $thinkup_homepage_layout ) ) {		
			$class_sidebar = '';
		} else if ( $thinkup_homepage_layout == "option2" ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $thinkup_homepage_layout == "option3" ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_page() and ! is_page_template( 'template-blog.php' ) ) {	
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_general_layout == "option1" or empty( $thinkup_general_layout ) ) {		
				$class_sidebar = '';
			} else if ( $thinkup_general_layout == "option2" ) {
				$class_sidebar = 'layout-sidebar-left';
			} else if ( $thinkup_general_layout == "option3" ) {
				$class_sidebar = 'layout-sidebar-right';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( thinkup_check_isblog() and ! is_single() and ! is_post_type_archive( 'portfolio' ) and ! is_post_type_archive( 'product' ) ) {
		if ( $thinkup_blog_layout == "option1" or empty( $thinkup_blog_layout ) ) {		
			$class_sidebar = '';
		} else if ( $thinkup_blog_layout == "option2" ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $thinkup_blog_layout == "option3" ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_page_template( 'template-blog.php' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_blog_layout == "option1" or empty( $thinkup_blog_layout ) ) {		
				$class_sidebar = '';
			} else if ( $thinkup_blog_layout == "option2" ) {
				$class_sidebar = 'layout-sidebar-left';
			} else if ( $thinkup_blog_layout == "option3" ) {
				$class_sidebar = 'layout-sidebar-right';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_post_type_archive( 'product' ) or is_tax( 'product_cat' ) or is_tax( 'product_tag' ) ) {
		if ( $thinkup_woocommerce_layout == "option1" or empty( $thinkup_woocommerce_layout ) ) {
			$class_sidebar = '';
		} else if ( $thinkup_woocommerce_layout == "option5" or $thinkup_woocommerce_layout == "option7" ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $thinkup_woocommerce_layout == "option6" or $thinkup_woocommerce_layout == "option8" ) {
			$class_sidebar = 'layout-sidebar-right';
		} else {
			$class_sidebar = '';
		}
	} else if ( is_singular( 'post' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_post_layout == "option1" or empty( $thinkup_post_layout ) ) {		
				$class_sidebar = '';
			} else if ( $thinkup_post_layout == "option2" ) {
				$class_sidebar = 'layout-sidebar-left';
			} else if ( $thinkup_post_layout == "option3" ) {
				$class_sidebar = 'layout-sidebar-right';
			} else {
				$class_sidebar = '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_singular( 'portfolio' ) ) {	
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_project_layout == "option1" or empty( $thinkup_project_layout ) ) {		
				$class_sidebar = '';
			} else if ( $thinkup_project_layout == "option2" ) {
				$class_sidebar = 'layout-sidebar-left';
			} else if ( $thinkup_project_layout == "option3" ) {
				$class_sidebar = 'layout-sidebar-right';
			} else {
				$class_sidebar = '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_singular( 'product' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_woocommerce_layoutproduct == "option1" or empty( $thinkup_woocommerce_layoutproduct ) ) {		
				$class_sidebar = '';
			} else if ( $thinkup_woocommerce_layoutproduct == "option2" ) {
				$class_sidebar = 'layout-sidebar-left';
			} else if ( $thinkup_woocommerce_layoutproduct == "option3" ) {
				$class_sidebar = 'layout-sidebar-right';
			} else {
				$class_sidebar = '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else if ( is_search() ) {	
		if ( $thinkup_general_layout == "option1" or empty( $thinkup_general_layout ) ) {		
			$class_sidebar = '';
		} else if ( $thinkup_general_layout == "option2" ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ($thinkup_general_layout == "option3") {
			$class_sidebar = 'layout-sidebar-right';
		}
	} else {
		if ( $_thinkup_meta_layout == 'option2' ) {
			$class_sidebar = '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			$class_sidebar = 'layout-sidebar-left';
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			$class_sidebar = 'layout-sidebar-right';
		}
	}

	// Output sidebar class
	if( ! empty( $class_sidebar ) ) {
		$classes[] = $class_sidebar;
	} else {
		$classes[] = 'layout-sidebar-none';
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_sidebar_css' );

/* Add Custom Sidebar html */
function thinkup_sidebar_html() {
global $thinkup_homepage_layout;
global $thinkup_general_layout;
global $thinkup_blog_layout;
global $thinkup_post_layout;
global $thinkup_portfolio_layout;
global $thinkup_project_layout;
global $thinkup_woocommerce_layout;
global $thinkup_woocommerce_layoutproduct;

global $post;
$_thinkup_meta_layout = get_post_meta( $post->ID, '_thinkup_meta_layout', true );

do_action('thinkup_sidebar_html');

	if ( is_front_page() ) {	
		if ( $thinkup_homepage_layout == "option1" or empty( $thinkup_homepage_layout ) ) {		
				echo '';
		} else if ( $thinkup_homepage_layout == "option2" ) {
				echo get_sidebar(); 
		} else if ( $thinkup_homepage_layout == "option3" ) {
				echo get_sidebar();
		}
	} else if ( is_page() and !is_page_template( 'template-blog.php' ) ) {	
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_general_layout == "option1" or empty( $thinkup_general_layout ) ) {		
				echo '';
			} else if ( $thinkup_general_layout == "option2" ) {
				echo get_sidebar();
			} else if ( $thinkup_general_layout == "option3" ) {
				echo get_sidebar();
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			echo get_sidebar(); 
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			echo get_sidebar(); 
		}
	} else if ( is_page_template( 'template-blog.php' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_blog_layout == "option1" or empty( $thinkup_blog_layout ) ) {		
				echo '';
			} else if ( $thinkup_blog_layout == "option2" ) {
				echo get_sidebar();
			} else if ( $thinkup_blog_layout == "option3" ) {
				echo get_sidebar();
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			echo get_sidebar(); 
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			echo get_sidebar(); 
		}
	} else if ( thinkup_check_isblog() and ! is_single() and ! is_post_type_archive( 'portfolio' ) and ! is_post_type_archive( 'product' ) ) {
		if ( $thinkup_blog_layout == "option1" or empty( $thinkup_blog_layout ) ) {		
			echo '';
		} else if ( $thinkup_blog_layout == "option2" ) {
			echo get_sidebar();
		} else if ( $thinkup_blog_layout == "option3" ) {
			echo get_sidebar();
		}
	} else if ( is_post_type_archive( 'portfolio' ) ) {	
		if ( $thinkup_portfolio_layout == "option1" or empty( $thinkup_portfolio_layout ) ) {		
			echo '';
		} else if ( $thinkup_portfolio_layout == "option5" or $thinkup_portfolio_layout == "option7" ) {
			echo get_sidebar();
		} else if ( $thinkup_portfolio_layout == "option6" or $thinkup_portfolio_layout == "option8" ) {
			echo get_sidebar();
		} else {
			echo '';
		}
	} else if ( is_post_type_archive( 'product' ) or is_tax( 'product_cat' ) or is_tax( 'product_tag' ) ) {	
		if ( $thinkup_woocommerce_layout == "option1" or empty( $thinkup_woocommerce_layout ) ) {		
			echo '';
		} else if ( $thinkup_woocommerce_layout == "option5" or $thinkup_woocommerce_layout == "option7" ) {
			echo get_sidebar();
		} else if ( $thinkup_woocommerce_layout == "option6" or $thinkup_woocommerce_layout == "option8" ) {
			echo get_sidebar();
		} else {
			echo '';
		}
	} else if ( is_singular( 'post' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_post_layout == "option1" or empty( $thinkup_post_layout ) ) {
				echo '';
			} else if ( $thinkup_post_layout == "option2" ) {
				echo get_sidebar();
			} else if ( $thinkup_post_layout == "option3" ) {
				echo get_sidebar();
			} else {
				echo '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			echo get_sidebar();
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			echo get_sidebar();
		}
	} else if ( is_singular( 'portfolio' ) ) {	
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_project_layout == "option1" or empty( $thinkup_project_layout ) ) {		
				echo '';
			} else if ( $thinkup_project_layout == "option2" ) {
				echo get_sidebar();
			} else if ( $thinkup_project_layout == "option3" ) {
				echo get_sidebar();
			} else {
				echo '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			echo get_sidebar();
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			echo get_sidebar();
		}
	} else if ( is_singular( 'product' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' ) {
			if ( $thinkup_woocommerce_layoutproduct == "option1" or empty( $thinkup_woocommerce_layoutproduct ) ) {		
				echo '';
			} else if ( $thinkup_woocommerce_layoutproduct == "option2" ) {
				echo get_sidebar();
			} else if ( $thinkup_woocommerce_layoutproduct == "option3" ) {
				echo get_sidebar();
			} else {
				echo '';
			}
		} else if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			echo get_sidebar();
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			echo get_sidebar();
		}
	} else if ( is_search() ) {	
		if ( $thinkup_general_layout == 'option1' or empty( $thinkup_general_layout ) ) {		
			echo '';
		} else if ( $thinkup_general_layout == "option2" ) {
			get_sidebar();
		} else if ( $thinkup_general_layout == "option3" ) {
			get_sidebar();
		}
	} else {
		if ( $_thinkup_meta_layout == 'option2' ) {
			echo '';
		} else if ( $_thinkup_meta_layout == 'option3' ) {
			get_sidebar();
		} else if ( $_thinkup_meta_layout == 'option4' ) {
			get_sidebar();
		}
	}
}


/* ----------------------------------------------------------------------------------
	Select a Sidebar
---------------------------------------------------------------------------------- */

/* Add Selected Sidebar To Specific Pages */
function thinkup_input_sidebars() {
global $thinkup_general_sidebars;
global $thinkup_homepage_sidebars;
global $thinkup_blog_sidebars;
global $thinkup_post_sidebars;
global $thinkup_portfolio_sidebars;
global $thinkup_project_sidebars;
global $thinkup_woocommerce_sidebars;
global $thinkup_woocommerce_sidebarsproduct;

global $post;
$_thinkup_meta_layout = get_post_meta( $post->ID, '_thinkup_meta_layout', true );
$_thinkup_meta_sidebars = get_post_meta( $post->ID, '_thinkup_meta_sidebars', true );

	if ( is_front_page() ) {
			$output = $thinkup_homepage_sidebars;
	} else if ( is_page() and ! is_page_template( 'template-blog.php' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' or $_thinkup_meta_sidebars == 'Select a sidebar:' ) {
				$output = $thinkup_general_sidebars;
		} else {
			$output = $_thinkup_meta_sidebars;
		}
	} else if ( is_page_template( 'template-blog.php' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' or $_thinkup_meta_sidebars == 'Select a sidebar:' ) {
				$output = $thinkup_blog_sidebars;
		} else {
			$output = $_thinkup_meta_sidebars;
		}	
	} else if ( thinkup_check_isblog() and ! is_single() and ! is_post_type_archive( 'portfolio' ) and ! is_post_type_archive( 'product' ) ) {
		$output = $thinkup_blog_sidebars;
	} else if ( is_post_type_archive( 'portfolio' ) ) {
		$output = $thinkup_portfolio_sidebars;
	} else if ( is_post_type_archive( 'product' ) or is_tax( 'product_cat' ) or is_tax( 'product_tag' ) ) {
		$output = $thinkup_woocommerce_sidebars;
	} else if ( is_singular( 'post' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' or $_thinkup_meta_sidebars == 'Select a sidebar:' ) {
			$output = $thinkup_post_sidebars;
		} else {
			$output = $_thinkup_meta_sidebars;
		}
	} else if ( is_singular( 'portfolio' ) ) {	
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' or $_thinkup_meta_sidebars == 'Select a sidebar:' ) {
			$output = $thinkup_project_sidebars;
		} else {
			$output = $_thinkup_meta_sidebars;
		}
	} else if ( is_singular( 'product' ) ) {
		if ( empty( $_thinkup_meta_layout ) or $_thinkup_meta_layout == 'option1' or $_thinkup_meta_sidebars == 'Select a sidebar:' ) {
			$output = $thinkup_woocommerce_sidebarsproduct;
		} else {
			$output = $_thinkup_meta_sidebars;
		}
	} else if ( is_search() ) {	
		$output = $thinkup_general_sidebars;
	} else {
		$output = esc_attr( $_thinkup_meta_sidebars );
	}

	if ( empty( $output ) or $output == 'Select a sidebar:' ) {
		$output = 'Sidebar';
	}

return $output;
}


/* ----------------------------------------------------------------------------------
	Page Templates - Meta Information
---------------------------------------------------------------------------------- */

function thinkup_custom_pagetemplateclass($classes) {
global $post;

// Set variables to avoid php non-object notice error
$_thinkup_meta_pagetemplates = NULL;

// Assign meta data variable
if ( ! empty( $post->ID ) and thinkup_check_currentpage() == get_permalink() ) {
	$_thinkup_meta_pagetemplates = get_post_meta( $post->ID, '_thinkup_meta_pagetemplates', true ); 
}

	if ( is_array( $_thinkup_meta_pagetemplates ) and $_thinkup_meta_pagetemplates['template'] == 'template-parallax' ) {
		$classes[] = 'page-template-template-parallax-php';
	} else if ( is_array( $_thinkup_meta_pagetemplates ) and ! empty( $_thinkup_meta_pagetemplates['template'] ) ) {
		$classes[] = 'page-template-' . $_thinkup_meta_pagetemplates['template'] . '-php';
	}

	return $classes;
}
add_action( 'body_class', 'thinkup_custom_pagetemplateclass');


/* ----------------------------------------------------------------------------------
	Intro Default options
---------------------------------------------------------------------------------- */

/* Add custom intro section [Extend for more options in melos update] */
function thinkup_custom_intro() {
$class_intro = NULL;

	if ( ! is_front_page() ) {

		// If no breadcrumbs are available on current page then change intro class to option1
		if ( thinkup_input_breadcrumbswitch() == '' ) { 
			$class_intro = 'option1'; 
		}

		// Output intro
		echo	'<div id="intro" class="' . esc_attr( $class_intro ) . '"><div class="wrap-safari"><div id="intro-core">',
				thinkup_input_breadcrumbswitch(),
				'<h1 class="page-title">',
				thinkup_title_select(),
				'</h1>',
				'</div></div></div>';
	}
}


//Output header above slider - Melos specific
function thinkup_custom_introabove() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( ( empty( $thinkup_header_styleswitch ) or $thinkup_header_styleswitch == 'option1' ) and $thinkup_header_locationswitch == 'option2' ) {
			return;
		} else {
			thinkup_custom_intro();	
		}
	} else if ( $_thinkup_meta_headerstyle == 'option2' and ( empty( $_thinkup_meta_headerlocation ) or $_thinkup_meta_headerlocation == 'option1' ) ) {
			thinkup_custom_intro();	
	} else if ( $_thinkup_meta_headerstyle == 'option3' ) {
			thinkup_custom_intro();	
	}
}

//Output header below slider - Melos specific
function thinkup_custom_introbelow() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( ( empty( $thinkup_header_styleswitch ) or $thinkup_header_styleswitch == 'option1' ) and $thinkup_header_locationswitch == 'option2' ) {
			thinkup_custom_intro();	
		}
	} else if ( $_thinkup_meta_headerstyle == 'option2' and $_thinkup_meta_headerlocation == 'option2' ) {
			thinkup_custom_intro();	
	}
}


/* ----------------------------------------------------------------------------------
	Enable Breadcrumbs
---------------------------------------------------------------------------------- */

/* Toggle Breadcrumbs */
function thinkup_input_breadcrumbswitch() {
global $thinkup_general_breadcrumbswitch;

	if( ! is_front_page() ) {
		if ( $thinkup_general_breadcrumbswitch == '1' ) {
			return thinkup_input_breadcrumb();
		}
	}
}

/* ----------------------------------------------------------------------------------
	Enable Responsive Layout
---------------------------------------------------------------------------------- */

/* http://wordpress.stackexchange.com/questions/27497/how-to-use-wp-nav-menu-to-create-a-select-menu-dropdown */
class thinkup_nav_menu_responsive extends Walker_Nav_Menu{

	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$output .= $indent . '<li id="res-menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) .'"' : '';

        // Insert title for top level
		$title = ( $depth == 0 )
			? '<span>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' : apply_filters( 'the_title', $item->title, $item->ID );

        // Insert sub-menu titles
		if ( $depth > 0 ) {
			$title = str_repeat('&#45; ', $depth ) . $item->title;
		}

        // Structure of output
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

// Fallback responsive menu when custom header menu has not been set.
function thinkup_input_responsivefall() {

	$output = wp_list_pages('echo=0&title_li=');

	echo '<div id="header-responsive-inner" class="responsive-links nav-collapse collapse"><ul>',
		 $output,
		 '</ul></div>';
}

function thinkup_input_responsivehtml1() {
global $thinkup_general_fixedlayoutswitch;

	if ( $thinkup_general_fixedlayoutswitch !== '1' ) {

		echo '<div id="header-nav">',
		     '<a class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">',
		     '<span class="icon-bar"></span>',
		     '<span class="icon-bar"></span>',
		     '<span class="icon-bar"></span>',
		     '</a>',
		     '</div>';
	}
}

function thinkup_input_responsivehtml2() {
global $thinkup_general_fixedlayoutswitch;

	if ( $thinkup_general_fixedlayoutswitch !== '1' ) {

		$args =  array(
			'container_class' => 'responsive-links nav-collapse collapse', 
			'container_id'    => 'header-responsive-inner', 
			'menu_class'      => '', 
			'theme_location'  => 'header_menu', 
			'walker'          => new thinkup_nav_menu_responsive(), 
			'fallback_cb'     => 'thinkup_input_responsivefall',
		);

		echo '<div id="header-responsive">',
		     wp_nav_menu( $args ),
		     '</div>';
	}
}

// Input responsive header when menu is above slider
function thinkup_input_responsivehtml2_above() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( $thinkup_header_styleswitch == 'option2' and $thinkup_header_locationswitch == 'option2' ) {
			echo '';
		} else {
			thinkup_input_responsivehtml2();
		}
	} else if ( $_thinkup_meta_headerstyle == 'option3' and ( empty( $_thinkup_meta_headerlocation ) or $_thinkup_meta_headerlocation == 'option1' ) ) {
			thinkup_input_responsivehtml2();
	} else if ( $_thinkup_meta_headerstyle == 'option2' ) {
			thinkup_input_responsivehtml2();	
	}
}

// Input responsive header when menu is below slider
function thinkup_input_responsivehtml2_below() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( $thinkup_header_styleswitch == 'option2' and $thinkup_header_locationswitch == 'option2' ) {
			thinkup_input_responsivehtml2();
		}
	} else if ( $_thinkup_meta_headerstyle == 'option3' and $_thinkup_meta_headerlocation == 'option2' ) {
			thinkup_input_responsivehtml2();
	}
}


function thinkup_input_responsivecss() {
global $thinkup_general_fixedlayoutswitch;
	
	if ( $thinkup_general_fixedlayoutswitch !== '1' ) {
		wp_enqueue_style ( 'thinkup-responsive' );
	}
}
add_action( 'wp_enqueue_scripts', 'thinkup_input_responsivecss', '12' );

function thinkup_input_responsiveclass($classes){
global $thinkup_general_fixedlayoutswitch;

	if ( $thinkup_general_fixedlayoutswitch == '1' ) {
		$classes[] = 'layout-fixed';
	} else {
		$classes[] = 'layout-responsive';	
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_responsiveclass');


/* ----------------------------------------------------------------------------------
	Custom CSS
---------------------------------------------------------------------------------- */

/* Add Custom CSS */
function thinkup_custom_css() {
global $thinkup_general_customcss;

global $post;

// Set variables to avoid php non-object notice error
$_thinkup_meta_customcss = NULL;

// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_customcss = get_post_meta( $post->ID, '_thinkup_meta_customcss', true );
}

	if ( ! empty( $thinkup_general_customcss ) ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
				wp_kses_post( $thinkup_general_customcss ) . "\n",
				'</style>' . "\n";
	}
	if ( ! empty( $_thinkup_meta_customcss ) ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
				wp_kses_post( $_thinkup_meta_customcss ) . "\n",
				'</style>' . "\n";
	}
}
add_action( 'wp_head','thinkup_custom_css', '12' );


/* ----------------------------------------------------------------------------------
	Custom JavaScript - Front End
---------------------------------------------------------------------------------- */

/* Add Custom Front-End Javascript */
function thinkup_custom_javafront() {
global $thinkup_general_customjavafront;

global $post;
$_thinkup_meta_customjava = get_post_meta( $post->ID, '_thinkup_meta_customjava', true );

	if ( ! empty( $thinkup_general_customjavafront ) ) {
	echo 	'<script type="text/javascript">',
			"\n" . wp_kses_post( $thinkup_general_customjavafront ) . "\n",
			'</script>' . "\n";
	}
	if ( ! empty( $_thinkup_meta_customjava ) ) {
	echo 	'<script type="text/javascript">',
			"\n" . wp_kses_post( $_thinkup_meta_customjava ) . "\n",
			'</script>' . "\n";
	}
}
//add_action( 'wp_footer', 'thinkup_custom_javafront' );


?>