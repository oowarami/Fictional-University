<?php

function ju_new_nav_menu_items( $items ){
  if( !is_user_logged_in() ){
    return $items;
  }

  $new_link           = "<li>" . wp_loginout( home_url( '/' ), false ) . "</li>";
  return $items . $new_link;
}