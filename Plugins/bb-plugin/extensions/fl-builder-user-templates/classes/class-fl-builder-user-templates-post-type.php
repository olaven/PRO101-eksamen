<?php

/**
 * Logic for the user templates post type.
 *
 * @since 1.10
 */
final class FLBuilderUserTemplatesPostType {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.10
	 * @return void
	 */
	static public function init() {
		/* Actions */
		add_action( 'init', __CLASS__ . '::register' );
		add_action( 'init', __CLASS__ . '::register_taxonomies' );
	}

	/**
	 * Registers the custom post type for user templates.
	 *
	 * @since 1.10
	 * @return void
	 */
	static public function register() {
		$admin_access 	 = FLBuilderUserAccess::current_user_can( 'builder_admin' );
		$can_edit 		 = FLBuilderUserAccess::current_user_can( 'unrestricted_editing' );
		$can_edit_global = FLBuilderUserAccess::current_user_can( 'global_node_editing' );

		$args = apply_filters( 'fl_builder_register_template_post_type_args', array(
			'public'            => $admin_access && $can_edit ? true : false,
			'labels'            => array(
				'name'               => _x( 'Templates', 'Custom post type label.', 'fl-builder' ),
				'singular_name'      => _x( 'Template', 'Custom post type label.', 'fl-builder' ),
				'menu_name'          => _x( 'Builder', 'Custom post type label.', 'fl-builder' ),
				'name_admin_bar'     => _x( 'Template', 'Custom post type label.', 'fl-builder' ),
				'add_new'            => _x( 'Add New', 'Custom post type label.', 'fl-builder' ),
				'add_new_item'       => _x( 'Add New', 'Custom post type label.', 'fl-builder' ),
				'new_item'           => _x( 'New', 'Custom post type label.', 'fl-builder' ),
				'edit_item'          => _x( 'Edit', 'Custom post type label.', 'fl-builder' ),
				'view_item'          => _x( 'View', 'Custom post type label.', 'fl-builder' ),
				'all_items'          => _x( 'All', 'Custom post type label.', 'fl-builder' ),
				'search_items'       => _x( 'Search', 'Custom post type label.', 'fl-builder' ),
				'parent_item_colon'  => _x( 'Parent:', 'Custom post type label.', 'fl-builder' ),
				'not_found'          => _x( 'Nothing found.', 'Custom post type label.', 'fl-builder' ),
				'not_found_in_trash' => _x( 'Nothing found in Trash.', 'Custom post type label.', 'fl-builder' ),
			),
			'supports'          => array(
				'title',
				'revisions',
				'page-attributes',
			),
			'taxonomies'		=> array(
				'fl-builder-template-category'
			),
			'menu_icon'			=> 'dashicons-welcome-widgets-menus',
			'menu_position'		=> 64,
			'publicly_queryable' 	=> $can_edit || $can_edit_global,
			'exclude_from_search'	=> true,
			'show_in_rest'			=> true,
		) );

		register_post_type( 'fl-builder-template', $args );
	}

	/**
	 * Registers the taxonomies for user templates.
	 *
	 * @since 1.10
	 * @return void
	 */
	static public function register_taxonomies() {
		// Register the template category tax.
		$args = apply_filters( 'fl_builder_register_template_category_args', array(
			'labels'            => array(
				'name'              => _x( 'Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'singular_name'     => _x( 'Category', 'Custom taxonomy label.', 'fl-builder' ),
				'search_items'      => _x( 'Search Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'all_items'         => _x( 'All Categories', 'Custom taxonomy label.', 'fl-builder' ),
				'parent_item'       => _x( 'Parent Category', 'Custom taxonomy label.', 'fl-builder' ),
				'parent_item_colon' => _x( 'Parent Category:', 'Custom taxonomy label.', 'fl-builder' ),
				'edit_item'         => _x( 'Edit Category', 'Custom taxonomy label.', 'fl-builder' ),
				'update_item'       => _x( 'Update Category', 'Custom taxonomy label.', 'fl-builder' ),
				'add_new_item'      => _x( 'Add New Category', 'Custom taxonomy label.', 'fl-builder' ),
				'new_item_name'     => _x( 'New Category Name', 'Custom taxonomy label.', 'fl-builder' ),
				'menu_name'         => _x( 'Categories', 'Custom taxonomy label.', 'fl-builder' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
		) );

		register_taxonomy( 'fl-builder-template-category', array( 'fl-builder-template', 'fl-theme-layout' ), $args );

		// Register the template type tax.
		$args = apply_filters( 'fl_builder_register_template_type_args', array(
			'label'             => _x( 'Type', 'Custom taxonomy label.', 'fl-builder' ),
			'hierarchical'      => false,
			'public'            => false,
			'show_admin_column' => false,
		) );

		register_taxonomy( 'fl-builder-template-type', array( 'fl-builder-template' ), $args );
	}
}

FLBuilderUserTemplatesPostType::init();
