<div class="wrap">
	
	<h2>Wp Link Rewriter</h2>
	<p>Customize the link writer as you want</p>
	<form method="post" action="" class="">
	<?php 
		
		//dynamically populates parameters
		foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
			echo '<strong>' . $param['title'] . '</strong>';
			
			if (isset($param['form'])):
				echo '<table class="">';
				
				foreach($param['form'] as $key => $con):
				?>
					<tr class="">
						<th scope="row"><?php echo $con['description']; ?></th>
					</tr>
				<?php
				endforeach;	
							
				echo '</table>';
			endif;
		}
	
	?>
	
	</form>
</div>