<?php

/**
 * Class picasaGallery
 */
class WordpressPicasaAlbum extends Gallery
{
	/*
	 * image sizes:
	 */
	public $settings;

	function __construct(){
		parent::__construct('');
	}

	protected function setSettings(){
	    $this->settings = array(
            "type" => "wordpress_picasa",
            "sizes" => array(
                "medium" => 320,
                "large" => 1024
            ),
            "crop" => 'u',
            "showthumbs" => -1
        );
    }

	protected function itemList(){
		$c1 = new WordpressAlbum();
		$entries_1 = $c1->itemList();
		$c2 = new PicasaAlbum(PICASA_URL);
		$entries_2 = $c2->itemList();
		return array_merge($entries_1,$entries_2);
	}

	protected function imageSizes(){
		return false;
	}

	protected function getTitle(){
		return '';
	}

	protected function getDescription(){
		return '';
	}
}
?>