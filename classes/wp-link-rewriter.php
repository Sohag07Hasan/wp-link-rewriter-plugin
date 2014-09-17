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
		self::populate_affiliates_options(); //populates parameters from affiliates_for_parameters.php	
		add_action('admin_menu', array(get_class(), 'admin_menu_for_wp_link_rewriter')); //add amdin menu
		add_filter('the_title', array(get_class(), 'include_affiliates_below_title'), 10, 2);	//add affiliates links after the title
		add_action('add_meta_boxes', array(get_class(), 'metabox_at_post_edit_page'));	//add a metabox in post editing page
		add_action('save_post', array(get_class(), 'save_metabox_data'), 10, 1); //save metabox info
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
		
		
		/**
		 * return title followed by affiliates
		 */
		 static function include_affiliates_below_title($title, $post_id){
		 	global $post;			
			$amazon_url = self::get_amazon_url($post->post_title);			
			return $title . '<br/><p style="color: red"> <a target="_blank" href="'.$amazon_url.'">Amazon</a> </p>';			
		 }
		 
		 
		 /**
		  * generate amazon url
		  */
		  static function get_amazon_url($keywords){
		  	if(!class_exists('AffiliateAmazon')){
		  		include WPAFFILIATES_DIR . '/classes/amazon.php';
			}
			
			$amazon = new AffiliateAmazon($keywords);
			return $amazon->get_amazon_url();
		  }
		 
		 
		 /**
		  * generates affiliates links
		  * return affiliate links baesed on options
		  */
		 static function get_affiliates_links(){
		  	foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
		 		foreach($param['form'] as $key => $con):
					//$options[$aff[$con['name']]] = $_POST[$aff[$con['name']]];
					$options[$aff][$con['name']] = $_POST[$aff][$con['name']];				
				endforeach;
		 	}
		 }
		  
		  
		 /**
		  * adds metabox to handle with affilate keywords
		  */
		 static function metabox_at_post_edit_page(){
		  	add_meta_box('matebox-to-handle-keywords', 'Affiliate Keywords', array(get_class(), 'metabox_to_deal_keywords'), 'post', 'side', 'high');	   	
		 }
		 
		 
		 /**
		  * affiliate keywords deals with this function
		  */
		 static function metabox_to_deal_keywords($post){
		 	$keywords = self::get_keywords($post->ID);
		 	echo '<strong>keywords to generate affiliate links</strong>';
			echo '<p><input size="0%" type="text" value="'.$keywords.'" name="affiliate_keywords"></p>';
		 }
		
		
		static function save_metabox_data($post_id){
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
				return;
			}
			
			//now it's safe to save info
			if(isset($_POST['affiliate_keywords'])){
				return self::save_keywords($post_id, $_POST['affiliate_keywords']);
			}
		}
		
		
		/**
		 * save keywords against each post
		 */
		static function save_keywords($post_id, $keywords){
			update_post_meta($post_id, 'affiliate_keywords', trim($keywords));
		}
		
		
		/**
		 * get saved keywords against each post
		 */
		static function get_keywords($post_id){
			$keywords = get_post_meta($post_id, 'affiliate_keywords', true);
			
			return empty($keywords) ? '' : $keywords;
		}
		

 }
 
?>