<?php
/**
 * Social media functions.
 *
 * @package ThinkUpThemes
 */


 /* ----------------------------------------------------------------------------------
	PRE HEADER STYLE
---------------------------------------------------------------------------------- */
function thinkup_input_headerstylepre($classes) {
global $thinkup_header_styleswitchpre;

global $post;

// Set variables to avoid php non-object notice error
$_thinkup_meta_headerstylepre = NULL;

// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstylepre = get_post_meta( $post->ID, '_thinkup_meta_headerstylepre', true );
}

	// Check which header style should be output
	if ( empty( $_thinkup_meta_headerstylepre ) or $_thinkup_meta_headerstylepre == 'option1' ) {
		if ( empty( $thinkup_header_styleswitchpre ) or $thinkup_header_styleswitchpre == 'option1' ) {
			$classes[] = 'pre-header-style1';
		} else if ( $thinkup_header_styleswitchpre == 'option2' ) {
			$classes[] = 'pre-header-style2';
		}
	} else if ( $_thinkup_meta_headerstylepre == 'option2' ) {
		$classes[] = 'pre-header-style1';
	} else if ( $_thinkup_meta_headerstylepre == 'option3' ) {
		$classes[] = 'pre-header-style2';
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_headerstylepre');


/* ----------------------------------------------------------------------------------
	HEADER STYLE
---------------------------------------------------------------------------------- */
function thinkup_input_headerstyle($classes) {

	$classes[] = 'header-style1';
	return $classes;
}
add_action( 'body_class', 'thinkup_input_headerstyle');


/* ----------------------------------------------------------------------------------
	HEADER LOCATION (ALSO OUTPUTS FULL #HEADER HTML
---------------------------------------------------------------------------------- */

function thinkup_input_headerlocation() {
global $post;
global $thinkup_header_styleswitch;
global $thinkup_header_socialswitchmain;

// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
}

// Reset variable values
$class_header1_socialshow  = NULL;
$class_header2_socialshow  = NULL;
$class_header2_socialstart = NULL;
$class_header2_socialend   = NULL;

// Assign variables to add #header social media icons next to logo for header style 1
if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
	if ( $thinkup_header_styleswitch == 'option2' and $thinkup_header_socialswitchmain == '1' ) {
		$class_header1_socialshow = '1';
	}
} else if ( $_thinkup_meta_headerstyle == 'option2' ) {
	$class_header1_socialshow = '1';
}

// Assign variables to add #header social media icons next to logo for header style 2
if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
	if ( $thinkup_header_styleswitch == 'option2' and $thinkup_header_socialswitchmain == '1' ) {
		$class_header2_socialstart = '<div id="header-container">';
		$class_header2_socialend   = '</div>';
		$class_header2_socialshow  = '1';
	}
} else if ( $_thinkup_meta_headerstyle == 'option3' ) {
	$class_header2_socialstart = '<div id="header-container">';
	$class_header2_socialend   = '</div>';
	$class_header2_socialshow  = '1';
}

?>
		<div id="header">
		<div id="header-core">

			<?php echo $class_header2_socialstart; ?>

			<div id="logo">
			<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php /* Custom Logo */ thinkup_custom_logo(); ?></a>
			</div>

			<?php echo $class_header2_socialend; ?>

			<div id="header-links" class="main-navigation">
			<div id="header-links-inner" class="header-links">

				<?php $walker = new thinkup_menudescription;
				wp_nav_menu(array( 'container' => false, 'theme_location'  => 'header_menu', 'walker' => new thinkup_menudescription() ) ); ?>
				
				<?php /* Header Search */ thinkup_input_headersearch(); ?>

			</div>
			</div>
			<!-- #header-links .main-navigation -->
 	
			<?php /* Add responsive header menu */ thinkup_input_responsivehtml1(); ?>

		</div>
		</div>
		<!-- #header -->
<?php
}

// Input #header before slider
function thinkup_input_headerlocationabove() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( $thinkup_header_styleswitch == 'option1' and $thinkup_header_locationswitch == 'option2' ) {
			echo '';
		} else {
			thinkup_input_headerlocation();
		}
	} else if ( $_thinkup_meta_headerstyle == 'option2' and ( empty( $_thinkup_meta_headerlocation ) or $_thinkup_meta_headerlocation == 'option1' ) ) {
			thinkup_input_headerlocation();
	} else if ( $_thinkup_meta_headerstyle == 'option3' ) {
			thinkup_input_headerlocation();	
	}
}

// Input #header after slider
function thinkup_input_headerlocationbelow() {
global $thinkup_header_styleswitch;
global $thinkup_header_locationswitch;

global $post;
// Assign meta data variable
if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_headerstyle = get_post_meta( $post->ID, '_thinkup_meta_headerstyle', true );
	$_thinkup_meta_headerlocation = get_post_meta( $post->ID, '_thinkup_meta_headerlocation', true );
}

	if ( empty( $_thinkup_meta_headerstyle ) or $_thinkup_meta_headerstyle == 'option1' ) {
		if ( $thinkup_header_styleswitch == 'option1' and $thinkup_header_locationswitch == 'option2' ) {
			thinkup_input_headerlocation();
		}
	} else if ( $_thinkup_meta_headerstyle == 'option2' and $_thinkup_meta_headerlocation == 'option2' ) {
			thinkup_input_headerlocation();
	}
}


/* ----------------------------------------------------------------------------------
	SEARCH - DISABLE SEARCH (PRE HEADER)
---------------------------------------------------------------------------------- */
function thinkup_input_preheadersearch() {
global $thinkup_header_searchswitchpre;

	if ( $thinkup_header_searchswitchpre == '1' ) {
		echo '<div id="pre-header-search">',
			 '<div class="fa fa-search"></div>',
		     get_search_form(),
		     '</div>';
	}
}

/* ----------------------------------------------------------------------------------
	SEARCH - DISABLE SEARCH (HEADER)
---------------------------------------------------------------------------------- */
function thinkup_input_headersearch() {
global $thinkup_header_searchswitch;

	if ( $thinkup_header_searchswitch == '1' ) {
		echo '<div id="header-search">',
			 '<a><div class="fa fa-search"></div></a>',
		     get_search_form(),
		     '</div>';
	}
}

/* ----------------------------------------------------------------------------------
	SOCIAL MEDIA - DISPLAY MESSAGE
---------------------------------------------------------------------------------- */

/* Message Settings */
function thinkup_input_socialmessage(){
global $thinkup_header_socialmessage;
global $thinkup_header_facebookswitch;
global $thinkup_header_twitterswitch;
global $thinkup_header_googleswitch;
global $thinkup_header_linkedinswitch;
global $thinkup_header_flickrswitch;
global $thinkup_header_youtubeswitch;
global $thinkup_header_rssswitch;

	if ( empty( $thinkup_header_facebookswitch ) 
		and empty( $thinkup_header_twitterswitch ) 
		and empty( $thinkup_header_googleswitch ) 
		and empty( $thinkup_header_linkedinswitch ) 
		and empty( $thinkup_header_flickrswitch ) 
		and empty( $thinkup_header_lastfmswitch ) 
		and empty( $thinkup_header_youtubeswitch ) 
		and empty( $thinkup_header_rssswitch ) ) {	
		return '';
	} else if ( ! empty( $thinkup_header_socialmessage ) ) {	
		return $thinkup_header_socialmessage;
	} else if ( empty( $thinkup_header_socialmessage ) ) {
		return '';
	}
}


/* ----------------------------------------------------------------------------------
	SOCIAL MEDIA - CUSTOM ICONS
---------------------------------------------------------------------------------- */

/* Facebook - Custom Icon */
function thinkup_input_facebookicon(){
global $thinkup_header_facebookiconswitch;
global $thinkup_header_facebookcustomicon;

	$output = NULL;

	if ( $thinkup_header_facebookiconswitch == '1' and ! empty( $thinkup_header_facebookcustomicon ) ) {
		
		// Output for header social media
		$output .= '#pre-header-social li.facebook a,';
		$output .= '#pre-header-social li.facebook a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_facebookcustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.facebook i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.facebook a,';
		$output .= '#post-footer-social li.facebook a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_facebookcustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.facebook i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* Twitter - Custom Icon */
function thinkup_input_twittericon(){
global $thinkup_header_twittericonswitch;
global $thinkup_header_twittercustomicon;

	$output = NULL;

	if ( $thinkup_header_twittericonswitch == '1' and ! empty( $thinkup_header_twittercustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.twitter a,';
		$output .= '#pre-header-social li.twitter a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_twittercustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.twitter i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.twitter a,';
		$output .= '#post-footer-social li.twitter a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_twittercustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.twitter i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* Google+ - Custom Icon */
function thinkup_input_googleicon(){
global $thinkup_header_googleiconswitch;
global $thinkup_header_googlecustomicon;

	$output = NULL;

	if ( $thinkup_header_googleiconswitch == '1' and ! empty( $thinkup_header_googlecustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.google-plus a,';
		$output .= '#pre-header-social li.google-plus a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_googlecustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.google-plus i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.google-plus a,';
		$output .= '#post-footer-social li.google-plus a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_googlecustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.google-plus i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* LinkedIn - Custom Icon */
function thinkup_input_linkedinicon(){
global $thinkup_header_linkediniconswitch;
global $thinkup_header_linkedincustomicon;

	$output = NULL;

	if ( $thinkup_header_linkediniconswitch == '1' and ! empty( $thinkup_header_linkedincustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.linkedin a,';
		$output .= '#pre-header-social li.linkedin a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_linkedincustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.linkedin i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.linkedin a,';
		$output .= '#post-footer-social li.linkedin a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_linkedincustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.linkedin i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* Flickr - Custom Icon */
function thinkup_input_flickricon(){
global $thinkup_header_flickriconswitch;
global $thinkup_header_flickrcustomicon;

	$output = NULL;

	if ( $thinkup_header_flickriconswitch == '1' and ! empty( $thinkup_header_flickrcustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.flickr a,';
		$output .= '#pre-header-social li.flickr a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_flickrcustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.flickr i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.flickr a,';
		$output .= '#post-footer-social li.flickr a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_flickrcustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.flickr i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* YouTube - Custom Icon */
function thinkup_input_youtubeicon(){
global $thinkup_header_youtubeiconswitch;
global $thinkup_header_youtubecustomicon;

	$output = NULL;

	if ( $thinkup_header_youtubeiconswitch == '1' and ! empty( $thinkup_header_youtubecustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.youtube a,';
		$output .= '#pre-header-social li.youtube a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_youtubecustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.youtube i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.youtube a,';
		$output .= '#post-footer-social li.youtube a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_youtubecustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.youtube i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* RSS - Custom Icon */
function thinkup_input_rssicon(){
global $thinkup_header_rssiconswitch;
global $thinkup_header_rsscustomicon;

	$output = NULL;

	if ( $thinkup_header_rssiconswitch == '1' and ! empty( $thinkup_header_rsscustomicon ) ) {

		// Output for header social media
		$output .= '#pre-header-social li.rss a,';
		$output .= '#pre-header-social li.rss a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_rsscustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#pre-header-social li.rss i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

		// Output for footer social media
		$output .= '#post-footer-social li.rss a,';
		$output .= '#post-footer-social li.rss a:hover {';
		$output .= 'background: url("' . esc_url( $thinkup_header_rsscustomicon ) . '") no-repeat center;';
		$output .= 'background-size: 25px;';
		$output .= '-webkit-border-radius: 0;';
		$output .= '-moz-border-radius: 0;';
		$output .= '-o-border-radius: 0;';
		$output .= 'border-radius: 0;';
		$output .= '}' . "\n";
		$output .= '#post-footer-social li.rss i {';
		$output .= 'display: none;';
		$output .= '}' . "\n";

	}
	return $output;
}

/* Input Custom Social Media Icons */
function thinkup_input_socialicon(){

	$output = NULL;
	
	$output .= thinkup_input_facebookicon();
	$output .= thinkup_input_twittericon();
	$output .= thinkup_input_googleicon();
	$output .= thinkup_input_linkedinicon();
	$output .= thinkup_input_flickricon();
	$output .= thinkup_input_youtubeicon();
	$output .= thinkup_input_rssicon();

	if ( ! empty( $output ) ) {
		echo    '<style type="text/css">' . "\n" . $output . '</style>';
	}
}
add_action( 'wp_head', 'thinkup_input_socialicon', 13 );


/* ----------------------------------------------------------------------------------
	SOCIAL MEDIA - OUTPUT SOCIAL MEDIA SELECTIONS (PRE HEADER)
---------------------------------------------------------------------------------- */

function thinkup_input_socialmediaheaderpre() {
global $thinkup_header_socialswitchpre;
global $thinkup_header_socialmessage;
global $thinkup_header_facebookswitch;
global $thinkup_header_facebooklink;
global $thinkup_header_twitterswitch;
global $thinkup_header_twitterlink;
global $thinkup_header_googleswitch;
global $thinkup_header_googlelink;
global $thinkup_header_linkedinswitch;
global $thinkup_header_linkedinlink;
global $thinkup_header_flickrswitch;
global $thinkup_header_flickrlink;
global $thinkup_header_youtubeswitch;
global $thinkup_header_youtubelink;
global $thinkup_header_rssswitch;
global $thinkup_header_rsslink;

// Reset count values used in foreach loop
$i = 0;
$j = 0;

	if ( $thinkup_header_socialswitchpre == '1' ) {

		// Assign social media link to an array
		$social_links = array( 
			array( 'social' => 'Facebook',  'icon' => 'facebook',     'toggle' => $thinkup_header_facebookswitch,  'link' => $thinkup_header_facebooklink ),
			array( 'social' => 'Twitter',   'icon' => 'twitter',      'toggle' => $thinkup_header_twitterswitch,   'link' => $thinkup_header_twitterlink ),
			array( 'social' => 'Google+',   'icon' => 'google-plus',  'toggle' => $thinkup_header_googleswitch,    'link' => $thinkup_header_googlelink ),
			array( 'social' => 'LinkedIn',  'icon' => 'linkedin',     'toggle' => $thinkup_header_linkedinswitch,  'link' => $thinkup_header_linkedinlink ),
			array( 'social' => 'Flickr',    'icon' => 'flickr',       'toggle' => $thinkup_header_flickrswitch,    'link' => $thinkup_header_flickrlink ),
			array( 'social' => 'YouTube',   'icon' => 'youtube',      'toggle' => $thinkup_header_youtubeswitch,   'link' => $thinkup_header_youtubelink ),
			array( 'social' => 'RSS',       'icon' => 'rss',          'toggle' => $thinkup_header_rssswitch,       'link' => $thinkup_header_rsslink ),
		);


		// Output social media links if any link is set
		foreach( $social_links as $social ) {	
			if ( ! empty( $social['link'] ) and $j == 0 ) {
				echo '<div id="pre-header-social"><ul>'; $j = 1;

				if ( ! empty ( $thinkup_header_socialmessage ) ) {
					echo '<li class="social message">' . thinkup_input_socialmessage() . '</li>';
				}
			}

			if ( ! empty( $social['link'] ) and $social['toggle'] == '1' ) {

			echo '<li class="social ' . $social['icon'] . '">',
				 '<a href="' . $social['link'] . '" data-tip="bottom" data-original-title="' . $social['social'] . '" target="_blank">',
				 '<i class="fa fa-' . $social['icon'] . '"></i>',
				 '</a>',
				 '</li>';
			}
		}

		// Close list output of social media links if any link is set
		if ( $j !== 0 ) echo '</ul></div>';
	}
}


/* ----------------------------------------------------------------------------------
	SOCIAL MEDIA - OUTPUT SOCIAL MEDIA SELECTIONS (FOOTER)
---------------------------------------------------------------------------------- */

function thinkup_input_socialmediafooter() {
global $thinkup_header_socialswitchfooter;
global $thinkup_header_socialmessage;
global $thinkup_header_facebookswitch;
global $thinkup_header_facebooklink;
global $thinkup_header_twitterswitch;
global $thinkup_header_twitterlink;
global $thinkup_header_googleswitch;
global $thinkup_header_googlelink;
global $thinkup_header_linkedinswitch;
global $thinkup_header_linkedinlink;
global $thinkup_header_flickrswitch;
global $thinkup_header_flickrlink;
global $thinkup_header_youtubeswitch;
global $thinkup_header_youtubelink;
global $thinkup_header_rssswitch;
global $thinkup_header_rsslink;

// Reset count values used in foreach loop
$i = 0;
$j = 0;

	if ( $thinkup_header_socialswitchfooter == '1' ) {
	
		// Assign social media link to an array
		$social_links = array( 
			array( 'social' => 'Facebook',  'icon' => 'facebook',     'toggle' => $thinkup_header_facebookswitch,  'link' => $thinkup_header_facebooklink ),
			array( 'social' => 'Twitter',   'icon' => 'twitter',      'toggle' => $thinkup_header_twitterswitch,   'link' => $thinkup_header_twitterlink ),
			array( 'social' => 'Google+',   'icon' => 'google-plus',  'toggle' => $thinkup_header_googleswitch,    'link' => $thinkup_header_googlelink ),
			array( 'social' => 'LinkedIn',  'icon' => 'linkedin',     'toggle' => $thinkup_header_linkedinswitch,  'link' => $thinkup_header_linkedinlink ),
			array( 'social' => 'Flickr',    'icon' => 'flickr',       'toggle' => $thinkup_header_flickrswitch,    'link' => $thinkup_header_flickrlink ),
			array( 'social' => 'YouTube',   'icon' => 'youtube',      'toggle' => $thinkup_header_youtubeswitch,   'link' => $thinkup_header_youtubelink ),
			array( 'social' => 'RSS',       'icon' => 'rss',          'toggle' => $thinkup_header_rssswitch,       'link' => $thinkup_header_rsslink ),
		);


		// Output social media links if any link is set
		foreach( $social_links as $social ) {	
			if ( ! empty( $social['link'] ) and $j == 0 ) {
				echo '<div id="post-footer-social"><ul>'; $j = 1;

				if ( ! empty ( $thinkup_header_socialmessage ) ) {
					echo '<li class="social message">' . thinkup_input_socialmessage() . '</li>';
				}
			}

			if ( ! empty( $social['link'] ) and $social['toggle'] == '1' ) {

			echo '<li class="social ' . $social['icon'] . '">',
				 '<a href="' . $social['link'] . '" data-tip="top" data-original-title="' . $social['social'] . '" target="_blank">',
				 '<i class="fa fa-' . $social['icon'] . '"></i>',
				 '</a>',
				 '</li>';
			}
		}

		// Close list output of social media links if any link is set
		if ( $j !== 0 ) echo '</ul></div>';
	}
}

?>