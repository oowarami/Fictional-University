<?php

function r_enqueue_block_editor_assets(){
    wp_register_script(
        'r_blocks_bundle',
        plugins_url( '/blocks/dist/bundle.js', EVENTS_PLUGIN_URL ),
        [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor', 'wp-api' ],
        filemtime( plugin_dir_path( EVENTS_PLUGIN_URL ) . '/blocks/dist/bundle.js' )
    );

    wp_enqueue_script( 'r_blocks_bundle' );
}

function r_enqueue_block_assets(){
    wp_register_style(
        'r_blocks',
        plugins_url( '/blocks/dist/blocks-main.css', EVENTS_PLUGIN_URL )
    );

    wp_enqueue_style( 'r_blocks' );
}

