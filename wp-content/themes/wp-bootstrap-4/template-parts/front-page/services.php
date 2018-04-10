<?php
$featured_page_1_id = get_theme_mod( 'featured_page_1' );
$featured_page_2_id = get_theme_mod( 'featured_page_2' );
$featured_page_3_id = get_theme_mod( 'featured_page_3' );

$featured_page_1 = get_post( $featured_page_1_id );
$featured_page_2 = get_post( $featured_page_2_id );
$featured_page_3 = get_post( $featured_page_3_id );
?>

<?php if ( ( $featured_page_1_id && $featured_page_1 && $featured_page_1->post_status === 'publish' ) ||
            ( $featured_page_2_id && $featured_page_2 && $featured_page_2->post_status === 'publish' ) ||
            ( $featured_page_3_id && $featured_page_3 && $featured_page_3->post_status === 'publish' ) ) : ?>
    <section class="wp-bp-services-section bg-white">
        <div class="container">
            <div class="row">
                <?php if ( $featured_page_1_id && $featured_page_1 && $featured_page_1->post_status === 'publish' ) : ?>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card">
                            <?php echo get_the_post_thumbnail( $featured_page_1, 'medium', array( 'class' => 'card-img-top wp-bp-feat-card-img' ) ); ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html( $featured_page_1->post_title ); ?></h5>
                                <p class="card-text">
                                    <?php echo esc_html( wp_bootstrap_4_get_short_excerpt( 20, $featured_page_1 ) ); ?>
                                </p>
                                <a href="<?php echo esc_url( get_post_permalink( $featured_page_1 ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Read More', 'wp-bootstrap-4' ); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $featured_page_2_id && $featured_page_2 && $featured_page_2->post_status === 'publish' ) : ?>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card">
                            <?php echo get_the_post_thumbnail( $featured_page_2, 'medium', array( 'class' => 'card-img-top wp-bp-feat-card-img' ) ); ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html( $featured_page_2->post_title ); ?></h5>
                                <p class="card-text">
                                    <?php echo esc_html( wp_bootstrap_4_get_short_excerpt( 20, $featured_page_2 ) ); ?>
                                </p>
                                <a href="<?php echo esc_url( get_post_permalink( $featured_page_2 ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Read More', 'wp-bootstrap-4' ); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $featured_page_3_id && $featured_page_3 && $featured_page_3->post_status === 'publish' ) : ?>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card">
                            <?php echo get_the_post_thumbnail( $featured_page_3, 'medium', array( 'class' => 'card-img-top wp-bp-feat-card-img' ) ); ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc_html( $featured_page_3->post_title ); ?></h5>
                                <p class="card-text">
                                    <?php echo esc_html( wp_bootstrap_4_get_short_excerpt( 20, $featured_page_3 ) ); ?>
                                </p>
                                <a href="<?php echo esc_url( get_post_permalink( $featured_page_3 ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Read More', 'wp-bootstrap-4' ); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
