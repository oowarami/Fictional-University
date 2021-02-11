<?php

function r_recipe_auth_alt_form_shortcode(){
  if( is_user_logged_in() ){
    return '';
  }

  $formHTML           =   '<div class="col_one_third nobottommargin">';
  $errors             =   isset($_GET['login']) ? explode( ',', $_GET['login']) : [];

  foreach( $errors as $error ){
		if( $error === 'empty_username' ){
			$formHTML       .=  '<div class="alert alert-warning">Please enter an e-mail.</div>';
		}

		if( $error === 'empty_password' ){
			$formHTML       .=  '<div class="alert alert-warning">Please enter a password.</div>';
		}

		if( $error === 'invalid_username' ){
			$formHTML       .=  '<div class="alert alert-warning">Invalid username.</div>';
		}

		if( $error === 'incorrect_password' ){
			$formHTML       .=  '<div class="alert alert-warning">Incorrect Password</div>';
		}
	}

  $formHTML           .=  wp_login_form([
    'echo'            =>  false,
    'redirect'        =>  home_url( '/' )
  ]);

  $formHTML           .=  '</div>';

  return $formHTML;
}

function r_alt_authenticate( $user, $username, $password ){
  if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
    return $user;
  }

  if( !is_wp_error($user) ){
    return $user;
  }

  $error_codes          = join( ',', $user->get_error_codes() );
  $login_url            = home_url( 'my-account');
  $login_url            = add_query_arg(
    'login', $error_codes, $login_url
  );

  wp_redirect($login_url);
  exit;
}