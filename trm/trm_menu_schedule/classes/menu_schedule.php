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
    }

    /**
     * mysql error handling
     * @return bool|string
     */
    public function mysqlError(){
        global $wpdb;
        if($wpdb->last_error !== '') :

            $str   = htmlspecialchars( $wpdb->last_result, ENT_QUOTES );
            $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

            return "<div id='error'>
                <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
                <code>$query</code></p>
                </div>";

        endif;
        return false;
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
            return array('title' => '', 'date' => $this->mysqlDate($this->datepicker), 'content' => '');
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
                    "date" => $_POST['date']
                ),
                array(
                    "id" => $this->recordId
                )
            );
        } else {
            return $wpdb->insert($this->menu_table, array(
                "title" => $this->weekday($_POST['date']),
                "content" => $_POST['editor_1'],
                "date" => $_POST['date']
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
     * get menu from weekday
     * @param $number
     * @return string
     */
    public function getWeekDayMenu($number) {
        $date = date("Y-m-d", strtotime('monday this week +' . $number . ' day'));
        global $wpdb;
        $res = $wpdb->get_row('SELECT * FROM ' . $this->menu_table . ' WHERE date="' . $date . '"', ARRAY_A);

        // if no record exists set empty array
        if (empty($res)) {
            $res = array('title' => '', 'date' => $date, 'content' => '');
        }
        return $res;
    }

    public function getWeekMenu() {
        for($i = 0;$i < 5;$i++){
            $menu[] = $this->getWeekDayMenu($i);
        }
        $this->weekmenu = $menu;
        return $this->view('weekmenu.phtml');
    }

    public function getNextWeekMenu() {
        for($i = 7;$i < 12;$i++){
            $menu[] = $this->getWeekDayMenu($i);
        }
        $this->weekmenu = $menu;
        return $this->view('weekmenu.phtml');
    }

}