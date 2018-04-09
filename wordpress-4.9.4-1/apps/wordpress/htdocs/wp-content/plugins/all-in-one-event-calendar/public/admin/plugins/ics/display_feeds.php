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
    endif;
?>
<div id="ics-alerts"></div>
<p></p>
<?php
    if ( $migration ):
?>
<div class="ai1ec-feeds-migration">
    <?php _e(
        '<b>Your feeds will be migrated at the next scheduled refresh (it can take up to one hour).</b><br />
        You can\'t edit or remove them at the moment.
        Please, visit this page later to manage your feeds.',
        AI1EC_PLUGIN_NAME )
    ?>
    <br /><br />
</div>
<?php
    endif;
?>
<h5><?php _e( 'My imported Feeds:', AI1EC_PLUGIN_NAME ) ?></h5>
<div class="timely ai1ec-form-inline ai1ec-panel-group ai1ec-ics-feeds-list
            <?php if ( $migration ):?>ai1ec-feeds-migration<?php endif; ?>"
     id="ai1ec-feeds-accordion">
    <?php echo $feed_rows; ?>
</div>
<br />
<?php
    if ( $single_feed_rows ):
?>
<h5><?php _e( 'My imported Events (click on the feed to see the individually imported events):', AI1EC_PLUGIN_NAME ) ?></h5>
<div class="timely ai1ec-form-inline ai1ec-panel-group ai1ec-ics-single-events
            <?php if ( $migration ):?>ai1ec-feeds-migration<?php endif; ?>"
     id="ai1ec-feeds-accordion">
    <?php echo $single_feed_rows; ?>
</div>
<?php
    endif;
?>
<?php echo $modal->render(); ?>
