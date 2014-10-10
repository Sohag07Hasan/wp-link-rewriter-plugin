<?php 
	$action = sprintf(admin_url('admin.php?page=%s'), $_REQUEST['page']);
	
	if($_REQUEST['link_id'] > 0){
		$LinkDb = self::get_db_instance();
		$link = $LinkDb->get_link_by('id', $_REQUEST['link_id']);
		
		//var_dump($keyword);
	}
?>
<div class="wrap">
	<h2> <?php echo ($_REQUEST['link_id'] > 0) ? 'Edit Link' : 'Add new Link'; ?> </h2>
	
	<?php 
		if($_REQUEST['message'] == 1){
			?>
			<div class="updated"><p> Link Information saved </p></div>
			<?php 
		}
		
		if($_REQUEST['message'] == 2){
			echo '<div class="error"><p>This Link is already existed. Please try with another Link</p></div>';
		}
		
	?>
	
	<form action="<?php echo $action; ?>" method="post">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
		<input type="hidden" name="add_new_link" value="Y" />
		
		<?php 
			if($_REQUEST['link_id'] > 0 && !empty($link)){
				echo '<input type="hidden" name="link[id]" value="'.$link->id.'" />';
			}
		?>
		
		<table class="form-table" >
			<tbody>
				<tr>
					<th scope="row"><label for="link_link">link</label></th>
					<td><input id="link_link" size="40" type="text" name="link[link]" value="<?php echo $link->link; ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="link_name">Name</label></th>
					<td><input size="40" type="text" name="link[name]" value="<?php echo $link->name; ?>" id="link_name" /></td>
				</tr>
			</tbody>
		</table>
		
		<p>
			<?php if($_REQUEST['link_id'] > 0) : ?>
				<input type="submit" value="Update link" class="button button-primary" />
			<?php else: ?>
				<input type="submit" value="Save link" class="button button-primary" />
			<?php endif; ?>
		</p>
				
	</form>
	
</div>
