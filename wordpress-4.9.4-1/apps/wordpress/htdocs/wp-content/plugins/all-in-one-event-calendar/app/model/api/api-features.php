<?php
class Ai1ec_Api_Features {

    const CODE_API_ACCESS           = 'api-access';
    const CODE_TICKETING            = 'ticketing';
    const CODE_TWITTER              = 'twitter';
    const CODE_FRONTEND_SUBMISSIONS = 'frontend-submissions';
    const CODE_CSV_IMPORT           = 'csv-import';
    const CODE_SUPER_WIDGET         = 'super-widget';
    const CODE_EXTENDED_VIEWS       = 'extended-views';
    const CODE_BIG_FILTERING        = 'big-filtering';
    const CODE_CUSTOM_FILTERS       = 'custom-filter-groups';
    const CODE_DISCOVER_EVENTS      = 'discover-events';
    const CODE_EVENT_PROMOTE        = 'event-promote';
    const CODE_FACEBOOK_INTEGRATION = 'facebook-integration';
    const CODE_FEATURED_EVENTS      = 'featured-events';
    const CODE_MAILCHIMP            = 'mailchimp';
    const CODE_PHRASE_OVERRIDE      = 'phrase-override';
    const CODE_POPOVERS             = 'popovers';
    const CODE_SAVE_AND_SHARE       = 'save-and-share';
    const CODE_VENUES               = 'venues';
    const CODE_IMPORT_FEEDS         = 'import-feeds';

    public static $features = array(
        self::CODE_API_ACCESS           => '',
        self::CODE_TICKETING            => '',
        self::CODE_TWITTER              => 'all-in-one-event-calendar-twitter-integration/all-in-one-event-calendar-twitter-integration.php',
        self::CODE_FRONTEND_SUBMISSIONS => 'all-in-one-event-calendar-frontend-submissions/all-in-one-event-calendar-frontend-submissions.php',
        self::CODE_CSV_IMPORT           => 'all-in-one-event-calendar-csv-feed/all-in-one-event-calendar-csv-feed.php',
        self::CODE_SUPER_WIDGET         => 'all-in-one-event-calendar-super-widget/all-in-one-event-calendar-super-widget.php',
        self::CODE_EXTENDED_VIEWS       => 'all-in-one-event-calendar-extended-views/all-in-one-event-calendar-extended-views.php',
        self::CODE_BIG_FILTERING        => 'all-in-one-event-calendar-big-filtering/all-in-one-event-calendar-big-filtering.php',
        self::CODE_CUSTOM_FILTERS       => 'all-in-one-event-calendar-custom-filter-groups/all-in-one-event-calendar-custom-filter-groups.php',
        self::CODE_DISCOVER_EVENTS      => '',
        self::CODE_EVENT_PROMOTE        => 'all-in-one-event-calendar-event-promote/all-in-one-event-calendar-event-promote.php',
        self::CODE_FACEBOOK_INTEGRATION => 'all-in-one-event-calendar-facebook-integration/all-in-one-event-calendar-facebook-integration.php',
        self::CODE_FEATURED_EVENTS      => 'all-in-one-event-calendar-featured-events/all-in-one-event-calendar-featured-events.php',
        self::CODE_MAILCHIMP            => 'all-in-one-event-calendar-mailchimp/all-in-one-event-calendar-mailchimp.php',
        self::CODE_PHRASE_OVERRIDE      => 'all-in-one-event-calendar-phrase-override/all-in-one-event-calendar-phrase-override.php',
        self::CODE_POPOVERS             => 'all-in-one-event-calendar-popovers/all-in-one-event-calendar-popovers.php',
        self::CODE_SAVE_AND_SHARE       => 'all-in-one-event-calendar-save-and-share/all-in-one-event-calendar-save-and-share.php',
        self::CODE_VENUES               => 'all-in-one-event-calendar-venue/all-in-one-event-calendar-venue.php',
        self::CODE_IMPORT_FEEDS         => '',
    );
}
