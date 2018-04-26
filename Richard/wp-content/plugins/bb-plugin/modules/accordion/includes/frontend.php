<?php global $wp_embed; ?>
<div class="fl-accordion fl-accordion-<?php echo $settings->label_size;
if ( $settings->collapse ) { echo ' fl-accordion-collapse';} ?>"  role="tablist"<?php if ( ! $settings->collapse ) { echo 'multiselectable="true"';} ?>>
	<?php for ( $i = 0; $i < count( $settings->items );
	$i++ ) : if ( empty( $settings->items[ $i ] ) ) { continue;} ?>
	<div class="fl-accordion-item"<?php if ( ! empty( $settings->id ) ) { echo ' id="' . sanitize_html_class( $settings->id ) . '-' . $i . '"';} ?>>
		<div class="fl-accordion-button" id="<?php echo 'fl-accordion-' . $module->node . '-tab-' . $i; ?>" aria-selected="false" aria-controls="<?php echo 'fl-accordion-' . $module->node . '-panel-' . $i; ?>" aria-expanded="<?php echo ( $i > 0 || ! $settings->open_first) ? 'false' : 'true'; ?>" role="tab" tabindex="0">
			<div class="fl-accordion-button-label"><?php echo $settings->items[ $i ]->label; ?></div>
			<i class="fl-accordion-button-icon fa fa-plus"></i>
		</div>
		<div class="fl-accordion-content fl-clearfix" id="<?php echo 'fl-accordion-' . $module->node . '-panel-' . $i; ?>" aria-labelledby="<?php echo 'fl-accordion-' . $module->node . '-tab-' . $i; ?>" aria-hidden="<?php echo ( $i > 0 || ! $settings->open_first) ? 'true' : 'false'; ?>" role="tabpanel" aria-live="polite"><?php echo wpautop( $wp_embed->autoembed( $settings->items[ $i ]->content ) ); ?></div>
	</div>
	<?php endfor; ?>
</div>
