<?php
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
    else:
?>
<div class="ai1ec-form ai1ec-suggested-search-form">
    <label><?php _e( 'Find events matching:', AI1EC_PLUGIN_NAME ); ?>
        <input type="text" placeholder="Ex.: Concert"
               class="ai1ec-form-control" name="term" id="ai1ec_suggested_term" />
    </label>

    <label><?php _e( 'Located in:', AI1EC_PLUGIN_NAME ); ?>
        <input type="text" placeholder="Ex.: Vancouver"
               class="ai1ec-form-control" name="location" id="ai1ec_suggested_location" autocomplete="off"/>
    </label>

    <a href="#" class="ai1ec-btn ai1ec-btn-success" id="ai1ec_suggested_search">
        <i class="ai1ec-fa ai1ec-fa-search"></i>
        <?php _e( 'Search', AI1EC_PLUGIN_NAME ); ?>
    </a>
    <input type="hidden" id="ai1ec_suggested_radius" />
    <input type="hidden" id="ai1ec_suggested_lat" />
    <input type="hidden" id="ai1ec_suggested_lng" />
</div>

<div class="ai1ec-suggested-results">
    <div>
        <b>
            <span class="ai1ec-suggested-results-found">0</span>
            <?php _e( ' events found.', AI1EC_PLUGIN_NAME ); ?>
        </b>
        <?php _e( 'Update settings for the imported events in “My feeds” tab.', AI1EC_PLUGIN_NAME ); ?>
    </div>
    <div id="ai1ec-discovery-status">&nbsp;</div>
    <div class="ai1ec-suggested-view-selector">
        <a href="#" data-ai1ec-view="map">
            <?php _e( 'Map', AI1EC_PLUGIN_NAME ); ?>
        </a> |
        <a href="#" data-ai1ec-view="both" class="ai1ec-active">
            <?php _e( 'Both', AI1EC_PLUGIN_NAME ); ?>
        </a> |
            <a href="#" data-ai1ec-view="list">
            <?php _e( 'List', AI1EC_PLUGIN_NAME ); ?>
        </a>
    </div>
    <div class="ai1ec-suggested-map-container" data-ai1ec-show="both map">
        <div id="ai1ec_events_extra_details" data-ai1ec-show="both"></div>
        <div id="ai1ec_events_map_canvas"></div>
    </div>
    <div class="ai1ec-feeds-list-container">
    </div>
</div>

<?php
    endif;
?>

<div class="ai1ec-suggested-no-results">

    <h4>
        <i class="ai1ec-fa ai1ec-fa-times-circle"></i>
        <?php _e( 'No events found.', AI1EC_PLUGIN_NAME ); ?>
    </h4>
    <p class="ai1ec-suggested-results-hint">
        <?php _e( 'Please, modify your search criteria and try again.', AI1EC_PLUGIN_NAME ); ?>
    </p>
</div>

<div class="ai1ec-suggested-events-actions-template ai1ec-hidden">
    <?php echo $event_actions; ?>
</div>


