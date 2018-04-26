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
 * @subpackage  Field_thinkup_slider_free
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) {
    exit;
}

// Don't duplicate me!
if ( !class_exists ( 'ReduxFramework_thinkup_slider_free' ) ) {

    /**
     * Main ReduxFramework_thinkup_slider_free class
     *
     * @since       1.0.0
     */
    class ReduxFramework_thinkup_slider_free {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct ( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

                if ( empty( $this->_extension_dir ) ) {
                    $this->_extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                    $this->_extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '/', $this->_extension_dir ) );
                }
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render () {

            $defaults = array(
                'show' => array(
                    'slide_title' => true,
                    'slide_description' => true,
                    'slide_url' => true,
//                    '***EXAMPLE-NEW-VARIABLE***' => true, // Copy this line to add a new field
                ),
                'content_title' => __ ( 'Slide', 'redux-framework' )
            );

            $this->field = wp_parse_args ( $this->field, $defaults );

            echo '<div class="redux-thinkup_slider_free-accordion" data-new-content-title="' . esc_attr ( sprintf ( __ ( 'New %s', 'redux-framework' ), $this->field[ 'content_title' ] ) ) . '">';

            $x = 0;

            $multi = ( isset ( $this->field[ 'multi' ] ) && $this->field[ 'multi' ] ) ? ' multiple="multiple"' : "";

            if ( isset ( $this->value ) && is_array ( $this->value ) && !empty ( $this->value ) ) {

                $thinkup_slider_free = $this->value;

                foreach ( $thinkup_slider_free as $slide ) {

                    if ( empty ( $slide ) ) {
                        continue;
                    }

                    $defaults = array(
                        'slide_title' => '',
                        'slide_description' => '',
//                        '***EXAMPLE-NEW-VARIABLE***' => '', // Copy this line to add a new field
                        'slide_sort' => '',
                        'slide_url' => '',
                        'slide_image_url' => '',
                        'slide_image_thumb' => '',
                        'slide_image_id' => '',
                        'slide_image_height' => '',
                        'slide_image_width' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args ( $slide, $defaults );

					if (empty($slide['slide_image_url']) && !empty($slide['slide_image_id'])) {
                        $img = wp_get_attachment_image_src ( $slide[ 'slide_image_id' ], 'full' );
                        $slide[ 'slide_image_url' ] = $img[ 0 ];
                        $slide[ 'slide_image_width' ] = $img[ 1 ];
                        $slide[ 'slide_image_height' ] = $img[ 2 ];
                    }
					if (!empty($slide['slide_image_url'])) {
						$slide[ 'slide_image_thumb' ] = $slide[ 'slide_image_url' ];
					}

                    echo '<div class="redux-thinkup_slider_free-accordion-group"><fieldset class="redux-field" data-id="' . $this->field[ 'id' ] . '"><h3><span class="redux-thinkup_slider_free-header">' . $slide[ 'slide_title' ] . '</span></h3><div>';

                    $hide = '';

					// ThinkUpThemes Customization. Allows image to show in customizer
					if ( empty ( $slide[ 'slide_image_url' ] ) ) {
//						$hide = ' hide';
					}

                    echo '<div class="screenshot' . $hide . '">';
                    echo '<a class="of-uploaded-image" href="' . $slide[ 'slide_image_url' ] . '">';
                    echo '<img class="redux-thinkup_slider_free-image" id="image_image_id_' . $x . '" src="' . $slide[ 'slide_image_thumb' ] . '" alt="" target="_blank" rel="external" />';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="redux_thinkup_slider_free_add_remove">';

                    echo '<span class="button media_upload_button" id="add_' . $x . '">' . __ ( 'Upload', 'redux-framework' ) . '</span>';

                    $hide = '';
                    if ( empty ( $slide[ 'slide_image_url' ] ) || $slide[ 'slide_image_url' ] == '' ) {
                        $hide = ' hide';
                    }

                    echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $slide[ 'slide_image_id' ] . '">' . __ ( 'Remove', 'redux-framework' ) . '</span>';

                    echo '</div>' . "\n";

                    echo '<ul id="' . $this->field[ 'id' ] . '-ul" class="redux-thinkup_slider_free-list">';

					// Add field - slide_title
                    if ( $this->field[ 'show' ][ 'slide_title' ] ) {
                        $title_type = "text";
                    } else {
                        $title_type = "hidden";
                    }
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_title' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_title' ] ) : __ ( 'Title', 'redux-framework' );
                    echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-slide_title_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_title]' . $this->field['name_suffix'] . '" value="' . esc_attr ( $slide[ 'slide_title' ] ) . '" placeholder="' . $placeholder . '" class="full-text slide-title" /></li>';

					// Add field - slide_description
                    if ( $this->field[ 'show' ][ 'slide_description' ] ) {
                        $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_description' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_description' ] ) : __ ( 'Description', 'redux-framework' );
                        echo '<li><textarea name="' . $this->field[ 'name' ] . '[' . $x . '][slide_description]' . $this->field['name_suffix'] . '" id="' . $this->field[ 'id' ] . '-slide_description_' . $x . '" placeholder="' . $placeholder . '" class="large-text" rows="6">' . esc_attr ( $slide[ 'slide_description' ] ) . '</textarea></li>';
                    }

					// Add field - slide_url
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_url' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_url' ] ) : __ ( 'URL', 'redux-framework' );
                    if ( $this->field[ 'show' ][ 'slide_url' ] ) {
                        $url_type = "text";
                    } else {
                        $url_type = "hidden";
                    }
                    echo '<li><input type="' . $url_type . '" id="' . $this->field[ 'id' ] . '-slide_url_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_url]' . $this->field['name_suffix'] .'" value="' . esc_attr ( $slide[ 'slide_url' ] ) . '" class="full-text" placeholder="' . $placeholder . '" /></li>';

					// Add field - ***EXAMPLE-NEW-VARIABLE*** // Copy this line to add a new field
/*                    if ( $this->field[ 'show' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) {
						$placeholder = ( isset ( $this->field[ 'placeholder' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) : __ ( '***EXAMPLE PLACEHOLDER TEXT***', 'redux-framework' );
						echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-***EXAMPLE-NEW-VARIABLE***_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][***EXAMPLE-NEW-VARIABLE***]' . $this->field['name_suffix'] . '" value="' . esc_attr ( $slide[ '***EXAMPLE-NEW-VARIABLE***' ] ) . '" placeholder="' . $placeholder . '" class="full-text" /></li>';
                    } */

                    echo '<li><input type="hidden" class="slide-sort" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_sort]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-slide_sort_' . $x . '" value="' . $slide[ 'slide_sort' ] . '" />';
                    echo '<li><input type="hidden" class="upload-id" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_id]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_id_' . $x . '" value="' . $slide[ 'slide_image_id' ] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_thumb]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-slide_image_thumb_url_' . $x . '" value="' . $slide[ 'slide_image_thumb' ] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_url]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_url_' . $x . '" value="' . $slide[ 'slide_image_url' ] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload-height" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_height]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_slide_image_height_' . $x . '" value="' . $slide[ 'slide_image_height' ] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_width]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_slide_image_width_' . $x . '" value="' . $slide[ 'slide_image_width' ] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-thinkup_slider_free-remove">' . __ ( 'Delete', 'redux-framework' ) . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x ++;
                }
            }

            if ( $x == 0 ) {
                echo '<div class="redux-thinkup_slider_free-accordion-group"><fieldset class="redux-field" data-id="' . $this->field[ 'id' ] . '"><h3><span class="redux-thinkup_slider_free-header">' . esc_attr ( sprintf ( __ ( 'New %s', 'redux-framework' ), $this->field[ 'content_title' ] ) ) . '</span></h3><div>';

				 // ThinkUpThemes Customization. Allows image to show in customizer
//				$hide = ' hide';

                echo '<div class="screenshot' . $hide . '">';
                echo '<a class="of-uploaded-image" href="">';
                echo '<img class="redux-thinkup_slider_free-image" id="image_image_id_' . $x . '" src="" alt="" target="_blank" rel="external" />';
                echo '</a>';
                echo '</div>';

                //Upload controls DIV
                echo '<div class="upload_button_div">';

                //If the user has WP3.5+ show upload/remove button
                echo '<span class="button media_upload_button" id="add_' . $x . '">' . __ ( 'Upload', 'redux-framework' ) . '</span>';

                echo '<span class="button remove-image' . $hide . '" id="reset_' . $x . '" rel="' . $this->parent->args[ 'opt_name' ] . '[' . $this->field[ 'id' ] . '][slide_image_id]">' . __ ( 'Remove', 'redux-framework' ) . '</span>';

                echo '</div>' . "\n";

                echo '<ul id="' . $this->field[ 'id' ] . '-ul" class="redux-thinkup_slider_free-list">';

				// Add field - slide_title (Empty Slider)
                if ( $this->field[ 'show' ][ 'slide_title' ] ) {
                    $title_type = "text";
                } else {
                    $title_type = "hidden";
                }
                $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_title' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_title' ] ) : __ ( 'Title', 'redux-framework' );
                echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-slide_title_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_title]' . $this->field['name_suffix'] .'" value="" placeholder="' . $placeholder . '" class="full-text slide-title" /></li>';

				// Add field - slide_description (Empty Slider)
                if ( $this->field[ 'show' ][ 'slide_description' ] ) {
                    $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_description' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_description' ] ) : __ ( 'Description', 'redux-framework' );
                    echo '<li><textarea name="' . $this->field[ 'name' ] . '[' . $x . '][slide_description]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-slide_description_' . $x . '" placeholder="' . $placeholder . '" class="large-text" rows="6"></textarea></li>';
                }

				// Add field - slide_url (Empty Slider)
                $placeholder = ( isset ( $this->field[ 'placeholder' ][ 'slide_url' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ 'slide_url' ] ) : __ ( 'URL', 'redux-framework' );
                if ( $this->field[ 'show' ][ 'slide_url' ] ) {
                    $url_type = "text";
                } else {
                    $url_type = "hidden";
                }
                echo '<li><input type="' . $url_type . '" id="' . $this->field[ 'id' ] . '-slide_url_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_url]' . $this->field['name_suffix'] .'" value="" class="full-text" placeholder="' . $placeholder . '" /></li>';

				// Add field - ***EXAMPLE-NEW-VARIABLE*** (Empty Slider) // Copy this line to add a new field
/*				if ( $this->field[ 'show' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) {
					$placeholder = ( isset ( $this->field[ 'placeholder' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) ) ? esc_attr ( $this->field[ 'placeholder' ][ '***EXAMPLE-NEW-VARIABLE***' ] ) : __ ( '***EXAMPLE PLACEHOLDER TEXT***', 'redux-framework' );
					echo '<li><input type="' . $title_type . '" id="' . $this->field[ 'id' ] . '-***EXAMPLE-NEW-VARIABLE***_' . $x . '" name="' . $this->field[ 'name' ] . '[' . $x . '][title]' . $this->field['name_suffix'] .'" value="" placeholder="' . $placeholder . '" class="full-text" /></li>';
                } */

                echo '<li><input type="hidden" class="slide-sort" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_sort]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-slide_sort_' . $x . '" value="' . $x . '" />';
                echo '<li><input type="hidden" class="upload-id" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_id]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_id_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_url]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_url_' . $x . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload-height" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_height]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_slide_image_height_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_width]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-image_slide_image_width_' . $x . '" value="" /></li>';
                echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field[ 'name' ] . '[' . $x . '][slide_image_thumb]' . $this->field['name_suffix'] .'" id="' . $this->field[ 'id' ] . '-slide_image_thumb_url_' . $x . '" value="" /></li>';
                echo '<li><a href="javascript:void(0);" class="button deletion redux-thinkup_slider_free-remove">' . __ ( 'Delete', 'redux-framework' ) . '</a></li>';
                echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button redux-thinkup_slider_free-add button-primary" rel-id="' . $this->field[ 'id' ] . '-ul" rel-name="' . $this->field[ 'name' ] . '[title][]' . $this->field['name_suffix'] .'">' . sprintf ( __ ( 'Add %s', 'redux-framework' ), $this->field[ 'content_title' ] ) . '</a><br/>';
        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue () {
            if ( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script( 'media-upload' );
            }

            wp_enqueue_style ('redux-field-media-css');

            wp_enqueue_style (
                'thinkup-field-thinkup_slider_free-css', 
                $this->_extension_url . 'field_thinkup_slider_free.css', 
                array(),
                time (), 
                'all'
            );
            
            wp_enqueue_script(
                'redux-field-media-js',
                ReduxFramework::$_url . 'assets/js/media/media' . Redux_Functions::isMin() . '.js',
                array( 'jquery', 'redux-js' ),
                time(),
                true
            );

            wp_enqueue_script (
                'thinkup-field-thinkup_slider_free-js',
				$this->_extension_url . 'field_thinkup_slider_free.js',
                array( 'jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js' ),
                time (), 
                true
            );
        }
    }
}