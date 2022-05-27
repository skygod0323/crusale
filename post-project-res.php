<?php
ob_start();
session_start();
include "common.php";

if(!isset($_GET['p']))
{
	header("location:".$_SESSION['last_page']);	
}

$prj_id=$_GET['p'];

$_SESSION['last_page']="post-project-res.php?p=".$prj_id;

if($_SESSION['uid']=='')
{ 
    $_SESSION['temp_proj']=$prj_id;
    $_SESSION['msg']='<font color="#009900">'.$lang[624].'</font>';
    header("location:login.php");	
}

//print_r($_SESSION);

//$res_prj=mysql_query("select max(prj_id) from project where prj_usr_id='".$_SESSION['uid']."' and prj_status='open'");
//$row_prj=mysql_fetch_array($res_prj);

if($_SESSION['temp_proj']==$prj_id && $_SESSION['uid']!='' && $_SESSION['type']!="Freelancer")
{
    $sql_upd_prj="update project
			set					
				prj_usr_id ='".$_SESSION['uid']."'
                  where
                        prj_id='".$prj_id."'";
   
    mysql_query($sql_upd_prj);
    $disp_msg=$lang[411];
    unset($_SESSION['temp_proj']);    
}
else if($_SESSION['temp_proj']==$prj_id && $_SESSION['uid']!='' && $_SESSION['type']=="Freelancer")
{
    $disp_msg=$lang[623];
    $sql_del="delete from project where prj_id='".$prj_id."'";
    mysql_query($sql_del);
    unset($_SESSION['temp_usr']);
}
else
{
   
    $disp_msg=$lang[411];    
}


if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

if(isset($_SESSION['pp']) && isset($_SESSION['tot_pp_amt']))
{
	
	$sql_chb="select * from user where usr_id=".$_SESSION['uid'];
	$res_chb=mysql_query($sql_chb);
	$row_chb=mysql_fetch_object($res_chb);
	
	if($row_chb->usr_balance < $_SESSION['tot_pp_amt'])
	{
        $_SESSION['promotion_msg']="$lang[689]";
		header("location:payment-deposit.php");
	}
	else
	{
		foreach($_SESSION['pp'] as $val)
		{
			$sql_ppo="insert into project_promotion_option
				set
					ppo_prj_id='".$prj_id."',
					ppo_pp_id='".$val."',
					ppo_updated_date=now()";	
			mysql_query($sql_ppo);
		}
		$sql_tr="insert into transaction
			set					
				tr_to_id ='0',
				tr_from_id ='".$_SESSION['uid']."',
				tr_prj_id ='".$prj_id."',
				tr_amount ='".$_SESSION['tot_pp_amt']."',	
				tr_type ='promotion',	
				tr_updated_date=now(),
				tr_status=1";
		mysql_query($sql_tr);
		
		$sql_us="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance - $_SESSION['tot_pp_amt'];
		
		$sql_upd="update user
			set
				usr_balance = '".$new_bal."'
			where
				usr_id='".$_SESSION['uid']."'";
			
		mysql_query($sql_upd);
		
		unset($_SESSION['pp']);
		unset($_SESSION['tot_pp_amt']);
	}
}

?>
<?php include "includes/header.php"; ?>


<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[422]; ?></h1>
                        </div>
                        
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="row">
                        <div class="content col-md-1">
						</div>
                        <div class="content col-md-10">
                            <div class="post-padding">
                                
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
										
										<div class="page-content">
											<div class="row">
												<div class="col-xs-12">
													<div style="margin-bottom:25px;"><h2 style="color:#093"><?php echo $disp_msg; ?></h2></div>
											
												
												<a class="btn btn-info btn-lg" href="project.php?p=<?php echo $prj_id; ?>"><span><?php echo $lang[273]; ?></span></a>
												</div>
											</div>
										</div>
										
										</div>	
									</div>
                            </div><!-- end row -->
                                <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
						<div class="content col-md-1">
						</div>
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
<?php include "includes/footer.php"; ?>