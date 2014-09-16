<?php
/**
 * This class will combine affiliates
 */
 
 class WpLinkRewriter{	
	
 	static $affiliates_options;
	
	/**
	 * initialization of the plugin
	 */
	static function init(){
		add_action('admin_menu', array(get_class(), 'admin_menu_for_wp_link_rewriter')); //add amdin menu
		self::populate_affiliates_options(); //populates parameters from affiliates_for_parameters.php
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
	  		include self::get_script_location('link_rewriter_menupage.php');
	  }
	  
	  
	  /**
	   * get admin scripts
	   */
	   static function get_script_location($name = '', $type='admin'){
	   		if(!empty($type) && !empty($name)){
	   			return WPAFFILIATES_DIR . '/includes/' . $type . '/' . $name;
	   		}
	   }
	   
	   
	   /**
	    * affiliate options
	    * dynamically populate form with different options
	    * script location /includes/admin/affiliates_form_parameters.php
	    */
	   static function populate_affiliates_options($affiliate='amazon'){
	   		if(empty(self::$affiliates_options)){
	   			include self::get_script_location('affiliates_form_parameters.php');
				
				/**
				 * use this filter to add affilates
				 */
				self::$affiliates_options = apply_filters('link_rewrite_affiliates', $parameters);
	   		}						
	   }

		
		/**
		 * return form fiels based on different combination
		 */
	   static function get_form_field($aff, $params , $current_value=''){
	   		switch ($params['type']){
				case "checkbox":
					$checked = $current_value == 1 ? "checked" : "";
				//	return "<input name='{$params['name']}' type='checkbox' value='1' {$checked}  />";
				//	return '<input type="checkbox" name="'.$aff[$params['name']].'" value="1" '.$checked.' >';
					return '<input type="checkbox" name="'.$aff. '['.$params['name'].']' .'" value="1" '.$checked.' >';
					break;
				case "input":
				//	return "<input name='{$params['name']}' type='text' value='{$current_value}/>'";
				//	return '<input type="checkbox" name="'.$aff[$params['name']].'" value="'.$current_value.'" '.$checked.' >';
					return '<input type="checkbox" name="'.$aff. '['.$params['name'].']' .'" value="'.$current_value.' >';
					break;
	   		}
	   }
	   
	   
	   
	   /**
	    * update the options from menu page
	    */
	    static function update_options($options){
	    	update_option('link_rewriter_options', $options);
	    }
		
		
		/**
		 * ge the options set from menu page
		 */
		 static function get_options(){
		 	$options = get_option('link_rewriter_options');
			return $options;
		 }
		
		

 }
 
?>