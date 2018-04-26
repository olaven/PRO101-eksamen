.fl-node-<?php echo $id; ?> .fl-separator {
	border-top:<?php echo $settings->height; ?>px <?php echo $settings->style; ?> #<?php echo $settings->color; ?>;
	filter: alpha(opacity = <?php echo $settings->opacity; ?>);
	opacity: <?php echo $settings->opacity / 100; ?>;
	<?php if ( 'custom' == $settings->width ) : ?>
	width: <?php echo $settings->custom_width; ?>%;
	max-width: 100%;
	<?php endif; ?>
	<?php if ( 'center' == $settings->align ) : ?>
	margin: auto;
	<?php endif; ?>
	<?php if ( 'left' == $settings->align ) : ?>
	margin: 0 0 0 0;
	<?php endif; ?>
	<?php if ( 'right' == $settings->align ) : ?>
	margin: 0 0 0 auto;
	<?php endif; ?>
}
