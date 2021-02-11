<?php

function r_recipe_auth_form_shortcode(){
  if( is_user_logged_in() ){
    return '';
  }

  $formHTML               = file_get_contents( 'auth-form-template.php', true );

  $formHTML               = str_replace( 
    'NONCE_FIELD_PH', 
    wp_nonce_field( 'recipe_auth', '_wpnonce', true, false ),
    $formHTML
  );
  $formHTML               = str_replace(
    'SHOW_REG_FORM',
    ( !get_option('users_can_register') ? 'style="display:none;"' : ''),
    $formHTML
  );

  return $formHTML;
}