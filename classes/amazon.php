<?php
/**
 * this class is to deal with amazon and int's interactivities
 */
 
 class AffiliateAmazon{
 	
	var $base_url = 'http://www.amazon.com/s/ref=%s?field-keywords=%s';
	var $amazon_url = '';
 	
	function __construct($keywords=''){
		$this->amazon_url = sprintf($this->base_url, 'nb_sb_noss', urldecode($keywords));
	}
	
	function get_url(){
		return $this->amazon_url;
	}
	
 }
