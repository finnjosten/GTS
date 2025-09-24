<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <?php wp_head() ?>
    </head>
    
    <body <?php body_class('is-preload'); ?>>

        <?php wp_body_open(); ?>

        <div id="wrapper">
            
            <?php get_template_part( 'snippets/header/header', "primary" ); ?>
