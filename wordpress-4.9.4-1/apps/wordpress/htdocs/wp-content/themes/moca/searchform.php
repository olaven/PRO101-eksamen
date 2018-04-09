<?php $unique_id = esc_attr( uniqid( 'search_form_' ) ); ?>

<div class="search_form_wrap">
  <form role="search" method="get" class="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  	<input type="search" id="<?php echo $unique_id; ?>" class="search_field" placeholder="<?php _e( 'Search...', 'moca' ) ?>" value="<?php echo get_search_query(); ?>" name="s" />
  	<button type="submit" class="search_submit"><i class="fa fa-search" aria-hidden="true"></i></button>
  </form>
</div><!-- /.search_form_wrap -->
