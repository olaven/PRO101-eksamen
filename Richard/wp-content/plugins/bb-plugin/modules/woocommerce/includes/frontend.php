<?php

// Opening Wrapper
echo '<div class="fl-woocommerce-' . $settings->layout . '">';

// Shortcodes
$pages = array(
	'cart'          => '[woocommerce_cart]',
	'checkout'      => '[woocommerce_checkout]',
	'tracking'      => '[woocommerce_order_tracking]',
	'account'       => '[woocommerce_my_account]',
);

// WooCommerce Pages
if ( isset( $pages[ $settings->layout ] ) ) {
	echo $pages[ $settings->layout ];
} // End if().
elseif ( 'product' == $settings->layout ) {
	add_filter( 'post_class', array( $module, 'single_product_post_class' ) );
	echo '[product id="' . $settings->product_id . '"]';
	remove_filter( 'post_class', array( $module, 'single_product_post_class' ) );
} // Single Product Page
elseif ( 'product_page' == $settings->layout ) {
	add_filter( 'post_class', array( $module, 'single_product_post_class' ) );
	echo '[product_page id="' . $settings->product_id . '"]';
	remove_filter( 'post_class', array( $module, 'single_product_post_class' ) );
} // Add to Cart Button
elseif ( 'add-cart' == $settings->layout ) {
	echo '[add_to_cart id="' . $settings->product_id . '" style=""]';
} // Categories
elseif ( 'categories' == $settings->layout ) {
	echo '[product_categories parent="' . $settings->parent_cat_id . '" columns="' . $settings->cat_columns . '"]';
} // Multiple Products
elseif ( 'products' == $settings->layout ) {
	add_filter( 'post_class', array( $module, 'products_post_class' ) );

	// Product IDs
	if ( 'ids' == $settings->products_source ) {
		echo '[products ids="' . $settings->product_ids . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	} // End if().
	elseif ( 'category' == $settings->products_source ) {
		echo '[product_category category="' . $settings->category_slug . '" per_page="' . $settings->num_products . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	} // Recent Products
	elseif ( 'recent' == $settings->products_source ) {
		echo '[recent_products per_page="' . $settings->num_products . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	} // Featured Products
	elseif ( 'featured' == $settings->products_source ) {
		echo '[featured_products per_page="' . $settings->num_products . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	} // Sale Products
	elseif ( 'sale' == $settings->products_source ) {
		echo '[sale_products per_page="' . $settings->num_products . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	} // Best Selling Products
	elseif ( 'best-selling' == $settings->products_source ) {
		echo '[best_selling_products per_page="' . $settings->num_products . '" columns="' . $settings->columns . '"]';
	} // Top Rated Products
	elseif ( 'top-rated' == $settings->products_source ) {
		echo '[top_rated_products per_page="' . $settings->num_products . '" columns="' . $settings->columns . '" orderby="' . $settings->orderby . '" order="' . $settings->order . '"]';
	}

	remove_filter( 'post_class', array( $module, 'products_post_class' ) );
}

// Closing Wrapper
echo '</div>';
