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

<style>
	.form-affliate-purpose table{
		margin-bottom: 0px 0px 50px 50px ;
	}
	
	.form-affliate-purpose table tr{
		padding: -2px;
	}
</style>

<div class="wrap">
	
	<?php if(isset($_POST['link-rewriter-options'])){ ?>
	<div class="updated"> <p>Saved..</p> </div>
	<?php } ?>
	
	<h2>Wp Link Rewriter</h2>
	<p>Customize the link writer as you want</p>
	<form method="post" action="" class="">
	<?php 
		
		//dynamically populates parameters
		$options = WpLinkRewriter::get_options();
		
		echo '<table class="form-table">';
		
		foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
			echo '<tr>';
			echo '<th scope="row">' .$param['title']. '</th>';
			
			if (isset($param['form'])){				
				echo '<td> <fieldset>';
								
				foreach($param['form'] as $key => $con){					
					$value = (isset($options[$aff][$con['name']])) ? $options[$aff][$con['name']] : '';
					
					//echo $con['description'];					
					echo WpLinkRewriter::get_form_field($aff, $con, $value);
					echo '<br/>';
				
				}							
				
				echo '</fieldset> </td>';
				
			}
			
			echo '</tr>';
		}
		
		echo '</table>';
	?>
	<input type="submit" name="link-rewriter-options" value="Save" class="button-primary">
	</form>
</div>