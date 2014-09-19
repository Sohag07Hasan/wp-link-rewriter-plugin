<?php
/**
 * this class is to deal with http://www.entertainmentearth.com/
 */
 
 class AffiliateForbiddenPlanet{
 	
	var $base_url = 'https://forbiddenplanet.com/?q=%s';
	var $forbidden_planet_url = '';
 	
	function __construct($keywords=''){
		$this->forbidden_planet_url = sprintf($this->base_url, $this->sanitized_keywords($keywords));
	}
	
	function get_url(){
		return $this->forbidden_planet_url;
	}
	
	
	function sanitized_keywords($keywords){
		$keywords = preg_replace('[ ]', '+', trim($keywords));
		return $keywords;
	}
	
 }