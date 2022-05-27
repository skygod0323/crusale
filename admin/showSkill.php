<?php
include "../common.php";
$q=$_GET["q"];

//lookup all hints from array if length of q>0
if (strlen($q) > 0)
{
	$sql="select * from skills where sk_cat_id=".$q." and sk_status=1 order by sk_name";
	$j=0;
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
   	if($count >0)
   	{
		?>
<div class="table-responsive">
<table id="sample-table-2" class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><strong>Skill Name</strong></th>
    <th style="text-align:center"><strong>Action</strong></th>
</thead>
<tbody>
<?php
		while($row=mysql_fetch_object($result))
		{
			$j++;	
?>
	<tr>
        <td>
    		<span id="display_<?php echo $row->sk_id; ?>"><?php echo  ucfirst($row->sk_name); ?></span>
			<span id="input_<?php echo  $row->sk_id; ?>" style="display:none;">
				<input type="text" style="width:200px;" name="sk_<?php echo $row->sk_id; ?>" id="sk_<?php echo $row->sk_id; ?>"  value="<?php echo $row->sk_name; ?>"/>
			</span>
		</td>
		<td style="text-align:center">
			<span id="edit_<?php echo $row->sk_id; ?>">
				<a href="javascript:ShowEditSkill(<?php echo  $row->sk_id; ?>)" class="ajax"><img width="15"  alt="edit" src="images/edit.jpg" border="0" style="styles:clear"></a>
			</span>
			<span id="save_<?php echo $row->sk_id; ?>" style="display:none;">
				<a href="javascript:SaveSkill(<?php echo $row->sk_id; ?>)" class="ajax"><img width="15"  alt="save" src="images/save.png" border="0" style="styles:clear"></a>
			</span>
			<span>
				<a href=javascript:DelSkill(<?php echo $row->sk_id; ?>)><img width="15"  alt="delete" src="images/delete.jpg" border="0" style="styles:clear" ></a>
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