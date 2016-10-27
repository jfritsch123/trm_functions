<?php

/**
 * Class picasaGallery
 */
class WordpressGallery extends Gallery
{
	/*
	 * image sizes:
	 */
	public $settings;

	function __construct($url){
		parent::__construct($url);
	}

	protected function setSettings(){
	    $this->settings = array(
            "type" => "wordpress",
            "sizes" => array(
                "medium" => 300,
                "large" => 1024
            ),
            "crop" => 'u',
            "showthumbs" => -1
        );
    }

	public function itemList(){

		$args = array(
			'p' => url_to_postid($_POST['url'])
		);
		$the_query = new WP_Query( $args );

		if( $the_query->have_posts() ){
			$the_query->the_post();
			$images = $this->getImages();
			for($i = 0;$i < count($images);$i++){
				$image = wp_get_attachment_metadata($images[$i]);
				$x['type'] = 'wordpress';
				$x['title'] = $image['image_meta']['title'];
				$x['description'] =  $image['image_meta']['caption'];
				$x['date'] = get_the_date();
				$x['alt'] = $image['image_meta']['title'];
				foreach($this->settings['sizes'] as $size=>$a){
					$image = wp_get_attachment_image_src($images[$i], $size );
					$x['data-sizes'][$size] = $image[1] .'x'. $image[2];
					$x['data-urls'][$size] = $image[0];
					if($size == 'medium'){
						$x['thumbUrl'] = $image[0];
					}
					if($size == 'large'){
						$x['imageUrl'] = $image[0];
					}
				}
				$x['linkUrl'] = get_the_permalink();
				$entries[] = $x;
			}
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
		return get_the_title();
	}

	protected function getDescription(){
		global $more;
		$temp = $more;
		$more = 0;
		$ret = get_the_content('');
		$more = $temp;
		return $ret;
	}

	private function getImages(){
		$images = array();
		$galleries = get_post_galleries(get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) )
			$images = explode( ',', $galleries[0]['ids'] );
		if ( ! $images ) {
			$images = get_posts( array(
				'fields'         => 'ids',
				'numberposts'    => 999,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_mime_type' => 'image',
				'post_parent'    => get_the_ID(),
				'post_type'      => 'attachment',
			) );
		}
		return $images;
	}
}
?>