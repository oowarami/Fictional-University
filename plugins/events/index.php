<?php
/*
 * Plugin Name: Events 
 * Description: A simple WordPress plugin that allows user to create events and see other events that are happening
 * Version: 1.0
 * Author: Warami 
 * Text Domain: event
 */

if( !function_exists( 'add_action' ) ){
    echo "Hi there! I'm just a plugin, not much I can do when called directly.";
    exit;
}

// Setup
define( 'EVENTS_PLUGIN_URL', __FILE__ );

// Includes
include( 'includes/activate.php' );
include( 'includes/init.php' );
include( 'process/save-post.php' );
include( 'process/filter-content.php' );
include( 'includes/front/enqueue.php' );
include( 'process/rate-recipe.php' );
include( 'includes/admin/init.php' );
include( 'blocks/enqueue.php' );
include( dirname(EVENTS_PLUGIN_URL) . '/includes/widgets.php' );
include( 'includes/widgets/daily-events.php' );
include( 'includes/cron.php' );
include( 'includes/deactivate.php' );
include( 'includes/utility.php' );
include( 'includes/shortcodes/creator.php' );
include( 'process/submit-event.php' );
include( 'includes/shortcodes/auth-form.php' );
include( 'process/create-account.php' );
include( 'process/login.php' );
include( 'includes/shortcodes/auth-alt-form.php' );
include( 'includes/front/logout-link.php' );
include( 'includes/admin/dashboard-widgets.php' );
include( 'includes/shortcodes/twitter-follow.php' );
include( 'includes/admin/menus.php' );
include( 'includes/admin/options-page.php' );
include( 'process/save-options.php' );
include( 'includes/admin/origin-fields.php' );
include( 'process/save-origin.php' );

// Hooks
register_activation_hook( __FILE__, 'r_activate_plugin' );
register_deactivation_hook( __FILE__, 'r_deactivate_plugin' );
add_action( 'init', 'recipe_init' );
add_action( 'save_post_recipe', 'r_save_post_admin', 10, 3 );
add_filter( 'the_content', 'r_filter_recipe_content' );
add_action( 'wp_enqueue_scripts', 'r_enqueue_scripts', 100 );
add_action( 'wp_ajax_r_rate_recipe', 'r_rate_recipe' );
add_action( 'wp_ajax_nopriv_r_rate_recipe', 'r_rate_recipe' );
add_action( 'admin_init', 'recipe_admin_init' );
add_action( 'enqueue_block_editor_assets', 'r_enqueue_block_editor_assets' );
add_action( 'enqueue_block_assets', 'r_enqueue_block_assets' );
add_action( 'widgets_init', 'r_widgets_init' );
add_action( 'r_daily_event_hook', 'r_daily_generate_event' );
add_action( 'wp_ajax_r_submit_event', 'r_submit_event' );
add_action( 'wp_ajax_nopriv_r_submit_event', 'r_submit_event' );
add_action( 'wp_ajax_nopriv_recipe_create_account', 'recipe_create_account' );
add_action( 'wp_ajax_nopriv_recipe_user_login', 'recipe_user_login' );
// add_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
// add_filter( 'authenticate', 'wp_authenticate_spam_check', 99 );
// add_filter( 'authenticate', 'r_alt_authenticate', 100, 3 );
add_filter( 'wp_nav_menu_secondary_items', 'ju_new_nav_menu_items', 999 );
add_action( 'wp_dashboard_setup', 'r_dashboard_widgets' );

// Shortcodes
add_shortcode( 'event_creator', 'r_event_creator_shortcode' );
add_shortcode( 'event_auth_form', 'r_event_auth_form_shortcode' );
// add_shortcode( 'recipe_auth_alt_form', 'r_recipe_auth_alt_form_shortcode' );
add_shortcode( 'twitter_follow', 'r_twitter_follow_shortcode' );