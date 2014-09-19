<?php
/**
 * this class is to deal with hot topic
 */
 
 class AffiliateHotTopic{
 	
	var $base_url = 'http://search.hottopic.com/search?p=Q&ts=custom&lbc=hottopic&w=%s';
	var $hottopic_url = '';
 	
	function __construct($keywords=''){
		$this->hottopic_url = sprintf($this->base_url, $this->sanitized_keywords($keywords));
	}
	
	function get_url(){
		return $this->hottopic_url;
	}
	
	
	function sanitized_keywords($keywords){
		return urlencode($keywords);
	}
	
 }