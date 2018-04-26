<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_thinkup_upgrade
 * @author      Tobias Karnetze (athoss.de)
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( ! class_exists( 'ReduxFramework_thinkup_upgrade' ) ) {

	/**
	 * Main ReduxFramework_thinkup_upgrade class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_thinkup_upgrade {

		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since         1.0.0
		 * @access        public
		 * @return        void
		 */
		public function __construct( $field = array(), $value = '', $parent ) {
			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;

			if ( empty( $this->_extension_dir ) ) {
				$this->_extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
				$this->_extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '/', $this->_extension_dir ) );
			}

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );

		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since         1.0.0
		 * @access        public
		 * @return        void
		 */
		public function render() {

			// -------------------------------------------------------------------------------------
			// 1. Intro section
			// -------------------------------------------------------------------------------------

				echo	'<div id="thinkup-promotion-field-header" class="' . $this->field['style'] . $this->field['class'] . '">';
				
					echo	'<div id="promotion-table">';
					echo	'<div id="promotion-header">';
					echo	'<p class="main-title">Upgrade for $31 (10% off)</p>';
					echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-button">Upgrade Now</a>';
					echo	'</div>';

					echo	'<div id="promotion-coupon">';
					echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank">melos31<span>Normally $35. Use coupon at checkout.</span></a>';
					echo	'</div>';
					echo	'</div>';

					echo	'<p class="main-title">So... Why upgrade?</p>';
					echo	'<p class="secondary-title">We&#39;re glad you asked! Here&#39;s just some of the amazing features you&#39;ll get when you upgrade...</p>';

				echo	'</div>';


			// -------------------------------------------------------------------------------------
			// 2. Image section
			// -------------------------------------------------------------------------------------

				// Image - 1_trusted_team.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/1_trusted_team.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 2_page_builder.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/2_page_builder.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 3_premium_support.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/3_premium_support.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 4_theme_options.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/4_theme_options.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 5_shortcodes.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/5_shortcodes.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 6_unlimited_colors.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/6_unlimited_colors.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 7_parallax_pages.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/7_parallax_pages.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 8_typography.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/8_typography.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 9_backgrounds.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/9_backgrounds.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 10_responsive.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/10_responsive.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 11_retina_ready.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/11_retina_ready.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 12_site_layout.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/12_site_layout.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 13_translation_ready.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/13_translation_ready.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 14_rtl_support.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/14_rtl_support.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 15_infinite_sidebars.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/15_infinite_sidebars.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 16_portfolios.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/16_portfolios.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 17_seo_optimized.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/17_seo_optimized.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

				// Image - 18_demo_content.png
				echo	'<div id="thinkup-promotion-field-item">';
				echo	'<div class="has-screenshot">';
				echo	'<a href="' . $this->field['upgrade_url'] . '" target="_blank" class="promotion-image ">';
				echo	'<img src="' . $this->_extension_url . 'img/18_demo_content.png" alt="Premium WordPress Theme - Melos Pro" />';
				echo	'</a>';
				echo	'</div>';
				echo	'</div>';

		}

		public function enqueue() {

            wp_enqueue_style (
                'thinkup-field-thinkup_upgrade-css', 
                $this->_extension_url . 'field_thinkup_upgrade.css', 
                array(),
                time (), 
                'all'
            );

            wp_enqueue_script (
                'thinkup-field-thinkup_upgrade-js',
				$this->_extension_url . 'field_thinkup_upgrade.js',
                array(),
                time (), 
                true
            );
		}
	}
}