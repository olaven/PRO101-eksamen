<?php

/**
 * @class FLMenuModule
 */
class FLMenuModule extends FLBuilderModule {

	/**
	 * @property $fl_builder_page_id
	 */
	public static $fl_builder_page_id;

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Menu', 'fl-builder' ),
			'description'   	=> __( 'Renders a WordPress menu.', 'fl-builder' ),
			'category'      	=> __( 'Actions', 'fl-builder' ),
			'partial_refresh'	=> true,
			'editor_export' 	=> false,
			'icon'				=> 'hamburger-menu.svg',
		));

		add_action( 'pre_get_posts', 		__CLASS__ . '::set_pre_get_posts_query', 10, 2 );
	}

	public static function _get_menus() {
		$get_menus = get_terms( 'nav_menu', array(
			'hide_empty' => true,
		) );
		$fields = array(
			'type'          => 'select',
			'label'         => __( 'Menu', 'fl-builder' ),
			'helper'		=> __( 'Select a WordPress menu that you created in the admin under Appearance > Menus.', 'fl-builder' ),
		);

		if ( $get_menus ) {

			foreach ( $get_menus as $key => $menu ) {

				if ( 0 == $key ) {
					$fields['default'] = $menu->name;
				}

				$menus[ $menu->slug ] = $menu->name;
			}

			$fields['options'] = $menus;

		} else {
			$fields['options'] = array(
				'' => __( 'No Menus Found', 'fl-builder' ),
			);
		}

		return $fields;

	}

	public function render_toggle_button() {

		$toggle = $this->settings->mobile_toggle;

		if ( isset( $toggle ) && 'expanded' != $toggle ) {

			if ( in_array( $toggle, array( 'hamburger', 'hamburger-label' ) ) ) {

				echo '<button class="fl-menu-mobile-toggle ' . $toggle . '"><span class="svg-container">';
				include FL_BUILDER_DIR . 'img/svg/hamburger-menu.svg';
				echo '</span>';

				if ( 'hamburger-label' == $toggle ) {
					echo '<span class="fl-menu-mobile-toggle-label">' . __( 'Menu', 'fl-builder' ) . '</span>';
				}

				echo '</button>';

			} elseif ( 'text' == $toggle ) {

				echo '<button class="fl-menu-mobile-toggle text"><span class="fl-menu-mobile-toggle-label">' . __( 'Menu', 'fl-builder' ) . '</span></button>';

			}
		}
	}

	public static function set_pre_get_posts_query( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {

			if ( $query->queried_object_id ) {

				self::$fl_builder_page_id = $query->queried_object_id;

				// Fix when menu module is rendered via hook
			} elseif ( isset( $query->query_vars['page_id'] ) && 0 != $query->query_vars['page_id'] ) {

				self::$fl_builder_page_id = $query->query_vars['page_id'];

			}
		}
	}

	public static function sort_nav_objects( $sorted_menu_items, $args ) {
		$menu_items = array();
		$parent_items = array();
		foreach ( $sorted_menu_items as $key => $menu_item ) {
			$classes = (array) $menu_item->classes;

			// Setup classes for current menu item.
			if ( $menu_item->ID == self::$fl_builder_page_id ) {
				$parent_items[ $menu_item->object_id ] = $menu_item->menu_item_parent;

				if ( ! in_array( 'current-menu-item', $classes ) ) {
					$classes[] = 'current-menu-item';

					if ( 'page' == $menu_item->object ) {
						$classes[] = 'current_page_item';
					}
				}
			}
			$menu_item->classes = $classes;
			$menu_items[ $key ] = $menu_item;
		}

		// Setup classes for parent's current item.
		foreach ( $menu_items as $key => $sorted_item ) {
			if ( in_array( $sorted_item->db_id, $parent_items ) && ! in_array( 'current-menu-parent', (array) $sorted_item->classes ) ) {
				$menu_items[ $key ]->classes[] = 'current-menu-ancestor';
				$menu_items[ $key ]->classes[] = 'current-menu-parent';
			}
		}

		return $menu_items;
	}

	public function get_media_breakpoint() {
		$global_settings = FLBuilderModel::get_global_settings();
		$media_width = $global_settings->responsive_breakpoint;
		$mobile_breakpoint = $this->settings->mobile_breakpoint;

		if ( isset( $mobile_breakpoint ) && 'expanded' != $this->settings->mobile_toggle ) {
			if ( 'medium-mobile' == $mobile_breakpoint ) {
				$media_width = $global_settings->medium_breakpoint;
			} elseif ( 'mobile' == $this->settings->mobile_breakpoint ) {
				$media_width = $global_settings->responsive_breakpoint;
			} elseif ( 'always' == $this->settings->mobile_breakpoint ) {
				$media_width = 'always';
			}
		}

		return $media_width;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLMenuModule', array(
	'general'       => array( // Tab
		'title'         => __( 'General', 'fl-builder' ), // Tab title
		'sections'      => array( // Tab Sections
			'general'       => array( // Section
				'title'         => '', // Section Title
				'fields'        => array( // Section Fields
					'menu' => FLMenuModule::_get_menus(),
					'menu_layout' => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'fl-builder' ),
						'default'       => 'horizontal',
						'options'       => array(
							'horizontal'	=> __( 'Horizontal', 'fl-builder' ),
							'vertical'		=> __( 'Vertical', 'fl-builder' ),
							'accordion'		=> __( 'Accordion', 'fl-builder' ),
							'expanded'		=> __( 'Expanded', 'fl-builder' ),
						),
						'toggle'		=> array(
							'horizontal'	=> array(
								'fields'		=> array( 'submenu_hover_toggle', 'menu_align' ),
							),
							'vertical'		=> array(
								'fields'		=> array( 'submenu_hover_toggle' ),
							),
							'accordion'		=> array(
								'fields'		=> array( 'submenu_click_toggle', 'collapse' ),
							),
						),
					),
					'submenu_hover_toggle' => array(
						'type'          => 'select',
						'label'         => __( 'Submenu Icon', 'fl-builder' ),
						'default'       => 'none',
						'options'       => array(
							'arrows'		=> __( 'Arrows', 'fl-builder' ),
							'plus'			=> __( 'Plus sign', 'fl-builder' ),
							'none'			=> __( 'None', 'fl-builder' ),
						),
					),
					'submenu_click_toggle' => array(
						'type'          => 'select',
						'label'         => __( 'Submenu Icon click', 'fl-builder' ),
						'default'       => 'arrows',
						'options'       => array(
							'arrows'		=> __( 'Arrows', 'fl-builder' ),
							'plus'			=> __( 'Plus sign', 'fl-builder' ),
						),
					),
					'collapse'   => array(
						'type'          => 'select',
						'label'         => __( 'Collapse Inactive', 'fl-builder' ),
						'default'       => '1',
						'options'       => array(
							'1'             => __( 'Yes', 'fl-builder' ),
							'0'             => __( 'No', 'fl-builder' ),
						),
						'help'          => __( 'Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'none',
						),
					),
				),
			),
			'mobile'       => array(
				'title'         => __( 'Responsive', 'fl-builder' ),
				'fields'        => array(
					'mobile_toggle' => array(
						'type'          => 'select',
						'label'         => __( 'Responsive Toggle', 'fl-builder' ),
						'default'       => 'hamburger',
						'options'       => array(
							'hamburger'			=> __( 'Hamburger Icon', 'fl-builder' ),
							'hamburger-label'	=> __( 'Hamburger Icon + Label', 'fl-builder' ),
							'text'				=> __( 'Menu Button', 'fl-builder' ),
							'expanded'			=> __( 'None', 'fl-builder' ),
						),
						'toggle'		=> array(
							'hamburger'	=> array(
								'fields'		=> array( 'mobile_full_width', 'mobile_breakpoint' ),
							),
							'hamburger-label'	=> array(
								'fields'		=> array( 'mobile_full_width', 'mobile_breakpoint' ),
							),
							'text'	=> array(
								'fields'		=> array( 'mobile_breakpoint' ),
							),
						),
					),
					'mobile_full_width' => array(
						'type'          => 'select',
						'label'         => __( 'Responsive Style', 'fl-builder' ),
						'default'       => 'no',
						'options'       => array(
							'no'			=> __( 'Inline', 'fl-builder' ),
							'below'			=> __( 'Below Row', 'fl-builder' ),
							'yes'			=> __( 'Overlay', 'fl-builder' ),
						),
						'toggle'		=> array(
							'yes'	=> array(
								'fields'		=> array( 'mobile_menu_bg' ),
							),
							'below'	=> array(
								'fields'		=> array( 'mobile_menu_bg' ),
							),
						),
					),
					'mobile_breakpoint' => array(
						'type'          => 'select',
						'label'         => __( 'Responsive Breakpoint', 'fl-builder' ),
						'default'       => 'mobile',
						'options'       => array(
							'always'		=> __( 'Always', 'fl-builder' ),
							'medium-mobile'	=> __( 'Medium &amp; Small Devices Only', 'fl-builder' ),
							'mobile'		=> __( 'Small Devices Only', 'fl-builder' ),
						),
					),
				),
			),
		),
	),
	'style'         => array( // Tab
		'title'         => __( 'Style', 'fl-builder' ), // Tab title
		'sections'      => array( // Tab Sections
			'general_style'    => array(
				'title'         => '',
				'fields'        => array(
					'menu_align' => array(
						'type'          => 'select',
						'label'         => __( 'Menu Alignment', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'		=> __( 'Default', 'fl-builder' ),
							'left'			=> __( 'Left', 'fl-builder' ),
							'center'		=> __( 'Center', 'fl-builder' ),
							'right'			=> __( 'Right', 'fl-builder' ),
						),
					),
					'drop_shadow' => array(
						'type'          => 'select',
						'label'         => __( 'Submenu Drop Shadow', 'fl-builder' ),
						'default'       => 'yes',
						'options'       => array(
							'no'			=> __( 'No', 'fl-builder' ),
							'yes'			=> __( 'Yes', 'fl-builder' ),
						),
					),
				),
			),
			'spacing'    	=> array(
				'title'         => __( 'Spacing', 'fl-builder' ),
				'fields'        => array(
					'horizontal_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Link Horizontal Spacing', 'fl-builder' ),
						'default'       => '14',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'      => array(
							'type'         => 'css',
							'rules'		   => array(
								array(
									'selector'     => '.menu a',
									'property'     => 'padding-left',
									'unit'		   => 'px',
								),
								array(
									'selector'     => '.menu a',
									'property'     => 'padding-right',
									'unit'		   => 'px',
								),
							),
						),
					),
					'vertical_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Link Vertical Spacing', 'fl-builder' ),
						'default'       => '10',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'      => array(
							'type'         => 'css',
							'rules'		   => array(
								array(
									'selector'     => '.menu a',
									'property'     => 'padding-top',
									'unit'		   => 'px',
								),
								array(
									'selector'     => '.menu a',
									'property'     => 'padding-bottom',
									'unit'		   => 'px',
								),
							),
						),
					),
					'submenu_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Submenu Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'      => array(
							'type'         => 'none',
						),
					),
				),
			),
			'text_style'    => array(
				'title'         => __( 'Text', 'fl-builder' ),
				'fields'        => array(
					'link_color'    => array(
						'type'          => 'color',
						'label'         => __( 'Link Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'      => array(
							'type'         => 'css',
							'rules'		   => array(
								array(
									'selector'     => '.fl-menu a, .menu > li > a, .menu > li > .fl-has-submenu-container > a, .sub-menu > li > a',
									'property'     => 'color',
								),
								array(
									'selector'     => '.menu .fl-menu-toggle:before, .menu .fl-menu-toggle:after',
									'property'     => 'border-color',
								),
							),
						),
					),
					'link_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Link Hover Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.fl-menu a, .menu > li.current-menu-item > a, .menu > li.current-menu-item > .fl-has-submenu-container > a, .sub-menu > li.current-menu-item > a',
							'property'     => 'color',
						),
					),
					'font'          => array(
						'type'          => 'font',
						'default'		=> array(
							'family'		=> 'Default',
							'weight'		=> 300,
						),
						'label'         => __( 'Link Font', 'fl-builder' ),
						'preview'         => array(
							'type'            => 'font',
							'selector'        => '.menu',
						),
					),
					'text_size' => array(
						'type'          => 'text',
						'label'         => __( 'Link Size', 'fl-builder' ),
						'default'       => '16',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.menu',
							'property'     => 'font-size',
							'unit'		   => 'px',
						),
					),
					'text_transform' => array(
						'type'          => 'select',
						'label'         => __( 'Link Format', 'fl-builder' ),
						'default'       => 'none',
						'options'       => array(
							'none'			=> __( 'None', 'fl-builder' ),
							'uppercase'		=> __( 'Uppercase', 'fl-builder' ),
							'lowercase'		=> __( 'Lowercase', 'fl-builder' ),
							'capitalize'	=> __( 'Capitalize', 'fl-builder' ),
						),
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.menu',
							'property'     => 'text-transform',
						),
					),
				),
			),
			'menu_style'    => array(
				'title'         => __( 'Backgrounds', 'fl-builder' ),
				'fields'        => array(
					'menu_bg_color'   => array(
						'type'          => 'color',
						'label'         => __( 'Menu Background Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.menu',
							'property'     => 'background-color',
						),
					),
					'mobile_menu_bg'   => array(
						'type'          => 'color',
						'label'         => __( 'Menu Background Color (Mobile)', 'fl-builder' ),
						'show_reset'    => true,
					),
					'menu_bg_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Menu Background Opacity', 'fl-builder' ),
						'default'       => '100',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),
					'submenu_bg_color' => array(
						'type'          => 'color',
						'label'         => __( 'Submenu Background Color', 'fl-builder' ),
						'show_reset'    => true,
						'default'		=> 'ffffff',
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.fl-menu .sub-menu',
							'property'     => 'background-color',
						),
					),
					'submenu_bg_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Submenu Background Opacity', 'fl-builder' ),
						'default'       => '100',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),

					'link_hover_bg_color' => array(
						'type'          => 'color',
						'label'         => __( 'Link Background Hover Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'      => array(
							'type'         => 'css',
							'selector'     => '.menu > li.current-menu-item > a, .menu > li.current-menu-item > .fl-has-submenu-container > a, .sub-menu > li.current-menu-item > a, .sub-menu > li.current-menu-item > .fl-has-submenu-container > a',
							'property'     => 'background-color',
						),
					),
				),
			),
			'separator_style'    => array(
				'title'         => __( 'Separator', 'fl-builder' ),
				'fields'        => array(
					'show_separator' => array(
						'type'          => 'select',
						'label'         => __( 'Show Separators', 'fl-builder' ),
						'default'       => 'no',
						'options'       => array(
							'no'			=> __( 'No', 'fl-builder' ),
							'yes'			=> __( 'Yes', 'fl-builder' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> array( 'separator_color', 'separator_opacity' ),
							),
						),
					),
					'separator_color'   => array(
						'type'          => 'color',
						'label'         => __( 'Separator Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'separator_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Separator Opacity', 'fl-builder' ),
						'default'       => '100',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),
				),
			),
		),
	),
));


class FL_Menu_Module_Walker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$args   = (object) $args;

		$class_names = '';
		$value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$submenu = $args->has_children ? ' fl-has-submenu' : '';

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = ' class="' . esc_attr( $class_names ) . $submenu . '"';

		$item_id = apply_filters( 'fl_builder_menu_item_id', 'menu-item-' . $item->ID, $item, $depth );
		$output .= $indent . '<li id="' . $item_id . '"' . $value . $class_names . '>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		$item_output = $args->has_children ? '<div class="fl-has-submenu-container">' : '';
		$item_output .= $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';

		if ( $args->has_children ) {
			$item_output .= '<span class="fl-menu-toggle"></span>';
		}

		$item_output .= $args->after;
		$item_output .= $args->has_children ? '</div>' : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
