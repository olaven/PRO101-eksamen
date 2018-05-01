(function($){

	FLBuilder.registerModuleHelper('button', {

		init: function()
		{
			$( 'input[name=bg_color]' ).on( 'change', this._bgColorChange );
			this._bgColorChange();

			$( 'select[name=lightbox_content_type]' ).on( 'change', this._contentTypeChange );
			this._contentTypeChange();

		},

		_bgColorChange: function()
		{
			var bgColor = $( 'input[name=bg_color]' ),
				style   = $( '#fl-builder-settings-section-style' );

			if ( '' == bgColor.val() ) {
				style.hide();
			}
			else {
				style.show();
			}
		},

		_contentTypeChange: function()
		{
			var contentType 	= $( 'select[name=lightbox_content_type]' ).val(),
				fieldCode 		= $( '.fl-code-field' ),
				activeEditor 	= fieldCode.find('.ace_editor'),
				editor 			= ace.edit(activeEditor[0]);

			/**
			 * Fix for initializing hidden Ace editor
			 */
			if (contentType == 'html') {
				editor.resize();
				editor.renderer.updateFull();
			}
		}
	});

})(jQuery);
