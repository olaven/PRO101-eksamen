<div class="ai1ec-panel-heading">
    <a data-toggle="ai1ec-collapse"
        data-parent="#ai1ec-add-new-event-accordion"
        href="#ai1ec-event-cost-box">
        <i class="ai1ec-fa ai1ec-fa-shopping-cart ai1ec-fa-fw"></i>
        <?php _e( 'Event cost and Tickets', AI1EC_PLUGIN_NAME ); ?>
        <i class="ai1ec-fa ai1ec-fa-warning ai1ec-fa-fw ai1ec-hidden"></i>
    </a>
</div>
<div id="ai1ec-event-cost-box" class="ai1ec-panel-collapse ai1ec-collapse">
    <?php
        if ( ! is_null( $tax_options ) ) {
            foreach ( get_object_vars ( $tax_options ) as $key => $value ) {
                if ( ! is_null( $value ) ) {
                    echo '<input type="hidden" name="tax_options['. $key .']" value="'. $value . '">';
                }
            }
        }
    ?>
    <input type="hidden" name="ai1ec_uid" value="<?php echo $uid;?>">
    <input type="hidden" id="ai1ec_editing_ticket" value="<?php echo $is_ticket_event ? 1 : 0;?>">
    <?php if ( $tickets_loading_error ):?>
        <input type="hidden" name="ai1ec_tickets_loading_error" value="<?php echo htmlentities( $tickets_loading_error ); ?>">
    <?php endif; ?>
    <div class="ai1ec-panel-body">

    <?php
    if ( $ticket_event_imported ):?>
        <p><?php _e( 'Cost options not available, this event was imported from an external calendar.', AI1EC_PLUGIN_NAME ); ?></p>
    <?php
    elseif ( $tickets_loading_error ): ?>
        <p><?php echo $tickets_loading_error; ?></p>
    <?php elseif ( $is_ticket_event && ! $ticketing ): ?>
        <p><?php echo sprintf(
            __( 'This event was created using Timely Network. Sign in with the account %s to see the Ticket options.', AI1EC_PLUGIN_NAME ),
        $ticket_event_account ); ?></p>
        <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-tickets"
               class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-lg">
                <?php _e( 'Sign In for Timely Network', AI1EC_PLUGIN_NAME ); ?>
        </a>
    <?php else: ?>

        <div class="ai1ec-cost-types">
            <label for="ai1ec_no_tickets">
                <input type="radio" value="free" id="ai1ec_no_tickets"
                       name="ai1ec_cost_type" <?php if ( 'free' == $cost_type ) { echo 'checked'; } ?>>
                <?php _e( 'No Tickets', AI1EC_PLUGIN_NAME ); ?>
            </label>

            <label for="ai1ec_has_tickets">
                <input type="radio" value="tickets" id="ai1ec_has_tickets"
                       name="ai1ec_cost_type" <?php if ( 'tickets' == $cost_type ) { echo 'checked'; } ?>>
                <?php _e( 'Time.ly Tickets', AI1EC_PLUGIN_NAME ); ?>
            </label>

            <label for="ai1ec_external_tickets">
                <input type="radio" value="external" id="ai1ec_external_tickets"
                       name="ai1ec_cost_type" <?php if ( 'external' == $cost_type ) { echo 'checked'; } ?>>
                <?php _e( 'External Tickets', AI1EC_PLUGIN_NAME ); ?>
            </label>
        </div>


        <?php
        if ( ! $ticketing ): ?>
            <div class="ai1ec-panel ai1ec-tickets-panel ai1ec-tickets-form">
                <?php
                if ( ! $tickets_message ): ?>
                    <p><?php _e( 'Ticketing allows you to sell tickets directly to the users.', AI1EC_PLUGIN_NAME ); ?></p>
                    <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings"
                       class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-lg">
                            <?php _e( 'Sign Up for Timely Network', AI1EC_PLUGIN_NAME ); ?>
                    </a>
                <?php
                else:
                    echo "<p>$tickets_message</p>";
                endif; ?>
            </div>
        <?php
        elseif ( ! $valid_payout_details ): ?>
            <div class="ai1ec-panel ai1ec-tickets-panel ai1ec-tickets-form">
                <p><?php _e( 'Please, provide valid payout details to use Ticketing.', AI1EC_PLUGIN_NAME ); ?></p>
                <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-tickets"
                   class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-lg">
                        <?php _e( 'Ticketing Settings', AI1EC_PLUGIN_NAME ); ?>
                </a>
            </div>
        <?php
        else:

            $i = 0;
            foreach ( $tickets as $ticket ):

        ?>

            <div class="ai1ec-panel ai1ec-tickets-panel ai1ec-tickets-form ai1ec-tickets-edit-form
                 <?php if ( 0 === $i ){ echo 'ai1ec-tickets-form-template';} ?>"
                 data-count="<?php echo $i;?>">
                <a href="#" class="ai1ec-btn ai1ec-btn-lg ai1ec-pull-right ai1ec-remove-ticket"
                   alt="" title="<?php _e( 'Remove Ticket Type', AI1EC_PLUGIN_NAME ); ?>">
                    <i class="ai1ec-fa ai1ec-fa-times"></i>
                </a>
                <?php if ( isset( $ticket->id ) ):?>
                    <input type="hidden" name="id" value="<?php echo esc_attr( $ticket->id );?>" />
                <?php endif; ?>
                <?php if ( isset( $ticket->taken ) ):?>
                    <input type="hidden" id="ai1ec-ticket-taken" name="taken" value="<?php echo esc_attr( $ticket->taken );?>" />
                <?php endif; ?>
                <?php if ( isset( $ticket->created_at ) ):?>
                    <input type="hidden" name="created_at" value="<?php echo esc_attr( $ticket->created_at );?>" />
                <?php endif; ?>
                <table class="ai1ec-form ai1ec-tickets-form">
                    <tbody>
                        <tr>
                            <td><?php _e( 'Title:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <div class="ai1ec-ticket-field-error">
                                    <?php _e( 'This field is required.', AI1EC_PLUGIN_NAME ); ?>
                                </div>
                                <input class="ai1ec-form-control ai1ec-required"
                                       id="ai1ec_new_ticket_name"
                                       name="ticket_name"
                                       value="<?php if ( isset( $ticket->ticket_name ) ){echo esc_attr( $ticket->ticket_name );}?>"
                                       placeholder="<?php _e( 'Ex.: Regular Ticket', AI1EC_PLUGIN_NAME ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e( 'Description:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <input class="ai1ec-form-control"
                                       id="ai1ec_new_ticket_description"
                                       name="description"
                                       value="<?php if ( isset( $ticket->description ) ){echo esc_attr( $ticket->description );}?>"
                                       placeholder="<?php _e( '(Optional)', AI1EC_PLUGIN_NAME ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="ai1ec-first"><?php _e( 'Price:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <div class="ai1ec-ticket-field-error">
                                    <?php _e( 'This field is required.', AI1EC_PLUGIN_NAME ); ?>
                                </div>
                                <input class="ai1ec-form-control ai1ec-required"
                                       name="ticket_price"
                                       value="<?php if ( isset( $ticket->ticket_price ) ){echo esc_attr( $ticket->ticket_price );}?>"
                                       id="ai1ec_ticket_price"
                                       >
                                <?php echo $ticket_currency; ?>
                            </td>
                        </tr>
                        <tr class="ai1ec-tickets-limits">
                            <td><?php _e( 'Limits:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <div class="ai1ec-ticket-field-error">
                                    <?php _e( 'This fields are required.', AI1EC_PLUGIN_NAME ); ?>
                                </div>
                                <label for="ai1ec_buy_min_limit">
                                    <?php _e( 'Min:', AI1EC_PLUGIN_NAME ); ?>
                                </label>
                                <input type="number"
                                       class="ai1ec-form-control ai1ec-required"
                                       id="ai1ec_buy_min_limit"
                                       name="buy_min_limit"
                                       min="0"
                                       data-default="0"
                                       value="<?php if ( isset( $ticket->buy_min_limit ) ){echo esc_attr( $ticket->buy_min_limit ); } else {echo 0;}?>">
                                <label for="ai1ec_buy_max_limit">
                                    <?php _e( 'Max:', AI1EC_PLUGIN_NAME ); ?>
                                </label>
                                <input type="number"
                                       class="ai1ec-form-control ai1ec-required"
                                       id="ai1ec_buy_max_limit"
                                       name="buy_max_limit"
                                       min="0"
                                       data-default="25"
                                       value="<?php if ( isset( $ticket->buy_max_limit ) ){echo esc_attr( $ticket->buy_max_limit );} else {echo 25;}?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e( 'Quantity:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <label>
                                    <input type="checkbox" id="ai1ec_ticket_unlimited"
                                           name="unlimited"
                                        <?php
                                            if ( isset( $ticket->unlimited ) && 'on' == $ticket->unlimited ) { echo 'checked="checked"';}
                                        ?>
                                    >
                                    <?php _e( 'Unlimited', AI1EC_PLUGIN_NAME ); ?>
                                </label>
                                <input type="number" class="ai1ec-form-control" id="ai1ec_ticket_quantity"
                                       name="quantity" min="0" data-default="100"
                                    <?php
                                        if ( isset( $ticket->unlimited ) && 'on' == $ticket->unlimited ) {
                                            echo 'value="100"';
                                        } else {
                                            if ( isset ( $ticket->quantity ) ) {
                                                echo 'value="' . esc_attr( $ticket->quantity ) . '"; style="display:inline-block"';
                                            }
                                        }
                                    ?>
                                >
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e( 'Available:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td class="ai1ec-avail-block">
                                <label>
                                    <input type="checkbox" id="ai1ec_ticket_avail"
                                           name="availibility"
                                           <?php
                                                if ( isset( $ticket->availibility ) &&
                                                    'on' == $ticket->availibility ) {
                                                    echo ' checked="checked" ';
                                                }
                                           ?>
                                           >
                                    <?php _e( 'Immediately', AI1EC_PLUGIN_NAME ); ?>
                                </label>
                                <div class="ai1ec-tickets-dates" style="display:
                                    <?php
                                        if ( isset( $ticket->availibility ) &&
                                                   'on' == $ticket->availibility ) {
                                            echo 'none';
                                        } else {
                                            echo 'block';
                                        }
                                    ?>;">
                                    <div>
                                        <div class="ai1ec-tickets-dates-block">
                                            <label><?php _e( 'From:', AI1EC_PLUGIN_NAME ); ?></label>
                                            <input type="text" class="ai1ec-form-control ai1ec-tickets-datepicker"
                                                   data-date-format="yyyy-mm-dd" size="12"
                                                   />
                                            <input type="text" class="ai1ec-form-control ai1ec-tickets-time"
                                                   value="00:00" size="5" maxlength="5"
                                                   /><br>
                                            <input type="hidden" id="ai1ec_ticket_sale_start_date"
                                                   name="ticket_sale_start_date"
                                                   class="ai1ec-tickets-full-date"
                                                <?php
                                                if ( isset( $ticket->ticket_sale_start_date ) ) {
                                                    echo 'value="' . esc_attr( $ticket->ticket_sale_start_date ) . '"';
                                                } else {
                                                    echo 'value="' . str_replace('T', ' ', $start->format_to_javascript( true ) ) . '"';
                                                } ?>
                                                >
                                        </div>
                                        <div class="ai1ec-tickets-dates-block">
                                            <label><?php _e( 'Till:', AI1EC_PLUGIN_NAME ); ?></label>
                                            <input type="text" class="ai1ec-form-control ai1ec-tickets-datepicker"
                                                   data-date-format="yyyy-mm-dd" size="12" />
                                            <input type="text" class="ai1ec-form-control ai1ec-tickets-time"
                                                   value="00:00" size="5" maxlength="5" /><br>
                                            <input type="hidden" id="ai1ec_ticket_sale_end_date"
                                                   name="ticket_sale_end_date"
                                                   class="ai1ec-tickets-full-date"
                                                <?php
                                                if ( isset( $ticket->ticket_sale_end_date ) ){
                                                    echo 'value="' . esc_attr( $ticket->ticket_sale_end_date ) . '"';
                                                } else {
                                                    echo 'value="' . str_replace('T', ' ', $end->format_to_javascript( true ) ) . '"';
                                                } ?>
                                                >
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php _e( 'Status:', AI1EC_PLUGIN_NAME ); ?></td>
                            <td>
                                <table><tr>
                                    <td>
                                        <select class="ai1ec-form-control ai1ec-select2"
                                            id="ai1ec_new_ticket_status"
                                            name="ticket_status">
                                            <option value="open" <?php if ( isset( $ticket->ticket_status )
                                                    && 'open' === $ticket->ticket_status ){echo 'selected';}?>>
                                                <?php _e( 'Open for sale', AI1EC_PLUGIN_NAME ); ?>
                                            </option>
                                            <?php if ( isset( $ticket->id ) ):?>
                                                <option value="closed" <?php if ( isset( $ticket->ticket_status )
                                                        && 'closed' === $ticket->ticket_status ){echo 'selected';}?>>
                                                    <?php _e( 'Sale ended', AI1EC_PLUGIN_NAME ); ?>
                                                </option>
                                                <option value="canceled" <?php if ( isset( $ticket->ticket_status )
                                                        && 'canceled' === $ticket->ticket_status ){echo 'selected';}?>>
                                                    <?php _e( 'Canceled', AI1EC_PLUGIN_NAME ); ?>
                                                </option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>
                                        <p id="ai1ec-ticket-status-message"></p>
                                    </td>
                                </tr></table>
                            </td>
                        </tr>
                        <?php if ( isset( $ticket->taken ) ) :?>
                            <tr>
                                <td><?php _e( 'Report:', AI1EC_PLUGIN_NAME ); ?></td>
                                <td>
                                    <?php echo sprintf(
                                        __( 'Sold: %d, Left: %s, Reserved: %d', AI1EC_PLUGIN_NAME ),
                                         $ticket->sold,
                                         ( is_null( $ticket->available ) ? __( 'Unlimited', AI1EC_PLUGIN_NAME ) :  $ticket->available ),
                                         ( $ticket->taken - $ticket->sold )
                                         );
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php $i++; endforeach; ?>

            <div id="ai1ec-ticket-forms"></div>
            <div class="ai1ec-tickets-form">
                <a href="#" class="ai1ec-btn ai1ec-btn-primary"
                   id="ai1ec_add_new_ticket">
                    <i class="ai1ec-fa ai1ec-fa-plus"></i>
                    <?php _e( 'Add New Ticket Type', AI1EC_PLUGIN_NAME ); ?>
                </a>&nbsp;

                <a href="#" class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-warning
                    <?php echo 1 < count( $tickets ) ? 'ai1ec-hidden' : ''?>"
                   id="ai1ec_tax_options">
                    <i class="ai1ec-fa ai1ec-fa-gears"></i>
                    <div class="ai1ec-ticket-field-error ai1ec-tax-options-button">
                        <?php _e( 'This field is required.', AI1EC_PLUGIN_NAME ); ?>
                    </div>
                    <?php _e( 'Add Tax &amp; Invoice Options (required)', AI1EC_PLUGIN_NAME ); ?>
                </a>
                <a href="#" class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-warning
                    <?php echo 1 < count( $tickets ) ? '' : 'ai1ec-hidden'?>"
                   id="ai1ec_update_tax_options">
                    <i class="ai1ec-fa ai1ec-fa-gears"></i>
                    <?php _e( 'Update Tax &amp; Invoice Options', AI1EC_PLUGIN_NAME ); ?>
                </a><br />

                <label>
                    <div class="ai1ec-ticket-field-error">
                        <?php _e( 'This field is required.', AI1EC_PLUGIN_NAME ); ?>
                    </div>
                     <input type="checkbox" name="ai1ec_accepted_terms" class="ai1ec-required" value="1" <?php echo 1 < count( $tickets ) ? 'checked' : ''?> />
                    <?php _e( 'I read and accept the <a href="https://time.ly/tos" target="_blank">terms of service</a>.', AI1EC_PLUGIN_NAME ); ?>
                </label>
                <div id="ai1ec_tax_box" class="ai1ec-modal ai1ec-fade">
                    <div class="ai1ec-modal-dialog">
                        <div class="ai1ec-modal-body ai1ec-text-center">
                            <div class="ai1ec-modal-content">
                                <div class="ai1ec-loading">
                                    <i class="ai1ec-fa ai1ec-fa-spinner ai1ec-fa-spin ai1ec-fa-3x"></i>
                                </div>
                                <iframe id="ai1ec_tax_frame" width="100%" height="600" class="ai1ec-hidden"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ai1ec_tax_inputs">
                </div>
            </div>
        <?php endif; ?>

        <div class="ai1ec-no-tickets">
            <table class="ai1ec-form">
                <tbody>
                    <tr>
                        <td class="ai1ec-first">
                            <label for="ai1ec_is_free">
                                <input type="checkbox"
                                       id="ai1ec_is_free"
                                       name="ai1ec_is_free"
                                       value="1"
                                       <?php echo $is_free; ?>>
                                <?php _e( 'Free Event', AI1EC_PLUGIN_NAME ); ?>
                            </label>
                        </td>
                        <td class="ai1ec-tickets-cost
                                   <?php if ( ! empty( $is_free ) ) { echo 'ai1ec-hidden'; }?>">
                            <label for="ai1ec_ticket_ext_cost">
                            <?php _e( 'Cost:', AI1EC_PLUGIN_NAME ); ?>
                                <input class="ai1ec-form-control"
                                       id="ai1ec_ticket_ext_cost"
                                       name="ai1ec_cost"
                                       value="<?php echo esc_attr( $cost ); ?>">
                            </label>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="ai1ec-tickets-external">
            <table class="ai1ec-form">
                <tbody>
                    <tr>
                        <td class="ai1ec-first">
                            <span class="ai1ec-tickets-url-text
                                        <?php if ( ! empty( $is_free ) ) { echo 'ai1ec-hidden'; }?>">
                                <?php _e( 'Tickets URL:', AI1EC_PLUGIN_NAME ); ?>
                            </span>
                            <span class="ai1ec-register-url-text
                                        <?php if ( empty( $is_free ) ) { echo 'ai1ec-hidden'; }?>">
                                <?php _e( 'Registration URL:', AI1EC_PLUGIN_NAME ); ?>
                            </span>
                        </td>
                        <td>
                            <input class="ai1ec-form-control"
                                   id="ai1ec_ticket_ext_url"
                                   name="ai1ec_ticket_url"
                                   value="<?php echo esc_attr( $ticket_url ); ?>"
                                   placeholder="http://">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
    </div>
</div>
