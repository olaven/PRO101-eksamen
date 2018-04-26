<?php if ( 'collage' == $settings->layout ) : ?>
.fl-node-<?php echo $id; ?> .fl-mosaicflow {
	margin-left: -<?php echo $settings->photo_spacing; ?>px;
}
.fl-mosaicflow-item {
	margin: 0 0 <?php echo $settings->photo_spacing; ?>px <?php echo $settings->photo_spacing; ?>px;
}
<?php endif; ?>
<?php if ( 'lightbox' == $settings->click_action && ! empty( $settings->show_captions ) ) : ?>
.mfp-gallery img.mfp-img {
	padding: 40px 0;
}
<?php endif; ?>
