<?php
include "../common.php";
$q=$_GET["q"];

//lookup all hints from array if length of q>0
if (strlen($q) > 0)
{
	$sql="select * from subcategory where scat_cat_id=".$q." and scat_status=1 order by scat_id";
	$j=0;
	$result=mysql_query($sql);
$j=1;
   	$count=mysql_num_rows($result);
   	if($count >0)
   	{
	?>
<div class="table-responsive">
<table id="sample-table-2" class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><strong>Sub-Category Name</strong></th>
    <th style="text-align:center"><strong>Action</strong></th>
</thead>
<tbody>
<?php
	
		while($row=mysql_fetch_object($result))
		{
	?>
    <tr>
        <td style="text-align:center;">
        <span id="display_<?php echo $row->scat_id; ?>"><?php echo ucfirst($row->scat_name); ?></span>
		<span id="input_<?php echo $row->scat_id; ?>" style="display:none;">
			<input type="text" style="width:200px;" name="scat_<?php echo $row->scat_id; ?>" id="scat_<?php echo $row->scat_id; ?>" class="reg_txtfld" value="<?php echo $row->scat_name; ?>"/>
		</span>
        </td>
  		<td style="text-align:center">
        	<span id="edit_<?php echo $row->scat_id; ?>">
				<a href="javascript:ShowEditSubcategory(<?php echo  $row->scat_id; ?>)" class="ajax"><img width="15"  alt="edit" src="images/edit.jpg" border="0" style="styles:clear"></a>
			</span>
			<span id="save_<?php echo $row->scat_id; ?>" style="display:none;">
				<a href="javascript:SaveSubcategory(<?php echo $row->scat_id; ?>)" class="ajax"><img width="15"  alt="save" src="images/save.png" border="0" style="styles:clear"></a>
			</span>
			<span>
				<a href=javascript:DelSubcategory(<?php echo $row->scat_id; ?>)><img width="15"  alt="delete" src="images/delete.jpg" border="0" style="styles:clear" ></a>
			</span>
		</td>
        </tr>
<?php $j++; 
		} ?>
</tbody>
</table>
</div>
<?php 
	}
} ?>