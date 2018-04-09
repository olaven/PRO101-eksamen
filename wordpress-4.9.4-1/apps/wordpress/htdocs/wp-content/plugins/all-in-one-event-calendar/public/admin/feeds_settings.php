<div class="wrap">

    <?php screen_icon(); ?>

    <h2><?php echo $title; ?></h2>

    <div id="poststuff">

            <div class="metabox-holder">
                <div class="post-box-container ai1ec-feeds-page left-side timely">
                    <?php do_meta_boxes( $settings_page, 'left', null ); ?>
                </div>
            </div>

    </div><!-- #poststuff -->

</div><!-- .wrap -->
