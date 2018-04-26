.fl-node-<?php echo $id; ?> .fl-accordion-item {

	border: 1px solid #<?php echo $settings->border_color; ?>;

	<?php if ( 0 == $settings->item_spacing ) : ?>

	border-bottom: none;

	<?php else : ?>

	margin-bottom: <?php echo $settings->item_spacing; ?>px;

	<?php endif; ?>
}

<?php if ( 0 == $settings->item_spacing ) : ?>

.fl-node-<?php echo $id; ?> .fl-accordion-item:last-child {
	border-bottom: 1px solid #<?php echo $settings->border_color; ?>;
}

<?php endif; ?>
