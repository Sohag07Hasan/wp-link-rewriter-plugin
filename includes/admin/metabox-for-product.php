<?php

$keywords = self::get_keywords($post->ID);
$keywords = !is_array($keywords) ? array() : $keywords;

$positions = array('Zero', '1st', '2nd', '3rd', '4th', '5th', '6th');

$saved_positions = self::get_local_positions($post->ID);

echo '<h4>Keywords</h4>';			
echo '<table class="form-table">';
		 			
foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
	if($aff == 'local_links') continue;
	?>
	<tr> <td>Keywords for <?php echo $param['title']; ?> </td> <td colspan="2"> <input type="text" size="50%", name="affiliate_keywords[<?php echo $aff; ?>]" value="<?php echo isset($keywords[$aff]) ? $keywords[$aff] : ''; ?>" ></td></tr>
	<?php
}
			
echo '</table>';

echo '<br/><br/> <hr/>';

echo '<h4>Positioning (Zero means disable)</h4>';

echo '<table class="form-table">';

if(self::is_local_position_enabled($post->ID)){
	$checked = 'checked';
}
else{
	$checked = '';
}	
echo '<tr> <td>Local Position Enabled? </td> <td> <input type="checkbox" size="50%" name="local_position_enabled" value="y" '.$checked.' ></td></tr>';
			
foreach(WpLinkRewriter::$affiliates_options as $aff => $param){
	?>
	<tr> <td>Position <?php echo $param['title']; ?> </td> 
		<td colspan="2">
			<select name="position[<?php echo $aff; ?>]">
			<?php
				foreach($positions as $p => $v){
					$selected = ( $saved_positions[$aff] == $p ) ? 'selected' : '';					
					echo '<option '.$selected.' value="'.$p.'">'.$v.'</option>';
				}
			?>
			</select>
		</td>
	</tr>
	<?php
}
			
echo '</table>';

echo '<br/><br/></hr>';


//local links
$local_links = LinkRewriterLocalLinks::get_local_links();
$post_local_links = self::get_local_links_by_post($post->ID);


echo '<h4>Local Links</h4>';
echo 'select local links to show with affiliate buttons';
if($local_links){
	echo '<table class="form-table">';
	echo '<tr><td colspan="2"><select name="local_links[]" style="width: 70%" multiple="multiple">';
		foreach($local_links as $link){
			$selected = in_array($link->id, $post_local_links) ? 'selected' : '';
			echo '<option '.$selected.' value="'.$link->id.'">'.$link->name. ' ('.$link->link.') ' .'</option>';
		}
	echo '</select></td></tr>';
}
else{
	echo 'No Links found!!';
}

