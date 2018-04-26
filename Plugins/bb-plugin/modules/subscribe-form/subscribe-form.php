<?php

/**
 * A module that adds a simple subscribe form to your layout
 * with third party optin integration.
 *
 * @since 1.5.2
 */
class FLSubscribeFormModule extends FLBuilderModule {

	/**
	 * @since 1.5.2
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'          	=> __( 'Subscribe Form', 'fl-builder' ),
			'description'   	=> __( 'Adds a simple subscribe form to your layout.', 'fl-builder' ),
			'category'      	=> __( 'Actions', 'fl-builder' ),
			'editor_export' 	=> false,
			'partial_refresh'	=> true,
			'icon'				=> 'editor-table.svg',
		));

		add_action( 'wp_ajax_fl_builder_subscribe_form_submit', array( $this, 'submit' ) );
		add_action( 'wp_ajax_nopriv_fl_builder_subscribe_form_submit', array( $this, 'submit' ) );
		add_filter( 'script_loader_tag', array( $this, 'add_async_attribute' ), 10, 2 );
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts() {
		$settings = $this->settings;
		if ( isset( $settings->show_recaptcha ) && 'show' == $settings->show_recaptcha
			&& isset( $settings->recaptcha_site_key ) && ! empty( $settings->recaptcha_site_key )
			) {

			$site_lang = substr( get_locale(), 0, 2 );
			$this->add_js(
				'g-recaptcha',
				'https://www.google.com/recaptcha/api.js?onload=onLoadFLReCaptcha&render=explicit&hl=' . $site_lang,
				array(),
				'2.0',
				true
			);
		}
	}

	/**
	 * @method  add_async_attribute for the enqueued `g-recaptcha` script
	 * @param string $tag    Script tag
	 * @param string $handle Registered script handle
	 */
	public function add_async_attribute( $tag, $handle ) {
		if ( ('g-recaptcha' !== $handle) || ('g-recaptcha' === $handle && strpos( $tag, 'g-recaptcha-api' ) !== false ) ) {
			return $tag;
		}

		return str_replace( ' src', ' id="g-recaptcha-api" async="async" defer="defer" src', $tag );
	}

	/**
	 * Called via AJAX to submit the subscribe form.
	 *
	 * @since 1.5.2
	 * @return string The JSON encoded response.
	 */
	public function submit() {
		$name       		= isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : false;
		$email      		= isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : false;
		$recaptcha     		= isset( $_POST['recaptcha'] ) ? $_POST['recaptcha'] : false;
		$post_id     		= isset( $_POST['post_id'] ) ? $_POST['post_id'] : false;
		$node_id    		= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
		$template_id    	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
		$template_node_id   = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
		$result    			= array(
			'action'    		=> false,
			'error'     		=> false,
			'message'   		=> false,
			'url'       		=> false,
		);

		if ( $email && $node_id ) {

			// Get the module settings.
			if ( $template_id ) {
				$post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
				$data	  = FLBuilderModel::get_layout_data( 'published', $post_id );
				$settings = $data[ $template_node_id ]->settings;
			} else {
				$module   = FLBuilderModel::get_module( $node_id );
				$settings = $module->settings;
			}

			// Validate reCAPTCHA first if enabled
			if ( $recaptcha ) {

				if ( ! empty( $settings->recaptcha_secret_key ) && ! empty( $settings->recaptcha_site_key ) ) {
					if ( version_compare( phpversion(), '5.3', '>=' ) ) {
						include FLBuilderModel::$modules['subscribe-form']->dir . 'includes/validate-recaptcha.php';
					} else {
						$result['error'] = false;
					}
				} else {
					$result['error'] = __( 'Your reCAPTCHA Site or Secret Key is missing!', 'fl-builder' );
				}
			}

			if ( ! $result['error'] ) {

				// Subscribe.
				$instance = FLBuilderServices::get_service_instance( $settings->service );
				$response = $instance->subscribe( $settings, $email, $name );

				// Check for an error from the service.
				if ( $response['error'] ) {
					$result['error'] = $response['error'];
				} // End if().
				else {

					$result['action'] = $settings->success_action;

					if ( 'message' == $settings->success_action ) {
						$result['message']  = $settings->success_message;
					} else {
						$result['url']  = $settings->success_url;
					}
				}

				do_action( 'fl_builder_subscribe_form_submission_complete', $response, $settings, $email, $name, $template_id, $post_id );
			}
		} else {
			$result['error'] = __( 'There was an error subscribing. Please try again.', 'fl-builder' );
		}// End if().

		echo json_encode( $result );

		die();
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'FLSubscribeFormModule', array(
	'general'       => array(
		'title'         => __( 'General', 'fl-builder' ),
		'sections'      => array(
			'service'       => array(
				'title'         => '',
				'services'      => 'autoresponder',
				'template'		=> array(
					'id'			=> 'fl-builder-service-settings',
					'file'          => FL_BUILDER_DIR . 'includes/ui-service-settings.php',
				),
			),
			'structure'        => array(
				'title'         => __( 'Structure', 'fl-builder' ),
				'fields'        => array(
					'layout'        => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'fl-builder' ),
						'default'       => 'stacked',
						'options'       => array(
							'stacked'       => __( 'Stacked', 'fl-builder' ),
							'inline'        => __( 'Inline', 'fl-builder' ),
						),
					),
					'show_name'     => array(
						'type'          => 'select',
						'label'         => __( 'Name Field', 'fl-builder' ),
						'default'       => 'show',
						'options'       => array(
							'show'          => __( 'Show', 'fl-builder' ),
							'hide'          => __( 'Hide', 'fl-builder' ),
						),
					),
				),
			),
			'success'       => array(
				'title'         => __( 'Success', 'fl-builder' ),
				'fields'        => array(
					'custom_subject' => array(
						'type'        => 'text',
						'label'       => __( 'Notification Subject', 'fl-builder' ),
						'placeholder' => __( 'Subscribe Form Signup', 'fl-builder' ),
					),
					'success_action' => array(
						'type'          => 'select',
						'label'         => __( 'Success Action', 'fl-builder' ),
						'options'       => array(
							'message'       => __( 'Show Message', 'fl-builder' ),
							'redirect'      => __( 'Redirect', 'fl-builder' ),
						),
						'toggle'        => array(
							'message'       => array(
								'fields'        => array( 'success_message' ),
							),
							'redirect'      => array(
								'fields'        => array( 'success_url' ),
							),
						),
						'preview'       => array(
							'type'             => 'none',
						),
					),
					'success_message' => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => __( 'Thanks for subscribing! Please check your email for further instructions.', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none',
						),
						'connections'   => array( 'string' ),
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none',
						),
						'connections'   => array( 'url' ),
					),
				),
			),
		),
	),
	'button'        => array(
		'title'         => __( 'Button', 'fl-builder' ),
		'sections'      => array(
			'btn_general'   => array(
				'title'         => '',
				'fields'        => array(
					'btn_text'      => array(
						'type'          => 'text',
						'label'         => __( 'Button Text', 'fl-builder' ),
						'default'       => __( 'Subscribe!', 'fl-builder' ),
					),
					'btn_icon'      => array(
						'type'          => 'icon',
						'label'         => __( 'Button Icon', 'fl-builder' ),
						'show_remove'   => true,
					),
					'btn_icon_position' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Position', 'fl-builder' ),
						'default'       => 'before',
						'options'       => array(
							'before'        => __( 'Before Text', 'fl-builder' ),
							'after'         => __( 'After Text', 'fl-builder' ),
						),
					),
					'btn_icon_animation' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Visibility', 'fl-builder' ),
						'default'       => 'disable',
						'options'       => array(
							'disable'        => __( 'Always Visible', 'fl-builder' ),
							'enable'         => __( 'Fade In On Hover', 'fl-builder' ),
						),
					),
				),
			),
			'btn_colors'     => array(
				'title'         => __( 'Button Colors', 'fl-builder' ),
				'fields'        => array(
					'btn_bg_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'btn_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'btn_text_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'btn_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Hover Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
				),
			),
			'btn_style'     => array(
				'title'         => __( 'Button Style', 'fl-builder' ),
				'fields'        => array(
					'btn_style'     => array(
						'type'          => 'select',
						'label'         => __( 'Style', 'fl-builder' ),
						'default'       => 'flat',
						'options'       => array(
							'flat'          => __( 'Flat', 'fl-builder' ),
							'gradient'      => __( 'Gradient', 'fl-builder' ),
							'transparent'   => __( 'Transparent', 'fl-builder' ),
						),
						'toggle'        => array(
							'transparent'   => array(
								'fields'        => array( 'btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size' ),
							),
						),
					),
					'btn_border_size' => array(
						'type'          => 'text',
						'label'         => __( 'Border Size', 'fl-builder' ),
						'default'       => '2',
						'description'   => 'px',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
					),
					'btn_bg_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Background Opacity', 'fl-builder' ),
						'default'       => '0',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
					),
					'btn_bg_hover_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Background Hover Opacity', 'fl-builder' ),
						'default'       => '0',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
					),
					'btn_button_transition' => array(
						'type'          => 'select',
						'label'         => __( 'Transition', 'fl-builder' ),
						'default'       => 'disable',
						'options'       => array(
							'disable'        => __( 'Disabled', 'fl-builder' ),
							'enable'         => __( 'Enabled', 'fl-builder' ),
						),
					),
				),
			),
			'btn_structure' => array(
				'title'         => __( 'Button Structure', 'fl-builder' ),
				'fields'        => array(
					'btn_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Font Size', 'fl-builder' ),
						'default'       => '14',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
					'btn_padding'   => array(
						'type'          => 'text',
						'label'         => __( 'Padding', 'fl-builder' ),
						'default'       => '10',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
					'btn_border_radius' => array(
						'type'          => 'text',
						'label'         => __( 'Round Corners', 'fl-builder' ),
						'default'       => '4',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
				),
			),
		),
	),
	'reCAPTCHA'	=> array(
		'title'         => __( 'reCAPTCHA', 'fl-builder' ),
		'sections'      => array(
			'recaptcha_general' => array(
				'title'         => '',
				'fields'        => array(
					'show_recaptcha'     => array(
						'type'          => 'select',
						'label'         => __( 'reCAPTCHA Field', 'fl-builder' ),
						'default'       => 'hide',
						'options'       => array(
							'show'          => __( 'Show', 'fl-builder' ),
							'hide'          => __( 'Hide', 'fl-builder' ),
						),
						'toggle' 		=> array(
							'show'			=> array(
								'fields' 		=> array( 'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_validate_type', 'recaptcha_theme' ),
							),
						),
						'help' 			=> __( 'If you want to show this field, please provide valid Site and Secret Keys.', 'fl-builder' ),
					),
					'recaptcha_site_key'	=> array(
						'type'					=> 'text',
						'label' 				=> __( 'Site Key', 'fl-builder' ),
						'default'       		=> '',
						'preview'      		 	=> array(
							'type'          		=> 'none',
						),
					),
					'recaptcha_secret_key'	=> array(
						'type'					=> 'text',
						'label' 				=> __( 'Secret Key', 'fl-builder' ),
						'default'       		=> '',
						'preview'       		=> array(
							'type'          		=> 'none',
						),
					),
					'recaptcha_validate_type' => array(
						'type'          		=> 'select',
						'label'         		=> __( 'Validate Type', 'fl-builder' ),
						'default'       		=> 'normal',
						'options'       		=> array(
							'normal'  				=> __( '"I\'m not a robot" checkbox', 'fl-builder' ),
							'invisible'     		=> __( 'Invisible', 'fl-builder' ),
						),
						'help' 					=> __( 'Validate users with checkbox or in the background.', 'fl-builder' ),
						'preview'      		 	=> array(
							'type'          		=> 'none',
						),
					),
					'recaptcha_theme'   => array(
						'type'          	=> 'select',
						'label'         	=> __( 'Theme', 'fl-builder' ),
						'default'       	=> 'light',
						'options'       	=> array(
							'light'  			=> __( 'Light', 'fl-builder' ),
							'dark'     			=> __( 'Dark', 'fl-builder' ),
						),
						'preview'      		 	=> array(
							'type'          		=> 'none',
						),
					),
				),
			),
		),
		'description'   => sprintf( __( 'Please register keys for your website at the <a%s>Google Admin Console</a>', 'fl-builder' ), ' href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener"' ),
	),
));
