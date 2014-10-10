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
		
		include WPAFFILIATES_DIR . '/classes/woocommerce_handler.php'; //including woocommmerce hanlder
		LinkRewriterWithWoocommerce::init();
		
		
		include WPAFFILIATES_DIR . '/classes/local_link_handler.php';
		LinkRewriterLocalLinks::init();
		  		
		
		self::populate_affiliates_options(); //populates parameters from affiliates_for_parameters.php	
		add_action('admin_menu', array(get_class(), 'admin_menu_for_wp_link_rewriter')); //add amdin menu
			
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
					return '<input type="checkbox" id="'.$aff. '['.$params['name'].']' .'" name="'.$aff. '['.$params['name'].']' .'" value="1" '.$checked.' > <label for="'.$aff. '['.$params['name'].']' .'"> '.$params['description'].' </label> ';
					break;
					
				case "text":
					return '<input type="text" id="'.$aff. '['.$params['name'].']' .'" name="'.$aff. '['.$params['name'].']' .'" value="'.$current_value.'" />  <label for="'.$aff. '['.$params['name'].']' .'"> '.$params['description'].' </label> ';
					break;
				
				case "select":
					return self::form_field_select($aff, $params , $current_value);
					break;
	   		}
	   }
	   
	   
	   
	   static function form_field_select($aff, $params , $current_value){
	   		$options = array('Zero', '1st', '2nd', '3rd', '4th', '5th', '6th');
			$text = '<select id="'.$aff. '['.$params['name'].']' .'" name="'.$aff. '['.$params['name'].']' .'">' ;
			
			foreach($options as $key => $opt){
				if($key == 0) continue;				
				
				$current_value = ($current_value >=0 && $current_value <=6) ? $current_value : $params['default'];
				$selected = ($current_value == $key) ? 'selected' : '';
				$text .= '<option value="'.$key.'" '.$selected.' >'.$opt.'</option>';
			}
			
			$text .= '</select> <label for="'.$aff. '['.$params['name'].']' .'"> '.$params['description'].' </label> ';
			return $text;
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
		 static function get_affiliates_for_product_meta(){		 			 		 						 	
		 	global $post;
		 			 	
			$keywords = self::get_keywords($post->ID); //keywords saved against each post/product
			$options = WpLinkRewriter::get_options();  //global options for link rewrite
									
			$affiliate_links = self::get_affiliate_links($post->post_title, $keywords, $post->ID); //get affliates links
			
			$affiliates = array();
			foreach($affiliate_links as $brand => $link){				
				$affiliates[$brand] = array(
					'url' => $link,
					'title' => self::$affiliates_options[$brand]['title'],
					'button_text' => $options[$brand]['button_text'],
					'store_info' => $options[$brand]['url']
					
				);
				
			}

			return $affiliates;	
					
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
				
				case 'forbidden_planet':
					$class = 'AffiliateForbiddenPlanet';
					$file = WPAFFILIATES_DIR . "/classes/forbiddenplanet.php";
					break;
					
				case 'hot_topic':
					$class = 'AffiliateHotTopic';
					$file = WPAFFILIATES_DIR . "/classes/hottopic.php";
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
		 static function get_affiliate_links($title, $keywords, $post_id){
		 				
			$options = WpLinkRewriter::get_options();
			$affiliate_links = array();
									 
			foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
				$aff_keywords = (isset($keywords[$aff]) && !empty($keywords[$aff])) ? $keywords[$aff] : $title; //filtering keys against title and keywords
		 		foreach($param['form'] as $key => $con):
					if((isset($options[$aff][$con['name']]))){
						$affiliate_links[$aff] = self::get_affilate_url($aff, $aff_keywords);
					}			
				endforeach;
		 	}

			return $affiliate_links;				
		 }
		  
		  
		 /**
		  * adds metabox to handle with affilate keywords
		  */
		 static function metabox_at_post_edit_page(){
		  	add_meta_box('matebox-to-handle-keywords', 'Affiliate Keywords', array(get_class(), 'metabox_to_deal_keywords'), 'product', 'advanced', 'high');	   	
		 }
		 
		 
		 /**
		  * affiliate keywords deals with this function
		  */
		 static function metabox_to_deal_keywords($post){		 	
			include self::get_script_location('metabox-for-product.php', 'admin');		 	
		 }
		
		
		/**
		 * saves meta box information
		 * checks auto save and ajax saving
		 * other filters lke post type etc can also be added
		 */
		static function save_metabox_data($post_id){
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
				return;
			}
			
			$keywords = array();			
			//now it's safe to save info
			if(isset($_POST['affiliate_keywords'])){
				foreach($_POST['affiliate_keywords'] as $key => $value){
					$keywords[$key] = trim($value);
				}
				self::save_keywords($post_id, $keywords);
			}
			
			if(isset($_POST['local_position_enabled'])){
				update_post_meta($post_id, 'local_position_enabled', 'y');
			}
			else{
				update_post_meta($post_id, 'local_position_enabled', '');
			}
			
			if(isset($_POST['position'])){
				$positions = array();
				foreach($_POST['position'] as $key => $value){
					$positions[$key] = $value;
				}
				
				update_post_meta($post_id, 'local_positions', $positions);
			}
			
			//saving loal links
			if(isset($_POST['local_links'])){
				update_post_meta($post_id, 'local_links', $_POST['local_links']);
			}
		}
		
		
		static function get_local_links_by_post($post_id){
			$links = get_post_meta($post_id, 'local_links', true);
			
			return is_array($links) ? $links : array();
		}
		
		
		/**
		 * returns boolean based on local posiiton status
		 */
		static function is_local_position_enabled($post_id){
			$enabled = get_post_meta($post_id, 'local_position_enabled', true);
			
			return ($enabled == 'y') ? true : false;
		}
		
		
		/**
		 * return local positions
		 */
		 static function get_local_positions($post_id){
		 	$positions = get_post_meta($post_id, 'local_positions', true);
			
			return is_array($positions) ? $positions : array();
		 }
		 
		
		/**
		 * save keywords against each post
		 */
		static function save_keywords($post_id, $keywords){
			update_post_meta($post_id, 'affiliate_keywords', $keywords);
		}
		
		
		/**
		 * get saved keywords against each post
		 */
		static function get_keywords($post_id, $title = null){
			$keywords = get_post_meta($post_id, 'affiliate_keywords', true);			
			return empty($keywords) ? '' : $keywords;
		}
		

 }
 
?>