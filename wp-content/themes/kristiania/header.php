<!DOCTYPE html> 
<html <?php language_attributes(); ?>>
    <head>
        <!--metagreier-->
        <meta charset=" <?php bloginfo('charset'); ?>">
        <meta  name="viewport" content="width=device-width">
        <!--stylesheets-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <title> <?php bloginfo('name'); ?> </title>
        <?php wp_head() ?> 
    </head>
    <body>
        <header class="header">
            <h1><?php bloginfo('name') ?></h1>
            <h2><?php bloginfo('description') ?></h2>
            <p>hei</p>
        </header>
