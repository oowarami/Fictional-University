<?php

function recipe_admin_init(){
    include( 'columns.php' );

    add_filter( 'manage_recipe_posts_columns', 'r_add_new_recipe_columns' );
    add_action( 'manage_recipe_posts_custom_column', 'r_manage_recipe_columns', 10, 2 );
}