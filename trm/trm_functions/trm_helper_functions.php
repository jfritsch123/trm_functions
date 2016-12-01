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
