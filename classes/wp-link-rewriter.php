<?php
/**
 * This class will combine affiliates
 */
 
 class WpLinkRewriter{
 	
 	
	/**
	 * initialization of the plugin
	 */
	static function init(){
		add_action('admin_menu', array(get_class(), 'admin_menu_for_wp_link_rewriter')); //add amdin menu
	}
	
	
	/**
	 * initialize admin menu 
	 */
	 static function admin_menu_for_wp_link_rewriter(){
	 	add_menu_page('wordpress link rewrite', 'Link Rewrite', 'manage_options', 'wp_link_rewriter', array(get_class(), 'link_rewriter_menupage'));
	 }
	 
	 
	 /**
	  * link rewriter menu page
	  */
	  static function link_rewriter_menupage(){
	  	
	  }
 }
 
?>