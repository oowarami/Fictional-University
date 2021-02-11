<?php

function r_save_options(){
  if( !current_user_can( 'edit_theme_options' ) ){
    wp_die( __( 'You are not allowed to be on this page.', 'recipe' ) );
  }

  check_admin_referer( 'r_options_verify' );

  $recipe_opts                                      =   get_option( 'r_opts' );
  $recipe_opts['rating_login_required']             =   absint($_POST['r_rating_login_required']);
  $recipe_opts['recipe_submission_login_required']  =   absint($_POST['r_submission_login_required']);

  update_option( 'r_opts', $recipe_opts );
  wp_redirect( admin_url('admin.php?page=r_plugin_opts&status=1') );
}