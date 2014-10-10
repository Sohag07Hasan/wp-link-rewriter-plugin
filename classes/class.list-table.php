<?php 

if( ! class_exists( 'WP_List_Table' ) ) {
	if(!class_exists('WP_Internal_Pointers')){
		require_once( ABSPATH . '/wp-admin/includes/template.php' );
	}
	require_once( ABSPATH . '/wp-admin/includes/class-wp-list-table.php' );
}

class LocalLinksListTable extends WP_List_Table{
	private $per_page;
	private $total_items;
	private $current_page;	
	public $LinkDb;
		
	function __construct(){
		$this->LinkDb = LinkRewriterLocalLinks::get_db_instance();
		parent::__construct();
	}
	
	/*preparing items must overwirte the mother function*/
	function prepare_items(){
			
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
	
		$this->_column_headers = array($columns, $hidden, $sortable);
	
		//paginations
		$this->_set_pagination_parameters();
	
		//every elements
		$this->items = $this->populate_table_data();	
	}
	
	
	//get the column names
	function get_columns(){
		$columns = array(
				'cb' => '<input type="checkbox" />',
				'link' => __('Keyword'),
				'name' => __('Name'),
			);
	
		return $columns;
	}
	
	//make some column sortable
	function get_sortable_columns(){
		$sortable_columns = array(
				'link' => array('link', false),
				'name' => array('name', false),
			);
	
		return $sortable_columns;
	}
	
	
	//pagination
	private function _set_pagination_parameters(){
			
		$this->current_page = $this->get_pagenum(); //it comes form mother class (WP_List_Table)
	
		$this->total_items = $this->LinkDb->get_total_links($_REQUEST['s']);
		$this->per_page = 25;
	
		$this->set_pagination_args( array(
				'total_items' => $this->total_items,                  //WE have to calculate the total number of items
				'per_page'    => $this->per_page,                     //WE have to determine how many items to show on a page
				'total_pages' => ceil($this->total_items/$this->per_page)   //WE have to calculate the total number of pages
		) );
	
	}
	
	
	//collectes every information
	function populate_table_data(){
		$link_table = $this->LinkDb->get_link_table();
				
		$sql = "select id, name, link from $link_table ";
		
		if(isset($_REQUEST['s']) && !empty($_REQUEST['s'])){
			$s = trim($_REQUEST['s']);
			$sql .= " where link like '%$s%' or name like '%$s%'";
		}
		
		//order
		$order_by = (isset($_GET['orderby'])) ? $_GET['orderby'] : 'name';
		$order = (isset($_GET['order'])) ? $_GET['order'] : 'asc';
		$sql .= " order by $order_by $order";
		
		//pagination
		$current_page = ($this->current_page > 0) ? $this->current_page - 1 : 0;
		$offset = (int) $current_page * (int) $this->per_page;
		$sql .= " limit $this->per_page offset $offset";
		
		$links = $this->LinkDb->db->get_results($sql);
		$sanitized_links = array();
		
		//var_dump($links);
		
		if($links){
			foreach($links as $link){
												
				$sanitized_links[] = array(
					'id' => $link->id,
					'link' => $link->link,
					'name' => $link->name,
				);
			}
		}
		
		return $sanitized_links;
	}
	
	
	/* Utility that are mendatory   */
	
	/* checkbox for bulk action*/
	function column_cb($item) {
		return sprintf(
				'<input type="checkbox" name="link_id[]" value="%s" />', $item['id']
		);
	}
	
	
	/* default column checking and it is must */
	function column_default($item, $column_name){
		switch($column_name){
			case "id":
			case "link":
			case "name":
			return $item[$column_name];
				break;
			default:
				var_dump($item);
					
		}
	}	
	
	
	//bulk actions initialization
	function get_bulk_actions() {
		$actions = array(
				'delete'    => 'Delete'
		);
		return $actions;
	}
	
	
	//handle bulk action
	function handle_bulk_action(){
		
		//var_dump($_REQUEST['keyword_id']);
		$count = 0;
		if($this->current_action() == 'delete'){
			$link_ids = $_REQUEST['link_id'];
		
			if(!is_array($link_ids)){
				$link_ids = array($link_ids);
			}
			
			//var_dump($link_ids); exit;
			
			foreach($link_ids as $link_id){
				$this->LinkDb->delete_link_by('id', $link_id);
				$count ++;				
			}
							
		}
		
		return $count;
	}
	
	
	/*adding extra actions when hovering first column
	 * name is column name
	 *  */
	function column_link($item){
	
		$delete_href = sprintf('?page=%s&action=%s&link_id=%s', $_REQUEST['page'],'delete',$item['id']);
	
		if(isset($_REQUEST['s']) && !empty($_REQUEST['s'])){
			$delete_href = add_query_arg(array('s'=>$_REQUEST['s']), $delete_href);
		}
	
		if($this->get_pagenum()){
			$delete_href = add_query_arg(array('paged'=>$this->get_pagenum()), $delete_href);
		}
	
		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&link_id=%s">Edit</a>','addnew_local_link','edit',$item['id']),
				'delete' => "<a href='$delete_href'>Delete</a>"
		);
	
	
		return sprintf('%1$s %2$s', $item['link'], $this->row_actions($actions) );
	}
	
}