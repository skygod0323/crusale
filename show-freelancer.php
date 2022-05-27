<?php
ob_start();
session_start();
include "common.php";


if($_GET['page'])
{
$page = $_GET['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;


$cat_id=$_GET['cat'];
if(isset($_GET['sk']))
{
	$sk_id=$_GET['sk'];
}
else
{
	$sk_id=0;	
}

if(isset($_GET['u']) && $_GET['u']!='')
{
	$sql_unm=" and usr_name like '%".$_GET['u']."%'";
}
else
{
	$sql_unm="";
}



if(isset($_GET['sk']))
{
	if($sk_id==0)
	{
		$sql="select * from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id.")) order by usr_name LIMIT $start, $per_page";
	}
	else
	{
		$sql="select * from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select distinct prj_usr_id from project where prj_id in(select distinct ps_prj_id from project_skill where ps_sk_id='".$sk_id."')) order by usr_name LIMIT $start, $per_page";
	}
}
else
{
	$sql="select * from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id.")) order by usr_name LIMIT $start, $per_page";
}

$recObj=mysql_query($sql) or die('MySql Error' . mysql_error());

if(mysql_num_rows($recObj)>0)	{
while($row=mysql_fetch_object($recObj)){
?>
<div class="col-md-12 col-sm-12" style="padding:10px;">
<div class="panel panel-default">
	<div class="panel-heading">
		<a href="profile.php?u=<?php echo md5($row->usr_id); ?>"><?php echo $row->usr_name; ?></a>
		<?php
					$res_cntry=mysql_query("select * from country where cn_id=(select ct_cn_id from city where ct_id='".$row->usr_ct_id."')");
					if(mysql_num_rows($res_cntry)>0)
					{
						$row_cntry=mysql_fetch_object($res_cntry);
				?>
					<span class="bidder-country-flag">&nbsp;<img src="images/country_flag/<?php echo $row_cntry->cn_name; ?>.png" alt="" title="<?php echo $row_cntry->cn_name; ?>" /></span>
                <?php } ?>
	</div>
	<div class="panel-body">
		<div class="widget-main" style="min-height:100px;">
			<?php	if($row->usr_image == ''){ ?>
			<img src="images/unknown.jpg" width="88" height="79" align="left">
			<?php	} else { 	?>
			<img src="images/users/<?php echo $row->usr_image; ?>" width="88" height="79" align="left"><!--<img src="images/profile_logo_71867.jpg" width="50" height="50">-->
			
			<?php } ?>
			<div class="ns_ratings-new" style="margin-left:110px; margin-bottom:10px;">
                    <?php
					$sql_rt_rv="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism), sum(rr_completionrate),count(rr_review) from review_rating where rr_to_usr='".$row->usr_id."'";

					$res_rt_rv=mysql_query($sql_rt_rv);
					$row_rt_rv=mysql_fetch_array($res_rt_rv);

					$avg_rt=0;
					if($row_rt_rv[0] != 0)
					{
						$avg_rt=((($row_rt_rv[1]+$row_rt_rv[2]+$row_rt_rv[3]+$row_rt_rv[4]+$row_rt_rv[5])+($row_rt_rv[6]*10)))/$row_rt_rv[0]/6;
					}

					?>
                	<div class="ns_ratings-new ns_active-stars" style="width:<?php echo $avg_rt*10; ?>%;"></div>
                    <div style="padding-left:80px;"><?php echo number_format($avg_rt,1); ?>&nbsp;&nbsp;<a href="review.php?u=<?php echo md5($row->usr_id); ?>">(<?php echo $row_rt_rv[7]; ?>&nbsp;<?php echo $lang[323]; ?>)</a></div>
            </div>
                    <div style="margin-left:110px;" align="left">
						<p>
                                    
						<?php
						$sql_skl="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$row->usr_id."')";
						$res_skl=mysql_query($sql_skl);
						if(mysql_num_rows($res_skl)>0){
						$n=0;
						?>
						<?php echo $lang[324]; ?>
                        <?php while($row_skl=mysql_fetch_object($res_skl)){ ?>
						<?php if($n>0){ echo ", "; } ?><?php echo $row_skl->sk_name; ?>
            
						<?php	$n++; } ?>
                        
						<?php } ?>
						</p>
                    </div>
		</div>
	</div>
</div>
</div>
<?php
}
}else{ ?>
    <div class="col-xs-12 col-sm-12 widget-container-span">
    	<div class="widget-box " style="border:1px solid #CCC;background-color:#FF4848">
        	<!--<div class="widget-header widget-header-small header-color-light"></div>-->
            <div class="widget-body">
            	<div class="widget-main">
                	<p class="alert alert-info" style="background-color:#FFD2D2"><?php echo $lang[722]; ?></p>
				</div>
			</div>
		</div>
	</div>
    
<?php } ?>



































	

<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */

if(isset($_GET['sk']))
{
	if($sk_id==0)
	{
		$query_pag_num="select count(*) AS count from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id."))";
	}
	else
	{
		$query_pag_num="select count(*) AS count from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select distinct prj_usr_id from project where prj_id in(select distinct ps_prj_id from project_skill where ps_sk_id='".$sk_id."'))";
	}
}
else
{
	$query_pag_num="select count(*) AS count from user where usr_status=1 and usr_emailVerified='1' ".$sql_unm." and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id."))";
}

$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>

<?php if($count>0){	?>
<ul class="pagination pull-right" >
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:show_result('<?php echo $pre; ?>')"><i class="fa fa-arrow-left" aria-hidden="true"></i>
</a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:show_result('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
	<!--<li class="active">
		<a href="#">1</a>
	</li>
	<li>
		<a href="#">2</a>
	</li>
	<li>
		<a href="#">3</a>
	</li>-->
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:show_result('<?php echo $nex; ?>')"><i class="fa fa-arrow-right" aria-hidden="true"></i>
</a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<?php	}	?>
<!------------------------- pagination end here ----------->



<?php	}	?>