<?php 
include "../common.php";
$cid=$_GET[cid];
$sql_cn="select * from city where ct_status=1 and ct_cn_id=".$cid." order by ct_name";
$res_cn=mysql_query($sql_cn);	
?>
<table   id="sample-table-2" class="table table-striped table-bordered table-hover">
<TR>
<?php  
$j=1;
while($rec_cn=mysql_fetch_object($res_cn)) {  ?>
<?php if(($j == 1)||($j == 5)){?><tr><?php	} ?>
<td>
<table><tr>
<td style="width: 86%;border:0px;">
<span id="display_<?php echo $rec_cn->ct_id; ?>">
<?php echo $rec_cn->ct_name; ?></span>
<span id="input_<?php echo $rec_cn->ct_id; ?>" style="display:none;">
<input type="text" name="city_<?php echo $rec_cn->ct_id; ?>" id="city_<?php echo $rec_cn->ct_id; ?>" class="reg_txtfld" value="<?php echo $rec_cn->ct_name; ?>"/></span>

</td>


<td style="width: 12%;border:0px;">
<span id="edit_<?php echo $rec_cn->ct_id; ?>"><a href="javascript:ShowEditCity(<?php echo $rec_cn->ct_id; ?>)" class="ajax badge badge-info"><i class="icon-edit"></i></a></span>
<span id="save_<?php echo $rec_cn->ct_id; ?>" style="display:none;"><a href="javascript:EditCity(<?php echo $rec_cn->ct_id; ?>)" class="ajax badge badge-success"><i class="icon-check"></i></a></span>
</td>
<td style="width: 4%;border:0px;"><a href = "javascript:DelCity(<?php echo $rec_cn->ct_id; ?>);" class="badge badge-danger"><i class="icon-trash"></i></a></td>
</tr></table>
</td>
<?php $j++; ?><?php if(($j == 1)||($j == 5)){?></tr><?php $j=1;} ?>
<?php } ?></table>