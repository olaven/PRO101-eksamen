<?php if ( isset( $settings->number_spacing ) ) : ?>
	.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-number {
		font-size: 1px;
		margin-left: <?php echo $settings->number_spacing ?>px;
		margin-right: <?php echo $settings->number_spacing ?>px;
	}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-unit-number {
	<?php
	if ( ! empty( $settings->number_size ) ) {
		echo 'font-size: ' . $settings->number_size . 'px;';
	}
	if ( ! empty( $settings->number_color ) ) {
		echo 'color: #' . $settings->number_color . ';';
	}
	?>
}

.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-unit-label {
	<?php
	if ( ! empty( $settings->label_size ) ) {
		echo 'font-size: ' . $settings->label_size . 'px;';
	}
	if ( ! empty( $settings->label_color ) ) {
		echo 'color: #' . $settings->label_color . ';';
	}
	?>
}

<?php if ( isset( $settings->layout ) && 'default' == $settings->layout ) : ?>
	.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-unit {
		<?php
		if ( isset( $settings->vertical_padding ) ) {
			echo 'padding-top: ' . $settings->vertical_padding . 'px;';
			echo 'padding-bottom: ' . $settings->vertical_padding . 'px;';
		}
		if ( isset( $settings->horizontal_padding ) ) {
			echo 'padding-left: ' . $settings->horizontal_padding . 'px;';
			echo 'padding-right: ' . $settings->horizontal_padding . 'px;';
		}
		if ( ! empty( $settings->number_bg_color ) ) {
			$number_raw_color = ! empty( $settings->number_bg_color ) ? $settings->number_bg_color : 'transparent';
			$number_opacity   = ! empty( $settings->number_bg_opacity ) ? $settings->number_bg_opacity : '100';
			$number_color     = 'rgba(' . implode( ',', FLBuilderColor::hex_to_rgb( $number_raw_color ) ) . ',' . ( $number_opacity / 100 ) . ')';

			echo 'background-color: #' . $number_raw_color . ';';
			echo 'background-color: ' . $number_color . ';';
		}
		if ( isset( $settings->border_radius ) ) {
			echo 'border-radius: ' . $settings->border_radius . 'px;';
		}
		?>
	}

	<?php if ( 'yes' == $settings->show_separator && 'colon' == $settings->separator_type ) : ?>
		.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-number:after {
			<?php
			if ( isset( $settings->number_spacing ) ) {
				echo 'width: ' . ( $settings->number_spacing * 2 ) . 'px;';
				echo 'right: -' . ( $settings->number_spacing * 2 ) . 'px;';
			}
			if ( isset( $settings->separator_color ) ) {
				echo 'color: #' . $settings->separator_color . ';';
			}

			?>
		}
	<?php endif; ?>

	<?php if ( 'yes' == $settings->show_separator && 'line' == $settings->separator_type ) : ?>
		.fl-node-<?php echo $id; ?> .fl-countdown .fl-countdown-number:after {
			<?php
			if ( isset( $settings->number_spacing ) ) {
				echo 'right: -' . $settings->number_spacing . 'px;';
			}
			if ( isset( $settings->separator_color ) ) {
				echo 'border-color: #' . $settings->separator_color . ';';
			}

			?>
		}
	<?php endif; ?>

<?php elseif ( isset( $settings->layout ) && 'circle' == $settings->layout ) : ?>
	.fl-node-<?php echo $id ?> .fl-countdown-unit{
		position: absolute;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%,-50%);
		   -moz-transform: translate(-50%,-50%);
			-ms-transform: translate(-50%,-50%);
				transform: translate(-50%,-50%);
	}
	.fl-node-<?php echo $id ?> .fl-countdown-number{
		<?php
		if ( ! empty( $settings->circle_width ) ) {
			echo 'width: ' . $settings->circle_width . 'px;';
			echo 'height: ' . $settings->circle_width . 'px;';
		} else {
			echo 'max-width: 100px;';
			echo 'max-height: 100px;';
		}
		?>
	}
	.fl-node-<?php echo $id ?> .fl-countdown-circle-container{
		<?php
		if ( ! empty( $settings->circle_width ) ) {
			echo 'max-width: ' . $settings->circle_width . 'px;';
			echo 'max-height: ' . $settings->circle_width . 'px;';
		} else {
			echo 'max-width: 100px;';
			echo 'max-height: 100px;';
		}
		?>
	}

	.fl-node-<?php echo $id ?> .fl-countdown .svg circle{
	<?php
	if ( ! empty( $settings->circle_dash_width ) ) {
		echo 'stroke-width: ' . $settings->circle_dash_width . 'px;';
	}
	?>
	}

	.fl-node-<?php echo $id ?> .fl-countdown .svg .fl-number-bg{
	<?php
	if ( ! empty( $settings->circle_bg_color ) ) {
		echo 'stroke: #' . $settings->circle_bg_color . ';';
	} else {
		echo 'stroke: transparent;';
	}
	?>
	}

	.fl-node-<?php echo $id ?> .fl-countdown .svg .fl-number{
	<?php
	if ( ! empty( $settings->circle_color ) ) {
		echo 'stroke: #' . $settings->circle_color . ';';
	} else {
		echo 'stroke: transparent;';
	}
	?>
	}
<?php endif; ?>
