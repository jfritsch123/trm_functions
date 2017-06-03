<?php
/**
 * trm_menu_schedule admin menu
 * jf
 * 31.05.17
 */

require_once PLUGIN_DIR_PATH.'trm/trm_menu_schedule/classes/menu_schedule.php';
require_once PLUGIN_DIR_PATH.'trm/trm_menu_schedule/classes/menu_frontend.php';

/**
 * insert menu
 */
function trm_menu_schedule_admin_page(){
    $menu_schedule = new MenuSchedule();
    echo $menu_schedule->view();
}
function trm_menu_schedule_admin_menu() {
    add_menu_page( 'menu_schedule', 'Speiseplan', 'manage_options', 'menu_schedule', 'trm_menu_schedule_admin_page','dashicons-index-card', 10 );
}
add_action( 'admin_menu', 'trm_menu_schedule_admin_menu' );

/**
 *  javascript and css for menu schedule
 */
function trm_menu_schedule_enqueue_assets() {
    // main javascript file
    wp_enqueue_script( 'trm_menu_schedule',plugin_dir_url(__FILE__ ).'js/trm_scripts.js', array('jquery' ),'1.0',true );

    // datepicker
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui',plugin_dir_url(__FILE__ ).'css/ui-lightness/jquery-ui.min.css',array(),'1.12.1');

    // media uploader
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'trm_menu_schedule_enqueue_assets' );

/*
 * define the shortcodes
 */
function trm_weekday_menu_shortcode($atts, $content=null, $code=""){
    $menu_frontend = new MenuFrontend();
    return $menu_frontend->getWeekDayMenu($atts['nr']);
}
add_shortcode('trm_weekday_menu', 'trm_weekday_menu_shortcode');



