<?php
/**
 * This class is to handle local links
 */


class LinkRewriterLocalLinks{
	
	static function init(){
		add_action('admin_menu', array(get_class(), 'admin_menu_for_local_links'), 100); //add amdin menu		
		add_action('admin_init', array(get_class(), 'admin_init_form_submission_handler'));
		
		register_activation_hook(WPAFFILIATES_FILE, array(get_class(), 'manage_db'));
	}
	
	
	/*
	 * this is to handle local links
	 */
	static function admin_menu_for_local_links(){
		add_submenu_page('wp_link_rewriter', 'local links', 'Local Links', 'manage_options', 'submenu_page_for_local_links', array(get_class(), 'local_links_submenu_page'));
		add_submenu_page('wp_link_rewriter', ucwords('new or edit a link'), 'Add New', 'manage_options', 'addnew_local_link', array(get_class(), 'submenu_add_or_edit_links'));
	}
	
	
	/**
   	 * submenu page to advertise local links
     */
	static function local_links_submenu_page(){
	 	include WpLinkRewriter::get_script_location('local_links_submenu_page.php');
	}
	
	
	static function submenu_add_or_edit_links(){
		include WpLinkRewriter::get_script_location('local_links_add_edit.php');
	}
	
	
	static function admin_init_form_submission_handler(){
		if($_POST['page'] == 'addnew_local_link'){
			
			//add or edit local link
			$url = admin_url('admin.php?page=addnew_local_link');
			
			if(empty($_POST['link']['link']) || empty($_POST['link']['name'])) return; // skip empty link or name field
			
			$linkDB = self::get_db_instance();
			$link_id =$linkDB->create_local_link($_POST['link']);
			$info = array();
			
			if($link_id){
				$info['message'] = 1;
				$info['link_id'] = $link_id;
			}
			else{
				$info['message'] = 2;
				$info['link_id'] = 0;
			}
			
			$url = add_query_arg($info, $url);
			return self::do_redirect($url);	
			
		}

		// list table's bulk action
		if($_REQUEST['link_table_bulk_action'] == 'y' || ($_REQUEST['page'] == 'submenu_page_for_local_links' && $_REQUEST['action'] == 'delete')){
						
			$sendback = remove_query_arg( array('deleted', 'link_id', ), wp_get_referer() );
						
			if(!$sendback){
				$sendback = admin_url('admin.php?page=submenu_page_for_local_links');
			}
			
			$wp_list_table = self::get_list_table();
			$doaction = $wp_list_table->current_action();
			$pagenum = $wp_list_table->get_pagenum();
			
			$sendback = add_query_arg( 'paged', $pagenum, $sendback );
			
			//var_dump($doaction); exit;
			
			if($doaction == 'delete'){
				$deleted = $wp_list_table->handle_bulk_action();
				$sendback = add_query_arg('deleted', $deleted, $sendback);
			}
			
			$sendback = remove_query_arg( array('action', 'action2', '_wp_http_referer', '_wpnonce'), $sendback );
			if(!empty($_REQUEST['s'])){
				$sendback = add_query_arg( 's', urlencode($_REQUEST['s']), $sendback );
			}
			
			return self::do_redirect($sendback);
		}		



	}

	
	static function get_db_instance(){
		if(!class_exists('LocalLinkDb')){
			include WPAFFILIATES_DIR . '/classes/local_link_db.php';
		}		
		return new LocalLinkDb();
	}
	
	
	static function manage_db(){		
				
		$LinkDb = self::get_db_instance();
		return $LinkDb->sync_db();
	}
	
	
	static function do_redirect($url){
		if(!function_exists('wp_redirect')){
			include ABSPATH . '/wp-includes/pluggable.php';
		}		
		wp_redirect($url);
		die();
	}
	
	
	//get list table instance
	static function get_list_table(){
		if(!class_exists('LocalLinksListTable')){
			include WPAFFILIATES_DIR . '/classes/class.list-table.php';
		}
		
		return new LocalLinksListTable();
	}
	
	
	static function get_local_links(){
		$LinkDb = self::get_db_instance();
		return $LinkDb->get_local_links();
	}
	
}

?>