<?php
include "../common.php";

$p=$_POST['id'];
$sql_cmt="select * from comment,user where usr_id=cmt_usr_id and cmt_prj_id=".$p." order by cmt_id desc";
$res_cmt=mysql_query($sql_cmt);
$num_cmt=mysql_num_rows($res_cmt);

?>

<div class="row">
<div class="col-xs-12">
<div class="row">

<?php
	while($row_cmt=mysql_fetch_object($res_cmt)){
	?>
		<div class="col-xs-12 col-sm-6 widget-container-span">
			<div class="widget-box">
				<div class="widget-header" align="left">
					<h5><a href="profile.php?u=<?php echo md5($row->usr_id); ?>"><?php echo $row_cmt->usr_name; ?></a></h5>
					<div class="widget-toolbar">
                    <?php	$dy=dateDifference($row_cmt->cmt_updated_date,date("Y-m-d"));	?>
		            <?php if($dy==0){ echo $lang[73]; }else{ echo $dy.$lang[74]; } ?>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main" style="min-height:80px;">
                    <?php	if($row_cmt->usr_image == ''){ ?>
						<img src="images/unknown.jpg" width="88" height="79" align="left">
						<?php	} else { 	?>
	                    <img src="images/users/<?php echo $row_cmt->usr_image; ?>" alt="<?php echo $row_cmt->usr_name; ?>" class="ns_user-logo" border="0" width="88" height="79" align="left"/>
                    <?php	}	?>
						<div style="margin-left:110px;" align="left">
							<p class="alert alert-info" style="min-height:47px;"><?php echo $row_cmt->cmt_text; ?></p>
                        </div>
					</div>
				</div>
			</div>
		</div>
<?php } ?>
</div>
</div>
</div>
|<?php echo $num_cmt; ?>