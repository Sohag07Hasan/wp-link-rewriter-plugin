<?php
//saving options
 
 if(isset($_POST['link-rewriter-options'])){
 	$options = array();
 	foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
 		foreach($param['form'] as $key => $con):
			//$options[$aff[$con['name']]] = $_POST[$aff[$con['name']]];
			$options[$aff][$con['name']] = $_POST[$aff][$con['name']];				
		endforeach;
 	}
	
	WpLinkRewriter::update_options($options);
 }
 
?>

<div class="wrap">
	
	<h2>Wp Link Rewriter</h2>
	<p>Customize the link writer as you want</p>
	<form method="post" action="" class="">
	<?php 
		
		//dynamically populates parameters
		$options = WpLinkRewriter::get_options();
		
		foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
			echo '<h3>' . $param['title'] . '</h3>';
			
			if (isset($param['form'])):
				echo '<table class="">';
				
				foreach($param['form'] as $key => $con):
					
					$value = (isset($options[$aff][$con['name']])) ? $options[$aff][$con['name']] : '';
					
				?>
					<tr class="">
						<th><?php echo $con['description']; ?></th>
						<td><?php echo WpLinkRewriter::get_form_field($aff, $con, $value); ?></td>
					</tr>
				<?php
				endforeach;								
				echo '</table>';
			endif;
		}
	
	?>
	<input type="submit" name="link-rewriter-options" value="Save" class="button-primary">
	</form>
</div>