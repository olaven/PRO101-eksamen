<div class="timely">
    <ul class="ai1ec-nav ai1ec-nav-tabs">
        <?php $calendar_feeds->render_tab_headers() ?>
        <li class="timely-saas">
            <a href="#facebook" data-toggle="ai1ec-tab">Facebook</a>
        </li>
        <li class="timely-saas">
            <a href="#how_to" data-toggle="ai1ec-tab">How To</a>
        </li>
    </ul>
    <div class="ai1ec-tab-content">
        <?php $calendar_feeds->render_tab_contents() ?>
        <div class="ai1ec-feeds-facebook ai1ec-tab-pane timely-saas" id="facebook">
            <b>Importing from Facebook pages is only available on our web-application calendars:
            <a href="https://time.ly/pricing/">https://time.ly/pricing/</a></b>
            <br><br>
        
            <ul>
                <div>Importing events from any Facebook page in 3 simple steps:</div>
                <li>Find the page you want to import from</li>
                <li>Copy the page URL</li>
                <li>Add to your Timely calendar</li>
            </ul>
        
            Once imported, syncing will be refreshed every hour.<br>
            Watch <a href="https://www.youtube.com/watch?v=J1VFjb_qC8Y">1 min video here</a>. 
            <br><br>
            1. Finding Events
            <div id="ai1ec-import-fb1" class="calendar-samples"></div>
            2. Copying page URL
            <div id="ai1ec-import-fb2" class="calendar-samples"></div>
            3. Adding to your Timely calendar
            <div id="ai1ec-import-fb3" class="calendar-samples"></div>
            
            <br><br>
            To import events from a Facebook Group:
            <div id="ai1ec-import-fb4" class="calendar-samples"></div>
        </div>
        <div class="ai1ec-feeds-howto ai1ec-tab-pane timely-saas" id="how_to">
            There are different ways to sync events depending on the source calendar provider. All of them require you to get their ‘ICS’ (international calendar standard) feed. <br><br>
            
            <ul>
                <div>Look for a button on their calendar with any of the following buttons:</div>
                <li>ICS</li>
                <li>iCal</li>
                <li>Subscribe</li>
                <li>Feed</li>
                <li>Export</li>
            </ul>
            <br>
            Often you need to click to get the ‘Copy Link Address’. Once you have the ICS feed, you can paste it into your Timely calendar Import Feeds section.
            <br><br>
            Specific documentation & videos for each major source calendar provider are found <a href="https://time.ly/document/user-guide/using-calendar/sourcing-pulling-in-local-feeds/">here</a>
            <br><br>
            Approximately 1 in 10 website calendars can export a feed. For those that don’t, you can ask to get their own Timely calendar <a href="https://time.ly/pricing/">https://time.ly/pricing/</a> which you will be able to pull/sync events from.
            <br><br>
            You can also do a web search for calendars, ie:<br>
            “Music” & “Toronto” & “Timely calendar”
            <br><br>
            The <a href="https://time.ly/hub/">Timely Hub</a> calendar allows you to search for local Timely calendars and add their events directly via your own dashboard. We call this EventDiscovery.
            <div id="ai1ec-import-howto" class="calendar-samples"></div>
        </div>
    </div>
</div>

