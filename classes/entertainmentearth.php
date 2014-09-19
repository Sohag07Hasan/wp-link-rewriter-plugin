<?php
/**
 * this class is to deal with http://www.entertainmentearth.com/
 */
 
 class AffiliateEntertainmentEarth{
 	
	var $base_url = 'http://www.entertainmentearth.com/hitlist.asp?searchfield=%s&onform=1&eeshop=&x=0&y=0';
	var $entertainment_earth_url = '';
 	
	function __construct($keywords=''){
		$this->entertainment_earth_url = sprintf($this->base_url, $this->sanitized_keywords($keywords));
	}
	
	function get_url(){
		return $this->entertainment_earth_url;
	}
	
	
	function sanitized_keywords($keywords){
		$keywords = preg_replace('[ ]', '+', trim($keywords));
		return $keywords;
	}
	
 }
