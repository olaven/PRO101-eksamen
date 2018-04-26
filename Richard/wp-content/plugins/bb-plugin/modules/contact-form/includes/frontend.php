<form class="fl-contact-form" <?php if ( isset( $module->template_id ) ) { echo 'data-template-id="' . $module->template_id . '" data-template-node-id="' . $module->template_node_id . '"';} ?>>

	<?php if ( 'show' == $settings->name_toggle ) : ?>
	<div class="fl-input-group fl-name">
		<label for="fl-name"><?php _ex( 'Name', 'Contact form field label.', 'fl-builder' );?></label>
		<span class="fl-contact-error"><?php _e( 'Please enter your name.', 'fl-builder' );?></span>
		<input type="text" id="fl-name" name="fl-name" value="" placeholder="<?php echo esc_attr( $settings->name_placeholder ); ?>" />
	</div>
	<?php endif; ?>

	<?php if ( 'show' == $settings->subject_toggle ) : ?>
	<div class="fl-input-group fl-subject">
		<label for="fl-subject"><?php _e( 'Subject', 'fl-builder' );?></label>
		<span class="fl-contact-error"><?php _e( 'Please enter a subject.', 'fl-builder' );?></span>
		<input type="text" id="fl-subject" name="fl-subject" value="" placeholder="<?php echo esc_attr( $settings->subject_placeholder ); ?>" />
	</div>
	<?php endif; ?>

	<?php if ( 'show' == $settings->email_toggle ) : ?>
	<div class="fl-input-group fl-email">
		<label for="fl-email"><?php _e( 'Email', 'fl-builder' );?></label>
		<span class="fl-contact-error"><?php _e( 'Please enter a valid email.', 'fl-builder' );?></span>
		<input type="email" id="fl-email" name="fl-email" value="" placeholder="<?php echo esc_attr( $settings->email_placeholder ); ?>" />
	</div>
	<?php endif; ?>

	<?php if ( 'show' == $settings->phone_toggle ) : ?>
	<div class="fl-input-group fl-phone">
		<label for="fl-phone"><?php _e( 'Phone', 'fl-builder' );?></label>
		<span class="fl-contact-error"><?php _e( 'Please enter a valid phone number.', 'fl-builder' );?></span>
		<input type="tel" id="fl-phone" name="fl-phone" value="" placeholder="<?php echo esc_attr( $settings->phone_placeholder ); ?>" />
	</div>
	<?php endif; ?>

	<div class="fl-input-group fl-message">
		<label for="fl-message"><?php _e( 'Your Message', 'fl-builder' );?></label>
		<span class="fl-contact-error"><?php _e( 'Please enter a message.', 'fl-builder' );?></span>
		<textarea id="fl-message" name="fl-message" placeholder="<?php echo esc_attr( $settings->message_placeholder ); ?>"></textarea>
	</div>

	<?php
	if ( 'show' == $settings->recaptcha_toggle && (isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )) ) :
	?>
	<div class="fl-input-group fl-recaptcha">
		<span class="fl-contact-error"><?php _e( 'Please check the captcha to verify you are not a robot.', 'fl-builder' );?></span>
		<div id="<?php echo $id; ?>-fl-grecaptcha" class="fl-grecaptcha" data-sitekey="<?php echo $settings->recaptcha_site_key; ?>"<?php if ( isset( $settings->recaptcha_validate_type ) ) { echo ' data-validate="' . $settings->recaptcha_validate_type . '"';} ?><?php if ( isset( $settings->recaptcha_theme ) ) { echo ' data-theme="' . $settings->recaptcha_theme . '"';} ?>></div>
	   </div>
	<?php endif; ?>

	<?php

	FLBuilder::render_module_html( 'button', array(
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
	<?php if ( 'redirect' == $settings->success_action ) : ?>
		<input type="text" value="<?php echo $settings->success_url; ?>" style="display: none;" class="fl-success-url">
	<?php elseif ( 'none' == $settings->success_action ) : ?>
		<span class="fl-success-none" style="display:none;"><?php _e( 'Message Sent!', 'fl-builder' ); ?></span>
	<?php endif; ?>

	<span class="fl-send-error" style="display:none;"><?php _e( 'Message failed. Please try again.', 'fl-builder' ); ?></span>
</form>
<?php if ( 'show_message' == $settings->success_action ) : ?>
  <span class="fl-success-msg" style="display:none;"><?php echo $settings->success_message; ?></span>
<?php endif; ?>
