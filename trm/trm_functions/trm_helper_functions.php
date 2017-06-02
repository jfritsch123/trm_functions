<?php
/********************************************************************
 * output buffer
 */
if(!function_exists('output_buffer')){
	function output_buffer($include,$data){
		ob_start();
		include $include;
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
}

/********************************************************************
 * debug
 */
if(!function_exists('debug')){
	function debug($var,$echo = true){
		if($echo)
			echo '<pre>'.print_r($var,1).'</pre>';
		else
			return '<pre>'.print_r($var,1).'</pre>';
	}
}

/********************************************************************
 * make mysql date format: Y-m-d
 * @param $german_date
 * @return string
 */
if(!function_exists('mysql_date')) {
    function mysql_date($german_date) {
        $date = DateTime::createFromFormat('d.m.Y', $german_date);
        return $date->format('Y-m-d');
    }
}

/********************************************************************
 * make german date format: d.m.Y
 * @param $mysql_date
 * @return string
 */
if(!function_exists('german_date')) {
    function german_date($mysql_date) {
        $date = DateTime::createFromFormat('Y-m-d', $mysql_date);
        return $date->format('d.m.Y');
    }
}
