<article class="entry">
  <div class="sec_thumb">
    <?php if( has_post_thumbnail() ){
      the_post_thumbnail( 'moca_thumb_image' );
    } else {
      echo '<div class="no_image"></div>';
    } ?>
    <div class="post_meta">
      <p class="post_posted"><time datetime="<?php the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time></p>
      <div class="post_cat_wrap">
        <p class="post_cats"><?php the_category(','); ?><?php the_tags('', ', '); ?></p>
      </div>
    </div>
    <div class="thumb_layer"><a href="<?php the_permalink(); ?>"></a></div>
  </div>
  <div class="sec_body">
    <h2 class="sec_title"><a href="<?php the_permalink(); ?> "><?php the_title(); ?></a></h2>
  </div><!-- /.sec_body -->
</article>
