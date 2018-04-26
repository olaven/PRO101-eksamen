/*Features Min Height*/
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-features  {
	min-height: <?php echo $settings->min_height; ?>px;
}

<?php
// Loop through and style each pricing box
for ( $i = 0; $i < count( $settings->pricing_columns ); $i++ ) :

	if ( ! is_object( $settings->pricing_columns[ $i ] ) ) { continue;
	}

	// Pricing Box Settings
	$pricing_column = $settings->pricing_columns[ $i ];

?>

/*Pricing Box Style*/
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> {
	border: 1px solid #<?php echo FLBuilderColor::adjust_brightness( $pricing_column->background, 30, 'darken' ); ?>;
	background: #<?php echo $pricing_column->background; ?>;
	margin-top: <?php echo $pricing_column->margin; ?>px;
}
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-inner-wrap {
	background: #<?php echo $pricing_column->foreground; ?>;
	border: 1px solid #<?php echo FLBuilderColor::adjust_brightness( $pricing_column->background, 30, 'darken' ); ?>;
}
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> h2 {
	font-size: <?php echo $pricing_column->title_size; ?>px;
}
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-price {
	font-size: <?php echo $pricing_column->price_size; ?>px;
}

/*Pricing Box Highlight*/
<?php if ( 'price' == $settings->highlight ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-price {
	background: #<?php echo $pricing_column->column_background; ?>;
	color: #<?php echo $pricing_column->column_color; ?>;
}
<?php elseif ( 'title' == $settings->highlight ) : ?>

.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-title {
	background: #<?php echo $pricing_column->column_background; ?>;
	color: #<?php echo $pricing_column->column_color; ?>;
}
<?php endif; ?>

/*Fix when price is NOT highlighted*/
<?php if ( 'title' == $settings->highlight || 'none' == $settings->highlight ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-price {
	margin-bottom: 0;
	padding-bottom: 0;
}
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-features {
	margin-top: 10px;
}
<?php endif; ?>

/*Fix when NOTHING is highlighted*/
<?php if ( 'none' == $settings->highlight ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-title {
	padding-bottom: 0;
}
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> .fl-pricing-table-price {
	padding-top: 0;
}
<?php endif; ?>

/*Button CSS*/
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-pricing-table-column-<?php echo $i; ?> a.fl-button {

	<?php if ( empty( $pricing_column->btn_bg_color ) ) : ?>
		background-color: #<?php echo $pricing_column->column_background; ?> !important;
		border: 1px solid #<?php echo $pricing_column->column_background; ?> !important;
	<?php endif; ?>

	<?php if ( empty( $pricing_column->btn_width ) ) : ?>
		 display:block;
		 margin: 0 30px 5px;
	<?php endif; ?>
}

<?php
FLBuilder::render_module_css('button', $id . ' .fl-pricing-table-column-' . $i , array(
	'align'             => 'center',
	'bg_color'          => $pricing_column->btn_bg_color,
	'bg_hover_color'    => $pricing_column->btn_bg_hover_color,
	'bg_opacity'        => $pricing_column->btn_bg_opacity,
	'bg_hover_opacity'  => $pricing_column->btn_bg_hover_opacity,
	'button_transition' => $pricing_column->btn_button_transition,
	'border_radius'     => $pricing_column->btn_border_radius,
	'border_size'       => $pricing_column->btn_border_size,
	'font_size'         => $pricing_column->btn_font_size,
	'icon'              => $pricing_column->btn_icon,
	'icon_position'     => $pricing_column->btn_icon_position,
	'link'              => $pricing_column->button_url,
	'link_target'       => '_self',
	'padding'           => $pricing_column->btn_padding,
	'style'             => $pricing_column->btn_style,
	'text_color'        => $pricing_column->btn_text_color,
	'text_hover_color'  => $pricing_column->btn_text_hover_color,
	'width'             => $pricing_column->btn_width,
));
?>

<?php endfor; ?>
