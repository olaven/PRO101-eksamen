<?php
    $feature      = Ai1ec_Api_Features::CODE_IMPORT_FEEDS;
    $api          = $this->_registry->get( 'model.api.api-feeds' );
    $provided     = $api->subscription_get_quantity_limit( $feature );
    $used         = $api->subscription_get_used_quantity( $feature );

    if ( $provided >= 1000000 ) {
        $provided = __( 'unlimited', AI1EC_PLUGIN_NAME );
    }

    if ( ! $api_signed ):
?>
<div class="ai1ec-ics-signup-box">
    <p>
        <?php _e( 'Please, Sign In to <b>Timely Network</b> to manage your feeds.', AI1EC_PLUGIN_NAME ) ?>
    </p>
    <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings"
       class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-md">
        <?php _e( 'Sign In to Timely Network', AI1EC_PLUGIN_NAME ) ?>
    </a>
</div>
<?php
    elseif ( ! $has_feature ):
?>
<div class="ai1ec-feed-container ai1ec-well ai1ec-well-sm ai1ec-clearfix">
    <?php _e(
        '<b>You don\'t have a subscription for this feature.</b><br>
        Please <a href="https://time.ly/pricing/" target="_blank">upgrade here</a> to a plan that
        supports "Import Feeds".', AI1EC_PLUGIN_NAME )
    ?>
</div>
<?php
    elseif ( $reached_limit ):
?>
<div class="ai1ec-feed-container ai1ec-well ai1ec-well-sm ai1ec-clearfix">
    <?php _e(
            sprintf(
                    __( 'You are importing %s feed(s) out of %s.', AI1EC_PLUGIN_NAME ),
                    $used,
                    $provided
            ) )
    ?>
</div>
<div class="ai1ec-feed-container ai1ec-well ai1ec-well-sm ai1ec-clearfix">
    <?php _e(
        '<b>You have reached the limit of how many feeds you can import.</b><br>
        Please sign up for EventBoost plan <a href="https://time.ly/eventboost/" target="_blank">here</a>.', AI1EC_PLUGIN_NAME )
    ?>
</div>
<?php
    else:
?>
<div class="ai1ec-feed-container ai1ec-well ai1ec-well-sm ai1ec-clearfix">
    <?php _e(
            sprintf(
                    __( 'You are importing %s feed(s) out of %s.', AI1EC_PLUGIN_NAME ),
                    $used,
                    $provided
            ) )
    ?>
</div>
<div id="ai1ec-feeds-after"
    class="ai1ec-feed-container ai1ec-well ai1ec-well-sm ai1ec-clearfix">
    <div class="ai1ec-form-group ai1ec-row">
        <div class="ai1ec-col-sm-1">
            <label class="ai1ec-feed-url-label">
                <?php _e( 'Feed URL:', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
        <div class="ai1ec-col-sm-11">
            <input type="text" name="ai1ec_feed_url" id="ai1ec_feed_url"
                class="ai1ec-form-control" maxlength="255">
        </div>
    </div>
    <div class="ai1ec-feeds-edit-fields">
        <div class="ai1ec-row">
            <div class="ai1ec-col-sm-6">
                <?php $event_categories->render(); ?>
            </div>
            <div class="ai1ec-col-sm-6">
                <?php $event_tags->render(); ?>
            </div>
        </div>
        <?php do_action( 'ai1ec_ics_row_after_categories_tags', null ); ?>
        <div class="ai1ec-feed-comments-enabled">
            <label for="ai1ec_comments_enabled">
                <input type="checkbox" name="ai1ec_comments_enabled"
                    id="ai1ec_comments_enabled" value="1">
                <?php _e( 'Allow comments on imported events', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
        <div class="ai1ec-feed-map-display-enabled">
            <label for="ai1ec_map_display_enabled">
                <input type="checkbox" name="ai1ec_map_display_enabled"
                    id="ai1ec_map_display_enabled" value="1">
                <?php _e( 'Show map on imported events', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
        <div class="ai1ec-feed-add-tags-categories">
            <label for="ai1ec_add_tag_categories">
                <input type="checkbox" name="ai1ec_add_tag_categories"
                    id="ai1ec_add_tag_categories" value="1">
                <?php _e( 'Import any tags/categories provided by feed, in addition those selected above', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
        <?php do_action( 'ai1ec_ics_row_after_keep_categories_tags', null ); ?>
        <div class="ai1ec-feed-keep-old-events">
            <label for="ai1ec_keep_old_events">
                <input type="checkbox" name="ai1ec_keep_old_events"
                    id="ai1ec_keep_old_events" value="1">
                <?php _e( 'On refresh, preserve previously imported events that are missing from the feed', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
        <div class="ai1ec-feed-import-timezone">
            <label for="ai1ec_feed_import_timezone">
                <input type="checkbox" name="ai1ec_feed_import_timezones"
                    id="ai1ec_feed_import_timezone" value="1">
                <?php _e( 'Convert event\'s date/time to calendar\'s timezone', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>
    </div>
    <div class="ai1ec-feeds-edit-fields">
        <div class="ai1ec-pull-right">
            <button type="button" id="ai1ec_cancel_ics"
                class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-sm ai1ec-hidden">
                <i class="ai1ec-fa ai1ec-fa-cancel"></i>
                <?php _e( 'Cancel', AI1EC_PLUGIN_NAME ); ?>
            </button>
            <button type="button" id="ai1ec_add_new_ics"
                class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-sm"
                data-loading-text="<?php echo esc_attr(
                    '<i class="ai1ec-fa ai1ec-fa-spinner ai1ec-fa-spin ai1ec-fa-fw"></i> ' .
                    __( 'Please wait&#8230;', AI1EC_PLUGIN_NAME ) ); ?>">
                <i class="ai1ec-fa ai1ec-fa-plus"></i>
                <span id="ai1ec_ics_add_new">
                    <?php _e( 'Import feed', AI1EC_PLUGIN_NAME ); ?>
                </span>
                <span id="ai1ec_ics_update" class="ai1ec-hidden">
                    <?php _e( 'Update feed', AI1EC_PLUGIN_NAME ); ?>
                </span>
            </button>
        </div>
    </div>
    <?php do_action( 'ai1ec_ics_row_after_settings', null ); ?>
</div>
<?php
    endif;
?>
