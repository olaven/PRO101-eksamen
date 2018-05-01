(function($) {

	// Clear the controls in case they were already created.
	$('.fl-node-<?php echo $id; ?> .fl-slider-next').empty();
	$('.fl-node-<?php echo $id; ?> .fl-slider-prev').empty();

	// Create the slider.
	$('.fl-node-<?php echo $id; ?> .fl-testimonials').bxSlider({
		autoStart : <?php echo $settings->auto_play ?>,
		auto : true,
		adaptiveHeight: true,
		pause : <?php echo $settings->pause * 1000; ?>,
		mode : '<?php echo $settings->transition; ?>',
		autoDirection: '<?php echo $settings->direction; ?>',
		speed : <?php echo $settings->speed * 1000;  ?>,
		pager : <?php echo ( 'wide' == $settings->layout ) ? $settings->dots : 0; ?>,
		nextSelector : '.fl-node-<?php echo $id; ?> .fl-slider-next',
		prevSelector : '.fl-node-<?php echo $id; ?> .fl-slider-prev',
		nextText: '<i class="fa fa-chevron-circle-right"></i>',
		prevText: '<i class="fa fa-chevron-circle-left"></i>',
		controls : <?php echo ( 'compact' == $settings->layout ) ? $settings->arrows : 0; ?>,
		onSliderLoad: function() {
			$('.fl-node-<?php echo $id; ?> .fl-testimonials').addClass('fl-testimonials-loaded');
		},
		onSliderResize: function(currentIndex){
			this.working = false;
			this.reloadSlider();
		},
		onSlideBefore: function(ele, oldIndex, newIndex) {
			$('.fl-node-<?php echo $id; ?> .fl-slider-next a').addClass('disabled');
			$('.fl-node-<?php echo $id; ?> .fl-slider-prev a').addClass('disabled');
			$('.fl-node-<?php echo $id; ?> .bx-controls .bx-pager-link').addClass('disabled');
		},
		onSlideAfter: function( ele, oldIndex, newIndex ) {
			$('.fl-node-<?php echo $id; ?> .fl-slider-next a').removeClass('disabled');
			$('.fl-node-<?php echo $id; ?> .fl-slider-prev a').removeClass('disabled');
			$('.fl-node-<?php echo $id; ?> .bx-controls .bx-pager-link').removeClass('disabled');
		},
	});

})(jQuery);
