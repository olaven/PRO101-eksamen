<div class="fl-subscribe-form fl-subscribe-form-<?php echo $settings->layout; ?> fl-subscribe-form-name-<?php echo $settings->show_name; ?> fl-form fl-clearfix" <?php if ( isset( $module->template_id ) ) { echo 'data-template-id="' . $module->template_id . '" data-template-node-id="' . $module->template_node_id . '"';} ?>>

	<?php if ( 'show' == $settings->show_name ) : ?>
	<div class="fl-form-field">
		<input type="text" name="fl-subscribe-form-name" placeholder="<?php _ex( 'Name', 'First and last name.', 'fl-builder' ); ?>" aria-label="name" />
		<div class="fl-form-error-message"><?php _e( 'Please enter your name.', 'fl-builder' ); ?></div>
	</div>
	<?php endif; ?>

	<div class="fl-form-field">
		<input type="email" name="fl-subscribe-form-email" placeholder="<?php _e( 'Email Address', 'fl-builder' ); ?>" aria-label="email address" />
		<div class="fl-form-error-message"><?php _e( 'Please enter a valid email address.', 'fl-builder' ); ?></div>
	</div>

	<?php if ( 'stacked' == $settings->layout && 'show' == $settings->show_recaptcha && (isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )) ) : ?>
	<div class="fl-form-field fl-form-recaptcha">
		<div class="fl-form-error-message"><?php _e( 'Please check the captcha to verify you are not a robot.', 'fl-builder' ); ?></div>
		<div id="<?php echo $id; ?>-fl-grecaptcha" class="fl-grecaptcha" data-sitekey="<?php echo $settings->recaptcha_site_key; ?>"<?php if ( isset( $settings->recaptcha_validate_type ) ) { echo ' data-validate="' . $settings->recaptcha_validate_type . '"';} ?><?php if ( isset( $settings->recaptcha_theme ) ) { echo ' data-theme="' . $settings->recaptcha_theme . '"';} ?>></div>
	</div>
	<?php endif; ?>

	<div class="fl-form-button" data-wait-text="<?php esc_attr_e( 'Please Wait...', 'fl-builder' ); ?>">
	<?php

	FLBuilder::render_module_html( 'button', array(
		'align'             => '',
		'bg_color'          => $settings->btn_bg_color,
		'bg_hover_color'    => $settings->btn_bg_hover_color,
		'bg_opacity'        => $settings->btn_bg_opacity,
		'border_radius'     => $settings->btn_border_radius,
		'border_size'       => $settings->btn_border_size,
		'font_size'         => $settings->btn_font_size,
		'icon'              => $settings->btn_icon,
		'icon_position'     => $settings->btn_icon_position,
		'icon_animation'    => $settings->btn_icon_animation,
		'link'              => '#',
		'link_target'       => '_self',
		'padding'           => $settings->btn_padding,
		'style'             => $settings->btn_style,
		'text'              => $settings->btn_text,
		'text_color'        => $settings->btn_text_color,
		'text_hover_color'  => $settings->btn_text_hover_color,
		'width'             => 'full',
	));

	?>
	</div>

	<?php if ( 'inline' == $settings->layout && 'show' == $settings->show_recaptcha && (isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )) ) : ?>
	<div class="fl-form-field fl-form-recaptcha">
		<div class="fl-form-error-message"><?php _e( 'Please check the captcha to verify you are not a robot.', 'fl-builder' ); ?></div>
		<div id="<?php echo $id; ?>-fl-grecaptcha" class="fl-grecaptcha" data-sitekey="<?php echo $settings->recaptcha_site_key; ?>"<?php if ( isset( $settings->recaptcha_validate_type ) ) { echo ' data-validate="' . $settings->recaptcha_validate_type . '"';} ?><?php if ( isset( $settings->recaptcha_theme ) ) { echo ' data-theme="' . $settings->recaptcha_theme . '"';} ?>></div>
	</div>
	<?php endif; ?>

	<div class="fl-form-error-message"><?php _e( 'Something went wrong. Please check your entries and try again.', 'fl-builder' ); ?></div>

</div>
