<?php
/**
 * Helper functions that act independently of the theme templates.
 *
 * @package Arctic Black
 */

if ( ! function_exists( 'arctic_black_get_terms' ) ) :
/**
 * Helper function display list of product categories in an array.
 *
 * @return array
 */
function arctic_black_get_terms( $term_name ){

	if ( ! taxonomy_exists( $term_name ) )
		return array();

	$term_item = array();

	$terms = get_terms( array(
		'taxonomy'		=> $term_name,
		'hide_empty' 	=> true
	) );

	foreach ( $terms as $term ) :
		$term_item[$term->term_id] = $term->name;
	endforeach;

	return $term_item;

}
endif;

/**
 * Retun an array of featured post ID
 * @return string
 */
function arctic_black_featured_post_id(){

	$featured_id = array();

 	$features = get_posts( array(
		'category'     		=> absint( get_theme_mod( 'slider_cat', 1 ) ),
		'posts_per_page' 	=> absint( get_theme_mod( 'slides_num', 5 ) ),
		'orderby'        	=> get_theme_mod( 'slider_orderby', 'date' ),
		'order'          	=> get_theme_mod( 'slider_order', 'DESC' ),
		'post__not_in' 		=> get_option( 'sticky_posts' ),
 	) );

 	foreach ( $features as $feature ) {
 		$featured_id[] = $feature->ID;
 	}

 	return $featured_id;

}

/**
 * [arctic_black_do_slider_content description]
 * @return [type] [description]
 */
function arctic_black_do_slider_content(){
	get_template_part( 'template-parts/content', 'slider' );
}

/**
 * [arctic_black_is_sticky description]
 * @return bool
 */
function arctic_black_is_sticky(){
	return (bool) is_sticky() && !is_paged() && !is_singular() && !is_archive();
}
