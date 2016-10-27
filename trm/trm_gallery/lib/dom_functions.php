<?php

   define ("MEDIA_NS", "http://search.yahoo.com/mrss/");

	// get items form rss feed
	function getItems($doc){
      return $doc->getElementsByTagName("item");
   }

	// get node value
	function getNode($node,$name){
		return $node->getElementsByTagName($name)->item(0);
	}
   
	// get node value
	function getNodeValue($node,$name){
		return $node->getElementsByTagName($name)->item(0)->nodeValue;
	}

  	// get node value with namespace
	function getNodeValueNS($ns,$node,$name){
		return $node->getElementsByTagNameNS($ns,$name)->item(0)->nodeValue;
	}

  	// get node attribute
	function getNodeAttribute($node,$name,$attr){
		return $node->getElementsByTagName($name)->item(0)->getAttribute($attr);
	}

	// get node attribute with namespace
	function getNodeAttributeNS($ns,$node,$name,$attr){
		return $node->getElementsByTagNameNS($ns,$name)->item(0)->getAttribute($attr);
	}
	
	// get xpath value
	function getXPathValue($doc,$xpath){
		$xp = new DOMXPath($doc);
		$nodeList = $xp->query($xpath);
		return $nodeList->item(0)->nodeValue;
	}
	// get xpath values as array
	function getXPathValueArr($doc,$xpath){
		$xp = new DOMXPath($doc);
		$nodeList = $xp->query($xpath);
		foreach($nodeList as $node){
			$a[] = $node->value;
		}
		return $a;
	}
	// get xpath nodes as array
	function getXPathNodeArr($doc,$xpath){
		$xp = new DOMXPath($doc);
		$nodeList = $xp->query($xpath);
		$i = 0;
		foreach($nodeList as $node){
			$aNodes = $node->attributes;
			foreach($aNodes as $aNode){
				$a[$i][$aNode->name] = $aNode->value;
			}
			$i++;
		}
		return $a;
	}
?>