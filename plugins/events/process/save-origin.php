<?php

function r_save_origin_meta( $term_id ){
  if( !isset($_POST['r_more_info_url']) ){
    return;
  }

  update_term_meta( $term_id, 'more_info_url', esc_url($_POST['r_more_info_url']) );
}