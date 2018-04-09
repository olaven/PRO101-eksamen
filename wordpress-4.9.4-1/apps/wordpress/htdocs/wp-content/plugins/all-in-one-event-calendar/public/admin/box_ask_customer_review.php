<!-- First question that appears to the user -->
<div class="timely ai1ec-alert ai1ec-alert-highlight ai1ec_review_modal">
    <div class="ai1ec-row">
        <div class="ai1ec-col-xs-12 ai1ec-text-center">
            <?php _e( 'Enjoying All-in-One Event Calendar?', AI1EC_PLUGIN_NAME ); ?>
        </div>
    </div>
    <div class="ai1ec-row" style="padding-top: 15px!important">
        <div class="ai1ec-col-xs-6 ai1ec-text-center">
            <button type="button" name="ai1ec_review_not_enjoying" id="ai1ec_review_not_enjoying"
                    class="ai1ec-btn ai1ec-btn-default-highlight ai1ec-btn-lg ai1ec-btn-block"
                    data-toggle="ai1ec-modal" data-target="#ai1ec_review_not_enjoying_question">
                <?php _e( 'Not really', AI1EC_PLUGIN_NAME ); ?>
            </button>
        </div>
        <div class="ai1ec-col-xs-6 ai1ec-text-center">
            <button type="button" name="ai1ec_review_enjoying" id="ai1ec_review_enjoying"
                    class="ai1ec-btn ai1ec-btn-primary-highlight ai1ec-btn-lg ai1ec-btn-block"
                    data-toggle="ai1ec-modal" data-target="#ai1ec_review_enjoying_question">
                <?php _e( 'Yes!', AI1EC_PLUGIN_NAME ); ?>
            </button>
        </div>
    </div>
</div>

<!-- Questions that pops up is the user is enjoying our plugin -->
<div id="ai1ec_review_enjoying_question" class="timely ai1ec-modal ai1ec_review_modal">
    <div class="ai1ec-modal-dialog">

        <div class="timely ai1ec-alert ai1ec-alert-highlight">
            <div class="ai1ec-row">
                <div class="ai1ec-col-xs-12 ai1ec-text-center">
                    <?php _e( 'Please rate our FREE calendar with 5 stars to help keeping it in Wordpress.org.', AI1EC_PLUGIN_NAME ); ?><br/>
                    <h6><?php _e( 'Thanks from the hard working fellas at Time.ly.', AI1EC_PLUGIN_NAME ) ?></h6>
                </div>
            </div>
            <div class="ai1ec-row" style="padding-top: 15px!important">
                <div class="ai1ec-col-xs-6 ai1ec-text-center">
                    <button type="button"
                        class="ai1ec-btn ai1ec-btn-default-highlight ai1ec-btn-lg
                               ai1ec-btn-block ai1ec_review_enjoying_no_rating"
                        data-dismiss="ai1ec-modal">
                        <?php _e( 'No, thanks', AI1EC_PLUGIN_NAME ); ?>
                    </button>
                </div>
                <div class="ai1ec-col-xs-6 ai1ec-text-center">
                    <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/all-in-one-event-calendar?filter=5#postform"
                        class="ai1ec-btn ai1ec-btn-primary-highlight ai1ec-btn-lg ai1ec-btn-block
                               ai1ec_review_enjoying_go_wordpress"
                        role="button">
                        <?php _e( 'Ok, sure!', AI1EC_PLUGIN_NAME ); ?>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Questions that pops up is the user is not enjoying our plugin -->
<div id="ai1ec_review_not_enjoying_question" class="timely ai1ec-modal ai1ec_review_modal">
    <div class="ai1ec-modal-dialog">

        <div class="timely ai1ec-alert ai1ec-alert-highlight">
            <div class="ai1ec-row">
                <div class="ai1ec-col-xs-12 ai1ec-text-center">
                    <?php _e( 'Would you please give us some feedback on how can we improve?', AI1EC_PLUGIN_NAME ); ?>
                </div>
            </div>
            <div class="ai1ec-row" style="padding-top: 15px!important">
                <div class="ai1ec-col-xs-6 ai1ec-text-center">
                    <button type="button"
                            class="ai1ec-btn ai1ec-btn-default-highlight ai1ec-btn-lg ai1ec-btn-block
                                   ai1ec_review_not_enjoying_no_rating"
                            data-dismiss="ai1ec-modal">
                        <?php _e( 'No, thanks', AI1EC_PLUGIN_NAME ); ?>
                    </button>
                </div>
                <div class="ai1ec-col-xs-6 ai1ec-text-center">
                    <button type="button"
                        class="ai1ec-btn ai1ec-btn-primary-highlight ai1ec-btn-lg
                               ai1ec-btn-block ai1ec_review_not_enjoying_rating"
                        data-dismiss="ai1ec-modal"
                        data-toggle="ai1ec-modal" data-target="#ai1ec_not_enjoying_popup">
                        <?php _e( 'Ok, sure!', AI1EC_PLUGIN_NAME ); ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Popup form to ask the User's feedback -->
<div id="ai1ec_not_enjoying_popup"
     class="timely ai1ec-modal ai1ec-fade ai1ec-in ai1ec_review_modal ai1ec_not_enjoying_popup"
     role="dialog" aria-hidden="true">
    <div class="ai1ec-modal-dialog">
        <div class="ai1ec-modal-content">
            <div class="ai1ec-modal-header">
                <button type="button" class="ai1ec-close" data-dismiss="ai1ec-modal" aria-hidden="true">×</button>
                <strong><?php _e( 'Please provide some feedback' );?></strong>
            </div>
            <div class="ai1ec-modal-body ai1ec-clearfix ai1ec-review-form">
                <table class="ai1ec-form">
                    <tbody>
                        <tr>
                            <td>
                                <label for="ai1ec_review_negative_feedback"><?php _e( 'Message:' ); ?></label>
                            </td>
                            <td>
                                <div class="ai1ec-text-error ai1ec-required-message">
                                    <?php _e( 'This field is required.' ); ?>
                                </div>
                                <textarea name="ai1ec_review_negative_feedback"
                                          class="ai1ec-form-control code ai1ec_review_negative_feedback"
                                          rows="4" cols="30"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="ai1ec-first">
                                <label for="ai1ec_review_contact_name"><?php _e( 'Name:' ); ?>
                                </label>
                            </td>
                            <td>
                                <div class="ai1ec-text-error ai1ec-required-message">
                                    <?php _e( 'This field is required.' ); ?>
                                </div>
                                <input type="text" name="ai1ec_review_contact_name"
                                       class="ai1ec-form-control ai1ec_review_contact_name"
                                       value="<?php echo $contact_name; ?>">
                                </input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ai1ec_review_contact_email"><?php _e( 'E-mail:' ); ?></label>
                            </td>
                            <td>
                                <div class="ai1ec-text-error ai1ec-required-message">
                                    <?php _e( 'This field is required.' ); ?>
                                </div>
                                <div class="ai1ec-text-error ai1ec-invalid-email-message">
                                    <?php _e( 'E-mail is invalid.' ); ?>
                                </div>
                                <input type="text" name="ai1ec_review_contact_email"
                                       class="ai1ec-form-control ai1ec_review_contact_email"
                                       value="<?php echo $contact_email; ?>">
                                </input>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="ai1ec_review_site_url"><?php _e( 'Site URL:' ); ?></label>
                            </td>
                            <td>
                                <div class="ai1ec-text-error ai1ec-required-message">
                                    <?php _e( 'This field is required.' ); ?>
                                </div>
                                <div class="ai1ec-text-error ai1ec-invalid-site-message">
                                    <?php _e( 'Site URL is invalid.' ); ?>
                                </div>
                                <input type="text" name="ai1ec_review_site_url"
                                       class="ai1ec-form-control ai1ec_review_site_url"
                                       value="<?php echo $site_url; ?>">
                                </input>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="text-align: right">
                    <br/>
                    <?php _e( 'Thank you for being our customer,' ); ?><br/>
                    <?php _e( 'Time.ly team' ); ?><br/>
                    <?php _e( 'info@time.ly' ); ?>
                </p>
            </div>
             <div class="ai1ec-modal-footer ai1ec-clearfix">
                <button type="button" class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-sm ai1ec_review_send_feedback"
                    data-loading-text="<?php echo esc_attr('<i class="ai1ec-fa ai1ec-fa-spinner ai1ec-fa-fw ai1ec-fa-spin"></i> '
                        . __( 'Sending...', AI1EC_PLUGIN_NAME ) ); ?>">
                    <?php _e( 'Send Message', AI1EC_PLUGIN_NAME ); ?>
                </button>
            </div>
        </div>
    </div>
</div>
