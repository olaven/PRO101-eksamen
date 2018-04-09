<div class="ai1ec-clearfix">
	<div class="ai1ec-brought-by">Your calendar is brought to you by:</div>
    <h2 class="timely-logo">
        <a href="https://time.ly/?utm_source=dashboard&nbsp;utm_medium=button&nbsp;utm_term=ai1ec-pro&nbsp;utm_content=1.11.4&nbsp;utm_campaign=logo"
            title="<?php esc_attr_e( 'Timely', AI1EC_PLUGIN_NAME ); ?>"
            target="_blank">
        </a>
    </h2>

    <div class="timely-intro">
        <h2>
            <?php _e( 'Timely’s All-in-One Event Calendar is a<br />revolutionary new way to find and share events.', AI1EC_PLUGIN_NAME ); ?>
        </h2>
        <div class="ai1ec-support-buttons ai1ec-row">
            <div class="ai1ec-col-lg-3" id="ai1ec-addons-col">
                <a class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-block"
                    target="_blank"
                    href="https://time.ly/document/user-guide/">
                    <i class="ai1ec-fa ai1ec-fa-book ai1ec-fa-fw"></i>
                    <?php _e( 'Guide', AI1EC_PLUGIN_NAME ); ?>
                </a>
            </div>
            <div class="ai1ec-col-lg-3" id="ai1ec-support-col">
                <a class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-block"
                    target="_blank"
                    href="#" onclick="jQuery('.ai1ec-support-tab').show(); jQuery('.ai1ec-news').hide(); return !1;">
                    <i class="ai1ec-fa ai1ec-fa-comments ai1ec-fa-fw"></i>
                    <?php _e( 'Support', AI1EC_PLUGIN_NAME ); ?>
                </a>
            </div>
            <div class="ai1ec-col-lg-3" id="ai1ec-videos-col">
                <a class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-block"
                    target="_blank"
                    href="https://www.youtube.com/playlist?list=PL0BLCDSrRmI5RJ1Pg4IPQScQQHShQzVn8">
                    <i class="ai1ec-fa ai1ec-fa-film ai1ec-fa-fw"></i>
                    <?php _e( 'Videos', AI1EC_PLUGIN_NAME ); ?>
                </a>
            </div>
            <div class="ai1ec-col-lg-3" id="ai1ec-events-col">
                <a class="ai1ec-btn ai1ec-btn-info ai1ec-btn-block"
                    target="_blank"
                    href="https://time.ly/wordpress-calendar-plugin/addons/">
                    <i class="ai1ec-fa ai1ec-fa-magic ai1ec-fa-fw"></i>
                    <?php _e( 'More Features', AI1EC_PLUGIN_NAME ); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="ai1ec-news">
        <h2>
            <i class="ai1ec-fa ai1ec-fa-bullhorn"></i>
            <?php _e( 'Timely News', AI1EC_PLUGIN_NAME ); ?>
            <small>
                <a href="https://time.ly/blog?utm_source=dashboard&nbsp;utm_medium=blog&nbsp;utm_term=ai1ec-pro&nbsp;utm_content=1.11.4&nbsp;utm_campaign=news"
                    target="_blank">
                    <?php _e( 'view all news', AI1EC_PLUGIN_NAME ); ?>
                    <i class="ai1ec-fa ai1ec-fa-arrow-right"></i>
                </a>
            </small>
        </h2>
        <div>
        <?php if ( count( $news ) > 0 ) : ?>
            <?php foreach ( $news as $n ) :
                $ga_args = array(
                    'utm_source'   => 'dashboard',
                    'utm_medium'   => 'blog',
                    'utm_campaign' => 'news',
                    'utm_term'     => urlencode(
                        strtolower( substr( $n->get_title(), 0, 40 ) )
                    ),
                );
                $href = esc_attr( add_query_arg( $ga_args, $n->get_permalink() ) );
                $desc = preg_replace( '/\s+?(\S+)?$/', '', $n->get_description() );
                $desc = wp_trim_words(
                    $desc,
                    40,
                    ' <a href="' . $href . '" target="_blank">[&hellip;]</a>'
                );
                ?>
                <article>
                    <header>
                        <h4>
                            <a href="<?php echo $href; ?>" target="_blank">
                                <?php echo $n->get_title(); ?>
                            </a>
                        </h4>
                    </header>
                    <p><?php echo $desc; ?></p>
                </article>
            <?php endforeach; ?>
        <?php else : ?>
            <p><em>No news available.</em></p>
        <?php endif; ?>
        </div>
    </div>

	<div class="ai1ec-support-tab">
		Seems like you’re having troubles, and we don’t like that. Here’s how we can work together to get your issues fixed.
		<br><br>
		
		<ol>
		<li><b>Do you have a theme or plugin conflict? </b><br>
		First Troubleshooting step click <a target="_blank" href="https://time.ly/document/user-guide/troubleshooting/first-troubleshooting-step/">here</a><br><br>
		
		Note: If the error is being caused by something in your environment (ie. hosting, theme or plugin conflict) - choosing any of our web-application calendars should solve it: <a target="_blank" href="https://time.ly/pricing/">https://time.ly/pricing/</a><br><br>
		
		
		
		<li><b>To submit a support ticket:</b><br>
		Please log into your Timely account and raise a ticket using the “get help” button <a target="_blank" href="https://dashboard.time.ly/account/get-help">https://dashboard.time.ly/account/get-help</a> <br><br>
		
		Please note the response times for free core users can be up to 3 days as we have prioritized support for our paid users depending on the plan. If you require a higher level of support we encourage you to look into one of our web-application calendar plans at <a target="_blank" href="https://time.ly/pricing/">https://time.ly/pricing/</a>
		
		
		
		<li><b>Feature Request</b><br>
		If there is a feature that we don’t currently provide that would make your life better, please share your idea here: <a target="_blank" href="https://ideas.time.ly/">https://ideas.time.ly/</a><br><br>
		
		For more details on how we provide support please go to <a target="_blank" href="http://time.ly/support">http://time.ly/support</a><br><br><br>
		

	</div>

    <div class="ai1ec-follow-fan">
        <div class="ai1ec-facebook-like-top">
            <script src="//connect.facebook.net/en_US/all.js#xfbml=1"></script>
            <fb:like href="https://www.facebook.com/timelycal" layout="button_count"
                show_faces="true" width="110" font="lucida grande"></fb:like>
        </div>
        <a href="https://twitter.com/_Timely" class="twitter-follow-button">
            <?php _e( 'Follow @_Timely', AI1EC_PLUGIN_NAME ) ?>
        </a>
        <script src="//platform.twitter.com/widgets.js" type="text/javascript">
        </script>
    </div>
</div>
