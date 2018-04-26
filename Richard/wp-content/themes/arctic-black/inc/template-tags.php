<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arctic Black
 */

if ( ! function_exists( 'arctic_black_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function arctic_black_posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		// Translators: %s: Post date
		esc_html_x( 'Posted on %s', 'post date', 'arctic-black' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		// Translators: %s: The author
		esc_html_x( 'by %s', 'post author', 'arctic-black' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'arctic_black_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function arctic_black_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'arctic-black' ) );
		if ( $categories_list && arctic_black_categorized_blog() ) {
			// Translators:: %1$s: Categories list
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'arctic-black' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'arctic-black' ) );
		if ( $tags_list ) {
			// Translators:: %1$s: Tags list
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'arctic-black' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'arctic-black' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'arctic-black' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function arctic_black_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'arctic_black_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'arctic_black_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so arctic_black_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so arctic_black_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in arctic_black_categorized_blog.
 */
function arctic_black_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'arctic_black_categories' );
}
add_action( 'edit_category', 'arctic_black_category_transient_flusher' );
add_action( 'save_post',     'arctic_black_category_transient_flusher' );

if ( ! function_exists( 'arctic_black_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function arctic_black_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

if( ! function_exists( 'arctic_black_do_breadcrumb' ) ) :
/**
 * [arctic_black_do_breadcrumb description]
 * @return [type] [description]
 */
function arctic_black_do_breadcrumb(){

	$breadcrumb_markup_open = '<div id="breadcrumb" typeof="BreadcrumbList" vocab="http://schema.org/">';
	$breadcrumb_markup_close = '</div>';

	if ( function_exists( 'bcn_display' ) ) {
		echo $breadcrumb_markup_open;
		bcn_display();
		echo $breadcrumb_markup_close;
	}
	elseif ( function_exists( 'breadcrumbs' ) ) {
		breadcrumbs();
	}
	elseif ( function_exists( 'crumbs' ) ) {
		crumbs();
	}
	elseif ( class_exists( 'WPSEO_Breadcrumbs' ) ) {
		yoast_breadcrumb( $breadcrumb_markup_open, $breadcrumb_markup_close );
	}
	elseif( function_exists( 'yoast_breadcrumb' ) && ! class_exists( 'WPSEO_Breadcrumbs' ) ) {
		yoast_breadcrumb( $breadcrumb_markup_open, $breadcrumb_markup_close );
	}

}
endif;

if ( ! function_exists( 'arctic_black_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 */
function arctic_black_post_thumbnail( $size = 'post-thumbnail') {

	if ( is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<div class="post-thumbnail">';
		the_post_thumbnail( $size );
		echo '</div>';
	} else {
		echo '<div class="post-thumbnail">';
			echo '<a href="'. esc_url( get_permalink( get_the_id() ) ) .'">';
				the_post_thumbnail( $size );
			echo '</a>';
		echo '</div>';
	}

}
endif;

if ( !function_exists( 'arctic_black_posts_navigation' ) ) :
/**
 * [arctic_black_posts_navigation description]
 * @return [type] [description]
 */
function arctic_black_posts_navigation(){

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return;
	}

	if ( get_theme_mod( 'posts_navigation', 'posts_navigation' ) == 'posts_navigation' ) {
		the_posts_navigation( array(
            'prev_text'          => esc_html__( '&larr; Older posts', 'arctic-black' ),
            'next_text'          => esc_html__( 'Newer posts &rarr;', 'arctic-black' ),
		) );
	} else {
		the_posts_pagination( array(
			// Translators: %1$s: Arrow left icon, %2$s: Previous page
			'prev_text'          => sprintf( '%1$s <span class="screen-reader-text">%2$s</span>', arctic_black_get_svg( array( 'icon' => 'chevron-left' ) ), esc_html__( 'Previous Page', 'arctic-black' ) ),
			// Translators: %1$s: Arrow left icon, %2$s: Previous page
			'next_text'          => sprintf( '%1$s <span class="screen-reader-text">%2$s</span>', arctic_black_get_svg( array( 'icon' => 'chevron-right' ) ), esc_html__( 'Next Page', 'arctic-black' ) ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'arctic-black' ) . ' </span>',
		) );
	}

}
endif;

if( ! function_exists( 'arctic_black_get_footer_copyright' ) ) :
/**
 * [arctic_black_get_footer_copyright description]
 * @return [type] [description]
 */
function arctic_black_get_footer_copyright(){
	// Translators: %1$s: Dynamic year, %2$s: Site link, %3$s: WordPress link
	$default_footer_copyright =	sprintf( __( 'Copyright &copy; %1$s %2$s. Proudly powered by %3$s.', 'arctic-black' ),
		date_i18n( __( 'Y', 'arctic-black' ) ),
		'<a href="'. esc_url( home_url('/') ) .'">'. esc_html( get_bloginfo( 'name' ) ) .'</a>',
		'<a href="'. esc_url( __( 'https://wordpress.org/', 'arctic-black' ) ) .'">'. __( 'WordPress', 'arctic-black' ) .'</a>' );

	apply_filters( 'arctic_black_get_footer_copyright', $default_footer_copyright );

	$footer_copyright = get_theme_mod( 'footer_copyright', $default_footer_copyright );

	if ( ! empty( $footer_copyright ) ) {
		$footer_copyright = str_replace( '[YEAR]', date_i18n( __( 'Y', 'arctic-black' ) ), $footer_copyright );
		$footer_copyright = str_replace( '[SITE]', '<a href="'. esc_url( home_url('/') ) .'">'. esc_html( get_bloginfo( 'name' ) ) .'</a>', $footer_copyright );
		return wp_kses_post( $footer_copyright );
	} else {
		return $default_footer_copyright;
	}

}
endif;

if( ! function_exists( 'arctic_black_do_footer_copyright' ) ) :
/**
 * [arctic_black_do_footer_copyright description]
 * @return [type] [description]
 */
function arctic_black_do_footer_copyright(){

	echo '<div class="site-info">'. wp_kses_post( arctic_black_get_footer_copyright() ) . '</div>';
	if ( get_theme_mod( 'theme_designer', true ) ) {
		// Translators: %1$s: Theme designer logo, %2$s: Theme designer site link
		echo '<div class="site-designer">'. sprintf( esc_html__( 'Theme design by %1$s %2$s.', 'arctic-black' ), arctic_black_get_svg( array( 'icon' => 'campaignkit' ) ), '<a href="'. esc_url( 'https://campaignkit.co/' ) .'">Campaign Kit</a>' ) .'</div>';
	}

}
endif;
