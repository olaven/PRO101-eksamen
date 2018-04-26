(function($){

	FLBuilder.registerModuleHelper('cta', {

		init: function()
		{
			$( 'input[name=btn_bg_color]' ).on( 'change', this._bgColorChange );

			this._bgColorChange();
		},

		_bgColorChange: function()
		{
			var bgColor = $( 'input[name=btn_bg_color]' ),
				style   = $( '#fl-builder-settings-section-btn_style' );


			if ( '' == bgColor.val() ) {
				style.hide();
			}
			else {
				style.show();
			}
		}
	});

})(jQuery);
