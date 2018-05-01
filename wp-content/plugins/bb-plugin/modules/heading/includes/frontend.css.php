.fl-node-<?php echo $id; ?>.fl-module-heading .fl-heading {
	text-align: <?php echo $settings->alignment; ?>;
	<?php if ( 'custom' == $settings->font_size ) : ?>
	font-size: <?php echo $settings->custom_font_size; ?>px;
	<?php endif; ?>
	<?php if ( 'custom' == $settings->line_height ) : ?>
	line-height: <?php echo $settings->custom_line_height; ?>;
	<?php endif; ?>
	<?php if ( 'custom' == $settings->letter_spacing ) : ?>
	letter-spacing: <?php echo $settings->custom_letter_spacing; ?>px;
	<?php endif; ?>
}
<?php if ( ! empty( $settings->color ) ) : ?>
.fl-node-<?php echo $id; ?> <?php echo $settings->tag; ?>.fl-heading a,
.fl-node-<?php echo $id; ?> <?php echo $settings->tag; ?>.fl-heading .fl-heading-text,
.fl-node-<?php echo $id; ?> <?php echo $settings->tag; ?>.fl-heading .fl-heading-text *,
.fl-row .fl-col .fl-node-<?php echo $id; ?> <?php echo $settings->tag; ?>.fl-heading .fl-heading-text {
	color: #<?php echo $settings->color; ?>;
}
<?php endif; ?>
<?php if ( ! empty( $settings->font ) && 'Default' != $settings->font['family'] ) : ?>
.fl-node-<?php echo $id; ?> .fl-heading .fl-heading-text{
	<?php FLBuilderFonts::font_css( $settings->font ); ?>
}
<?php endif; ?>
<?php if ( $global_settings->responsive_enabled && ( 'custom' == $settings->r_font_size || 'custom' == $settings->r_alignment || 'custom' == $settings->r_line_height || 'custom' == $settings->r_letter_spacing ) ) : ?>
@media (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {

	<?php if ( 'custom' == $settings->r_font_size ) : ?>
	.fl-node-<?php echo $id; ?>.fl-module-heading .fl-heading {
		font-size: <?php echo $settings->r_custom_font_size; ?>px;
	}
	<?php endif; ?>

	<?php if ( 'custom' == $settings->r_alignment ) : ?>
	.fl-node-<?php echo $id; ?>.fl-module-heading .fl-heading {
		text-align: <?php echo $settings->r_custom_alignment; ?>;
	}
	<?php endif; ?>

	<?php if ( 'custom' == $settings->r_line_height ) : ?>
	.fl-node-<?php echo $id; ?>.fl-module-heading .fl-heading {
		line-height: <?php echo $settings->r_custom_line_height; ?>;
	}
	<?php endif; ?>

	<?php if ( 'custom' == $settings->r_letter_spacing ) : ?>
	.fl-node-<?php echo $id; ?>.fl-module-heading .fl-heading {
		letter-spacing: <?php echo $settings->r_custom_letter_spacing; ?>px;
	}
	<?php endif; ?>
}
<?php endif; ?>
