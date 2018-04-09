<div class="ai1ec-panel ai1ec-panel-default ai1ec-feed-container">
    <div class="ai1ec-panel-heading">
        <a data-toggle="ai1ec-collapse"
           data-parent="#ai1ec-feeds-accordion"
           href="#ai1ec-feed-<?php echo $feed_id; ?>">
            <?php echo parse_url( trim( $feed_url ), PHP_URL_HOST ); ?>
        </a>
    </div>
    <div class="ai1ec-panel-collapse ai1ec-collapse"
         id="ai1ec-feed-<?php echo $feed_id; ?>">
        <div class="ai1ec-panel-body">
            <div class="ai1ec-feed-content">
                <div class="ai1ec-form-group">
                    <div class="ai1ec-col-sm-1">
                        <label class="ai1ec-feed-url-label">
                            <?php _e( 'Feed URL:', AI1EC_PLUGIN_NAME ); ?>
                        </label>
                    </div>
                    <div class="ai1ec-col-sm-11">
                        <input type="text" class="ai1ec-feed-url ai1ec-form-control"
                            readonly="readonly" value="<?php echo esc_attr( $feed_url ) ?>">
                    </div>
                </div>
                <input type="hidden" name="feed_id" class="ai1ec_feed_id"
                    value="<?php echo $feed_id; ?>">
                <div>
                    <div class="ai1ec-clearfix">
                        <?php if ( $event_category ) : ?>
                            <div class="ai1ec-feed-category"
                                 data-ids="<?php echo esc_attr( $categories_ids ); ?>">
                                <?php _e( 'Event categories:', AI1EC_PLUGIN_NAME ); ?>
                                <strong><?php echo $event_category; ?></strong>
                            </div>
                        <?php endif; ?>
                        <?php if ( $tags ) : ?>
                            <div class="ai1ec-feed-tags ai1ec-pull-left"
                                 data-ids="<?php echo esc_attr( $tags_ids ); ?>">
                                <?php _e( 'Tag with', AI1EC_PLUGIN_NAME ); ?>:
                                <strong><?php echo $tags; ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php do_action( 'ai1ec_ics_row_after_categories_tags', $feed_id ); ?>
                    <div class="ai1ec-clearfix">
                        <div class="ai1ec-feed-comments-enabled"
                             data-state="<?php echo esc_attr( $comments_enabled ? 1 : 0 ); ?>">
                            <?php _e( 'Allow comments', AI1EC_PLUGIN_NAME ); ?>:
                            <strong><?php
                            if ( $comments_enabled ) {
                                _e( 'Yes', AI1EC_PLUGIN_NAME );
                            } else {
                                _e( 'No',  AI1EC_PLUGIN_NAME );
                            }
                            ?></strong>
                        </div>
                        <div class="ai1ec-feed-map-display-enabled"
                             data-state="<?php echo esc_attr( $map_display_enabled ? 1 : 0 ); ?>">
                            <?php _e( 'Show map', AI1EC_PLUGIN_NAME ); ?>:
                            <strong><?php
                            if ( $map_display_enabled ) {
                                _e( 'Yes', AI1EC_PLUGIN_NAME );
                            } else {
                                _e( 'No',  AI1EC_PLUGIN_NAME );
                            }
                            ?></strong>
                        </div>
                    </div>
                    <div class="ai1ec-feed-keep-tags-categories"
                         data-state="<?php echo esc_attr( $keep_tags_categories ? 1 : 0 ); ?>">
                        <?php _e( 'Keep original events categories and tags', AI1EC_PLUGIN_NAME ); ?>:
                        <strong><?php
                        if ( $keep_tags_categories ) {
                            _e( 'Yes', AI1EC_PLUGIN_NAME );
                        } else {
                            _e( 'No',  AI1EC_PLUGIN_NAME );
                        }
                        ?></strong>
                    </div>
                    <?php do_action( 'ai1ec_ics_row_after_keep_categories_tags', $feed_id ); ?>
                    <div class="ai1ec-feed-keep-old-events"
                         data-state="<?php echo esc_attr( $keep_old_events ? 1 : 0 ); ?>">
                        <?php _e( 'On refresh, preserve previously imported events that are missing from the feed', AI1EC_PLUGIN_NAME ); ?>:
                        <strong><?php
                        if ( $keep_old_events ) {
                            _e( 'Yes', AI1EC_PLUGIN_NAME );
                        } else {
                            _e( 'No',  AI1EC_PLUGIN_NAME );
                        }
                        ?></strong>
                    </div>
                    <div class="ai1ec-feed-import-timezone"
                         data-state="<?php echo esc_attr( $feed_import_timezone ? 1 : 0 ); ?>">
                            <?php _e( 'Convert event\'s date/time to calendar\'s timezone', AI1EC_PLUGIN_NAME ); ?>:
                        <strong><?php
                            if ( $feed_import_timezone ) {
                                _e( 'Yes', AI1EC_PLUGIN_NAME );
                            } else {
                                _e( 'No',  AI1EC_PLUGIN_NAME );
                            } ?>
                        </strong>
                    </div>

                    <?php if ( sizeof( $feed_events_uids ) > 0 ) : ?>
                    <div class="ai1ec-feed-category"
                         data-ids="<?php echo esc_attr( $categories_ids ); ?>"><br />
                        <label><?php _e( 'List of imported events:', AI1EC_PLUGIN_NAME ); ?></label>
                            <br />
                            <strong>
                            <?php
                                foreach ( $feed_events_uids as $feed_event_uid => $feed_event_title ):?>
                                    <div class="ai1ec-myfeeds-event"
                                         data-event-id="<?php echo esc_attr( $feed_event_uid ); ?>"
                                         data-feed-id="<?php echo esc_attr( $feed_name ); ?>">
                                        <?php echo $feed_event_title; ?>&nbsp;&nbsp;
                                        <a href="#" class="ai1ec-btn ai1ec-btn-secondary ai1ec-btn-xs ai1ec-text-warning
                                                           ai1ec-disabled ai1ec-hidden ai1ec-suggested-removing">
                                            <?php _e( 'Removing', AI1EC_PLUGIN_NAME ); ?>&hellip;
                                        </a>
                                        <a href="#" class="ai1ec-btn ai1ec-btn-secondary ai1ec-btn-xs ai1ec-text-danger
                                                           ai1ec-suggested-remove-event">
                                            <i class="ai1ec-fa ai1ec-fa-minus ai1ec-fa-xs ai1ec-fa-fw"></i>
                                            <?php _e( 'Remove', AI1EC_PLUGIN_NAME ); ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </strong>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <div class="ai1ec-btn-group ai1ec-pull-right ai1ec-feed-actions">
                        <?php
                            if ( $api_signed ):
                        ?>
                        <button type="button"
                            class="ai1ec-btn ai1ec-btn-sm ai1ec-btn-default ai1ec-text-primary
                                ai1ec_update_ics"
                            data-loading-text="<?php echo esc_attr(
                                '<i class="ai1ec-fa ai1ec-fa-refresh ai1ec-fa-spin ai1ec-fa-fw"></i> ' .
                                __( 'Refreshing&#8230;', AI1EC_PLUGIN_NAME ) ); ?>">
                            <i class="ai1ec-fa ai1ec-fa-refresh ai1ec-fa-fw"></i>
                            <?php _e( 'Refresh', AI1EC_PLUGIN_NAME ); ?>
                        </button>
                        <button type="button"
                            class="ai1ec-btn ai1ec-btn-sm ai1ec-btn-default ai1ec-text-warning
                                ai1ec_edit_ics">
                            <i class="ai1ec-fa ai1ec-fa-edit ai1ec-fa-fw"></i>
                            <?php _e( 'Edit', AI1EC_PLUGIN_NAME ); ?>
                        </button>
                        <?php
                            endif;
                        ?>
                        <button type="button"
                            class="ai1ec-btn ai1ec-btn-sm ai1ec-btn-default ai1ec-text-danger
                                ai1ec_delete_ics"
                            data-loading-text="<?php echo esc_attr(
                                '<i class="ai1ec-fa ai1ec-fa-spinner ai1ec-fa-spin ai1ec-fa-fw"></i> ' .
                                __( 'Removing&#8230;', AI1EC_PLUGIN_NAME ) ); ?>">
                            <i class="ai1ec-fa ai1ec-fa-times ai1ec-fa-fw"></i>
                            <?php _e( 'Remove', AI1EC_PLUGIN_NAME ); ?>
                        </button>
                    </div>
                </div>
                <?php do_action( 'ai1ec_ics_row_after_settings', $feed_id ); ?>
            </div>
        </div>
    </div>
</div>
