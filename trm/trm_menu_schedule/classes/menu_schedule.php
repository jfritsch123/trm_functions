<?php

/**
 * trm_menu_schedule
 * database functions
 * jf
 * 01.06.17
 */
class MenuSchedule {

    protected $menu_table = 'trm_menu_schedule';
    public $action = '';
    public $datepicker = '';
    public $recordId = false;
    public $permalink;
    public $weekdaymenu;
    private $showFromWeekday = 7;   // default: Sunday
    private $firstWeekday = 0;      // starts on Sunday
    private $lastWeekday = 4;       // ends on Friday

    public function __construct() {
        $this->permalink = site_url() . '/wp-admin/admin.php?page=menu_schedule';
        if (isset($_REQUEST['datepicker'])) {
            $this->datepicker = $_REQUEST['datepicker'];
            $this->recordId = $this->recordId();
            $this->action = 'select';
        }
        if (isset($_POST['action'])) {
            $this->action = 'insert_update';
        }
        $showFromWeekday = get_option('showFromWeekday');
        if($showFromWeekday){
            $this->showFromWeekday = $showFromWeekday;
        }
    }

    /**
     * mysql error handling
     * @return bool|string
     */
    public function mysqlError(){
        global $wpdb;
        ob_start();
        $wpdb->show_errors();
        $wpdb->print_error();
        $error = ob_get_contents();
        ob_end_clean();
        if(strpos($error,'[]') !== false){
            return false;
        }
        return $error;
    }

    /**
     * @param string $template
     * @return string
     */
    public function view($template = 'main.phtml') {
        ob_start();
        include(PLUGIN_DIR_PATH . 'trm/trm_menu_schedule/phtml/admin/'. $template);
        $string = ob_get_contents();
        ob_end_clean();
        return $string;
    }

    /**
     * get record id of sent datepicker value
     * @return null|string
     */
    public function recordId() {
        global $wpdb;
        return $wpdb->get_var('SELECT id FROM ' . $this->menu_table . ' WHERE date="' . $this->mysqlDate($this->datepicker) . '"');
    }

    /**
     * select data from mysql table
     * @return array|null|object|void
     */
    public function selectData() {
        global $wpdb;

        // if no action do nothing
        if (!$this->action) return '';

        $res = $wpdb->get_row('SELECT * FROM ' . $this->menu_table . ' WHERE date="' . $this->mysqlDate($this->datepicker) . '"', ARRAY_A);

        // if no record exists set date input to sent datepicker
        if (empty($res)) {
            return array('title' => '', 'date' => $this->mysqlDate($this->datepicker), 'content' => '','image_id' => null);
        }
        return $res;
    }

    /**
     * insert data into mysql table
     * @return false|int
     */
    public function insertUpdateData() {
        if ($this->action != 'insert_update') return false;

        global $wpdb;
        if ($this->recordId) {
            return $wpdb->update($this->menu_table,
                array(
                    "title" => $this->weekday($_POST['date']),
                    "content" => $_POST['editor_1'],
                    "date" => $_POST['date'],
                    "image_id" => $_POST['upload_image_id']
                ),
                array(
                    "id" => $this->recordId
                )
            );
        } else {
            return $wpdb->insert($this->menu_table, array(
                "title" => $this->weekday($_POST['date']),
                "content" => $_POST['editor_1'],
                "date" => $_POST['date'],
                "image_id" => $_POST['upload_image_id']
            ));
        }
    }

    /**
     * german weekday
     * @return string
     */
    private function weekday($date) {
        setlocale(LC_TIME, "de_DE");
        return strftime("%A", strtotime($date));
    }

    /**
     * weekday names
     * @return array
     */
    public function weekdayNames(){
        return array('Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag','Sonntag');
    }

    /**
     * @param $german_date
     * @return string
     */
    public function mysqlDate($german_date) {
        if(empty($german_date)) return '';
        $date = DateTime::createFromFormat('d.m.Y', $german_date);
        return $date->format('Y-m-d');
    }

    /**
     * @param $mysql_date
     * @return string
     */
    public function germanDate($mysql_date) {
        if(empty($mysql_date)) return '';
        $date = DateTime::createFromFormat('Y-m-d', $mysql_date);
        return $date->format('d.m.Y');
    }

    /**
     * get current weekday as number: 1..Monday
     * @return false|string
     */
    public function getCurrentWeekDay(){
        date_default_timezone_set('Europe/Zurich');
        return date('N');
    }

    /**
     * get menu from weekday
     * @param $number
     * @return string
     */
    public function getWeekDayMenu($number) {

        date_default_timezone_set('Europe/Zurich');
        if($this->getCurrentWeekDay() <= $this->showFromWeekday){
            $date = date("Y-m-d", strtotime('monday this week +' . $number . ' day'));
        }else{
            $date = date("Y-m-d", strtotime('monday next week +' . $number . ' day'));
        }
        global $wpdb;
        $res = $wpdb->get_row('SELECT * FROM ' . $this->menu_table . ' WHERE date="' . $date . '"', ARRAY_A);

        // if no record exists set empty array
        if (empty($res)) {
            $res = array('title' => '', 'date' => $date, 'content' => '','image_id' => null);
        }
        return $res;
    }

    /**
     * get menu of current week
     * @return string
     */
    public function getWeekMenu() {
        for($i = $this->firstWeekday;$i <= $this->lastWeekday;$i++){
            $menu[] = $this->getWeekDayMenu($i);
        }
        $this->weekmenu = $menu;
        return $this->view('weekmenu.phtml');
    }

    /**
     * get menu of next week
     * @return string
     */
    public function getNextWeekMenu() {
        for($i = $this->firstWeekday + 7;$i <= $this->lastWeekday + 7;$i++){
            $menu[] = $this->getWeekDayMenu($i);
        }
        $this->weekmenu = $menu;
        return $this->view('weekmenu.phtml');
    }

    /**
     * get image from image_id
     * @param $image_id
     * @param string $size
     * @return array|false|string
     */
    public function getImage($image_id,$size='thumbnail'){
        $html = '<div id="attachment_image" data-placehold-url="http://placehold.it/150x150">';
        if(!empty($image_id)){
            $html .= wp_get_attachment_image($image_id,$size);
        }
        else{
            $html .= '<img src="http://placehold.it/150x150">';
        }
        $html .= '</div>';
        return $html;
    }



}