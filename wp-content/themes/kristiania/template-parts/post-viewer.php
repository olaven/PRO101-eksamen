<h1>Oppdateringer fra skolen: </h1>

<!--The Loop: https://codex.wordpress.org/The_Loop-->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article>
        <h2><?php the_title() ?></h2>
        <i><?php the_author() ?></i> - <b><?php the_date() ?></b>
        <p><?php the_content() ?></p>
    </article>
<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Ingen oppdateringer fra skolen..' ); ?></p>
<?php endif; ?>