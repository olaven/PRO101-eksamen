<?php
    if ( 0 === count( $suggested_feeds ) ):
?>
<p class="ai1ec-suggested-no-events"><?php _e( 'No events found.', AI1EC_PLUGIN_NAME ); ?></p>
<?php
    else:
?>
<table class="ai1ec-suggested-events" data-ai1ec-show="list both">
    <tbody>
        <?php foreach ( $suggested_feeds as $event ):?>
        <tr class="ai1ec-suggested-event"
            data-event="<?php echo esc_attr( json_encode( $event ) ); ?>"
            data-event-id="<?php echo $event->id;?>">
            <td class="ai1ec-suggested-image"
                style="background-image:url(<?php
                    if ( isset( $event->image_url ) ) {
                        echo esc_attr( $event->image_url );
                    } else {
                        echo esc_attr( $default_image );
                    }?>)">&nbsp;
            </td>
            <td class="ai1ec-suggested-content">
                <a href="#" class="ai1ec-suggested-title" data-url="<?php echo $event->url;?>">
                    <?php if ( isset( $event->longitude ) && isset( $event->latitude ) ):?>
                        <i class="ai1ec-fa ai1ec-fa-map-marker ai1ec-fa-xs ai1ec-fa-fw"></i>
                    <?php endif; ?>
                    <?php echo strip_tags( $event->title );?>
                </a>
                <div class="ai1ec-suggested-date">
                    <?php
                        $date = new DateTime( $event->dtstart );
                        echo $date->format( 'l jS M \'y' ) . ' @ ';
                        echo $event->venue_name;
                    ?>
                </div>
                <div class="ai1ec-suggested-description" data-ai1ec-show="list">
                    <?php echo strip_tags( $event->description ) ;?>
                </div>
            </td>
            <td class="ai1ec-suggested-event-actions">
                <?php echo $event_actions; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
    endif;
?>
<div class="ai1ec-feeds-pagination">
<?php
if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages">'
        . $page_links
    . '</div></div>';
}
?>
</div>