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
		
		
		add_action('woocommerce_before_main_content', array(get_class(), 'launch_woocommerce'));
		add_action('woocommerce_after_main_content', array(get_class(), 'end_woocommerce'));		
		
		add_action('add_meta_boxes', array(get_class(), 'metabox_at_post_edit_page'));	//add a metabox in post editing page
		add_action('save_post', array(get_class(), 'save_metabox_data'), 10, 1); //save metabox info
		
		//self::get_affiliates_links();
	}
	
	
	static function launch_woocommerce(){
		add_filter('the_title', array(get_class(), 'include_affiliates_below_title'), 10, 2);	//add affiliates links after the title
	}
	
	
	static function end_woocommerce(){
		remove_filter('the_title', array(get_class(), 'include_affiliates_below_title'), 10);
	}
	
	
	/**
	 * initialize admin menu 
	 */
	 static function admin_menu_for_wp_link_rewriter(){
	 	add_menu_page('wordpress link rewrite', 'Link Rewrite', 'manage_options', 'wp_link_rewriter', array(get_class(), 'link_rewriter_menupage'));
	 	add_submenu_page('wp_link_rewriter', 'local links', 'Local Links', 'manage_options', 'submenu_page_for_local_links', array(get_class(), 'local_links_submenu_page'));
	 }
	 
	 
	 /**
	  * link rewriter menu page
	  */
	  static function link_rewriter_menupage(){
	  	include self::get_script_location('link_rewriter_menupage.php');
	  }
	  
	  /**
	   * submenu page to advertise local links
	   */
	  static function local_links_submenu_page(){
	  	include self::get_script_location('local_links_submenu_page.php');
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
		 	if(is_admin()) return $title; //if admin page return the original title
		 	//if(in_array(get_post_type($post_id), array('post', 'page'))) return $title; //skip if the post type is post or page
		 						 	
		 	global $post;
		 	
			$keywords = self::get_keywords($post->ID);
			$keywords = empty($keywords) ? $title : $keywords;
						
			$affiliate_links = self::get_affiliate_links($keywords, $post_id);	
			
			$affiliates = array();
			foreach($affiliate_links as $brand => $link){
				$affiliates[$brand] = '<a target="_blank" href="'.$link.'">'.self::$affiliates_options[$brand]['title'].'</a>';			
			}
						
			return $title . '<br/><p style="color: red">' . implode(' | ', $affiliates) . '</p>';		
		 }
		 
				
		 
		 
		 /**
		  * generate amazon url
		  */
		  static function get_affilate_url($brand, $keywords){
		  	switch($brand){
				case 'amazon':
					$class = 'AffiliateAmazon';
					$file = WPAFFILIATES_DIR . "/classes/amazon.php";
					break;
				
				case 'ebay':
					$class = 'AffiliateEbay';
					$file = WPAFFILIATES_DIR . "/classes/ebay.php";
					break;
				
				case 'entertainment_earth':
					$class = 'AffiliateEntertainmentEarth';
					$file = WPAFFILIATES_DIR . "/classes/entertainmentearth.php";
					break;
		  	}
			
		  	if(!class_exists($class)){
		  		include $file;
			}
			
			$brand_obj = new $class($keywords);			
			return $brand_obj->get_url();
		  }  
		  
		 
		 
		 /**
		  * generates affiliates links
		  * return affiliate links baesed on options
		  */
		 static function get_affiliate_links($title, $post_id){
		 				
			$options = WpLinkRewriter::get_options();
			$affiliate_links = array();
			$keywords = $title;
						 
			foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
		 		foreach($param['form'] as $key => $con):
					if((isset($options[$aff][$con['name']]))){
						$affiliate_links[$aff] = self::get_affilate_url($aff, $keywords);
					}			
				endforeach;
		 	}

			return $affiliate_links;				
		 }
		  
		  
		 /**
		  * adds metabox to handle with affilate keywords
		  */
		 static function metabox_at_post_edit_page(){
		  	add_meta_box('matebox-to-handle-keywords', 'Affiliate Keywords', array(get_class(), 'metabox_to_deal_keywords'), 'product', 'side', 'high');	   	
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