<?php
ob_start();
session_start();
include "common.php";


if($_SESSION['uid']==''){ header("location:login.php");	}

$_SESSION['last_page']="membership-res.php";

if(isset($_POST['mp_id']))
{
	$_SESSION['mp_id']=$_POST['mp_id'];	
}
$mp_id=$_SESSION['mp_id'];

$sql_mp="select * from membership_plan where mp_id='".$mp_id."'";
$res_mp=mysql_query($sql_mp);
$row_mp=mysql_fetch_object($res_mp);



if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

$sql_chb="select * from user where usr_id=".$_SESSION['uid'];
$res_chb=mysql_query($sql_chb);
$row_chb=mysql_fetch_object($res_chb);
	
	if($row_chb->usr_balance < $row_mp->mp_rate)
	{
		header("location:payment-deposit.php");
	}
	else
	{
		$sql_us="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance - $row_mp->mp_rate;
		
		$sql="update user
			set			
				usr_mp_id ='".$row_mp->mp_id."',
				usr_balance = '".$new_bal."',
				usr_total_bid ='".$row_mp->mp_bidspermonth."',
				usr_left_bid ='".$row_mp->mp_bidspermonth."',
				usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH)
			where
				usr_id ='".$_SESSION['uid']."'";
			
		mysql_query($sql) or die(mysql_error());
		
		$sql_tr="insert into transaction
			set					
				tr_to_id ='0',
				tr_from_id ='".$_SESSION['uid']."',
				tr_prj_id ='0',
				tr_amount ='".$row_mp->mp_rate."',	
				tr_type ='upgrade membership',	
				tr_updated_date=now(),
				tr_status=1";
		mysql_query($sql_tr);
		
		
		unset($_SESSION['lst_prj']);
		
	}
	
?>

   	<?php include "includes/header.php"; ?>
<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[350]; ?><h2></div>
            
<div class="pg-bottom-text">
        <?php echo get_page_content('3'); ?>
        <?php
                   $sql_adv="select * from advertisement where adv_status='1' order by rand() limit 1";
                      $res_adv=mysql_query($sql_adv);
                      if(mysql_num_rows($res_adv)>0){
                      ?>
				<ul>
					<li>
                              <?php
                              
                              $row_adv=mysql_fetch_object($res_adv);
                              
                              ?>
                                  <a href="<?php echo $row_adv->adv_link; ?>" target="blank"><img src="upload/advertisement/<?php echo $row_adv->adv_img; ?>" height="<?php echo $row_adv->adv_imageheight; ?>" width="<?php echo $row_adv->adv_imagewidth; ?>"/></a>
                               
                                  </li>
					
				</ul>
                      <?php } ?>
	</div>
    </div>
</div>

<?php include "includes/footer.php"; ?>