<?php
/**
 * trm_menu_schedule admin menu
 * jf
 * 31.05.17
 */

/**
 * insert menu
 */
function trm_menu_schedule_admin_page(){
    require_once PLUGIN_DIR_PATH.'trm/trm_menu_schedule/phtml/main.phtml';
}
function trm_menu_schedule_admin_menu() {
    add_menu_page( 'menu_schedule', 'Speiseplan', 'manage_options', 'menu_schedule', 'trm_menu_schedule_admin_page', 'dashicons', 6  );
}
add_action( 'admin_menu', 'trm_menu_schedule_admin_menu' );

/**
 *  javascript and css for menu schedule
 */
function trm_menu_schedule_enqueue_assets() {
    // main javascript file
    wp_enqueue_script( 'trm_menu_schedule',plugin_dir_url(__FILE__ ).'js/trm_scripts.js', array('jquery' ),'1.0',true );
}
add_action( 'admin_enqueue_scripts', 'trm_menu_schedule_enqueue_assets' );

/**
 * trm_ajax_response_filter
 */
add_filter('trm_ajax_response','trm_trm_menu_schedule_data');
function trm_trm_menu_schedule_data(){
    ob_start();
    include_once PLUGIN_DIR_PATH.'trm/trm_menu_schedule/phtml/data.phtml';
    return ob_get_clean();
}
