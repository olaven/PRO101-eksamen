
<html>
    <head>
        <!--Definerer at dette er head i wordpress-->
        <?php wp_head(); ?>
    </head>
    <body>
        <?php get_header(); ?>
        <main>
            <?php get_template_part('template-parts/widget-areas/map-widget-area');?>
            <!-- posts -> oppdateringer fra skolen --> 
            <?php get_template_part('template-parts/post-viewer');?>
            <?php get_template_part('template-parts/footer');?>
        </main>
    </body>
</html>

