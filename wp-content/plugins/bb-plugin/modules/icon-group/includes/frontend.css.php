<?php

FLBuilder::render_module_css('icon', $id, array(
	'align'          => '',
	'bg_color'       => $settings->bg_color,
	'bg_hover_color' => $settings->bg_hover_color,
	'color'          => $settings->color,
	'hover_color'    => $settings->hover_color,
	'icon'           => '',
	'link'           => '',
	'link_target'    => '',
	'size'           => $settings->size,
	'text'           => '',
	'three_d'        => $settings->three_d,
));

?>
<?php foreach ( $settings->icons as $i => $icon ) : ?>	
	<?php if ( isset( $icon->color ) || isset( $icon->bg_color ) ) : ?>
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) i,
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) i:before {
			<?php if ( isset( $icon->color ) ) : ?>
			color: #<?php echo $icon->color; ?>;
			<?php endif; ?>
			<?php if ( isset( $icon->bg_color ) ) : ?>
			background: #<?php echo $icon->bg_color; ?>;
			<?php endif; ?>
		}
	<?php endif; ?>
	<?php if ( isset( $icon->hover_color ) || isset( $icon->bg_hover_color ) ) : ?>
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) i:hover,
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) i:hover:before,
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) a:hover i,
		.fl-node-<?php echo $id; ?> .fl-module-content .fl-icon:nth-child(<?php echo $i + 1; ?>) a:hover i:before {
			<?php if ( isset( $icon->hover_color ) ) : ?>
			color: #<?php echo $icon->hover_color; ?>;
			<?php endif; ?>
			<?php if ( isset( $icon->bg_hover_color ) ) : ?>
			background: #<?php echo $icon->bg_hover_color; ?>;
			<?php endif; ?>
		}
	<?php endif; ?>
<?php endforeach; ?>

/* Left */
.fl-node-<?php echo $id; ?> .fl-icon-group-left .fl-icon {
	margin-right: <?php echo $settings->spacing; ?>px;
}

/* Center */
.fl-node-<?php echo $id; ?> .fl-icon-group-center .fl-icon {
	margin-left: <?php echo $settings->spacing; ?>px;
	margin-right: <?php echo $settings->spacing; ?>px;
}

/* Right */
.fl-node-<?php echo $id; ?> .fl-icon-group-right .fl-icon {
	margin-left: <?php echo $settings->spacing; ?>px;
}
