<?php

$testimonials_class = 'fl-testimonials-wrap ' . $settings->layout;

if ( '' == $settings->heading && 'compact' == $settings->layout ) {
	$testimonials_class .= ' fl-testimonials-no-heading';
}

?>
<div class="<?php echo $testimonials_class; ?>">

	<?php if ( 'wide' != $settings->layout ) : ?>
		<h3 class="fl-testimonials-heading"><?php echo $settings->heading; ?></h3>
	<?php endif; ?>

	<div class="fl-testimonials">
		<?php

		for ( $i = 0; $i < count( $settings->testimonials ); $i++ ) :

			if ( ! is_object( $settings->testimonials[ $i ] ) ) {
				continue;
			}

			$testimonials = $settings->testimonials[ $i ];

		?>
		<div class="fl-testimonial">
			<?php echo $testimonials->testimonial; ?>
		</div>
		<?php endfor; ?>
	</div>

	<div class="fl-slider-next"></div>
	<div class="fl-slider-prev"></div>

</div>
