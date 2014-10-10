<?php

	$LocalLinks = self::get_list_table();
	
?>

<div class="wrap">
	<h2>Local Links
		<a href="<?php echo admin_url('admin.php?page=addnew_local_link'); ?>" class="add-new-h2">Add New</a>
		<?php 
			if(isset($_REQUEST['s']) && !empty($_REQUEST['s'])){
				echo '<span class="subtitle">Search results for “'.$_REQUEST['s'].'”</span>';
			}
		?>
	</h2>
	
	<?php 
		if($_REQUEST['deleted'] > 0) echo '<div class="updated"><p>' . $_REQUEST['deleted'] . ' deleted! </p></div>';
	?>
	
	<form action="" method="get">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" name="link_table_bulk_action" value="y" />
		<?php
			
			$LocalLinks->prepare_items();
			$LocalLinks->search_box('Search', 'link');
			$LocalLinks->display();
			 
		?>
	</form>
	
</div>