<?php

/**
 * trm_menu_frontend
 * frontend functions
 * jf
 * 01.06.17
 */
class MenuFrontend extends MenuSchedule {

    public $weekdaymenu;
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param string $template
     * @return string
     */
    public function view($template = 'weekdaymenu.phtml') {
        ob_start();
        include(PLUGIN_DIR_PATH . 'trm/trm_menu_schedule/phtml/frontend/' . $template);
        $string = ob_get_contents();
        ob_end_clean();
        return $string;
    }

    /**
     * get menu from weekday
     * @param $number
     * @return string
     */
    public function getWeekDayMenu($number,$template = 'weekdaymenu.phtml') {
        $this->weekdaymenu = parent::getWeekDayMenu($number);
        return $this->view();
    }

    /**
     * get image from image_id
     * @param $image_id
     * @param string $size
     * @return array|false|string
     */
    public function getImage($image_id,$size='medium'){
        if(!empty($image_id)) {
            return wp_get_attachment_image($image_id, $size);
        }
        return '';
    }
}