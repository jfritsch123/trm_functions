<?php

/**
 * Class picasaGallery
 */
class WordpressAlbum extends Gallery
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

		$posts_per_page = 1;
		$args = array(
			'post_status' => array( 'publish' ),
			'category_name' => 'allgemein',
			'posts_per_page' => $posts_per_page,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$the_query = new WP_Query( $args );

		while ( $the_query->have_posts() ){
			$the_query->the_post();
			$x['type'] = 'wordpress';
			$x['title'] = get_the_title();
			$x['alt'] = $x['title'];
			$x['description'] = get_the_content();
			$x['date'] = date('d.m.Y',strtotime(get_the_date()));
			$images = $this->getImages($the_query);
			foreach($this->settings['sizes'] as $size=>$a){
				$image = wp_get_attachment_image_src($images[0], $size );
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
		return '';
	}

	protected function getDescription(){
		return '';
	}

	private function getImages($the_query){
		$images = array();
		$galleries = get_post_galleries( $the_query->get_the_ID(), false );
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