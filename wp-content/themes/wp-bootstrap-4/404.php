<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_4
 */

get_header(); ?>

<?php
	$default_sidebar_position = get_theme_mod( 'default_sidebar_position', 'right' );
?>

	<div class="container">
		<div class="row">

			<?php if ( $default_sidebar_position === 'no' ) : ?>
				<div class="col-md-12 wp-bp-content-width">
			<?php else : ?>
				<div class="col-md-8 wp-bp-content-width">
			<?php endif; ?>

				<div id="primary" class="content-area wp-bp-404">
					<main id="main" class="site-main">

						<div class="card mt-3r">
							<div class="card-body">
								<section class="error-404 not-found">
									<header class="page-header">
										<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wp-bootstrap-4' ); ?></h1>
									</header><!-- .page-header -->

									<div class="page-content">
										<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wp-bootstrap-4' ); ?></p>

										<?php
											get_search_form();

											the_widget( 'WP_Widget_Recent_Posts', array(), array(
												'before_title' => '<h5 class="widget-title mt-4">',
												'after_title'  => '</h5>',
											) );
										?>

										<div class="widget widget_categories">
											<h5 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'wp-bootstrap-4' ); ?></h5>
											<ul>
											<?php
												wp_list_categories( array(
													'orderby'    => 'count',
													'order'      => 'DESC',
													'show_count' => 1,
													'title_li'   => '',
													'number'     => 10,
												) );
											?>
											</ul>
										</div><!-- .widget -->

										<?php

											the_widget( 'WP_Widget_Archives', 'dropdown=1', array(
												'before_title' => '<h5 class="widget-title">',
												'after_title'  => '</h5>',
											) );

											the_widget( 'WP_Widget_Tag_Cloud', array(), array(
												'before_title' => '<h5 class="widget-title">',
												'after_title'  => '</h5>',
											) );
										?>

									</div><!-- .page-content -->
								</section><!-- .error-404 -->
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->

					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
			<!-- /.col-md-8 -->

			<?php if ( $default_sidebar_position != 'no' ) : ?>
				<?php if ( $default_sidebar_position === 'right' ) : ?>
					<div class="col-md-4 wp-bp-sidebar-width">
				<?php elseif ( $default_sidebar_position === 'left' ) : ?>
					<div class="col-md-4 order-md-first wp-bp-sidebar-width">
				<?php endif; ?>
						<?php get_sidebar(); ?>
					</div>
					<!-- /.col-md-4 -->
			<?php endif; ?>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->
<?php
get_footer();
