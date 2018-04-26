<?php
/**
 * Homepage functions.
 *
 * @package ThinkUpThemes
 */

/* ----------------------------------------------------------------------------------
	ENABLE SLIDER - HOMEPAGE & INNER-PAGES
---------------------------------------------------------------------------------- */

// Add full width slider class to body
function thinkup_input_sliderclass($classes){
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_sliderpresetwidth;

global $post;

if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_slider     = get_post_meta( $post->ID, '_thinkup_meta_slider', true );
	$_thinkup_meta_sliderpage = get_post_meta( $post->ID, '_thinkup_meta_sliderimages', true ); 
}
	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
			if ( empty( $thinkup_homepage_sliderpresetwidth ) or $thinkup_homepage_sliderpresetwidth == '1' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	} else if ( ! is_front_page() and !thinkup_check_ishome() and !is_archive() and !thinkup_check_isblog() and $_thinkup_meta_slider == 'on' ) {
		if ( is_array( $_thinkup_meta_sliderpage ) ) {
			if ( $_thinkup_meta_sliderpage['full_width'] == 'on' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_sliderclass');


/* ----------------------------------------------------------------------------------
	ENABLE HOMEPAGE SLIDER
---------------------------------------------------------------------------------- */

// Content for slider layout - Standard
function thinkup_input_sliderhomestandard() {
global $thinkup_homepage_sliderpreset;

	foreach ($thinkup_homepage_sliderpreset as $slide) {

		// Get url of background image or set video overlay image
		if ( ! empty( $slide['slide_video'] ) ) {
			$slide_image = 'background: url(' . get_template_directory_uri() . '/images/slideshow/overlay.png' . ') repeat center;';
		} else {
			$slide_image = 'background: url(' . $slide['slide_image_url'] . ') no-repeat center; background-size: cover;';
		}

		// Get additional style classes if set by user
		if ( ! empty( $slide['slide_class'] ) ) {
			$slide_class = ' ' . str_replace( ',', ' ', $slide['slide_class'] );

			// Check if parallax class is being used
			if ( strpos( $slide_class, 'slider-parallax' ) !== false ) {
				$slide_class_parallax = 'class="slider-parallax"';
			}

		} else {
			$slide_class          = NULL;
			$slide_class_parallax = NULL;
		}

		// Used for slider image alt text
		if ( ! empty( $slide['slide_title'] ) ) {
			$slide_alt = $slide['slide_title'];
		} else {
			$slide_alt = __( 'Slider Image', 'melos' );
		}

		echo '<li>',
			 '<img src="' . get_template_directory_uri() . '/images/transparent.png" style="' .$slide_image . '" alt="' . $slide_alt . '"' . $slide_class_parallax . ' />',
			 '<div class="rslides-content' . $slide_class .'">',
			 '<div class="wrap-safari">',
			 '<div class="rslides-content-inner">',
			 '<div class="featured">';

			if ( ! empty( $slide['slide_title'] ) ) {

				// Wrap text in <span> tags
				$slide['slide_title'] = '<span>' . $slide['slide_title'] . '</span>';
				$slide['slide_title'] = str_replace( '<br />', '</span><br /><span>', $slide['slide_title'] );
				$slide['slide_title'] = str_replace( '<br/>', '</span><br/><span>', $slide['slide_title'] );

				echo '<div class="featured-title">',
					 $slide['slide_title'],
					 '</div>';
			}
			if ( ! empty( $slide['slide_description'] ) ) {
				$slide_description = str_replace( '<p>', '<p><span>', wpautop( $slide['slide_description'] ));
				$slide_description = str_replace( '</p>', '</span></p>', $slide_description );

				// Wrap text in <span> tags
				$slide_description = str_replace( '<br />', '</span><br /><span>', $slide_description );
				$slide_description = str_replace( '<br/>', '</span><br/><span>', $slide_description );

				echo '<div class="featured-excerpt">',
					 $slide_description,
					 '</div>';
			}
			if ( ! empty( $slide['slide_url'] ) ) {

				if ( empty( $slide['slide_button'] ) ) {
					$slide['slide_button'] = __( 'Read More', 'melos' );
				}

				echo '<div class="featured-link">',
					 '<a href="' . $slide['slide_url'] . '"><span>' . $slide['slide_button'] . '</span></a>',
					 '</div>';
			}

		echo '</div>',
			  '</div>',
			  '</div>',
			  '</div>',
			  '</li>';
	}
}

// Add Slider - Homepage
function thinkup_input_sliderhome() {
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_slidername;
global $thinkup_homepage_sliderpreset;
global $thinkup_homepage_sliderspeed;
global $thinkup_homepage_sliderstyle;

$thinkup_class_fullwidth = NULL;
$thinkup_class_style     = NULL;
$slide_image             = NULL;
$slider_toggle           = NULL;

	if ( is_front_page() or thinkup_check_ishome() ) {

		// Check if any slides have been assigned to ThinkUpSlider
		if ( isset( $thinkup_homepage_sliderpreset ) and is_array( $thinkup_homepage_sliderpreset ) ) {
			foreach( $thinkup_homepage_sliderpreset as $slide ) {
				$slide_image_url = $slide['slide_image_url'];
				if( ! empty( $slide_image_url ) ) {
					$slider_toggle = '1';	
				}
			}
		}

		// Set slider speed data attribute
		if ( empty( $thinkup_homepage_sliderspeed ) ) {
			$thinkup_homepage_sliderspeed = 'off';
		} else {
			$thinkup_homepage_sliderspeed = $thinkup_homepage_sliderspeed * 1000;
		}

		$thinkup_data_speed = ' data-speed="' . $thinkup_homepage_sliderspeed . '"';

		// Set slider style class
		if ( empty( $thinkup_homepage_sliderstyle ) or $thinkup_homepage_sliderstyle == 'option1' ) {
			$thinkup_class_style = ' class="style1"';
		} else if ( $thinkup_homepage_sliderstyle == 'option2' ) {
			$thinkup_class_style = ' class="style2"';
		} else if ( $thinkup_homepage_sliderstyle == 'option3' ) {
			$thinkup_class_style = ' class="style3"';
		}

		if ( ( current_user_can( 'edit_theme_options' ) and empty( $thinkup_homepage_sliderswitch ) ) or $thinkup_homepage_sliderswitch == 'option1' ) {

			echo '<div id="slider"' . $thinkup_class_style . '><div id="slider-core">',
			     '<div class="rslides-container"' . $thinkup_data_speed . '><div class="rslides-inner"><ul class="slides">';
				if ( empty( $slider_toggle ) ) {				 
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_stylesheet_directory_uri() ) . '/images/slideshow/slide_demo1.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo2.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . get_template_directory_uri() . '/images/slideshow/slide_demo3.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
				} else if (isset($thinkup_homepage_sliderpreset) and is_array($thinkup_homepage_sliderpreset)) {
					thinkup_input_sliderhomestandard();
				}
			echo '</ul></div></div>',
			     '</div></div>';

		} else if ( $thinkup_homepage_sliderswitch !== 'option2' or empty( $thinkup_homepage_slidername ) ) {
			echo '';
		} else {
			echo	'<div id="slider"><div id="slider-core">',
				do_shortcode( $thinkup_homepage_slidername ),
				'</div></div>';
		}
	}
}

// Add ThinkUpSlider Height - Homepage
function thinkup_input_sliderhomeheight() {
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_sliderpresetheight;

	if ( empty( $thinkup_homepage_sliderpresetheight ) ) $thinkup_homepage_sliderpresetheight = '350';

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
			'#slider .rslides, #slider .rslides li { height: ' . $thinkup_homepage_sliderpresetheight . 'px; max-height: ' . $thinkup_homepage_sliderpresetheight . 'px; }' . "\n",
			'#slider .rslides img { height: 100%; max-height: ' . $thinkup_homepage_sliderpresetheight . 'px; }' . "\n",
			'</style>' . "\n";
		}
	}
}
add_action( 'wp_head','thinkup_input_sliderhomeheight', '13' );


//----------------------------------------------------------------------------------
//	ENABLE HOMEPAGE CONTENT
//----------------------------------------------------------------------------------

function thinkup_input_homepagesection() {
global $thinkup_homepage_sectionswitch;
global $thinkup_homepage_section1_image;
global $thinkup_homepage_section1_imagesize;
global $thinkup_homepage_section1_title;
global $thinkup_homepage_section1_desc;
global $thinkup_homepage_section1_link;
global $thinkup_homepage_section1_url;
global $thinkup_homepage_section1_target;
global $thinkup_homepage_section1_button;
global $thinkup_homepage_section2_image;
global $thinkup_homepage_section2_imagesize;
global $thinkup_homepage_section2_title;
global $thinkup_homepage_section2_desc;
global $thinkup_homepage_section2_link;
global $thinkup_homepage_section2_url;
global $thinkup_homepage_section2_target;
global $thinkup_homepage_section2_button;
global $thinkup_homepage_section3_image;
global $thinkup_homepage_section3_imagesize;
global $thinkup_homepage_section3_title;
global $thinkup_homepage_section3_desc;
global $thinkup_homepage_section3_link;
global $thinkup_homepage_section3_url;
global $thinkup_homepage_section3_target;
global $thinkup_homepage_section3_button;

	// Set default values for images
	$imagesize1 = 'column3-2/5';
	$imagesize2 = 'column3-2/5';
	$imagesize3 = 'column3-2/5';
		
	if ( ! empty( $thinkup_homepage_section1_image ) ) {
		if ( $thinkup_homepage_section1_imagesize == '1' ) {
			$imagesize1 = 'full';
		}
		$thinkup_homepage_section1_image = wp_get_attachment_image_src( $thinkup_homepage_section1_image, $imagesize1 );
	}
	if ( ! empty( $thinkup_homepage_section2_image ) ) {
		if ( $thinkup_homepage_section2_imagesize == '1' ) {
			$imagesize2 = 'full';
		}
		$thinkup_homepage_section2_image = wp_get_attachment_image_src( $thinkup_homepage_section2_image, $imagesize2 );
	}
	if ( ! empty( $thinkup_homepage_section3_image ) ) {
		if ( $thinkup_homepage_section3_imagesize == '1' ) {
			$imagesize3 = 'full';
		}
		$thinkup_homepage_section3_image = wp_get_attachment_image_src( $thinkup_homepage_section3_image, $imagesize3 );
	}

	// Set default values for titles
	if ( empty( $thinkup_homepage_section1_title ) ) $thinkup_homepage_section1_title = 'Perfect For All';
	if ( empty( $thinkup_homepage_section2_title ) ) $thinkup_homepage_section2_title = '100% Responsive';
	if ( empty( $thinkup_homepage_section3_title ) ) $thinkup_homepage_section3_title = 'Powerful Framework';

	// Set default values for descriptions
	if ( empty( $thinkup_homepage_section1_desc ) ) 
	$thinkup_homepage_section1_desc = 'Melos makes it the perfect choice for any website. Blog, Business, charity, well everything! You can now do it all through the beauty of Melos!';

	if ( empty( $thinkup_homepage_section2_desc ) ) 
	$thinkup_homepage_section2_desc = 'Melos is 100% responsive. It looks great on all devices, from mobiles to desktops! Switch on the responsive layout from the theme options panel.';

	if ( empty( $thinkup_homepage_section3_desc ) ) 
	$thinkup_homepage_section3_desc = 'Get a taste of our awesome ThinkUpThemes Framework. Make changes without touching code! Take control and build your perfect website fast!';

	// Get page names for links
	if ( ! empty( $thinkup_homepage_section1_url ) ) {
		$thinkup_homepage_section1_link = $thinkup_homepage_section1_url;
	} else if ( ! empty( $thinkup_homepage_section1_link ) ) {
		$thinkup_homepage_section1_link = get_permalink( $thinkup_homepage_section1_link );
	}
	if ( ! empty( $thinkup_homepage_section2_url ) ) {
		$thinkup_homepage_section2_link = $thinkup_homepage_section2_url;
	} else if ( ! empty( $thinkup_homepage_section2_link ) ) {
		$thinkup_homepage_section2_link = get_permalink( $thinkup_homepage_section2_link );
	}
	if ( ! empty( $thinkup_homepage_section3_url ) ) {
		$thinkup_homepage_section3_link = $thinkup_homepage_section3_url;
	} else if ( ! empty( $thinkup_homepage_section3_link ) ) {
		$thinkup_homepage_section3_link = get_permalink( $thinkup_homepage_section3_link );
	}

	// Get button text
	if ( empty( $thinkup_homepage_section1_button ) )
		$thinkup_homepage_section1_button = __( 'Read More', 'melos' );
	if ( empty( $thinkup_homepage_section2_button ) )
		$thinkup_homepage_section2_button = __( 'Read More', 'melos' );
	if ( empty( $thinkup_homepage_section3_button ) )
		$thinkup_homepage_section3_button = __( 'Read More', 'melos' );

	// Set target values
	if ( $thinkup_homepage_section1_target == 'option2' ) $thinkup_homepage_section1_target = ' target="_blank"';
	if ( $thinkup_homepage_section2_target == 'option2' ) $thinkup_homepage_section2_target = ' target="_blank"';
	if ( $thinkup_homepage_section3_target == 'option2' ) $thinkup_homepage_section3_target = ' target="_blank"';

	// Output featured content areas
	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( ( current_user_can( 'edit_theme_options' ) and empty( $thinkup_homepage_sectionswitch ) ) or $thinkup_homepage_sectionswitch == '1' ) {

		echo '<div id="section-home"><div id="section-home-inner">';

			echo '<article class="section1 one_third">',
					'<div class="services-builder style1">',
					'<div class="iconimage">';
					if ( empty( $thinkup_homepage_section1_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/placeholder_image.png' . '" alt="Placeholder Image" />';
					} else {
						if ( ! empty( $thinkup_homepage_section1_link ) ) {
							echo '<a href="' . $thinkup_homepage_section1_link . '"' . $thinkup_homepage_section1_target . '><img src="' . $thinkup_homepage_section1_image[0] . '" alt="' . $thinkup_homepage_section1_title . '" /></a>';
						} else {
							echo '<img src="' . $thinkup_homepage_section1_image[0] . '" alt="' . $thinkup_homepage_section1_title . '" />';
						}
					}
			echo	'</div>',
					'<div class="iconmain">',
					'<h3>' . $thinkup_homepage_section1_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section1_desc ) );
					if ( ! empty( $thinkup_homepage_section1_link ) ) {
						echo '<p class="iconurl"><a class="themebutton" href="' . $thinkup_homepage_section1_link . '"' . $thinkup_homepage_section1_target . '>' . $thinkup_homepage_section1_button . '</a></p>';
					}
			echo	'</div>',
					'</div>',
				'</article>';
			echo '<article class="section2 one_third">',
					'<div class="services-builder style1">',
					'<div class="iconimage">';
					if ( empty( $thinkup_homepage_section2_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/placeholder_image.png' . '" alt="Placeholder Image" />';
					} else {
						if ( ! empty( $thinkup_homepage_section2_link ) ) {
							echo '<a href="' . $thinkup_homepage_section2_link . '"' . $thinkup_homepage_section2_target . '><img src="' . $thinkup_homepage_section2_image[0] . '" alt="' . $thinkup_homepage_section2_title . '" /></a>';
						} else {
							echo '<img src="' . $thinkup_homepage_section2_image[0] . '" alt="' . $thinkup_homepage_section2_title . '" />';
						}
					}
			echo	'</div>',
					'<div class="iconmain">',
					'<h3>' . $thinkup_homepage_section2_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section2_desc ) );
					if ( ! empty( $thinkup_homepage_section2_link ) ) {
						echo '<p class="iconurl"><a class="themebutton" href="' . $thinkup_homepage_section2_link . '"' . $thinkup_homepage_section2_target . '>' . $thinkup_homepage_section2_button . '</a></p>';
					}
			echo	'</div>',
					'</div>',
				'</article>';

			echo '<article class="section3 one_third last">',
					'<div class="services-builder style1">',
					'<div class="iconimage">';
					if ( empty( $thinkup_homepage_section3_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/placeholder_image.png' . '" alt="Placeholder Image" />';
					} else {
						if ( ! empty( $thinkup_homepage_section3_link ) ) {
							echo '<a href="' . $thinkup_homepage_section3_link . '"' . $thinkup_homepage_section3_target . '><img src="' . $thinkup_homepage_section3_image[0] . '" alt="' . $thinkup_homepage_section3_title . '" /></a>';
						} else {
							echo '<img src="' . $thinkup_homepage_section3_image[0] . '" alt="' . $thinkup_homepage_section3_title . '" />';
						}
					}
			echo	'</div>',
					'<div class="iconmain">',
					'<h3>' . $thinkup_homepage_section3_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section3_desc ) );
				if ( ! empty( $thinkup_homepage_section3_link ) ) {
					echo '<p class="iconurl"><a class="themebutton" href="' . $thinkup_homepage_section3_link . '"' . $thinkup_homepage_section3_target . '>' . $thinkup_homepage_section3_button . '</a></p>';
				}
			echo	'</div>',
					'</div>',
				'</article>';

		echo '<div class="clearboth"></div></div></div>';
		}
	}
}


/* ----------------------------------------------------------------------------------
	CALL TO ACTION - INTRO
---------------------------------------------------------------------------------- */

function thinkup_input_ctaintro() {
global $thinkup_homepage_introswitch;
global $thinkup_homepage_introaction;
global $thinkup_homepage_introactionteaser;
global $thinkup_homepage_introactiontext1;
global $thinkup_homepage_introactionlink1;
global $thinkup_homepage_introactionpage1;
global $thinkup_homepage_introactioncustom1;

	if ( $thinkup_homepage_introswitch == '1' and ( is_front_page() or thinkup_check_ishome() ) and ! empty( $thinkup_homepage_introaction ) ) {

		echo '<div id="introaction"><div id="introaction-core">';

			echo '<div class="action-message">';

			echo '<div class="action-text">',
				 '<h3>' . $thinkup_homepage_introaction . '</h3>',
				 '</div>';

			echo '<div class="action-teaser">',
				 wpautop( $thinkup_homepage_introactionteaser ),
				 '</div>';

			echo '</div>';

			if ( ( !empty( $thinkup_homepage_introactionlink1) and $thinkup_homepage_introactionlink1 !== 'option3' ) ) {

				// Set default value of buttons to "Read more"
				if( empty( $thinkup_homepage_introactiontext1 ) ) { $thinkup_homepage_introactiontext1 = 'Read More'; }
				
				echo '<div class="action-link">';
					// Add call to action button 1
					if ( $thinkup_homepage_introactionlink1 == 'option1' ) {
						echo '<a class="themebutton" href="' . get_permalink( $thinkup_homepage_introactionpage1 ) . '">',
						$thinkup_homepage_introactiontext1,
						'</a>';
					} else if ( $thinkup_homepage_introactionlink1 == 'option2' ) {
						echo '<a class="themebutton" href="' . $thinkup_homepage_introactioncustom1 . '">',
						$thinkup_homepage_introactiontext1,
						'</a>';
					}
				echo '</div>';
			}

		echo '</div></div>';
	}
}


?>