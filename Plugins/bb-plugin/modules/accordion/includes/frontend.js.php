(function($) {

	$(function() {
	
		new FLBuilderAccordion({
			id: '<?php echo $id ?>',
			defaultItem: <?php echo (isset( $settings->open_first ) && $settings->open_first) ? '1' : 'false'; ?>
		});
	});
	
})(jQuery);
