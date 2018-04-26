<?php global $wp_embed; ?>
<div class="fl-tabs fl-tabs-<?php echo $settings->layout; ?> fl-clearfix">

	<div class="fl-tabs-labels fl-clearfix" role="tablist">
		<?php for ( $i = 0; $i < count( $settings->items );
		$i++ ) : if ( ! is_object( $settings->items[ $i ] ) ) { continue;} ?>
		<div class="fl-tabs-label<?php if ( 0 == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" data-index="<?php echo $i; ?>" aria-selected="<?php echo ($i > 0) ? 'false' : 'true';?>" aria-controls="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" aria-expanded="<?php echo ( $i > 0 ) ? 'false' : 'true'; ?>" role="tab" tabindex="0">
			<?php echo $settings->items[ $i ]->label; ?>
		</div>
		<?php endfor; ?>
	</div>

	<div class="fl-tabs-panels fl-clearfix">
		<?php for ( $i = 0; $i < count( $settings->items );
		$i++ ) : if ( ! is_object( $settings->items[ $i ] ) ) { continue;} ?>
		<div class="fl-tabs-panel"<?php if ( ! empty( $settings->id ) ) { echo ' id="' . sanitize_html_class( $settings->id ) . '-' . $i . '"';} ?>>
			<div class="fl-tabs-label fl-tabs-panel-label<?php if ( 0 == $i ) { echo ' fl-tab-active';} ?>" data-index="<?php echo $i; ?>" tabindex="0">
				<span><?php echo $settings->items[ $i ]->label; ?></span>
				<i class="fa<?php if ( $i > 0 ) { echo ' fa-plus';} ?>"></i>
			</div>
			<div class="fl-tabs-panel-content fl-clearfix<?php if ( 0 == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" data-index="<?php echo $i; ?>"<?php if ( $i > 0 ) { echo ' aria-hidden="true"';} ?> aria-labelledby="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" role="tabpanel" aria-live="polite">
				<?php echo wpautop( $wp_embed->autoembed( $settings->items[ $i ]->content ) ); ?>
			</div>
		</div>
		<?php endfor; ?>
	</div>

</div>
