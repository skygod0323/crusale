<?php
ob_start();
session_start();
include "common.php";
$_SESSION['last_page']="post-project.php";


/*if(isset($_SESSION['prj_name'])){ 	$prj_name=$_SESSION['prj_name'];	unset($_SESSION['prj_name']); }else{ $prj_name=""; }
if(isset($_SESSION['cat_id'])){	$cat_id=$_SESSION['cat_id'];	unset($_SESSION['cat_id']); }else{ $cat_id=""; }
if(isset($_SESSION['prj_scat_id'])){ 	$prj_scat_id=$_SESSION['prj_scat_id'];	unset($_SESSION['prj_scat_id']); }else{ $prj_scat_id=""; }
if(isset($_SESSION['prj_details'])){	$prj_details=$_SESSION['prj_details'];	unset($_SESSION['prj_details']); }else{ $prj_details=""; }

if(isset($_SESSION['pb_type'])){	$pb_type=$_SESSION['pb_type'];	unset($_SESSION['pb_type']); }else{ $pb_type=""; }
if(isset($_SESSION['pb_minprice'])){	$pb_minprice=$_SESSION['pb_minprice'];	unset($_SESSION['pb_minprice']); }else{ $pb_minprice=$lang[434]; }
if(isset($_SESSION['pb_maxprice'])){ 	$pb_maxprice=$_SESSION['pb_maxprice'];	unset($_SESSION['pb_maxprice']); }else{ $pb_maxprice=$lang[435]; }
if(isset($_SESSION['pb_rate'])){	$pb_rate=$_SESSION['pb_rate'];	unset($_SESSION['pb_rate']); }else{ $pb_rate=$lang[436]; }
if(isset($_SESSION['$pb_duration'])){	$pb_duration=$_SESSION['$pb_duration'];	unset($_SESSION['$pb_duration']); }else{ $pb_duration=""; }*/

class addProduct{

    var $msg;
	var $prj_id;
	var $prj_usr_id;
	var $prj_name;
	var $cat_id;
	var $prj_scat_id;
	var $skills;
	var $prj_details;
	var $pb_type;
	var $pb_minprice;
	var $pb_maxprice;
	var $pb_rate;
	var $pb_duration;
	
	function __construct( $prj_usr_id, $prj_name, $cat_id, $prj_scat_id, $skills, $prj_details, $pb_type, $pb_minprice, $pb_maxprice, $pb_rate, $pb_duration)
	{
		$this->prj_usr_id=$prj_usr_id;
		$this->prj_name=$prj_name;
		$this->cat_id=$cat_id;
		$this->prj_scat_id=$prj_scat_id;
		$this->skills=$skills;
		$this->prj_details=$prj_details;
		$this->pb_type=$pb_type;
		$this->pb_minprice=$pb_minprice;
		$this->pb_maxprice=$pb_maxprice;
		$this->pb_rate=$pb_rate;
		$this->pb_duration=$pb_duration;
		
	}
	
	function add()
	{	
        include "language.php";
        $validity=get_page_settings(6);

        $sql="insert into project
		set					
			prj_usr_id ='".$this->prj_usr_id."',
			prj_name ='".$this->prj_name."',									
			prj_scat_id ='".$this->prj_scat_id."',								
			prj_details ='".$this->prj_details."',
			prj_expiry=date_add(NOW(),INTERVAL ".$this->pb_duration." DAY),
			prj_status ='open',
			prj_updated_date=now()";
        mysql_query($sql) or die(mysql_error());
			
        $res_prj=mysql_query("select max(prj_id) from project where prj_status='open' and prj_usr_id='".$this->prj_usr_id."'");
        $row_prj=mysql_fetch_array($res_prj);			
			
        $this->prj_id=$row_prj[0];
			
        $sql_img1="select * from temp_file_post where fl_uid=".$this->prj_usr_id;
        $res_img1=mysql_query($sql_img1);
	
        if(mysql_num_rows($res_img1)>=1)
        {
            while($row_img1=mysql_fetch_object($res_img1))
			{
				$sql_img2="insert into project_files
					set				
						pfl_pr_id ='".$row_prj[0]."',
						pfl_filename ='".$row_img1->fl_filename."'";
				mysql_query($sql_img2) or die(mysql_error());
			}
            $sql_img3="delete from temp_file_post where fl_uid=".$this->prj_usr_id;
            mysql_query($sql_img3);
        }

        $sk_id_arr=array();
        $sk_id_arr=explode(",",$this->skills);

        foreach($sk_id_arr as $sk_id)
        {
            if($sk_id != '')
		{
                $sql_ps="insert into project_skill
                set					
                    ps_prj_id ='".$row_prj[0]."',									
                    ps_sk_id ='".$sk_id."'";
                mysql_query($sql_ps);
		}
        }

        $sql_pb="insert into project_budget
            set					
                pb_prj_id ='".$row_prj[0]."',
                pb_type ='".$this->pb_type."',
                pb_minprice ='".$this->pb_minprice."',
                pb_maxprice ='".$this->pb_maxprice."',
                pb_rate ='".(float)$this->pb_rate."',
                pb_duration ='".$this->pb_duration."',
                pb_status ='1'";
						
        mysql_query($sql_pb);
			
        $this->msg='<font color="#009900">'.$lang[421].'</font>';	
			
        unset($_SESSION['prj_name']);
        unset($_SESSION['cat_id']);
        unset($_SESSION['prj_scat_id']);
        unset($_SESSION['prj_details']);
        unset($_SESSION['pb_type']);
        unset($_SESSION['pb_minprice']);
        unset($_SESSION['pb_maxprice']);
        unset($_SESSION['pb_rate']);
        unset($_SESSION['pb_duration']);
		
	}	
}

if(isset($_POST['addProj']))
{
	$adn=new addProduct($_SESSION['prj_usr_id'], $_SESSION['prj_name'], $_SESSION['cat_id'], $_SESSION['prj_scat_id'], $_SESSION['skills'], $_SESSION['prj_details'], $_SESSION['pb_type'], $_SESSION['pb_minprice'], $_SESSION['pb_maxprice'], $_SESSION['pb_rate'], $_SESSION['pb_duration']);

	$adn->add();		
	$_SESSION['msg']=$adn->msg;
	header("location:post-project-res.php?p=".$adn->prj_id);
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
                                            <div class="page-header"><h3><?php echo $lang[680]; ?></h3></div>
<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
    
    <div class="form-horizontal">
    	<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[18]; ?></label>
			<div class="col-sm-8">
			<label class="form-control"><?php echo stripslashes($_SESSION['prj_name']); ?></label>
			</div>
		</div>
        <div class="form-group">
        <?php
            $row_cat=mysql_fetch_object(mysql_query("select * from category where cat_id='".$_SESSION['cat_id']."'"));
        ?>
            <label class="col-sm-3 control-label no-padding-right"><?php echo $lang[677]; ?></label>
            <div class="col-sm-8">
                <label class="form-control"><?php echo stripslashes($row_cat->cat_name); ?></label>
            </div>
        </div>
		<div class="form-group">
		<?php
			$row_scat=mysql_fetch_object(mysql_query("select * from subcategory where scat_id='".$_SESSION['prj_scat_id']."'"));
		?>
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[678]; ?></label>
			<div class="col-sm-8">
				<label class="form-control"><?php echo stripslashes($row_scat->scat_name); ?></label>
			</div>
		</div>
        <div class="form-group">
		<?php
			$row_scat=mysql_fetch_object(mysql_query("select * from subcategory where scat_id='".$_SESSION['prj_scat_id']."'"));
		?>
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[395]; ?></label>
			<div class="col-sm-8">
				<label class="form-control">
                <?php 
		            $i=0;
        		    $sk_id_arr=array();
					$sk_id_arr=explode(",",$_SESSION['skills']);

					foreach($sk_id_arr as $sk_id)
					{
            		    if($sk_id != '')
		                {
		                    if($i>0){   echo ", ";  }
        		        	$row_sk=mysql_fetch_object(mysql_query("select * from skills where sk_id='".$sk_id."'"));
	                		echo $row_sk->sk_name;
    	        		    $i++;
	        	        }
    	        	}
        	    ?>
                </label>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[498]; ?></label>
			<div class="col-sm-8">
				<label class="col-sm-12" style="min-height:34px;max-height:auto;border: 1px solid #D5D5D5;"><?php echo $_SESSION['prj_details']; ?></label>
			</div>
		</div>    
	    <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[433]; ?></label>
			<div class="col-sm-8">
				<label class="form-control">
                <?php
			        if($_SESSION['pb_type']=='fixed')
			        {
			            echo getCurrencySymbol().$_SESSION['pb_minprice']." - ".getCurrencySymbol().$_SESSION['pb_maxprice'];
			        }
			        else
			        {
			            echo getCurrencySymbol().$_SESSION['pb_rate'];
			        }
		        ?>
                </label>
			</div>
		</div>  
        
        <?php if(isset($_SESSION['pp']) && isset($_SESSION['tot_pp_amt'])) {    ?>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right"><?php echo $lang[679]; ?></label>
			<div class="col-sm-8">
				<label class="form-control">
                 <?php
        foreach($_SESSION['pp'] as $val)
        {
            $row_pp=mysql_fetch_object(mysql_query("select * from project_promotion where pp_id='".$val."'"));
            ?>
            &nbsp;<span style="width: 250px;"><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></span>
            (<span style="width: 250px;"><?php echo getCurrencySymbol()." ".number_format($row_pp->pp_amount,2)." ".getCurrencyCode(); ?></span>)
            <?php
        }
        ?>
                </label>
			</div>
		</div> 
         <?php   }   ?>
    </div>

    
    <form  action="" method="post" enctype="multipart/form-data;utf-8">
        <div class="col-sm-12" style="text-align:center">
        <button type="submit" name="addProj" id="addProj" class="btn btn-success btn-lg"><i class="icon-ok"></i><?php echo $lang[681]; ?></button>
        </div>
    </form>
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