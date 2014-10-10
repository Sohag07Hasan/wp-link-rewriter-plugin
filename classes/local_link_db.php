<?php 
/*
 * this class is to handle db
 */
 
 class LocalLinkDb{
 	
	private $link_table;
	public $db;
	
	function __construct(){
		global $wpdb;
		$this->link_table = $this->get_link_table();
		$this->db = $wpdb;
	}
	
	
	function sync_db(){
		global $wpdb;
		
		$sql[] = "create table if not exists $this->link_table(
			id bigint not null auto_increment,
			link text not null,
			name varchar(255),
			primary key(id),
			unique(name)
			
		)";
		
		foreach($sql as $s){
			$wpdb->query($s);
		}
	}
	
	
	function create_local_link($posted){
		if(isset($posted['id']) && !empty($posted['id'])) return $this->update_link($posted);
		
		extract($posted, EXTR_SKIP);
		global $wpdb;
		
		$inserted = $wpdb->insert($this->link_table, array('link' => $link, 'name' => $name), array('%s', '%s'));
		
		if($inserted){
			return $wpdb->insert_id;
		}
		else{
			return false;
		}
	}
	
	
	function update_link($posted){
		global $wpdb;
		extract($posted, EXTR_SKIP);
		$updated = $wpdb->update($this->link_table, array('link' => $link, 'name' => $name), array('id' => $id), array('%s', '%s'));
		
		if($updated){
			return $posted['id'];
		}
		else{
			return false;
		}
	}
	
	
	function get_link_by($type, $value){
		global $wpdb;
		return $wpdb->get_row("select * from $this->link_table where $type = '$value'");
	}
	
	
	function get_link_table(){
		global $wpdb;
		return $wpdb->prefix . 'lw_local_links';
	}
	
	
	function delete_link_by($type, $value){
		return $this->db->query("delete from $this->link_table where $type = '$value'");
	}
	
	
	//get total keywords
	function get_total_links($search = null){
		$sql = "select count(id) from $this->link_table";
		if($search){
			$sql .= " where link like '%$search%' OR name like '%$search%'";
		}
		return $this->db->get_var($sql);
	}

	
	function get_local_links(){
		$results = $this->db->get_results("select * from $this->link_table order by name asc");
		return $results;
	}
		
 }
 
?>