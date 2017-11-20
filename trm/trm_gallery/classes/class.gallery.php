<?php
abstract class Gallery
{
	protected $filePath;
	protected $settings;
	//protected $itemList;
	
	abstract protected function setSettings();
	abstract protected function itemList();
    abstract protected function imageSizes();
	abstract protected function getTitle();
	abstract protected function getDescription();

	function __construct($filePath) {
		$this->filePath = $filePath;
        $this->setSettings();
	}

    public function imageOutput($image_output,$index,$entry,$atts){

        // if option show_thumbs == 1: insert link without image
        if($atts['showthumbs'] == 1 && $index > 0){
            $image_output = substr($image_output,0,strpos($image_output,'<img')).'</a>';
        }
        return substr($image_output,0,2).' data-index="'.$index.'" data-urls="'.htmlentities(json_encode($entry['data-urls']),ENT_QUOTES, 'UTF-8').'"
        	data-sizes="'.htmlentities(json_encode($entry['data-sizes']),ENT_QUOTES, 'UTF-8').'"'.substr($image_output,2);
    }

    public function toHTML($templatePath,$settings=array()){
        $settings = array_merge($this->settings,$settings);
        $entries = $this->itemList();
        $i = 0;
        $image_list = array();
        foreach($entries as $entry){
            $image = '<a href="'.$entry['imageUrl'].'" data-fancybox="group'.get_the_ID().'"><img src="'. $entry['thumbUrl'].'" alt="'.$entry['alt'].'"></a>';
            $image_list[] = $image; //$this->imageOutput($image,$i++,$entry,$settings);
        }
        //$image_sizes = $this->imageSizes();
        ob_start();
        include($templatePath);
        $v = ob_get_clean();
        return $v;
    }

    public function debug($var){
    	if(isset($_GET['debug'])){
    		return 'var:<pre>'.print_r($var,1).'</pre>';
	    }
    }
}
?>