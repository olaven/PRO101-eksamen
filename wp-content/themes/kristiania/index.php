
<html>
    <head>
        <!--Definerer at dette er head i wordpress-->
        <?php wp_head(); ?>
        <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
    </head>
    <body>
        <?php get_header(); ?>
        <main>
            <?php
                //posts -> oppdateringer fra skolen
                get_template_part('template-parts/post-viewer'); 
            ?>
        </main>
    </body>
</html>

