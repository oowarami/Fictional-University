<?php

function r_enqueue_scripts(){
    wp_register_style( 'r_rateit', plugins_url( '/assets/rateit/rateit.css', EVENTS_PLUGIN_URL ) );
    wp_register_style( 'r_auth', plugins_url( '/assets/css/auth.css', EVENTS_PLUGIN_URL ) );

    wp_enqueue_style( 'r_rateit' );
    wp_enqueue_style( 'r_auth' );

    wp_register_script( 
        'r_rateit', 
        plugins_url( '/assets/rateit/jquery.rateit.min.js', EVENTS_PLUGIN_URL ), 
        ['jquery'], 
        '1.0.0', 
        true 
    );
    wp_register_script( 
        'r_main', plugins_url( '/assets/js/main.js', EVENTS_PLUGIN_URL ), ['jquery'], '1.0.0', true 
    );

    wp_localize_script( 'r_main', 'recipe_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' ),
        'home_url'      =>  home_url( '/' )
    ]);
    
    wp_enqueue_script( 'r_rateit' );
    wp_enqueue_script( 'r_main' );
}