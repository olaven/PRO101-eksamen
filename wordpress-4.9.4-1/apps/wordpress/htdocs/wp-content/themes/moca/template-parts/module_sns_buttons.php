<ul class="sns_buttons">
  <li class="sns_button_item twitter">
    <a href="https://twitter.com/home?status=<?php echo esc_attr( get_the_title() ); ?>%20-%20<?php echo urlencode( the_permalink() ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
  </li>
  <li class="sns_button_item facebook">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
  </li>
</ul>
