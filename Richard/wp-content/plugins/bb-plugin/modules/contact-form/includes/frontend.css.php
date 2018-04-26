<?php

FLBuilder::render_module_css('button', $id, array(
	'bg_color'          => $settings->btn_bg_color,
	'bg_hover_color'    => $settings->btn_bg_hover_color,
	'bg_opacity'        => $settings->btn_bg_opacity,
	'bg_hover_opacity'  => $settings->btn_bg_hover_opacity,
	'button_transition' => $settings->btn_button_transition,
	'border_radius'     => $settings->btn_border_radius,
	'border_size'       => $settings->btn_border_size,
	'font_size'         => $settings->btn_font_size,
	'icon'              => $settings->btn_icon,
	'icon_position'     => $settings->btn_icon_position,
	'link'              => '#',
	'link_target'       => '_self',
	'padding'           => $settings->btn_padding,
	'style'             => $settings->btn_style,
	'text'              => $settings->btn_text,
	'text_color'        => $settings->btn_text_color,
	'text_hover_color'  => $settings->btn_text_hover_color,
	'width'             => $settings->btn_width,
	'align'				=> $settings->btn_align,
	'icon_animation'	=> $settings->btn_icon_animation,
));
?>

<?php if ( 'right' == $settings->btn_align ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-send-error,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success-none,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success-msg {
	float: right;
}
<?php endif; ?>

<?php if ( 'center' == $settings->btn_align ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-send-error,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success-none,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-contact-form .fl-success-msg {
	display: block;
	text-align: center;
}
<?php endif; ?>
