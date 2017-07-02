<?php
/**
 * trm_download
 * DOMDocument::loadHTML
 * jf
 * 02.07.17
 */

$url = 'http://www.shanti-austria.com/fotos-shanti/';
$filename = 'shanti-austria-';
$doc = new DOMDocument;
$doc->preserveWhiteSpace = FALSE;
@$doc->loadHTMLFile($url);
$html = $doc->saveHTML();
//echo $html;
$xpath = new DOMXpath($doc);
$elements = $xpath->query('//div[@id="gallery-1"]//a');
//echo dirname(__FILE__);
if (!is_null($elements)) {
    $i = 0;
    foreach ($elements as $element) {
        $url = $element->getAttribute('href');
        $type=substr($url,strrpos($url,'.')+1);
        echo $type.'<br>';
        $image = file_get_contents($url);
        file_put_contents('temp/'.$filename.(++$i).'.'.$type, $image); //Where to save the image on your server
    }
}

