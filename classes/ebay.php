<?php
/**
 * this class is to deal with amazon and int's interactivities
 */
 
 class AffiliateEbay{
 	
	var $base_url = 'http://www.ebay.com/sch/i.html?_from=%s&_nkw=%s';
	var $ebay_url = '';
 	
	function __construct($keywords=''){
		$this->ebay_url = sprintf($this->base_url, 'R40', $this->sanitized_keywords($keywords));
	}
	
	function get_url(){
		return $this->ebay_url;
	}
	
	function sanitized_keywords($keywords){
		return urldecode($keywords);
	}
	
 }