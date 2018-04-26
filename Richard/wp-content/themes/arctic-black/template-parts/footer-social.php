<?php
/**
 * Menu Social
 *
 * @package Arctic Black
 */

if ( has_nav_menu ( 'menu-2' ) ) : ?>
	<div class="social-links">
	<?php wp_nav_menu( array(
		'theme_location' 	=> 'menu-2',
		'depth' 			=> 1,
		'link_before' 		=> '<span class="screen-reader-text">',
		'link_after' 		=> '</span>',
		'container_class' 	=> 'wrap',
	) ); ?>
	</div>
<?php endif; ?>
