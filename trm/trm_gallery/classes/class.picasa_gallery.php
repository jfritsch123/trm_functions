<?php

/**
 * Class picasaGallery
 */
class PicasaGallery extends Gallery
{
	/*
	 * image sizes: 32, 48, 64, 72, 104, 144, 150, 160 cropped(c) and uncropped(u)
	 * 94, 110, 128, 200, 220, 288, 320, 400, 512, 576, 640, 720, 800, 912, 1024, 1152, 1280, 1440, 1600 (u)
	 */
	private $doc;
	public $settings;

	function __construct($url){
		parent::__construct($url);
		$xmlresponse = file_get_contents($url);
		$this->doc = new DOMDocument();
		$this->doc->loadXML($xmlresponse);
		//$this->debug(htmlentities($this->doc->saveXML()));
	}

	protected function setSettings(){
	    $this->settings = array(
            "type" => "picasa",
            "sizes" => array(
                "medium" => 320,
                "large" => 1024
            ),
            "crop" => 'u',
            "showthumbs" => -1
        );
    }

	protected function itemList(){

		$items = getItems($this->doc);

		foreach ($items as $item) {
			$x['type'] = 'picasa';
			$x['title'] = getNodeValue($item,'title');
			$x['alt'] = $x['title'];
			$x['description'] = getNodeValue($item,'description');
			$x['date'] = getNodeValue($item,'pubDate');
			$x['thumbUrl'] = getNodeAttributeNS(MEDIA_NS,$item,'content','url').'?imgmax='.$this->settings['sizes']['medium'];
			$x['imageUrl'] = getNodeAttributeNS(MEDIA_NS,$item,'content','url');
			$x['height'] = getNodeAttributeNS(MEDIA_NS,$item,'content','height');
			$x['width'] = getNodeAttributeNS(MEDIA_NS,$item,'content','width');
			$x['linkUrl'] = getNodeValue($item,'guid');
			$height = empty($x['height']) ? 1 : $x['height'];
			$width = empty($x['width']) ? 1 : $x['width'];

			foreach($this->settings['sizes'] as $size=>$a){
				$x['data-sizes'][$size] = $a .'x'. $a * $height/ $width;
				$x['data-urls'][$size] = $x['imageUrl'].'?imgmax='.$a;
			}
			$entries[] = $x;
		}
		return $entries;
	}

	protected function imageSizes(){
		$sizes = array();
		foreach ($this->settings['sizes'] as $size=>$a) {
			$sizes[$size]['width'] = $a;
			$sizes[$size]['height'] = $a;
			$sizes[$size]['crop'] = false;
		}
		return $sizes;
	}

	protected function getTitle(){
		return getXPathValue($this->doc,'/rss/channel/title');
	}

	protected function getDescription(){
		return getXPathValue($this->doc,'/rss/channel/description');
	}
}
?>