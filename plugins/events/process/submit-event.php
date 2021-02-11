<?php

function r_submit_event(){
  $output                         = [ 'status' => 1 ];

  if( empty($_POST['title']) ){
    wp_send_json( $output );
  }

  global $wpdb;
  $title                          =   sanitize_text_field( $_POST['title'] );
  $content                        =   wp_kses_post( $_POST['content'] );
  $event_data                    =   [];
  $event_data['rating']          =   0;
  $event_data['rating_count']    =   0;

  $post_id                        =   wp_insert_post([
    'post_content'                =>  $content,
    'post_name'                   =>  $title,
    'post_title'                  =>  $title,
    'post_status'                 =>  'pending',
    'post_type'                   =>  'event'
  ]);

  update_post_meta( $post_id, 'event_data', $event_data );

  $output['status']               =   2;
  wp_send_json($output);
}