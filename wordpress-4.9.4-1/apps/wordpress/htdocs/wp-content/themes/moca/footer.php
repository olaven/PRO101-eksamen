<div class="wrap">
	<footer class="footer" role="contentinfo">
		<button type="button" class="page_top_btn">&uarr;<span class="btn_txt"><?php _e( 'PageTop', 'moca' ) ?></span></button>
		<div class="footer_widget_wrap">
			<?php
				if( is_active_sidebar( 'footer-widget-area1' ) ){
					dynamic_sidebar( 'footer-widget-area1' );
				}
				if( is_active_sidebar( 'footer-widget-area2' ) ){
					dynamic_sidebar( 'footer-widget-area2' );
				}
				if( is_active_sidebar( 'footer-widget-area3' ) ){
					dynamic_sidebar( 'footer-widget-area3' );
				}
	 		?>
		</div><!-- /.footer_widget_wrap -->
	<div class="copy">
		<p><small class="copy_txt"><?php _e( 'Copyright', 'moca' ); ?> &copy; <?php echo esc_html( get_bloginfo('name') ); ?> <?php _e( 'All Right Reserved.', 'moca' ); ?></small></p>
		<p class="powered_txt">
			<?php _e( 'Powered by', 'moca' ); ?>
			<a href="https://wordpress.org/"><?php _e( 'WordPress', 'moca' ); ?></a>
			<?php _e( 'moca Theme by', 'moca' ); ?> <a href="https://memocarilog.info/" target="_blank"><?php _e( 'memocoarilog', 'moca' ); ?></a>
		</p>
	</div>
	</footer><!-- footer -->
</div><!-- /.wrap -->
<?php wp_footer(); ?>
</body>
</html>
