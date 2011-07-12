<?php
/**
 * Manual Merge Page.
 * 
 * @author Carl Saggs (cs305@kent.ac.uk)
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

 ?>
The following records have been found on attached accounts, that don't match with what we have in our database.
<br/><br/>
Please select the options you would like to use (the items selected in green will be kept).
<br/>&nbsp;<br/>
<?php
	//create form. (hidden form is used to store and submit selected values)
	echo $form->create('Identity', array('action' => 'save', 'style' =>'width:590px'));
?>
<div class='mergeLine'>
	<div class='merge_title'>Item</div>
	<div class='merge_title mergeCur'>Current</div>
	<div class='merge_title mergeOther'>New</div>
</div>
<?php 

//For each syncable item of data, create a new row.
foreach($sync_data As $line){
	//Check we have some updated data for this row. Do not display is their is none.
	if(isset($new_data[$line])){
		//Calcuate paramiters for row.  (used to fit all items in row & apply correct index's for javascript functions)
		$opt_list ='';
		$idx = 1;
		$range = count($new_data[$line])+1;
		$width = round(100/($range-1))-6;
		//generate items for this row.
		foreach($new_data[$line] AS $option){
			$idx++;
			$opt_list = $opt_list.'<div class="mergeItem" style="width:'.$width.'%" onclick="mergeSelect(this);" id="mItm_'.$line.'_'.$idx.'" range="'.$range.'">'.$option.'</div>';
		}
		//Output row with all items.
		echo '<div class="mergeLine">
				<div class="merge_title">'.$line.'</div>
				<div class="mergeItem mergeCur mergeSelected" onclick="mergeSelect(this);" id="mItm_'.$line.'_1" range="'.$range.'">'.$cur_data[$line].'</div>
				<div class="long">
					'.$opt_list.'
				</div>
				<div class="clear"></div>
			</div>
			';
			//End form.
			echo $form->input($line, array ('type'=> 'hidden', 'id'=>'mItm_'.$line.'_0', 'value' => $cur_data[$line]));
		
	}
}
echo $form->end('Save');
