<?php if( is_active_sidebar( 'side-widget-area1' ) || is_active_sidebar( 'side-widget-area2' ) || is_active_sidebar( 'side-widget-area3' ) ){ ?>
<div class="sub">
  <?php
    if( is_active_sidebar( 'side-widget-area1' ) ){
      dynamic_sidebar( 'side-widget-area1' );
    }
    if( is_active_sidebar( 'side-widget-area2' ) ){
      dynamic_sidebar( 'side-widget-area2' );
    }
    if( is_active_sidebar( 'side-widget-area3' ) ){
      dynamic_sidebar( 'side-widget-area3' );
    }
  ?>
</div><!-- /.sub -->
<?php } ?>
